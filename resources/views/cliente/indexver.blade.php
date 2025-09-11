@extends('adminlte::page')

@section('title', 'Ver cliente')

@section('content_header')
    <h1>Información del Cliente</h1>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@stop

@section('content')



<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Ver Datos</span>
                    
                </div>
                <div class="card-body bg-white">

                    
                    


                    <div class="mb-3 col-8">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->Nombre }}" readonly >
                    </div>

                    

                    <div class="mb-3 col-8">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $cliente->Direccion }}" readonly>
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $cliente->Telefono }}" readonly>
                    </div>


                    <div class="mb-3 col-4">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ $cliente->Correo }}" readonly>
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui" value="{{ $cliente->DUI }}" readonly>
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">NRC</label>
                        <input type="text" class="form-control" id="nrc" name="nrc" value="{{ $cliente->nrc }}" readonly>
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Giro</label>
                        <input type="text" class="form-control" id="giro" name="giro" value="{{ $cliente->giro }}" readonly>
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento" value="{{ $cliente->departamento }}" readonly>
                    </div>

                   


<hr>


                    <a href="/clientes">
                        <button type="button" class="btn btn-danger">Regresar</button> </a>

               
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  



@endsection


