<?php

namespace App\Core\Routing;

class Route
{
    protected string $type;

    protected string $path;

    protected string $regexPath;

    protected string $controllerName;

    protected string $methodName;

    protected ?string $name;

    protected ?array $middleware;

    public function __construct(string $routeType, string $routePath, string $controllerName, ?string $routeName, ?array $middleware)
    {
        preg_match('/([\\a-z]{1,})@([a-z]{1,})$/i', $controllerName, $matches);

        $this->type = $routeType;
        $this->path = $routePath;
        $this->controllerName = $matches[1];
        $this->methodName = $matches[2];
        $this->name = $routeName;
        $this->middleware = $middleware;

        $this->setRegexRoutePath();
    }

    public function __get(string $name)
    {
        return isset($this->$name) ? $this->$name : null;
    }

    public function setRegexRoutePath(): void
    {
        $this->regexPath = str_replace(
            '/',
            '\/',
            preg_replace('/\{[a-z_]{1,}\}/i', '([0-9a-z\-])', $this->path)
        );
    }

    public function getUrl(): string
    {
        $url = $_SERVER['HTTP_HOST'] . $this->path;
        if (!preg_match('/^http:\/\//', $url))
            $url = 'http://' . $url;

        return $url;
    }

    public function getController(): string
    {
        return $this->controllerName;
    }

    public function getMethod(): string
    {
        return $this->methodName;
    }

    public function getMiddleware(): ?array
    {
        return $this->middleware;
    }
}