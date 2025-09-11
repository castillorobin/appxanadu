@extends('adminlte::page')

@section('title', 'Editar cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@stop

@section('content')



<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Editar Datos</span>
                    
                </div>
                <div class="card-body bg-white">

                    
 <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

                    <div class="mb-3 col-8">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="Nombre" value="{{ $cliente->Nombre }}"  >
                    </div>

                    

                    <div class="mb-3 col-8">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="Direccion" value="{{ $cliente->Direccion }}" >
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="Telefono" value="{{ $cliente->Telefono }}" >
                    </div>


                    <div class="mb-3 col-4">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="Correo" value="{{ $cliente->Correo }}" >
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="DUI" value="{{ $cliente->DUI }}" >
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">NRC</label>
                        <input type="text" class="form-control" id="nrc" name="nrc" value="{{ $cliente->nrc }}" >
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Giro</label>
                        <input type="text" class="form-control" id="giro" name="giro" value="{{ $cliente->giro }}" >
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento" value="{{ $cliente->departamento }}" >
                    </div>

                    


<hr>


                    <button type="submit" class="btn btn-primary">Editar</button>
                    &nbsp; &nbsp; &nbsp;
                    <a href="/clientes">
                        <button type="button" class="btn btn-danger">Cancelar</button> </a>

                </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  



@endsection


