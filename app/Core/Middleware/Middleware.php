<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;

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
}