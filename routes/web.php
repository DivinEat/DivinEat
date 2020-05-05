<?php

use App\Core\Routing\Router;


$router->get('', 'HomeController@index', 'home');

$router->group(['as' => 'auth', 'namespace' => 'Auth', 'middleware' => ['user.not.connected']], function (Router $group) {
    $group->get('login', 'LoginController@showLoginForm', 'login');
    $group->post('login', 'LoginController@login');
});

$router->group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['user.connected']], function (Router $group) {
    $group->get('', 'DashboardController@index', 'index');
});

$router->get('not-found', 'NotFoundController@show', 'not-found');
