@extends('layouts.index')

@section('contenido')
    <div class="row">
        <div class="col-12 m-t-30">
            <div class="card-columns">
                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Gestionar Empleados</h4>
                        <p class="card-text"><i class="fa fa-users fa-3x"></i></p>
                        <a class="btn btn-info btn-block " href="{{url('empleados')}}"> Ver </a>
                    </div>
                </div>

                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Gestionar Roles</h4>
                        <p class="card-text"><i class="fa fa-users-cog fa-3x"></i></p>
                        <a class="btn btn-info btn-block " href="{{url('roles')}}"> Ver </a>
                    </div>
                </div>

                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Gestionar Horarios</h4>
                        <p class="card-text"><i class="fa fa-calendar-alt fa-3x"></i></p>
                        <a class="btn btn-info btn-block " href="{{url('horarios')}}"> Ver </a>
                    </div>
                </div>

                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Realizar Asignaciones</h4>
                        <p class="card-text"><i class="fa fa-hand-point-right fa-3x"></i></p>
                        <a class="btn btn-info btn-block " href="{{url('asignaciones')}}"> Ver </a>
                    </div>
                </div>

                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Gestionar Clientes</h4>
                        <p class="card-text"><i class="fa fa-user-tie fa-3x"></i></p>
                        <a class="btn btn-info btn-block" href="{{url('clientes')}}"> Ver </a>
                    </div>
                </div>

                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Gestionar Ubicaciones</h4>
                        <p class="card-text"><i class="fa fa-building fa-3x"></i></p>
                        <a class="btn btn-info btn-block" href="{{url('ubicaciones')}}"> Ver </a>
                    </div>
                </div>

                <div class="card text-center p-3" >
                    <div class="card-body">
                        <h4 class="card-title">Generar Reportes</h4>
                        <p class="card-text"><i class="fa fa-file-pdf fa-3x"></i></p>
                        <a class="btn btn-info btn-block" href="{{url('reportes')}}"> Ver </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
