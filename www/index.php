<?php

use App\Core\ConstantLoader;
use App\Core\Router;

session_start();

function myAutoloader($class)
{
    $class = str_replace('App', '', $class);
    $class = str_replace('\\', '/', $class);

    if ($class[0] == '/') {
        include substr($class.'.php', 1);
    } else {
        include $class.'.php';
    }
}

spl_autoload_register("myAutoloader");

new ConstantLoader();
$router = new Router();

$router->executeAction();

//http://localhost/user/add -> $c = user et $a add
//http://localhost/user -> $c = user et $a default
//http://localhost -> $c = default et $a default

