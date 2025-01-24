@extends('adminlte::page')

@section('title', 'Agregar Control')

@section('content_header')
    <h1>Agregar de Control</h1>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@stop

@section('content')



<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
        <input type="text" value="{{date_default_timezone_set('America/El_Salvador') }}" hidden>
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Ingresar Datos</span>
                    
                </div>
                <div class="card-body bg-white">

                    
                    
<form action="/control/guardar" method="get">
@csrf
        @method('GET')

                    <div class="mb-3 col-4">
                        <label class="form-label">Fecha</label>
                        <input type="text" class="form-control" id="fecha" name="fecha" value="{{ date('d-m-Y') }}" readonly>
                    </div>

                    

                    <div class="mb-3 col-4">
                        <label class="form-label">Vehiculo</label>
                        <input type="text" class="form-control" id="vehiculo" name="vehiculo" placeholder="Ingrese el vehiculo">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label"># de placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" value="P">
                    </div>


                    <div class="mb-3 col-4">
                        <label class="form-label"># de Habitacion</label>
                        <select class="form-control js-example-basic-single produ" name="habitacion" id="habitacion" >
                            @foreach($habitaciones as $producto)
                            @if($producto->estado == 0)
                            <option value="{{$producto->id}}">Habitacion {{$producto->numero}}</option>
                            @endif
                            
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Hora de Entrada</label>
                        <input type="text" class="form-control" id="entrada" name="entrada" value="{{date('h:i:s A')}}" readonly>
                    </div>
                    <div class="mb-3 col-4">
                        <label class="form-label">Tarifa</label>
                        <input type="text" class="form-control" id="tarifa" name="tarifa" placeholder="$">
                    </div>


<hr>


                    <button type="submit" class="btn btn-primary">Guardar</button>
                    &nbsp; &nbsp; &nbsp;
                    <a href="/control">
                        <button type="button" class="btn btn-danger">Cancelar</button> </a>

                </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  



@endsection


