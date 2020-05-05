<?php

namespace App\Core;

use App\Core\Routing\Router;

class Application
{
    protected array $routeFiles = [];

    protected array $routes = [];

    protected Router $router;

    public function __construct(array $routeFiles)
    {
        $this->router = new Router();

        foreach ($routeFiles as $routeFile)
            $this->addRouteFile($routeFile);

        $this->loadRoutes();
    }

    public function run(): void
    {
        var_dump(Router::getRoutes()->offsetGet(1));die;
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