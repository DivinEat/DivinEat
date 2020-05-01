<?php

Route::group(['as' => 'auth', 'namespace' => 'Auth', 'middleware' => ['user.not.connected']], function () {
    Route::get('login', 'LoginController@showLoginForm', 'login');
    Route::post('login', 'LoginController@login');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['user.connected']], function () {
    Route::get('', 'DashboardController@index', 'index');
});