<?php 

namespace App\Core;

use App\Core\Exceptions\BDDException;
use Exception;
use App\Controllers\ErrorController;

class Router 
{

    public function executeAction() 
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

        $listOfRoutes = yaml_parse_file("routes.yml");

        try {
            if (!empty($listOfRoutes[$uri])) {
                $c =  'App\Controllers\\'.ucfirst($listOfRoutes[$uri]["controller"]."Controller");
                $a =  $listOfRoutes[$uri]["action"]."Action";

                //Vérifier que la class existe, si ce n'est pas le cas faites un die("La class controller n'existe pas")
                if (class_exists($c)) {
                    $controller = new $c();
                    
                    //Vérifier que la méthode existe, si ce n'est pas le cas faites un die("L'action' n'existe pas")
    
                        if (method_exists($controller, $a)) {
                                $controller->$a();
                        } else {
                            throw new Exception("L'action' n'existe pas");
                            // die("L'action' n'existe pas");
                        }

                } else {
                    throw new Exception("La class controller n'existe pas");
                    // die("La class controller n'existe pas");
                }

            } else {
                throw new Exception("L'url n'existe pas : Erreur 404");
                // die("L'url n'existe pas : Erreur 404");
            }
        } catch(BDDException $e) {
            $errorController = new ErrorController();
            $errorController->displayErrorAction('bdd-error', $e->getMessage());
        }
        catch(Exception $e) {
            $errorController = new ErrorController();
            $errorController->displayErrorAction('error', $e->getMessage());
        }   
    }
}