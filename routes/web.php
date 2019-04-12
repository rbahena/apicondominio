<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Métodos de usuario Registrar y Login
Route::post('/api/register','UserController@register');
Route::post('/api/login','UserController@login');

//Ver todos los comentarios del foro
Route::get('/api/verTodasPublicaciones','PublicacionesController@index');

//Agregar comentarios al foro
Route::post('/api/agregarPublicacion','PublicacionesController@agregarPublicacion');

//Ver publicacion por Id de publicaciones
Route::get('/api/verPublicacion/{id}','PublicacionesController@verPublicacion');

//Actualizar registros de publicaciones
Route::put('/api/actualizarPublicacion/{id}','PublicacionesController@actualizarPublicacion');

//Elimina (actualiza) registro de la BD
Route::delete('/api/deletePublicacion/{id}','PublicacionesController@deletePublicacion');

//Actualizar BAJA de registros de publicaciones
Route::post('/api/bajaPublicacion/{id}','PublicacionesController@bajaPublicacion');
