<?php

namespace App\Http\Controllers\web;

use App\Asignacion_Horarios;
use App\Dia;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{


    public function getReporte(Request $request){
        $tuplas = array();
        $empleados = User::where('visible','=', 1)->get();
        foreach ($empleados as $empleado){
            $tuplas[] = $this->makeTupla($empleado->nombre,$this->totalTrabajo($empleado->id, $request->mes, $request->anio), "00:00", "00:00", "00:00");
        }
        return $tuplas;
    }

    public function totalTrabajo($user_id, $month, $year){
        $actual = json_decode($this->obtenerActual($user_id), true);
        $mes = json_decode($this->obtenerDiasDeLMes($month, $year), true);
        $total = '00:00';
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        foreach ($dias as $dia){
            for ($i = 0; $i < $mes[$dia]; $i++){
                $total = $this->sumaSuperior($total, $actual[$dia]);
            }
        }

        return $total;

    }

    public function makeTupla($nombre, $hrsTrabajo, $hrsTrabajadas, $hrsRetraso, $hrsExtras){
        $tupla = new \stdClass();
        $tupla->nombre = $nombre;
        $tupla->hrsTrabajo = $hrsTrabajo;
        $tupla->hrsTrabajadas = $hrsTrabajadas;
        $tupla->hrsRetraso = $hrsRetraso;
        $tupla->hrsExtras = $hrsExtras;
        return $tupla;
    }

    public function sumaSuperior($tiempo1, $tiempo2){

        $hora1 = $this->getHoras($tiempo1);
        $hora2 = $this->getHoras($tiempo2);

        $min1 = (int)substr($tiempo1,-2);
        $min2 = (int)substr($tiempo2, -2);

        $min = $min1 + $min2;
        $hora = $hora1 + $hora2;
        if ($min > 59){
            $hora++;
            $min = $min - 60;
        }

        $hora = ''.$hora;
        $min = ''.$min;
        if (count_chars($min)!=2){
            $min = '0'.$min;
        }

        return $hora.':'.$min;


    }

    public function getHoras($tiempo){
        $hora = '';
        for ($i = 0; $i < count_chars($tiempo); $i++){
            if ($tiempo[$i] == ':') break;
            $hora = $hora . $tiempo[$i];
        }
        return (int)$hora;
    }

    public function obtenerActual($user_id){
        $actual = new \stdClass();
        $actual->Lunes = "00:00";
        $actual->Martes = "00:00";
        $actual->Miercoles = "00:00";
        $actual->Jueves = "00:00";
        $actual->Viernes = "00:00";
        $actual->Sabado = "00:00";
        $actual->Domingo = "00:00";

        $horarios = Asignacion_Horarios::where('user_id', '=', $user_id)->get();
        foreach ($horarios as $horario){
            $dias = Dia::where('horario_id','=', $horario->horario_id)->get();
            foreach ($dias as $dia){
                switch ($dia->nombre) {
                    case 'Lunes':
                        $actual->Lunes = $this->sumar($actual->Lunes, $this->restar($dia->salida, $dia->entrada));
                        break;
                    case 'Martes':
                        $actual->Martes = $this->sumar($actual->Martes, $this->restar($dia->salida, $dia->entrada));;
                        break;
                    case 'Miercoles':
                        $actual->Miercoles = $this->sumar($actual->Miercoles, $this->restar($dia->salida, $dia->entrada));;
                        break;
                    case 'Jueves':
                        $actual->Jueves = $this->sumar($actual->Jueves, $this->restar($dia->salida, $dia->entrada));;
                        break;
                    case 'Viernes':
                        $actual->Viernes = $this->sumar($actual->Viernes, $this->restar($dia->salida, $dia->entrada));;
                        break;
                    case 'Sabado':
                        $actual->Sabado = $this->sumar($actual->Sabado, $this->restar($dia->salida, $dia->entrada));;
                        break;
                    case 'Domingo':
                        $actual->Domingo = $this->sumar($actual->Domingo, $this->restar($dia->salida, $dia->entrada));;
                        break;
                }
            }
        }

        return json_encode($actual);
    }

    public function restar($salida, $entrada){
        $hrs = substr($entrada, 0, 2);
        $min = substr($entrada, 3, 2);

        $salida = \DateTime::createFromFormat('H:i', $salida);
        $salida->modify('-'.$hrs.'hours');
        $salida->modify('-'.$min.'minute');
        return $salida->format('H:i');

    }

    public function sumar($hora1, $hora2){
        $hrs = substr($hora2, 0, 2);
        $min = substr($hora2, 3, 2);

        $hora1 = \DateTime::createFromFormat('H:i', $hora1);
        $hora1->modify('+'.$hrs.'hours');
        $hora1->modify('+'.$min.'minute');
        return $hora1->format('H:i');

    }

    public function obtenerDiasDeLMes($month, $year){
        $lunes = 0;
        $martes = 0;
        $miercoles = 0;
        $jueves = 0;
        $viernes = 0;
        $sabado = 0;
        $domingo = 0;
        $total = date('d', mktime(0,0,0, $month + 1, 0, $year));
        for ($i = 1; $i <= $total; $i++){
            switch (date('l', mktime(0,0,0, $month, $i, $year))){
                case "Monday":
                    $lunes++;
                    break;
                case "Tuesday":
                    $martes++;
                    break;
                case "Wednesday":
                    $miercoles++;
                    break;
                case "Thursday":
                    $jueves++;
                    break;
                case "Friday":
                    $viernes++;
                    break;
                case "Saturday":
                    $sabado++;
                    break;
                case "Sunday":
                    $domingo++;
                    break;
            }
        }
        $mes = new \stdClass();
        $mes->Lunes = $lunes;
        $mes->Martes = $martes;
        $mes->Miercoles = $miercoles;
        $mes->Jueves = $jueves;
        $mes->Viernes = $viernes;
        $mes->Sabado = $sabado;
        $mes->Domingo = $domingo;

        return json_encode($mes);
    }

}
