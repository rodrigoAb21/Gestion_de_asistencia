<?php

namespace App\Http\Controllers\web;

use App\Asignacion_Clientes;
use App\Asignacion_Horarios;
use App\Cliente;
use App\Dia;
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

        return view('vistas.asignaciones.asignacion_horarios', ['empleado' => $empleado, 'asignados' => $asignados,
            'horarios' => $horarios]);
    }

    // Guarda una nueva asignacion
    public function asignarHorario($id, Request $request){
        if ($this->asignacionValida($id, $request->horario_id)){
            $asignacion = new Asignacion_Horarios();
            $asignacion->horario_id = $request->horario_id;
            $asignacion->user_id = $id;
            $asignacion->save();

            return redirect('asignaciones/horarios/'.$id.'/editar');
        }

        $request->session()->flash('alert-danger', 'No se puede asignar por choque de horario.');

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

        return view('vistas.asignaciones.asignacion_clientes', ['empleado' => $empleado, 'asignados' => $asignados,
            'clientes' => $clientes]);
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
        return view('vistas.asignaciones.ubicacion', ['empleado' => $empleado, 'ubicacion' => $ubicacion,
            'ubicaciones' => $ubicaciones]);
    }

    public function asignarUbicacion($id, Request $request){
        $empleado = User::findOrFail($id);
        $empleado->ubicacion_id = $request['ubicacion_id'];
        $empleado->save();

        return redirect('asignaciones/ubicacion/'.$id);
    }


    // ************************************* FUNCIONCITAS **********************************************

    public function asignacionValida($user_id, $horario_id){
        $actual = json_decode($this->obtenerActual($user_id), true);
        $ingresado = $this->obtenerHorario($horario_id);

        foreach ($ingresado as $dia){
            if (count($dia) > 0){
                if (count($actual[$dia[0]->nombre]) > 0){
                    foreach ($actual[$dia[0]->nombre] as $item){
                        if (!$this->horarioValido($item['entrada'], $item['salida'],$dia[0]->entrada,$dia[0]->salida)){
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }


    public function horarioValido($e_actual, $s_actual, $entrada, $salida){
        // 1 es el actual y 2 nuevo
        // Convirtiendo a entero

        $e_actual = str_replace(':', '', $e_actual);
        $entrada = str_replace(':', '', $entrada);
        $s_actual = str_replace(':', '', $s_actual);
        $salida = str_replace(':', '', $salida);

        // buscando si solapa o esta dentro del rango actual

        return (($entrada < $e_actual  || $entrada > $s_actual) && ($salida < $e_actual  || $salida > $s_actual)
            && ($e_actual < $entrada  || $e_actual > $salida) && ($s_actual < $entrada  || $s_actual > $salida));
    }

    public function obtenerActual($user_id){
        $actual = new \stdClass();
        $actual->Lunes = array();
        $actual->Martes = array();
        $actual->Miercoles = array();
        $actual->Jueves = array();
        $actual->Viernes = array();
        $actual->Sabado = array();
        $actual->Domingo = array();

        $horarios = Asignacion_Horarios::where('user_id', '=', $user_id)->get();
        foreach ($horarios as $horario){
            $dias = Dia::where('horario_id','=', $horario->horario_id)->get();
            foreach ($dias as $dia){
                switch ($dia->nombre) {
                    case 'Lunes':
                        $actual->Lunes[] = $dia;
                        break;
                    case 'Martes':
                        $actual->Martes[] = $dia;
                        break;
                    case 'Miercoles':
                        $actual->Miercoles[] = $dia;
                        break;
                    case 'Jueves':
                        $actual->Jueves[] = $dia;
                        break;
                    case 'Viernes':
                        $actual->Viernes[] = $dia;
                        break;
                    case 'Sabado':
                        $actual->Sabado[] = $dia;
                        break;
                    case 'Domingo':
                        $actual->Domingo[] = $dia;
                        break;
                }
            }
        }

        return json_encode($actual);
    }

    public function obtenerHorario($id){
        $horario = new \stdClass();
        $horario->Lunes = array();
        $horario->Martes = array();
        $horario->Miercoles = array();
        $horario->Jueves = array();
        $horario->Viernes = array();
        $horario->Sabado = array();
        $horario->Domingo = array();


        $dias = Dia::where('horario_id','=', $id)->get();
        foreach ($dias as $dia){
            switch ($dia->nombre) {
                case 'Lunes':
                    $horario->Lunes[] = $dia;
                    break;
                case 'Martes':
                    $horario->Martes[] = $dia;
                    break;
                case 'Miercoles':
                    $horario->Miercoles[] = $dia;
                    break;
                case 'Jueves':
                    $horario->Jueves[] = $dia;
                    break;
                case 'Viernes':
                    $horario->Viernes[] = $dia;
                    break;
                case 'Sabado':
                    $horario->Sabado[] = $dia;
                    break;
                case 'Domingo':
                    $horario->Domingo[] = $dia;
                    break;
            }
        }


        return $horario;
    }




}
