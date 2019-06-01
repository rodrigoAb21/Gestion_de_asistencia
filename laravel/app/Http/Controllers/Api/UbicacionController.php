<?php

namespace App\Http\Controllers\Api;

use App\Ubicacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ubicacion::where('visible','=',true)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vistas.ubicaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ubicacion = new Ubicacion();
        $ubicacion->nombre = $request['nombre'];
        $ubicacion->direccion = $request['direccion'];
        $ubicacion->telefono = $request['telefono'];
        $ubicacion->latitud = $request['latitud'];
        $ubicacion->longitud = $request['longitud'];
        $ubicacion->save();

        return redirect('ubicaciones');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('vistas.ubicaciones.show',['ubicacion' => Ubicacion::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('vistas.ubicaciones.edit',['ubicacion' => Ubicacion::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ubicacion = Ubicacion::findOrFail($id);
        $ubicacion->nombre = $request['nombre'];
        $ubicacion->direccion = $request['direccion'];
        $ubicacion->telefono = $request['telefono'];
        $ubicacion->latitud = $request['latitud'];
        $ubicacion->longitud = $request['longitud'];
        $ubicacion->save();

        return redirect('ubicaciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ubicacion = Ubicacion::findOrFail($id);
        $ubicacion->visible = false;
        $ubicacion->save();

        return redirect('ubicaciones');
    }
}