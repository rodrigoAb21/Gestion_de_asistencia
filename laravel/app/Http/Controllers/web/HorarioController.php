<?php

namespace App\Http\Controllers\web;

use App\Dia;
use App\Horario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vistas.horarios.index', ['horarios' => Horario::where('visible', '=', true)->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $turnos = ['Mañana', 'Tarde', 'Noche', 'Continuo'];
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        return view('vistas.horarios.create',['dias' => $dias, 'turnos' => $turnos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{

            DB::beginTransaction();

            $horario = new Horario();
            $horario->nombre = $request['nombre'];
            $horario->turno = $request['turno'];
            $horario->save();

            $nombres = $request['nombresT'];
            $entradas = $request['entradasT'];
            $salidas = $request['salidasT'];

            $cont = 0;

            while ($cont < count($nombres)) {
                $dia = new Dia();
                $dia->nombre = $nombres[$cont];
                $dia->entrada = $entradas[$cont];
                $dia->salida = $salidas[$cont];
                $dia->horario_id = $horario->id;
                $dia->save();

                $cont++;
            }

            DB::commit();

        }catch (Exception $e){

            DB::rollback();

        }

        return redirect('horarios');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('vistas.horarios.show', ['horario'=> Horario::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->visible = false;
        $horario->save();

        return redirect('horarios');
    }
}
