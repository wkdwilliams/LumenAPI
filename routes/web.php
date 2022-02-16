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

$router->get('/test', ['middleware' => ['auth'], function() use ($router){
    dd('Success');
}]);

$router->group(['prefix' => 'api'], function() use ($router){

    $router->get('/user'        , '\App\User\Controllers\UserController@getResources');
    $router->get('/user/{id}'   , '\App\User\Controllers\UserController@getResource');
    $router->post('/user'       , '\App\User\Controllers\UserController@createResource');
    $router->put('/user'        , '\App\User\Controllers\UserController@updateResource');
    $router->delete('/user'     , '\App\User\Controllers\UserController@deleteResource');
    
});
