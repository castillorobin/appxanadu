@extends('adminlte::page')

@section('title', 'Proveedor')

@section('content_header')
    <h1>Agregar Productos</h1>
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

                    
                    
<form action="/producto/guardar" method="get">
@csrf
        @method('GET')

                    <div class="mb-3 col-8">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre">
                    </div>


                    <div class="mb-3 col-4">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripción">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ingrese la categoría">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Ingrese proveedor">
                    </div>


                    <div class="mb-3 col-8">
                        <label class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio" placeholder="Ingrese el precio">
                    </div>

                    <div class="mb-3 col-8">
                        <label class="form-label">Cantidad</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese la cantidad">
                    </div>

                    <div class="mb-3 col-4">
                        <label class="form-label">Unidad de medida</label>
                        <input type="text" class="form-control" id="unidad" name="unidad" placeholder="unidad">
                    </div>

                    


<hr>
<a href="/productos">
                    <button type="button" class="btn btn-danger">Cancelar</button> </a>
&nbsp; &nbsp; &nbsp;
                    <button type="submit" class="btn btn-primary">Guardar</button>

                </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  



@endsection


