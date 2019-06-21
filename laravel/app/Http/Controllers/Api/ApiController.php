<?php

namespace App\Http\Controllers\Api;

use App\Asignacion_Clientes;
use App\Ubicacion;
use App\Http\Controllers\Controller;
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


}
