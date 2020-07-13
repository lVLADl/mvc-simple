<?php
namespace App;

get('/', 'ExampleController@index');


post('/user/register', 'AuthController@register')->name('register');
post('/user/login', 'AuthController@login')->name('login');
get('/user/logout', 'AuthController@logout')->name('logout');

get('/internal_server_error', 'ErrorController@serverError');

/* Dashboard */
get('/admin', 'DashboardController@index')->name('admin:index');