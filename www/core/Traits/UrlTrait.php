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
}