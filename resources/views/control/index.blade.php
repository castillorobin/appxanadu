@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Control</h1>
@stop

@section('content')
    

    
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Listado de controles</span>
                    <a href="/control/crear">
                    <button type="button" class="btn btn-success" style="float: right;">Agregar Control</button>
                </a>
                </div>
                <div class="card-body bg-white">


                    <table id="clientes" class="table table-bordered shadow-lg mt-4 cell-border">
                        <thead >
                            <tr >
                                
                                <th scope="col">ID</th>
                                <th scope="col">Vehiculo</th>
                                <th scope="col">Placa</th>
                                <th scope="col">Habitacion</th>
                                <th scope="col">Entrada</th>
                                
                                <th scope="col">Tarifa</th>
                                <th scope="col">Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @for ($i=0; $i< count($controles); $i++)
                            @if($controles[$i]->estado == 1)
                            
                            <tr >
                            <td>{{ $controles[$i]->id }}</td>
                           
                            <td>{{ $controles[$i]->vehiculo }}</td>
                            <td>{{ $controles[$i]->placa }}</td>
                            <td>{{ $controles[$i]->habitacion }}</td>
                            <td>{{ $controles[$i]->entrada }}</td>
                       
                            <td>{{ $controles[$i]->tarifa }}</td>
                        
                            <td class="opciones text-center" style="">
                            

                                <a href="/control/salida/{{ $controles[$i]->id }}">
                                <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i>Salida</button>
                            </a>
                        
                            </td>
                            </tr>
                            @endif
                            @endfor
                        </tbody>

                        </table>
                        



                    
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
     </script>
@stop
