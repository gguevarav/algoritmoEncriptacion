<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/usuarios', 'UsuarioController@index');
$router->post('/usuarios', 'UsuarioController@store');
$router->get('/usuarios/{id}', 'UsuarioController@show');
$router->put('/usuarios/{id}', 'UsuarioController@update');
$router->delete('/usuarios/{id}', 'UsuarioController@destroy');
// Desencriptado
$router->post('/desencriptar', 'UsuarioController@desencriptarDatos');
// Encriptado
$router->post('/encriptar', 'UsuarioController@encriptarDatos');

//Route::get('usuarios', 'UsuarioController@index');
