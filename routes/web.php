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

    $group->get('user.index', 'UserController@index', 'userindex');
    $group->get('user.edit', 'UserController@edit', 'useredit');
    $group->post('user.update', 'UserController@update', 'userdupdate');
    $group->post('user.destroy', 'UserController@destroy', 'userdestroy');

    $group->group(['prefix' => 'user', 'as' => 'user.'], function (Router $group) {
        $group->get('', 'UserController@index', 'index');
        $group->group(['prefix' => '{user_id}'], function (Router $group) {
            $group->get('edit', 'UserController@edit', 'edit');
            $group->post('update', 'UserController@update', 'update');
            $group->delete('', 'UserController@destroy', 'destroy');
        });
    });
});

$router->get('not-found', 'NotFoundController@show', 'not.found');