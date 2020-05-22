<?php 

namespace App\Core;

use App\Core\Exceptions\BDDException;
use Exception;

class Router 
{
    use Traits\UrlTrait;

    public function executeAction() 
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

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
                                try {
                                    $controller->$a();
                                } catch(BDDException $e) {
                                    $this->redirect('bdd-error', ['message' => $e->getMessage()]);
                                }
                                catch(Exception $e) {
                                    $this->redirect('error', ['message' => $e->getMessage()]);
                                }   
                            } else {
                                throw new Exception("L'action' n'existe pas");
                                // die("L'action' n'existe pas");
                            }
                        } catch(Exception $e) {
                            $this->redirect('error', ['message' => $e->getMessage()]);
                        }
                    } else {
                        throw new Exception("La class controller n'existe pas");
                        // die("La class controller n'existe pas");
                    }
                } catch(Exception $e) {
                    $this->redirect('error', ['message' => $e->getMessage()]);
                }
            } else {
                throw new Exception("L'url n'existe pas : Erreur 404");
                // die("L'url n'existe pas : Erreur 404");
            }
        } catch(Exception $e) {
            $this->redirect('not-found', ['message' => $e->getMessage()]);
        }
    }
}