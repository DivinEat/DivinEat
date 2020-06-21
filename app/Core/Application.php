<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Middleware\Middleware;
use App\Core\Middleware\MiddlewareDispatcher;
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
            $route = Router::getRouteByUrlAndType($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']) ?? Router::getRouteByName('not.found');

            $request = new Request($route);

            $response = new MiddlewareDispatcher($this->container, $request);

        } catch (\Exception|\RuntimeException $exception) {
            die('Oups something went wrong ! :p');
        }
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