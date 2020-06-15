<?php
namespace App;

get('/', 'ExampleController@index');



post('/user/register', 'AuthController@register');