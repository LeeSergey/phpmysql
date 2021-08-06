<?php

namespace App\DI;


use App\Router\Exception\MethodDoesNotExistException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionObject;

class Container
{
    public function execute(string $className, string $methodName)
    {

    }

    public function get(string $className)
    {
        return new $className();
    }

    public function getController(string $className)
    {
        $reflectionClass = new ReflectionClass($className);
        $reflectionConstructor = $reflectionClass->getConstructor();
        $arguments = $this->getDependencies($reflectionConstructor);

        return $reflectionClass->newInstanceArgs($arguments);
    }

    /**
     * @param $object
     * @param string $propertyName
     * @param $value
     * @return bool|null
     * @throws ReflectionException
     */
    public function setProperty($object, string $propertyName, $value)
    {
        if (!is_object($object)){
            return null;
        }

        $reflectionController = new ReflectionObject($object);

        $reflectionRenderer = $reflectionController->getProperty($propertyName);
        $reflectionRenderer->setAccessible(true);
        $reflectionRenderer->setValue($object , $value);
        $reflectionRenderer->setAccessible(false);

        return true;

    }

    protected function getDependencies(ReflectionMethod $reflectionMethod)
    {
        $reflectionParameters = $reflectionMethod->getParameters();

        $arguments = [];

        foreach ($reflectionParameters as $parameter) {
            $parameterName = $parameter->getName();
            $parameterType = $parameter->getType();

            assert($parameterType instanceof \ReflectionNamedType);
            $className = $parameterType->getName();

            if (class_exists($parameterType)){
                $arguments[$parameterName] = $this->get($className);
            }

        }

        return $arguments;
    }

    /**
     * @param object $object
     * @param string|null $methodName
     * @return false|mixed|null
     * @throws ReflectionException
     */
    public function call(object $object, ?string $methodName)
    {
        if(!is_object($object)){
            return null;
        }

        $reflectionClass = new ReflectionObject($object);
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $arguments = $this->getDependencies($reflectionMethod);

        return call_user_func_array([$object , $methodName], $arguments);

    }
}