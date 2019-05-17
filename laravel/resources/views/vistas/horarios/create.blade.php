@extends('layouts.index')

@section('contenido')
    <div class="row pt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="pb-2">
                        Nuevo Horario
                    </h3>

                    <form method="POST" action="{{url('horarios')}}" autocomplete="off">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre" >Nombre</label>
                                    <input type="text" name="nombre" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre" >Turnos</label>
                                    <select class="form-control" name="nombre" >
                                        @foreach($turnos as $turno)
                                            <option value="{{$turno}}">{{$turno}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <br>

                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="dia" >Dia</label>
                                    <select class="form-control" name="dia" >
                                        @foreach($dias as $dia)
                                            <option value="{{$dia}}">{{$dia}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre" >Entrada</label>
                                    <input type="time" name="entrada" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nombre" >Salida</label>
                                    <input type="time" name="salida" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="mt-1">
                                    <br>
                                </div>
                                <button class="btn btn-circle btn-lg btn-success"><i class="fa fa-plus fa-1x"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered color-table info-table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>DIA</th>
                                    <th>ENTRADA</th>
                                    <th>SALIDA</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-info">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
