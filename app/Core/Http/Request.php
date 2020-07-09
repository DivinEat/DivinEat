<?php

namespace App\Core\Http;

use App\Core\Routing\Route;
use App\Core\Routing\Router;

class Request
{
    protected Route $route;

    protected array $parsedBody;

    protected string $inputPrefix;

    public function __construct(Route $route)
    {
        $this->route = $route;

        $this->parseBody();
    }

    public function getCurrentRoute(): Route
    {
        return $this->route;
    }

    public function getRouteArgs(): array
    {
        return $this->route->getRouteArgs();
    }

    public function get(string $propertyName = null)
    {
        if (null === $propertyName)
            return $this->parsedBody;

        if (isset($this->parsedBody[$this->inputPrefix . $propertyName]))
            return $this->parsedBody[$this->inputPrefix . $propertyName];

        return $this->parsedBody[$propertyName] ?? null;
    }

    public function setInputPrefix(string $inputPrefix): Request
    {
        $this->inputPrefix = $inputPrefix;

        return $this;
    }

    protected function parseBody(): void
    {
        $this->parsedBody = array_merge($_GET, $_POST);
    }
}