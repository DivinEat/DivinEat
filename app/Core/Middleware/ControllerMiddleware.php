<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;

abstract class ControllerMiddleware implements Handler
{
    protected string $controllerMethod;

    public function setControllerMethod(string $controllerMethod)
    {
        $this->controllerMethod = $controllerMethod;
    }

    public function handle(Request $request, Middleware $handler)
    {
        return $this->$this->controllerMethod($request);
    }
}