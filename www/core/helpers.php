<?php
namespace App\core;
use App\traits\ImgTrait;

class helpers
{
    public static function getUrl($controller, $action)
    {
        $listOfRoutes = yaml_parse_file("routes.yml");

        foreach ($listOfRoutes as $url=>$route) {
            if ($route["controller"] == $controller && $route["action"]==$action) {
                return $url;
            }
        }

    }

    public function getHtmlUrl($controller, $action){
        $url = $this->getUrl($controller, $action);

        return "<a href='$url'>".getImg("https://ibb.co/8N7Ny19", "img")."</a>";
    }
}
