<?php

use App\Core\Routing\Router;
use App\Managers\NavbarElementManager;


$customRoutes = (new NavbarElementManager())->findAll();

$router->group(['middleware' => ['installed'], 'as' => 'custom.'], function (Router $router) {
    $customRoutes = (new NavbarElementManager())->findAll();
    foreach ($customRoutes as $customRoute) {
        $slug = strtolower($customRoute->getSlug());
        if (NULL === Router::getRouteByName($slug))
            $router->get($slug, 'Admin\PageController@displayPageContent', $slug);
    }
});