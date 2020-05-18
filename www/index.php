<?php

use App\Core\ConstantLoader;

session_start();

function myAutoloader($class)
{
    // echo $class .'<br>';
    $class = str_replace('App', '', $class);
    // echo $class .'<br>';
    $class = str_replace('\\', '/', $class);

    // echo $class;

    if ($class[0] == '/') {
        include substr($class.'.php', 1);
    } else {
        include $class.'.php';
    }
    
    // if (file_exists("core/".$class.".class.php")) {
    //     include "core/".$class.".class.php";
    // } elseif (file_exists("models/".$class.".model.php")) {
    //     include "models/".$class.".model.php";
    // }
}

spl_autoload_register("myAutoloader");


new ConstantLoader();


//http://localhost/user/add -> $c = user et $a add
//http://localhost/user -> $c = user et $a default
//http://localhost -> $c = default et $a default

$uri = $_SERVER["REQUEST_URI"];


$listOfRoutes = yaml_parse_file("routes.yml");

try {
    if (!empty($listOfRoutes[$uri])) {
        $c =  'App\Controllers\\'.ucfirst($listOfRoutes[$uri]["controller"]."Controller");
        $a =  $listOfRoutes[$uri]["action"]."Action";

        //Vérifier que la class existe, si ce n'est pas le cas faites un die("La class controller n'existe pas")
        try {
            if (class_exists($c)) {
                $controller = new $c();
                
                //Vérifier que la méthode existe, si ce n'est pas le cas faites un die("L'action' n'existe pas")
                try {        
                    if (method_exists($controller, $a)) {

                        $controller->$a();

                    } else {
                        throw new Exception("L'action' n'existe pas");
                        // die("L'action' n'existe pas");
                    }
                } catch(Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                throw new Exception("La class controller n'existe pas");
                // die("La class controller n'existe pas");
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    } else {
        throw new Exception("L'url n'existe pas : Erreur 404");
        // die("L'url n'existe pas : Erreur 404");
    }
} catch(Exception $e) {
    echo $e->getMessage();
}
