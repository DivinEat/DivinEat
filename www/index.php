<?php

use App\core\ConstantLoader;

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


//http://localhost/user/add -> $c = user et $a add
//http://localhost/user -> $c = user et $a default
//http://localhost -> $c = default et $a default

$uri = $_SERVER["REQUEST_URI"];


$listOfRoutes = yaml_parse_file("routes.yml");


if (!empty($listOfRoutes[$uri])) {
    $c = 'App\controllers\\'.ucfirst($listOfRoutes[$uri]["controller"]."Controller");
    $a =  $listOfRoutes[$uri]["action"]."Action";
    $pathController = "controllers/".$c.".php";

  if (class_exists($c)) {
        $controller = new $c();

        //Vérifier que la méthode existeet si ce n'est pas le cas faites un die("L'action' n'existe pas")
        if (method_exists($controller, $a)) {

            //EXEMPLE :
            //$controller est une instance de la class UserController
            //$a = userAction est une méthode de la class UserController
            $controller->$a();
        } else {
            die("L'action' n'existe pas");
        }
    } else {
        die("La class controller n'existe pas");
    }
} else {
    die("Le fichier controller n'existe pas");
}
