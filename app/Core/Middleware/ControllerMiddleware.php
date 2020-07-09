<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;

abstract class ControllerMiddleware extends Middleware
{
    protected string $controllerMethod;

    protected array $args;

    public function setControllerMethod(string $controllerMethod)
    {
        $this->controllerMethod = $controllerMethod;
    }

    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    public function run(Request $request, Response $response)
    {
        return $this->handle($request, $response, [$this, $this->getControllerMethod()]);
    }

    public function handle(Request $request, Response $response, callable $handler)
    {
        return $handler($request, $response, $request->getRouteArgs());
    }
}