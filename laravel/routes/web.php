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

Auth::routes();

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('ubicaciones', 'web\UbicacionController');
    Route::resource('roles', 'web\RolController');
    Route::resource('clientes', 'web\ClienteController');
    Route::resource('horarios', 'web\HorarioController');
    Route::resource('empleados', 'web\EmpleadoController');


    // Asignaciones
    Route::get('asignaciones', 'web\AsignacionController@principal');

    // Horarios
    Route::get('asignaciones/horarios/{id}', 'web\AsignacionController@verHorarios');
    Route::get('asignaciones/horarios/{id}/editar', 'web\AsignacionController@editarHorario');
    Route::post('asignaciones/horarios/{id}/asignar', 'web\AsignacionController@asignarHorario');
    Route::delete('asignaciones/horarios/{id}/eliminar/{id_horario}', 'web\AsignacionController@quitarHorario');

    // Clientes
    Route::get('asignaciones/clientes/{id}/editar', 'web\AsignacionController@editarCliente');
    Route::post('asignaciones/clientes/{id}/asignar', 'web\AsignacionController@asignarCliente');
    Route::delete('asignaciones/clientes/{id}/eliminar/{id_horario}', 'web\AsignacionController@quitarCliente');
    Route::get('asignaciones/clientes/{id}/{cliente_id}', 'web\AsignacionController@verCliente');

    // Ubicaiones
    Route::get('asignaciones/ubicacion/{id}', 'web\AsignacionController@verUbicacion');
    Route::patch('asignaciones/ubicacion/{id}/asignar', 'web\AsignacionController@asignarUbicacion');

    // Reportes
    Route::get('reportes/prueba', 'web\ReporteController@sumar');

});

