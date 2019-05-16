<?php

namespace App\Http\Controllers\web;

use App\Rol;
use App\Ubicacion;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = DB::table('users')
            ->join('rol', 'users.rol_id','=', 'rol.id')
            ->join('ubicacion', 'users.ubicacion_id','=', 'ubicacion.id')
            ->where('users.visible','=', true)
            ->select('users.id', 'users.nombre', 'rol.nombre as rol', 'ubicacion.nombre as ubicacion')
            ->paginate(5);
        return view('vistas.empleados.index', ['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ubicaciones = Ubicacion::where('visible','=',true)->get();
        $roles = Rol::where('visible','=',true)->get();
        return view('vistas.empleados.create',['ubicaciones' => $ubicaciones, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empleado = new User();
        $empleado->nombre = $request['nombre'];
        $empleado->direccion = $request['direccion'];
        $empleado->telefono = $request['telefono'];
        $empleado->email = $request['email'];
        $empleado->password = bcrypt($request['password']);
        $empleado->ubicacion_id = $request['ubicacion_id'];
        $empleado->rol_id = $request['rol_id'];

        if (Input::hasFile('foto')) {
            $file = Input::file('foto');
            $file->move(public_path() . '/img/', $file->getClientOriginalName());
            $empleado -> foto = $file->getClientOriginalName();
        }

        $empleado->save();

        return redirect('empleados');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('vistas.empleados.edit',['cliente' => User::findOrFail($id)]);
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
        $empleado = User::findOrFail($id);
        $empleado->nombre = $request['nombre'];
        $empleado->direccion = $request['direccion'];
        $empleado->telefono = $request['telefono'];
        $empleado->latitud = $request['latitud'];
        $empleado->longitud = $request['longitud'];
        $empleado->save();

        return redirect('empleados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = User::findOrFail($id);
        $empleado->visible = false;
        $empleado->save();

        return redirect('empleados');
    }
}
