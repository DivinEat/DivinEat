<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;

class Application
{
    protected array $routeFiles = [];

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
        try {
            $route = Router::getRouteByUrl($_SERVER['REQUEST_URI']);
            if ($route === null)
                Router::redirect('not-found');

            $request = new Request($route);
            $response = new Response();

            $this->loadMiddleware($request, $response);
            $this->loadController($request, $response);

            $this->loadView($response);
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

    protected function loadMiddleware(Request $request, Response $response): ?Response
    {
        return $response;
    }

    protected function loadController(Request $request, Response $response): ?Response
    {
        $controllerName =  'App\\Controllers\\' . $request->getCurrentRoute()->getController();
        $methodName = $request->getCurrentRoute()->getMethod();

        $controller = new $controllerName;

        return $controller->$methodName();
    }

    protected function loadView(Response $response)
    {

    }
}