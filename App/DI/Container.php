<?php

namespace App\DI;

class Container
{
    public function execute(string $className, string $methodName)
    {
        $controller = new $className($this);

        $controllerMethod = $this->getMethod();

        if (method_exists($controller, $controllerMethod)){
            return $controller->{$controllerMethod}();
        }

        throw new MethodDoesNotExistException();

    }
}