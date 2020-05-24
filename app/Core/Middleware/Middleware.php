<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;

abstract class Middleware implements Handler
{
    protected ?Handler $next;

    public function __construct(Handler $next = null)
    {
        $this->next = $next;
    }

    public function setNext(Handler $next)
    {
        $this->next = $next;
    }

    public function run(Request $request, Response $response)
    {
        if ($this->next instanceof ControllerMiddleware)
        {
            $methodName = $this->next->getControllerMethod();
            return $this->next->$methodName($request, $response,$this->next->getArgs());
        }

        return $this->handle($request, $response, $this->next->run());
    }
}