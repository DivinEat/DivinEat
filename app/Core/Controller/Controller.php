<?php

namespace App\Core\Controller;

use App\Core\Middleware\ControllerMiddleware;

class Controller extends ControllerMiddleware
{
    protected ?array $container;

    public function __construct(array $container)
    {
        $this->container = $container;
    }
}