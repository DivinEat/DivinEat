<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Middleware\Middleware;
use App\Core\Middleware\MiddlewareDispatcher;
use App\Core\Routing\Route;
use App\Core\Routing\Router;

class Application
{
    protected array $routeFiles = [];

    protected Router $router;

    protected array $container = [];

    public function __construct(array $routeFiles)
    {
        $this->router = new Router();

        foreach ($routeFiles as $routeFile)
            $this->addRouteFile($routeFile);

        $this->loadRoutes();
    }

    public function run(): void
    {
        try {
            $request = new Request($this->getAdequateRoute(
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD']
            ));

            new MiddlewareDispatcher($this->container, $request);

        } catch (\Exception|\RuntimeException $exception) {
            die('Oups something went wrong ! :p');
        }
    }

    protected function getAdequateRoute(string $requestUri, string $requestMethod): Route
    {
        $route = Router::getRouteByUrlAndType($requestUri, $requestMethod);

        if (null === $route)
            return Router::getRouteByName('not.found');

        if ($route->getType() === 'POST' &&
            (! isset($_POST['csrf_token']) || ! Csrf::checkUserCsrfToken($_POST['csrf_token'])))
            return Router::getRouteByName('unauthorized');

        return $route;
    }

    protected function addRouteFile(string $fileName): void
    {
        if (file_exists(ROOT . '/routes/' . $fileName))
            $this->routeFiles[] = ROOT . '/routes/' . $fileName;
    }

    protected function loadRoutes(): void
    {
        foreach ($this->routeFiles as $routeFile)
            $this->loadRoute($routeFile);
    }

    protected function loadRoute($routeFile): void
    {
        $router = $this->router;

        include $routeFile;
    }
}