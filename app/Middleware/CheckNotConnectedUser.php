<?php

namespace App\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Middleware\Middleware;

class CheckNotConnectedUser extends Middleware
{
    public function handle(Request $request, Response $response, callable $handler)
    {
        return $handler->handle($request);
    }
}