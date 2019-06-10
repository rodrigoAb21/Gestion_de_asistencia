<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
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

        return $mes;
    }

    public function totalEmpleado($empleado_id){

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


}
