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
            preg_replace('/\{[a-z_]{1,}\}/i', '([0-9a-z\-]*)', $this->path)
        );
    }

    public function getRouteArgs(): array
    {
        if ($this->countNecessaryArguments() === 0)
            return [];

        if (preg_match_all('/' . $this->regexPath . '/', $_SERVER['REQUEST_URI'], $matchedArgs) !== 1)
            throw new \Exception('Impossible de récupérer les arguments.');
        array_shift($matchedArgs);

        preg_match_all('/{([_a-z]*)}/', $this->path, $matchedargsName);
        array_shift($matchedargsName);

        if (count($matchedArgs) !== count($matchedargsName[0]))
            throw new \Exception('Le nombre d\'arguments et le nombre de nom d\'argmuents ne correspondent pas.');

        $args = [];
        for ($i = 0; $i < count($matchedArgs); $i++)
           $args = array_merge($args, [$matchedargsName[0][$i] => $matchedArgs[$i][0]]);

        return $args;
    }

    public function addMiddleware(string $middlewareName): Route
    {
        if (! in_array($middlewareName, $this->middleware))
            $this->middleware[] = $middlewareName;

        return $this;
    }

    public function addMiddlewares(array $middlewaresName): Route
    {
        array_map(function ($middlewareName) {
            $this->addMiddleware($middlewareName);
        }, $middlewaresName);

        return $this;
    }

    public function setArgs($args = []): Route
    {
        if ($this->countNecessaryArguments() === 0)
            return $this;

        if (! is_array($args))
            $args = [$args];

        if (count($args) !== $this->countNecessaryArguments())
            throw new \Exception('Mauvais nombre d\'arguments passé pour la route.');

        $this->mergeRouteUrlWithArgs($args);

        return $this;
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

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->methodName;
    }

    public function getMiddleware(): ?array
    {
        return $this->middleware;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function countNecessaryArguments(): int
    {
        return preg_match_all('/\{[_a-z]*\}/', $this->path);
    }

    protected function mergeRouteUrlWithArgs(array $args): Route
    {

        foreach ($args as $arg)
            $this->path = preg_replace('/\{[_a-z]*\}/', $arg, $this->path, 1);

        return $this;
    }
}