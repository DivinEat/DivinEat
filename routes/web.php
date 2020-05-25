<?php

use App\Core\Routing\Router;

$router->get('', 'HomeController@index', 'home');

$router->group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Auth', 'middleware' => ['user.not.connected']], function (Router $group) {
    $group->get('login', 'LoginController@showLoginForm', 'login');
    $group->post('login', 'LoginController@login');
    $group->get('register', 'RegisterController@showRegisterForm', 'register');
    $group->post('register', 'RegisterController@register');
    $group->get('forgot-password', 'ForgotPasswordController@showRegisterForm', 'forgot.password');
    $group->post('forgot-password', 'ForgotPasswordController@register');
});

$router->group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['user.connected']], function (Router $group) {
    $group->get('', 'DashboardController@index', 'index');
    $group->group(['prefix' => 'menu', 'as' => 'menu.'], function (Router $group) {
        $group->get('', 'MenuController@index', 'index');
        $group->get('create', 'MenuController@create', 'create');
        $group->post('create', 'MenuController@store');
        $group->group(['prefix' => '{menu_id}'], function (Router $group) {
            $group->get('show', 'MenuController@show', 'show');
            $group->get('edit', 'MenuController@edit', 'edit');
            $group->put('edit', 'MenuController@update');
            $group->delete('', 'MenuController@destroy', 'destroy');
        });
    });
});

$router->get('not-found', 'NotFoundController@show', 'not.found');
