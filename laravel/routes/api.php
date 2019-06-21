<?php


Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');



Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');
    Route::get('ubicacion', 'Api\ApiController@getUbicacion');
    Route::get('usuario', 'Api\ApiController@getUsuario');
    Route::get('clientes', 'Api\ApiController@getClientes');

});