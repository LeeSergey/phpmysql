<?php

namespace App\DI;


use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Route;
use ReflectionClass;
use ReflectionException;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionObject;
use ReflectionProperty;

class Container
{
    /**
     * @var callable[]
     */
    private $factories = [];

    /**
     * @var object[]
     */
    private $singletones = [];

    /**
     * @var object[]
     */
    private $dependencyMapping =[];

    /**
     * @param string $className
     * @return object
     * @throws ReflectionException
     */
    public function get(string $className, array $dependencyMapping = null)
    {
        if (!is_null($dependencyMapping)){
            $this->setDependencyMapping($dependencyMapping);
        }

        if (array_key_exists($className, $this->dependencyMapping) && is_object($this->dependencyMapping[$className])){
            return $this->dependencyMapping[$className];
        }

        if ($this->isSingletone($className)){
            return $this->getSingletone($className);
        }

        return $this->createInstance($className);
    }

    /**
     * @param string $className
     * @param callable $factory
     */
    public function factory(string $className, callable $factory)
    {
        $this->factories[$className] = $factory;
    }

    /**
     * @param string $className
     * @param callable|null $factory
     */
    public function singletone(string $className, callable $factory = null)
    {
        if (!$this->isSingletone($className)){
            $this->singletones[$className] = null;
        }

        if (is_callable($factory)){
            $this->factory($className, $factory);
        }
    }

    /**
     * @param string $className
     * @return bool
     */
    public function isSingletone(string $className)
    {
        return array_key_exists($className, $this->singletones);
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

    /**
     * @param ReflectionClass|ReflectionFunctionAbstract|ReflectionProperty $target
     * @return array|string[]|null
     */
    public function parseDocComment($target)
    {
        $isReflectionClass = $target instanceof ReflectionClass;
        $isReflectionFunction = $target instanceof ReflectionFunctionAbstract;
        $isReflectionProperty = $target instanceof ReflectionProperty;

        $hasDocComment = $isReflectionClass || $isReflectionFunction || $isReflectionProperty;

        if (!$hasDocComment){
            return null;
        }

        $docComment = (string) $target->getDocComment();

        $docComment = str_replace(['/**','*/'],'',$docComment);
        $docComment = trim($docComment);
        $docCommentArray = explode("\n", $docComment);

        $docCommentArray = array_map(function ($item){
            $item = trim($item);

            $position = strpos($item, '*');
            if ($position === 0){
                $item = substr($item, 1);
            }

            return trim($item);
        }, $docCommentArray);

        return $docCommentArray;

    }

    protected function setDependencyMapping(array $mapping)
    {
        $this->dependencyMapping = $mapping;
    }
    
    protected function initProtectedAndPrivateProperties($object)
    {
        $reflectionObject = new ReflectionObject($object);
        $reflectionProperties = $reflectionObject->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);

        foreach ($reflectionProperties as $reflectionProperty){
//            $docComment = $reflectionProperty->getDocComment();
            $docCommentArray = $this->parseDocComment($reflectionProperty);

            $dependencyClass = null;

            foreach ($docCommentArray as $docComment){
                $onInitPrefix = '@onInit(';
                $isOnInit = strpos($docComment, $onInitPrefix) === 0;

                if (!$isOnInit) {
                    continue;
                }

                $dependencyClass = str_replace($onInitPrefix, '',$docComment);
                $dependencyClass = substr($dependencyClass, 0, -1);

                if (!class_exists($dependencyClass)){
                    $dependencyClass = null;
                }

                break;
            }

            if (is_null($dependencyClass)){
                continue;
            }

            $reflectionProperty->setAccessible(true);
            $dependencyClassObject = $this->get($dependencyClass);
            $reflectionProperty->setValue($object, $dependencyClassObject);
            $reflectionProperty->setAccessible(false);

//               echo "<pre>";var_dump($docCommentArray, $reflectionProperty->getDeclaringClass());echo "</pre>";

        }
    }

    /**
     * @param string $className
     * @return object|null
     */
    protected function getSingletone(string $className)
    {
        if (!$this->isSingletone($className)){
            return null;
        }

        if(is_null($this->singletones[$className])){
            $this->singletones[$className] = $this->createInstance($className);
        }

        return $this->singletones[$className];
    }

    /**
     * @param string $className
     * @return object
     * @throws ReflectionException
     */
    protected function createInstance(string $className)
    {
        if (isset($this->factories[$className])){
            return $this->factories[$className]();
        }

        $reflectionClass = new ReflectionClass($className);
        $reflectionConstructor = $reflectionClass->getConstructor();



        if ($reflectionConstructor instanceof ReflectionMethod){
            $arguments = $this->getDependencies($reflectionConstructor);
            $object = $reflectionClass->newInstanceArgs($arguments);
        } else {
            $object = $reflectionClass->newInstance();
        }
        $this->initProtectedAndPrivateProperties($object);
        return $object;
    }
    


    /**
     * @param ReflectionMethod $reflectionMethod
     * @return array|void
     * @throws ReflectionException
     */
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


}