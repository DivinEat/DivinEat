<?php

namespace App\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Middleware\Middleware;
use App\Core\Routing\Router;

class CheckNotInstall extends Middleware
{
    public function handle(Request $request, Response $response, callable $handler)
    {
        if (! defined('INSTALLATION_SUCCESS') || INSTALLATION_SUCCESS != true)
            return Router::redirect('install.show-database-form');

        return $handler($request, $response);
    }
}