<?php

use App\Core\ConstantLoader;
use App\Core\Routing\Router;

define('ROOT', dirname(__DIR__));

session_start();

require "../app/Core/Autoloader.php";
Autoloader::register();

new ConstantLoader();

new Router($_SERVER);