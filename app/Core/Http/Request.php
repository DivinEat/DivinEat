<?php

namespace App\Core\Http;

use App\Core\Routing\Route;
use App\Core\Routing\Router;

class Request
{
    protected Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function getCurrentRoute(): Route
    {
        return $this->route;
    }

    public function getRouteArgs(): array
    {
        return $this->route->getRouteArgs();
    }
}