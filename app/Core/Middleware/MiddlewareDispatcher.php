<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;
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

        if ($this->tip instanceof ControllerMiddleware)
        {
            $methodName = $this->tip->getControllerMethod();

            return $this->tip->$methodName($request, new Response(), $request->getRouteArgs());
        }

        return $this->tip->run($request, new Response());
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
        $controllerName =  preg_replace('#[\\\]{2,}#', '\\', 'App\\Controllers\\' . $this->request->getCurrentRoute()->getController());
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