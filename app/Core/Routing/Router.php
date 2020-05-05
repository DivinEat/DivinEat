<?php

namespace App\Core\Routing;

class Router
{
    private static \ArrayObject $routes;

    protected array $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function group(array $params, callable $function)
    {
        return $function (new Router($this->mergeParams($this->params, $params)));
    }

    public function get(string $routePath, string $controllerName, ?string $routeName = null): Route
    {
        return $this->addRoute('GET', $routePath, $controllerName, $routeName);
    }

    public function post(string $routePath, string $controllerName, ?string $routeName = null): Route
    {
        return $this->addRoute('POST', $routePath, $controllerName, $routeName);
    }

    public function put(string $routePath, string $controllerName, ?string $routeName = null): Route
    {
        return $this->addRoute('POST', $routePath, $controllerName, $routeName);
    }

    public function delete(string $routePath, string $controllerName, ?string $routeName = null): Route
    {
        return $this->addRoute('POST', $routePath, $controllerName, $routeName);
    }

    protected function mergeParams(): array
    {
        return [];
    }

    protected function addRoute(string $routeType, string $routePath, string $controllerName, ?string $routeName): Route
    {
        $route = new Route($routeType, $routePath, $controllerName, $routeName);
        self::getRoutes()->append($route);

        return $route;
    }

    public static function getRoutes(): \ArrayObject
    {
        if (!isset(self::$routes))
            self::$routes = new \ArrayObject();

        return self::$routes;
    }
}