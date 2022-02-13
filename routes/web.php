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

$router->get('/', function(){
    return "Front page of API";
});

$router->group(['prefix' => 'api'], function() use ($router){

    $router->get('/user', '\App\User\Controllers\UserController@getAll');
    $router->get('/user/{id}', '\App\User\Controllers\UserController@get');
    $router->post('/user', '\App\User\Controllers\UserController@post');
    
});
