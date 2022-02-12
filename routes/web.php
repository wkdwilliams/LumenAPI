<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\User\DataMappers\UserDataMapper;

$router->get('/', function(){
    return "Front page of API";
});

$router->get('/user/{id}', '\App\User\Controllers\UserController@get');
$router->get('/test', '\App\User\Controllers\UserController@test');
