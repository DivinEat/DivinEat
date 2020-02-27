<?php

use Src\Core\ConstantLoader;
use Src\Core\Router;

session_start();

define('DS', DIRECTORY_SEPARATOR); // meilleur portabilité sur les différents systeme.
define('ROOT', dirname(__FILE__).DS); // pour se simplifier la vie

require "../src/Core/Autoloader.php";
Autoloader::register();

new ConstantLoader();

new Router($_SERVER);