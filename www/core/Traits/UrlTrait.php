<?php

namespace App\Core\Traits;

trait UrlTrait 
{
    public function redirect(string $route, array $params) 
    {        

        header('Status: 301 Moved Permanently', false, 301);              

        $header = 'Location: '.$route;

        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $header .= '?'.$param.'='.$value;
            }
        }
        header($header);      
        exit();
    }

    public function getUrl($controller, $action)
    {
        $listOfRoutes = yaml_parse_file("routes.yml");

        foreach ($listOfRoutes as $url=>$route) {
            if ($route["controller"] == $controller && $route["action"]==$action) {
                return $url;
            }
        }
        throw new Exception("Aucune correspondance pour la route");
        // die("Aucune correspondance pour la route");
    }
}