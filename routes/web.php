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
//paises
$router->get('/paises', 'PaisesController@index');
$router->get('/paises/{id}', 'PaisesController@ver');
$router->post('/paises', 'PaisesController@Guardar');
$router->delete('/paises/{id}', 'PaisesController@eliminar');
$router->post('/paises/{id}', 'PaisesController@actualizar');
//usuario
$router->get('/usuario', 'UserController@index');
$router->post('/usuario', 'UserController@Guardar');
$router->post('/usuario/{id}', 'UserController@Modificar');
$router->put('/usuario/{id}/', 'UserController@actualizar');
$router->delete('/usuario/{id}', 'UserController@eliminar');
$router->get('/usuario/{id}', 'UserController@ver');
// categorias
$router->get('/categorias', 'CategoriasController@index');
$router->get('/categorias/{id}', 'CategoriasController@ver');
$router->post('/categorias', 'CategoriasController@Guardar');
$router->delete('/categorias/{id}', 'CategoriasController@eliminar');
$router->put('/categorias/{id}', 'CategoriasController@actualizar');
// comentarios
$router->get('/comenta', 'ComentariosController@index');
$router->get('/comenta/{id}', 'ComentariosController@mostrar');
$router->get('/comenta/{id}/{num}', 'ComentariosController@ver');
$router->post('/comenta', 'ComentariosController@Guardar');
$router->delete('/comenta/{id}', 'ComentariosController@eliminar');
$router->put('/comenta/{id}', 'ComentariosController@actualizar');




// Periodo_lugar
$router->get('/pl', 'Periodo_lugarController@index');
$router->get('/pl/{id}', 'Periodo_lugarController@ver');
$router->post('/pl', 'Periodo_lugarController@Guardar');
$router->post('/pl/{id}', 'Periodo_lugarController@Finalizar');
$router->put('/pl/{id}/', 'Periodo_lugarController@actualizar');
$router->delete('/pl/{id}', 'Periodo_lugarController@eliminar');
$router->get('/pf', 'Periodo_lugarController@final');
// lugar
$router->get('/l', 'LugarController@index');
$router->post('/l', 'LugarController@Guardar');
$router->put('/l/{id}/', 'LugarController@actualizar');
$router->get('/l/{num}/{cadena}', 'LugarController@mostrar');
$router->get('/l/{id}', 'LugarController@ver');
$router->delete('/l/{id}', 'LugarController@eliminar');
// lugar_categorias
$router->get('/lc', 'Lugar_categoriasController@index');
$router->get('/lc/{id}', 'Lugar_categoriasController@ver');
$router->post('/lc', 'Lugar_categoriasController@Guardar');
$router->delete('/lc/{id}', 'Lugar_categoriasController@eliminar');
$router->put('/lc/{id}', 'Lugar_categoriasController@actualizar');
// Imagenes
$router->get('/imagen', 'ImagenesController@index');
$router->get('/imagen/{id}', 'ImagenesController@ver');
$router->post('/imagen', 'ImagenesController@Guardar');
$router->delete('/imagen/{id}', 'ImagenesController@eliminar');
$router->put('/imagen/{id}', 'ImagenesController@actualizar');

//general
$router->get('/general/{num}/{id}', 'GeneralController@ver');

//reserva
$router->get('/reserva', 'ReservaController@index');
$router->get('/reserva/{id}', 'ReservaController@ver');
$router->post('/reserva', 'ReservaController@guardar');
//Notificacion
$router->get('/notificacion', 'NotificacionController@index');
$router->get('/notificacion/{id}', 'NotificacionController@ver');
$router->post('/notificacion', 'NotificacionController@guardar');
