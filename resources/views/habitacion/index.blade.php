@extends('adminlte::page')

@section('title', 'Habitaciones')

@section('content_header')
    <h1>Habitaciones</h1>
@stop

@section('content')
    

    
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Listado de Habitaciones</span>
                    <a href="/habitacion/crear">
                    <button type="button" class="btn btn-success" style="float: right;">Agregar Habitacion</button>
                </a>
                </div>
                <div class="card-body bg-white">


                    <table id="clientes" class="table table-bordered shadow-lg mt-4 cell-border">
                        <thead >
                            <tr >
                                
                                <th scope="col" style="width:60px;">ID</th>
                                <th scope="col">#</th>
                                <th scope="col">Estado</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @for ($i=0; $i< count($habitaciones); $i++)
                            
                            
                            <tr >
                            <td>{{ $habitaciones[$i]->id }}</td>
                           
                            <td>Habitacion {{ $habitaciones[$i]->numero }}</td>
                            <td>
                                @if($habitaciones[$i]->estado == 0)
                                <span class="badge badge-pill badge-success">Libre</span>
                                @else
                                <span class="badge badge-pill badge-danger">Ocupada</span>
                                @endif
                            </td>
                           
                            </tr>
                          
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
