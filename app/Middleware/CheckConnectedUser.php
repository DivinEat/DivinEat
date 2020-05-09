<?php

namespace App\Middleware;

use App\Core\Http\Request;
use App\Core\Middleware\Middleware;

class CheckConnectedUser extends Middleware
{
    public function handle(Request $request, Middleware $handler)
    {
        return $handler->handle($request);
    }

}