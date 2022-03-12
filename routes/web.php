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

    $router->post('auth/login'  , '\Core\Controllers\AuthController@login');
    $router->post('auth/logout' , '\Core\Controllers\AuthController@logout');
    $router->post('auth/me'     , '\Core\Controllers\AuthController@me');

    // Test authentication
    $router->group(['middleware' => ['auth']], function() use ($router){

        $router->get('/product'        , '\App\Product\Controllers\ProductController@getResources');
        $router->get('/product/{id}'   , '\App\Product\Controllers\ProductController@getResource');
        $router->post('/product'       , '\App\Product\Controllers\ProductController@createResource');
        $router->put('/product'        , '\App\Product\Controllers\ProductController@updateResource');
        $router->delete('/product'     , '\App\Product\Controllers\ProductController@deleteResource');
        
    });

    // Categories
    $router->get('/category'        , '\App\category\Controllers\categoryController@getResources');
    $router->get('/category/{id}'   , '\App\category\Controllers\categoryController@getResource');
    $router->post('/category'       , '\App\category\Controllers\categoryController@createResource');
    $router->put('/category'        , '\App\category\Controllers\categoryController@updateResource');
    $router->delete('/category'     , '\App\category\Controllers\categoryController@deleteResource');
    
});
