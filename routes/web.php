<?php

use App\Core\Routing\Router;

$router->group(['prefix' => 'install', 'as' => 'install.', 'middleware' => ['not.installed']], function (Router $group) {
    $group->get('', 'InstallController@showDatabaseForm', 'show-database-form');
    $group->post('', 'InstallController@storeDatabaseForm', 'store-database-form');
    $group->get('mails', 'InstallController@showSMTPForm', 'show-smtp-form');
    $group->post('mails', 'InstallController@storeSMTPForm', 'store-smtp-form');
    $group->get('informations', 'InstallController@showGeneralForm', 'show-general-form');
    $group->post('informations', 'InstallController@storeGeneralForm', 'store-general-form');
});

$router->group(['middleware' => ['installed']], function (Router $router) {
    $router->get('', 'HomeController@index', 'home');
    $router->get('menus', 'HomeController@menus', 'menus');

    $router->group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['user.connected']], function (Router $group) {
        $group->get('', 'UserController@edit', 'edit');
        $group->post('update', 'UserController@update', 'update');
    });
  
    $router->group(['prefix' => 'contact', 'as' => 'contact.'], function (Router $group) {
          $group->get('', 'ContactController@index', 'index');
          $group->post('store', 'ContactController@store', 'store');
    });
  
    $router->group(['prefix' => 'actualites', 'as' => 'actualites.'], function (Router $group) {
        $group->get('', 'ArticleController@index', 'index');
        $group->group(['prefix' => '{article_id}'], function (Router $group) {
            $group->get('show', 'ArticleController@show', 'show');
        });
    });

    $router->group(['prefix' => 'order', 'as' => 'order.'], function (Router $group) {
        $group->get('', 'OrderController@index', 'index')->addMiddleware('user.connected');
        $group->get('create', 'OrderController@create', 'create');
        $group->post('store', 'OrderController@store', 'store');
    });
  
    $router->group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Auth'], function (Router $group) {
        $group->group(['middleware' => ['user.connected']], function (Router $group) {
            $group->post('logout', 'LogoutController@logout', 'logout');
        });
        $group->group(['middleware' => ['user.not.connected']], function (Router $group) {
            $group->get('login', 'LoginController@showLoginForm', 'show-login');
            $group->post('login', 'LoginController@login', 'login');
            $group->get('register', 'RegisterController@showRegisterForm', 'show-register');
            $group->post('register', 'RegisterController@register', 'register');
            $group->get('forgot-password', 'ForgotPasswordController@showForgotPassword', 'show-forgot-password');
            $group->post('forgot-password', 'ForgotPasswordController@forgotPassword', 'forgot-password');
        });
    });

    $router->group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['user.connected', 'user.is.admin']], function (Router $group) {
        $group->get('', 'DashboardController@index', 'index');

        $group->group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function (Router $group) {
            $group->get('', 'DashboardController@index', 'index');
            $group->get('month', 'DashboardController@month', 'month');
            $group->get('year', 'DashboardController@year', 'year');
            $group->get('all', 'DashboardController@all', 'all');
        });


        $group->group(['prefix' => 'menu', 'as' => 'menu.'], function (Router $group) {
            $group->get('', 'MenuController@index', 'index');
            $group->get('create', 'MenuController@create', 'create');
            $group->post('store', 'MenuController@store', 'store');
            $group->group(['prefix' => '{menu_id}'], function (Router $group) {
                $group->get('edit', 'MenuController@edit', 'edit');
                $group->post('update', 'MenuController@update', 'update');
                $group->delete('', 'MenuController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'image', 'as' => 'image.'], function (Router $group) {
            $group->get('', 'ImageController@index', 'index');
            $group->get('create', 'ImageController@create', 'create');
            $group->post('store', 'ImageController@store', 'store');
            $group->group(['prefix' => '{image_id}'], function (Router $group) {
                $group->delete('', 'ImageController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'elementmenu', 'as' => 'elementmenu.'], function (Router $group) {
            $group->get('create', 'ElementMenuController@create', 'create');
            $group->post('store', 'ElementMenuController@store', 'store');
            $group->group(['prefix' => '{elementmenu_id}/category/{categorie_id}'], function (Router $group) {
                $group->get('edit', 'ElementMenuController@edit', 'edit');
                $group->post('update', 'ElementMenuController@update', 'update');
                $group->delete('', 'ElementMenuController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'user', 'as' => 'user.'], function (Router $group) {
            $group->get('', 'UserController@index', 'index');
            $group->group(['prefix' => '{user_id}'], function (Router $group) {
                $group->get('edit', 'UserController@edit', 'edit');
                $group->post('update', 'UserController@update', 'update');
                $group->delete('', 'UserController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'article', 'as' => 'article.'], function (Router $group) {
            $group->get('', 'ArticleController@index', 'index');
            $group->get('create', 'ArticleController@create', 'create');
            $group->post('store', 'ArticleController@store', 'store');
            $group->group(['prefix' => '{article_id}'], function (Router $group) {
                $group->get('edit', 'ArticleController@edit', 'edit');
                $group->post('update', 'ArticleController@update', 'update');
                $group->delete('', 'ArticleController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'horaire', 'as' => 'horaire.'], function (Router $group) {
            $group->get('', 'HoraireController@index', 'index');
            $group->get('create', 'HoraireController@create', 'create');
            $group->post('store', 'HoraireController@store', 'store');
            $group->group(['prefix' => '{horaire_id}'], function (Router $group) {
                $group->get('edit', 'HoraireController@edit', 'edit');
                $group->post('update', 'HoraireController@update', 'update');
                $group->delete('', 'HoraireController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'order', 'as' => 'order.'], function (Router $group) {
            $group->get('', 'OrderController@index', 'index');
            $group->get('create', 'OrderController@create', 'create');
            $group->post('store', 'OrderController@store', 'store');
            $group->group(['prefix' => '{order_id}'], function (Router $group) {
                $group->get('edit', 'OrderController@edit', 'edit');
                $group->post('update', 'OrderController@update', 'update');
                $group->delete('', 'OrderController@destroy', 'destroy');
            });
        });

        $group->group(['prefix' => 'configuration', 'as' => 'configuration.'], function (Router $group) {
            $group->get('', 'ConfigurationController@index', 'index');
            $group->post('store', 'ConfigurationController@store', 'store');
            $group->group(['prefix' => '{config_id}'], function (Router $group) {
                $group->get('edit', 'ConfigurationController@edit', 'edit');
                $group->post('update', 'ConfigurationController@update', 'update');
            });
        });
    });
});

$router->get('not-found', 'NotFoundController@show', 'not.found');
$router->get('unauthorized', 'UnauthorizedController@show', 'unauthorized');