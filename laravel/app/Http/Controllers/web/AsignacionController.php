<?php

namespace App\Http\Controllers\web;

use App\Asignacion_Clientes;
use App\Asignacion_Horarios;
use App\Cliente;
use App\Ubicacion;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AsignacionController extends Controller
{

    public function principal()
    {
        $empleados = DB::table('users')
            ->join('rol', 'users.rol_id','=', 'rol.id')
            ->join('ubicacion', 'users.ubicacion_id','=', 'ubicacion.id')
            ->where('users.visible','=', true)
            ->select('users.id', 'users.nombre', 'rol.nombre as rol', 'ubicacion.nombre as ubicacion')
            ->paginate(5);
        return view('vistas.asignaciones.index', ['empleados' => $empleados]);
    }

    // --------------------- ASIGNACION DE HORARIOS ---------------------------------

    // Muestra los horarios
    public function verHorarios($id)
    {

        $empleado = User::findOrfail($id);
        $a_horarios = Asignacion_Horarios::with('horario', 'horario.dias')
            ->where('user_id', '=', $id)
            ->get();

        return view('vistas.asignaciones.horarios', ['empleado' => $empleado, 'a_horarios' => $a_horarios]);

    }

    // Redirige a la vista de asignacion de horarios
    public function editarHorario($id){
        $empleado = User::findOrFail($id);
        $asignados = DB::table('a_horarios')
            ->join('horario', 'a_horarios.horario_id', '=', 'horario.id')
            ->where('a_horarios.user_id', '=', $id)
            ->select('a_horarios.id', 'horario.id as horario_id', 'horario.nombre', 'horario.turno')
            ->get();

        $horarios = DB::table('horario')
            ->where('horario.visible', '=', true)
            ->whereNotIn('horario.id', function($query) use ($id) {
                    $query->from('a_horarios')
                    ->select('horario_id')
                    ->where('user_id','=', $id)
                    ->get();
                }
            )
            ->select('horario.id', 'horario.nombre', 'horario.turno')
            ->orderBy('horario.id')
            ->get();

        return view('vistas.asignaciones.asignacion_horarios', ['empleado' => $empleado, 'asignados' => $asignados, 'horarios' => $horarios]);
    }

    // Guarda una nueva asignacion
    public function asignarHorario($id, Request $request){
        $asignacion = new Asignacion_Horarios();
        $asignacion->horario_id = $request->horario_id;
        $asignacion->user_id = $id;
        $asignacion->save();

        return redirect('asignaciones/horarios/'.$id.'/editar');
    }

    // Eliminar una asignacion
    public function quitarHorario($id, $asignacion_id){
        $asignacion = Asignacion_Horarios::findOrFail($asignacion_id);
        $asignacion->delete();

        return redirect('asignaciones/horarios/'.$id.'/editar');
    }

    // --------------------- ASIGNACION DE CLIENTES ---------------------------------

    // ver cliente
    public function verCliente($id){
        return view('vistas.clientes.show',['cliente' => Cliente::findOrFail($id)]);
    }


    // Ver Asignaciones del empleado
    public function editarCliente($id){
        $empleado = User::findOrfail($id);
        $asignados = Asignacion_Clientes::with('cliente')
            ->where('user_id', '=', $id)
            ->get();


        $clientes = DB::table('cliente')
            ->where('cliente.visible', '=', true)
            ->whereNotIn('cliente.id', function($query) use ($id) {
                $query->from('a_clientes')
                    ->select('cliente_id')
                    ->where('user_id','=', $id)
                    ->get();
            }
            )
            ->select('cliente.id', 'cliente.nombre')
            ->orderBy('cliente.id')
            ->get();




        return view('vistas.asignaciones.asignacion_clientes', ['empleado' => $empleado, 'asignados' => $asignados, 'clientes' => $clientes]);
    }

    public function asignarCliente($id, Request $request){
        $asignacion = new Asignacion_Clientes();
        $asignacion->cliente_id = $request->cliente_id;
        $asignacion->user_id = $id;
        $asignacion->save();

        return redirect('asignaciones/clientes/'.$id.'/editar');
    }

    public function quitarCliente($id, $asignacion_id){
        $asignacion = Asignacion_Clientes::findOrFail($asignacion_id);
        $asignacion->delete();

        return redirect('asignaciones/clientes/'.$id.'/editar');
    }



    // ------------------------------------ASIGNACIONES UBICACIONES ---------------------------------

    public function verUbicacion($id){
        $empleado = User::findOrFail($id);
        $ubicacion = Ubicacion::findOrFail($empleado->ubicacion_id);
        $ubicaciones = Ubicacion::where('id', '!=', $empleado->ubicacion_id)
            ->where('visible', '=', true)
            ->get();
        return view('vistas.asignaciones.ubicacion', ['empleado' => $empleado, 'ubicacion' => $ubicacion, 'ubicaciones' => $ubicaciones]);
    }

    public function asignarUbicacion($id, Request $request){
        $empleado = User::findOrFail($id);
        $empleado->ubicacion_id = $request['ubicacion_id'];
        $empleado->save();

        return redirect('asignaciones/ubicacion/'.$id);
    }


    // ************************************* FUNCIONCITAS **********************************************

    public function fueraRango($entrada, $salida, $hora){
        return ($hora < $entrada && $hora > $salida);
    }

    public function prueba(){

        $actual = new \stdClass();
        $actual->dias = 'nada';


        dd(json_encode($actual));
    }

}
