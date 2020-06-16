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

    $group->get('menu.index', 'MenuController@index', 'menuindex');
    $group->get('menu.create', 'MenuController@create', 'menucreate');
    $group->get('menu.edit', 'MenuController@edit', 'menuedit');
    $group->post('menu.update', 'MenuController@update', 'menudupdate');
    $group->post('menu.destroy', 'MenuController@destroy', 'menudestroy');
    $group->post('menu.store', 'MenuController@store', 'menustore');

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

    $group->get('article.create', 'ArticleController@create', 'articlecreate');
    $group->get('article.index', 'ArticleController@index', 'articleindex');
    $group->get('article.edit', 'ArticleController@edit', 'articleedit');
    $group->post('article.store', 'ArticleController@store', 'articlestore');
    $group->post('article.update', 'ArticleController@update', 'articleupdate');
    $group->post('article.destroy', 'ArticleController@destroy', 'articledestroy');

    $group->group(['prefix' => 'article', 'as' => 'article.'], function (Router $group) {
        $group->get('', 'ArticleController@index', 'index');
        $group->get('create', 'ArticleController@create', 'create');
        $group->group(['prefix' => '{article_id}'], function (Router $group) {
            $group->get('edit', 'ArticleController@edit', 'edit');
            $group->post('update', 'ArticleController@update', 'update');
            $group->delete('', 'ArticleController@destroy', 'destroy');
        });
    });
});

$router->get('not-found', 'NotFoundController@show', 'not.found');