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

                    
                    
<form action="/habitacion/guardar" method="get">
@csrf
        @method('GET')

                    <div class="mb-3 col-4">
                        <label class="form-label">Numero de habitacion</label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Ingrese el numero">
                    </div>     

<hr>


                    <button type="submit" class="btn btn-primary">Guardar</button>
                    &nbsp; &nbsp; &nbsp;
                    <a href="/habitacion">
                        <button type="button" class="btn btn-danger">Cancelar</button> </a>

                </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  



@endsection


