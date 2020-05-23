<?php 

namespace App\core;

use App\core\Exceptions\BDDException;
use Exception;
use App\controllers\ErrorController;

class Router 
{
    private $params = [];
    private $routes;
    private $routeCalled;

    public function __construct()
    {
        $this->getRoutes();
        $this->manageUrl();
    }

    public function getRoutes()
    {
        $uriParams = explode('?', $_SERVER['REQUEST_URI'], 2);

        $this->routeCalled = $uriParams[0];

        if(isset($uriParams[1]))
            $this->params = $this->getParams($uriParams[1]);
        $this->routes =  yaml_parse_file("routes.yml");

        return;
    }

    public function manageUrl()
    {
        $errorController = new ErrorController();

        if (!empty($this->routes[$this->routeCalled])) {
            $c =  'App\controllers\\'.ucfirst($this->routes[$this->routeCalled]["controller"]."Controller");
            $a =  $this->routes[$this->routeCalled]["action"]."Action";
        
                try {
                    $controller = new $c();
                } catch( \Throwable $t) {
                    $errorController->controllerNotExist();
                }
               
                if (method_exists($controller, $a)) {
                    try {
                        $controller->$a($this->params);
                    } catch(NotFoundException $e) {
                        echo $e->getMessage();
                    }
                } else {
                    $errorController->actionNotExist();
                }
        } else {
            $errorController->urlNotExist();
        }
        
    }

    function getParams($params) {
        $explodedParams = explode('&', $params, 2);
        $result = [];
        foreach($explodedParams as $param) {
            $data = explode("=", $param);
            if(isset($data[1]))
            $result[$data[0]] =  $data[1];
        }
        return $result;
    }
}