<?php

namespace App\Http\Controllers\web;

use App\Asignacion_Horarios;
use App\Horario;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AsignacionController extends Controller
{

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

//        $horarios = Horario::where('visible','=', true)->get();

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

        return redirect('/empleados/horarios/'.$id.'/editar');
    }

    // Eliminar una asignacion
    public function quitarHorario($id, $asignacion_id){
        $asignacion = Asignacion_Horarios::findOrFail($asignacion_id);
        $asignacion->delete();

        return redirect('/empleados/horarios/'.$id.'/editar');
    }
}
