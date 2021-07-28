<?php

namespace App\Router;

use App\Category\CategoryController;
use App\Import\ImportController;
use App\Product\ProductController;
use App\Queue\QueueController;
use App\Renderer;
use App\Request;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

class Dispatcher
{
    protected $routes = [
        '/products/'                => [ProductController::class, 'list'],
        '/products/edit'            => [ProductController::class, 'edit'],
        '/products/edit/{id}'       => [ProductController::class, 'edit'],
        '/products/add'             => [ProductController::class, 'add'],
        '/products/delete'          => [ProductController::class, 'delete'],
        '/products/delete_image'    => [ProductController::class, 'deleteImage'],

        '/categories/'          => [CategoryController::class, 'list'],
        '/categories/add'       => [CategoryController::class, 'add'],
        '/categories/edit'      => [CategoryController::class, 'edit'],
        '/categories/delete'    => [CategoryController::class, 'delete'],
        '/categories/view'      => [CategoryController::class, 'view'],

        '/categories/view/{id}'      => [CategoryController::class, 'view'],
        '/categories/{id}/view'      => [CategoryController::class, 'view'],
        '/categories/edit/{id}'      => [CategoryController::class, 'edit'],
        '/categories/{id}/edit'      => [CategoryController::class, 'edit'],

        '/queue/list'         => [QueueController::class, 'list'],
        '/queue/run'      => [QueueController::class, 'run'],
        '/queue/delete'   => [QueueController::class, 'delete'],

        '/import/index'       => [ImportController::class, 'index'],
        '/import/upload'      => [ImportController::class, 'upload'],

    ];

    public function dispatch()
    {

        $url = Request::getUrl();
        $route = new Route($url);

        foreach ($this->routes as $path => $controller){
            if ($this->isValidPath($path, $route))
                break;
        }

        try {
            $route->execute();
        } catch (NotFoundException | MethodDoesNotExistException $e){
            $this->error404();
        }
    }

    public function isValidPath(string $path, Route $route)
    {
        $controller = $this->routes[$path];

        $isValidPath = $route->isValidPath($path);
        if ($isValidPath){
            $route->setController($controller[0]);
            $route->setMethod($controller[1]);
        };

        return $isValidPath;

    }
    
    private function error404()
    {
        Renderer::getSmarty()->display('404.tpl');
        exit;
    }

}