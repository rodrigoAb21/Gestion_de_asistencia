@extends('layouts.index')

@section('contenido')
    <div class="row pt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="pb-2">
                        Editar Cliente: {{$cliente->id}}
                    </h3>

                    <form method="POST" action="{{url('clientes/'.$cliente->id)}}" autocomplete="off">
                        {{csrf_field()}}
                        {{method_field('PATCH')}}
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" required class="form-control"  value="{{$cliente->nombre}}" name="nombre">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" required class="form-control"  value="{{$cliente->telefono}}" name="telefono">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input type="text" required class="form-control"  value="{{$cliente->direccion}}" name="direccion">
                                </div>
                            </div>
                            <input type="hidden" value="{{$cliente->latitud}}" required id="latitud" name="latitud">
                            <input type="hidden" value="{{$cliente->longitud}}" required id="longitud" name="longitud">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div id="map" style="width: 100%; height: 400px; background: #b4c1cd; margin-bottom: 1rem"></div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-info">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
