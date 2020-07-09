<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Middleware\Middleware;
use App\Core\Routing\Router;
use App\Models\User;

class CheckConnectedUser extends Middleware
{
    public function handle(Request $request, Response $response, callable $handler)
    {
        if (Auth::isAuthenticated())
            return Router::redirect('auth.login');

        return $handler($request, $response);
    }

}