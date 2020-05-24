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

    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function handle(Request $request, Response $response, callable $handler)
    {
        return $this->$this->controllerMethod($request);
    }
}