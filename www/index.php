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

/*$uri = $_SERVER["REQUEST_URI"];

$listOfRoutes = yaml_parse_file("routes.yml");

if (!empty($listOfRoutes[$uri])) {
    $c = 'App\controllers\\'.ucfirst($listOfRoutes[$uri]["controller"]."Controller");
    $a =  $listOfRoutes[$uri]["action"]."Action";
    $pathController = "controllers/".$c.".php";

  if (class_exists($c)) {
        $controller = new $c();

        //Vérifier que la méthode existeet si ce n'est pas le cas faites un die("L'action' n'existe pas")
        if (method_exists($controller, $a)) {
            $controller->$a();
        } else {
            throw new Exception("L'action' n'existe pas");
        }
    } else {
        throw new Exception("La class controller n'existe pas");
    }
} else {
    throw new Exception("Le fichier controller n'existe pas");
}*/