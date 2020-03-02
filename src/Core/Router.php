<?php

namespace Src\Core;

class Router
{
    protected array $serverArray;

    public function __construct(array $serverArray)
    {
        $this->serverArray = $serverArray;
        $this->urlChecker();
        $this->middlewareChecker();
        $this->loadController();
    }

    protected function urlChecker(): void
    {
        $route = Cache::remember('route_array', function (){
            var_dump(\yaml_parse_file(ROOT.DS . 'routes.yml'));
        });

        echo '<pres>';
        var_dump($route);
    }

    protected function middlewareChecker(): void
    {

    }

    protected function loadController(): void
    {

    }
}