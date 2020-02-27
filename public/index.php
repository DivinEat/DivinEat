<?php

use Src\Core\ConstantLoader;
use Src\Core\Router;

session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)).DS);

require "../src/Core/Autoloader.php";
Autoloader::register();

new ConstantLoader();

new Router($_SERVER);