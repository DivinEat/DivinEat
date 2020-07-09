<?php

namespace App\Core\Routing;

use App\Core\Collection;

class Router
{
    private static Collection $routes;

    protected array $params = ['prefix' => '/', 'as' => '', 'namespace' => '', 'middleware' => []];

    public function __construct(array $params = [])
    {
        $this->params = $this->mergeParams($params);
    }

    public function group(array $params, callable $function)
    {
        return $function (new Router($this->mergeParams($params)));
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

    protected function mergeParams(array $params): array
    {
        $params['as'] = isset($params['as']) ? $this->params['as'] . $params['as'] : $this->params['as'];

        $params['namespace'] = isset($params['namespace']) ? preg_replace(
            '/[\\\]{2,}/',
            '\\',
            $this->params['namespace'] . $params['namespace'] . '\\'
            ) : $this->params['namespace'];

        $params['prefix'] = isset($params['prefix']) ? preg_replace(
            '/[\/]{2,}/',
            '/',
            $this->params['prefix'] . '/' . $params['prefix'] . '/'
            ) : $this->params['prefix'];

        $params['middleware'] = isset($params['middleware']) && is_array($params['middleware']) ? array_merge(
            $this->params['middleware'],
            $params['middleware']
        ) : $this->params['middleware'];

        return $params;
    }

    protected function addRoute(string $routeType, string $routePath, string $controllerName, ?string $routeName): Route
    {
        $route = new Route(
            $routeType,
            $this->params['prefix'] . $routePath,
            $this->params['namespace'] . $controllerName,
            $routeName !== null ? $this->params['as'] . $routeName : '',
            $this->params['middleware']
        );

        self::getRoutes()->append($route);

        return $route;
    }

    public static function getRoutes(): Collection
    {
        if (!isset(self::$routes))
            self::$routes = new Collection();

        return self::$routes;
    }

    public static function getRouteList(): array
    {
        $routeList = [];

        foreach (self::getRoutes()->getIterator() as $route) {
            array_push($routeList, [
                'Name' => $route->getName(),
                'Type' => $route->getType(),
                'Url' => $route->getUrl(),
                'Controller' => $route->getController(),
                'Method' => $route->getMethod(),
                'Middleware' => $route->getMiddleware(),
            ]);
        }

        return $routeList;
    }

    public static function getRouteByName(string $routeName, $args = []): ?Route
    {
        foreach (self::getRoutes()->getIterator() as $route)
            if ($route->name === $routeName)
                return (clone $route)->setArgs($args);

        return null;
    }

    public static function getRouteByUrl(string $requestUri): ?Route
    {
        foreach (self::getRoutes()->getIterator() as $route)
            if (preg_match('/^' . $route->regexPath . '$/', $requestUri))
                return clone $route;

        return null;
    }

    public static function getRouteByUrlAndType(string $requestUri, string $type): ?Route
    {
        foreach (self::getRoutes()->getIterator() as $route)
            if (preg_match('/^' . $route->regexPath . '$/', $requestUri) && $route->getType() === $type)
                return clone $route;

        return null;
    }

    public static function redirect(string $routeName, array $args = []): void
    {
        $route = self::getRouteByName($routeName);
        if ($route === null)
            throw new \Exception('La redirection est impossible, la route n\'existe pas');

        header('Location: ' . $route->setArgs($args)->getUrl());
    }
}