@extends('adminlte::page')

@section('title', 'Cotización')

@section('content_header')
    <h1>Agregar Cotización</h1>
  

@stop

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Ingresar Datos</span>
                    
                </div>
                <div class="card-body bg-white">

                    
                    
                    <form action="/cotizacion/detalleconcabe" method="get">
                        @csrf
                                @method('GET')


        <div class="row">

                    <div class="mb-3 col-6">
                        <label class="form-label">Atención</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre">
                    </div>


                    <div class="mb-3 col-3">
                        <label class="form-label">Cotización</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese el #">
                    </div>

                    <div class="mb-3 col-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Ingrese el # telefono">
                    </div>
        </div>

        <div class="row">

                    <div class="mb-3 col-6">
                        <label class="form-label">Empresa</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Empresa">
                    </div>


                    <div class="mb-3 col-3">
                        <label class="form-label">Registro</label>
                        <input type="text" class="form-control" id="registro" name="registro" placeholder="Ingrese el #">
                    </div>      
        </div>

        <div class="row">

                    <div class="mb-3 col-6">
                        <label class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="">
                    </div>


                    <div class="mb-3 col-3">
                        <label class="form-label">Contacto 1</label>
                        <input type="text" class="form-control" id="contacto1" name="contacto1" placeholder="Ingrese el contacto">
                    </div>      
        </div>

        <div class="row">

                    <div class="mb-3 col-6">
                        <label class="form-label">Orden</label>
                        <input type="text" class="form-control" id="orden" name="orden" placeholder="">
                    </div>


                    <div class="mb-3 col-3">
                        <label class="form-label">Contacto 2</label>
                        <input type="text" class="form-control" id="contacto2" name="contacto2" placeholder="Ingrese el contacto">
                    </div>      
        </div>

        <div class="row">

                    <div class="mb-3 col-6">
                        <label class="form-label">Garantia</label>
                        <input type="text" class="form-control" id="garantia" name="garantia" placeholder="">
                    </div>


                    <div class="mb-3 col-3">
                        <label class="form-label">Registro</label>
                        <input type="text" class="form-control" id="registro2" name="registro2" placeholder="Ingrese el #">
                    </div>     
                    <div class="mb-3 col-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingrese el Email">
                    </div>   
        </div>
        @foreach($productos as $producto)
        
        <input type="text" hidden id="det{{ $producto->id }}" value="{{ $producto->Descripcion }}"> 
        <input type="text" hidden id="can{{ $producto->id }}" value="{{ $producto->Cantidad }}"> 
        <input type="text" hidden id="pre{{ $producto->id }}" value="{{ $producto->Precio }}"> 
        
        @endforeach

        <div class="row">
            
                    <div class="mb-3 col-6">
                        <label class="form-label">Productos</label>
                        <select class="form-control js-example-basic-single produ" name="producto" id="producto" onChange="getComboA(this)">
                            @foreach($productos as $producto)
                            <option value="{{$producto->id}}">{{$producto->Nombre}}</option>
                            
                            
                            @endforeach
                            
                        </select>
                    </div>
                  
                    <div class=" col-3 " >
                    
                    
                    
                    </div>   
                
        </div>
        
        <div class="row">
            <div class="mb-3 col-2">
                <label class="form-label">Detalle </label>
                        <input type="text" class="form-control" id="detalle" name="detalle" placeholder="Ingrese descripción">
            </div>
            <div class=" col-1 " >
            
                <label class="form-label">Cantidad </label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese cantidad" onChange="totalizar()">
                
            </div>  
            <div class=" col-1 " >
            
                <label class="form-label">Precio Unit. </label>
                        <input type="text" class="form-control" id="precio" name="precio" placeholder="Ingrese Precio" onChange="totalizar()">
                
            </div> 
            <div class=" col-1 " >
            
                <label class="form-label">Precio Total</label>
                        <input type="text" class="form-control" id="total" name="total">
                
            </div> 
            <div class=" col-1 " >
            
                <label class="form-label">Recargado</label>
                        <input type="text" class="form-control" id="recarga" name="recarga">
                
            </div> 

            <div class=" col-2 " >
            
                <label class="form-label">Precio Uni Recargado</label>
                        <input type="text" class="form-control" id="unirecarga" name="unirecarga">
                
            </div> 
            <div class=" col-3 " >
            
            <button type="submit" class="btn btn-success mt-4" >Agregar</button>
        </form>
            </div>   
</div>
                    
<hr>
<a href="/cotizacion">
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
  
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>





<script>
    function getComboA(selectObject) {
var id = selectObject.value;  
//var cant = document.getElementById('can1').text; 
var canti = document.getElementById('can' + id).value ;

document.getElementById("cantidad").value = canti;

var deta = document.getElementById('det' + id).value ;

document.getElementById("detalle").value = deta;

var preci = document.getElementById('pre' + id).value ;

document.getElementById("precio").value = preci;

document.getElementById("total").value = preci * canti ;


}

function totalizar() {

    var canti = document.getElementById("cantidad").value ;
    var preci = document.getElementById('precio').value ;

    document.getElementById("total").value = preci * canti ;

}

</script>
@endsection


