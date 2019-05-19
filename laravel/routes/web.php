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
    Route::get('empleados/horarios/{id}', 'web\AsignacionController@horariosAsignados');
    Route::get('empleados/horarios/{id}/editar', 'web\AsignacionController@editarHorario');
    Route::post('empleados/horarios/{id}/asignar', 'web\AsignacionController@asignarHorario');
    Route::delete('empleados/horarios/{id}/eliminar/{id_horario}', 'web\AsignacionController@quitarHorario');
});
