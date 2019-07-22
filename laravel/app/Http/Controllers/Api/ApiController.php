<?php

namespace App\Http\Controllers\Api;

use App\Asistencia;
use App\Horario;
use App\Ubicacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function getUbicacion(){
        $ubicacion = Ubicacion::findOrFail(Auth::user()->ubicacion_id);
        return $ubicacion;
    }

    public function getUsuario(){
        return Auth::user();
    }

    public function getClientes(){
        $id = Auth::user()->id;
        $clientes = DB::table('cliente')
            ->where('cliente.visible', '=', true)
            ->whereIn('cliente.id', function($query) use ($id) {
                $query->from('a_clientes')
                    ->select('cliente_id')
                    ->where('user_id','=', $id)
                    ->get();
            }
            )->get();
        return $clientes;
    }

    public function getHorarios(){
        $id = Auth::user()->id;
        $horarios = Horario::with('dias')
            ->where('horario.visible', '=', true)
            ->whereIn('horario.id', function($query) use ($id) {
                $query->from('a_horarios')
                    ->select('horario_id')
                    ->where('user_id','=', $id)
                    ->get();
            }
            )->get();
        return $horarios;
    }

    public function marcarEntrada(Request $request){
        $asistencia = new Asistencia();
        $asistencia->fecha = $request['fecha'];
        $asistencia->dia = $request['dia'];
        $asistencia->hora = $request['hora'];
        $asistencia->latitud = $request['latitud'];
        $asistencia->longitud = $request['longitud'];
        $asistencia->tipo = $request['tipo'];
        $asistencia->user_id = Auth::user()->id;
        $asistencia->save();

        return response()->json([], 200);
    }
}
