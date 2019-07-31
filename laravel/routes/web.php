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
    Route::get('reportes', 'web\ReporteController@index');
    Route::post('reportes', 'web\ReporteController@getReporte');
});

Route::get('prueba', function (){
    $apiKey = 'AIzaSyAiw5KGY8korLZOLBOE6KO9hK-Ol4WKkwQ';
    $data = array('body' => 'New message');
    $flutter = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK');
    $to = 'e9rzYwlUxpQ:APA91bFut3p1Mj7sc1SVpK2kd9tQm4w5LvOAr-ZOlFWt3-HAcnS0bP6U98vYmG3faAwWfFVacYj7IP3M1Hge3bnwQ7QS5bQK3Gy7VoRQZLeq-wEQqabpg0DTROm-94k53urf0VfRgbYU';
    $fields = array( 'to' => $to, 'notification' => $data, 'data' => $flutter);
    $headers = array('Authorization: key='.$apiKey, 'Content-Type: application/json');
    $url = 'https://fcm.googleapis.com/fcm/send';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
});
