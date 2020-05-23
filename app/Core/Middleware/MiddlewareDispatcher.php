<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Middleware\CheckConnectedUser;
use App\Middleware\CheckNotConnectedUser;

class MiddlewareDispatcher
{
    protected array $container;

    protected Request $request;

    protected ?Handler $tip = null;

    protected ?Handler $last;

    public function __construct(array $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;

        $this->addMiddlewares();
        $this->addControllerMiddleware();

        return $this->tip->handle($request);
    }

    protected function addHandler(Handler $handler)
    {
        //TODO : Faire une méthode récursive pour la list chainé
        if ($this->tip === null)
        {
            $this->tip = $handler;
            $this->last = $handler;
        }
        else
        {
            if ($this->last instanceof Middleware)
                $this->last->setNext($handler);
            $this->last = $handler;
        }
    }

    protected function addMiddlewares(): void
    {
        array_map(function ($middlewareName) {
            $middlewareClass = $this->getMiddleware($middlewareName);
            $this->addHandler(new $middlewareClass());
        }, $this->request->getCurrentRoute()->getMiddleware());
    }

    protected function addControllerMiddleware(): void
    {
        $controllerName =  'App\\Controllers\\' . $this->request->getCurrentRoute()->getController();
        $controller = new $controllerName($this->container);
        $this->addHandler($controller);
        $controller->setControllerMethod($this->request->getCurrentRoute()->getMethod());
    }

    protected function getMiddleware(string $middlewareName): ?string
    {
        $middlewares = [
            'user.not.connected' => CheckNotConnectedUser::class,
            'user.connected' => CheckConnectedUser::class,
        ];

        return $middlewares[$middlewareName] ?? null;
    }
}