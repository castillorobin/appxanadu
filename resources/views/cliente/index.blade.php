@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    

    
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Listado de clientes</span>
                    <a href="/clientes/create">
                    <button type="button" class="btn btn-success" style="float: right;">Agregar Cliente</button>
                </a>
                </div>
                <div class="card-body bg-white">


                    <table id="clientes" class="table table-bordered shadow-lg mt-4 cell-border">
                        <thead >
                            <tr >
                                
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($clientes as $cliente)
                            <tr >
                            <td>{{ $cliente->id }}</td>
                           
                            <td>{{ $cliente->Nombre }}</td>
                            <td>{{ $cliente->Telefono }}</td>
                            <td>{{ $cliente->Direccion }}</td>
                        
                            <td class="opciones text-center" style="">
                                <a href="/clientes/ver/{{ $cliente->id }}">
                                <button type="button" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                            </a>           

                           
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Estás seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                            </td>
                            </tr>
                            @endforeach
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
