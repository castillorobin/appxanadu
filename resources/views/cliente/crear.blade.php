@extends('adminlte::page')

@section('title', 'Proveedor')

@section('content_header')
    <h1>Agregar de Cliente</h1>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@stop

@section('content')



<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Ingresar Datos</span>
                    
                </div>
                <div class="card-body bg-white">

                    
                    
<form action="/cliente/guardar" method="get">
@csrf
        @method('GET')

                    <div class="mb-3 col-8">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre">
                    </div>

                    

                    <div class="mb-3 col-8">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese la dirección">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el # telefono">
                    </div>


                    <div class="mb-3 col-4">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@dominio.com">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui" placeholder="Ingrese el DUI">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">NRC</label>
                        <input type="text" class="form-control" id="nrc" name="nrc" placeholder="Ingrese el NRC">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Giro</label>
                        <input type="text" class="form-control" id="giro" name="giro" placeholder="Ingrese el Giro">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Ingrese el Departamento">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" value="P">
                    </div>
                    


<hr>


                    <button type="submit" class="btn btn-primary">Guardar</button>
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


