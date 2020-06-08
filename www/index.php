<?php

use App\core\ConstantLoader;
use App\core\Router;

session_start();

spl_autoload_register('myAutoloader');

function myAutoloader($class)
{
    $class = str_replace('App', '', $class);
    $class = str_replace('\\', '/', $class);
    if ($class[0] == '/') {
        include substr($class.'.php',1);
    }
    else{
        include $class . '.php';
    }
}

new ConstantLoader();
$router = new Router();