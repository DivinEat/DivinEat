<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;

abstract class Middleware
{
    protected Middleware $next;

    abstract public function handle(Request $request, Middleware $handler);
}