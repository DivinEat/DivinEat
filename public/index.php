<?php

declare(strict_types = 1);

use App\Core\Application;
use App\Core\Routing\Router;
use App\Core\ConstantLoader;

define('ROOT', dirname(__DIR__));

session_start();

require "../app/Core/Autoloader.php";
require '../app/Core/helpers.php';

Autoloader::register();
new ConstantLoader("env");

$app = New Application(['web.php', 'customRoutes.php']);

$app->run();
