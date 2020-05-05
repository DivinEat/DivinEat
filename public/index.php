<?php

declare(strict_types = 1);

use App\Core\Application;

define('ROOT', dirname(__DIR__));

session_start();

require "../app/Core/Autoloader.php";
Autoloader::register();

$app = New Application(['web.php']);

$app->run();
