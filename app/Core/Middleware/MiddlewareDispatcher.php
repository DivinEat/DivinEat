<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Middleware\CheckConnectedUser;
use App\Middleware\CheckNotConnectedUser;

class MiddlewareDispatcher
{
    protected array $container;

    protected Request $request;

    protected Middleware $tip;

    protected Middleware $lat;

    public function __construct(array $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;

        $this->addMiddlewares();
        $this->addControllerMiddleware();

        return $this->tip->handle($request);
    }

    protected function addMiddlewares(): void
    {
        var_dump($this->request->getCurrentRoute());die;
    }

    protected function addControllerMiddleware(): void
    {

    }

    protected function getMiddleware(string $middlewareName): ?Middleware
    {
        $middlewares = [
            'user.not.connected' => CheckNotConnectedUser::class,
            'user.connected' => CheckConnectedUser::class,
        ];

        return $middlewares[$middlewareName] ?? null;
    }
}