@extends('adminlte::page')

@section('title', 'Cotización')

@section('content_header')
    <h1>Agregar Factura</h1>
  

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

                    
                    
                    <form action="/facturacion/detalleconcabe" method="get">
                        @csrf
                                @method('GET')
<div class="container">



    
    <div class="row my-3">

        <div class="col-6 text-center">
         <h5>Santos Alberto Guerrero Beltran</h5>
            <h4>MOTEL XANADU</h4>
            <H5>Carretera a los Naranjos</H5>
            <H5>Cantón Cantarrana, Santa Ana</H5>
            <H5>Tel.: 2429-0920</H5>


        </div>


        <div class="col-6 text-center">
            <h3 >FACTURA</h3>
            <h5 >N.R.C Nº 183428-4</h5>
            <h5>DUI 00520755-0</h5>
            <h5 >NIT 0509-021159-101-0</h5>
        </div>  


</div>
        <div class="row my-2">

                    <div class="col-6">
                        
                        <div class="input-group">
                            <span class="input-group-text">Fecha</span>
                            <input class="form-control form-control-transparent fw-bold pe-5" value="{{ date('d/m/Y') }}" name="fecha"/>
 
                        </div>
                    </div>


                  
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Cliente</span>
                        <select class="form-control js-example-basic-single produ edit" name="cliente" id="cliente" >
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->Nombre}}</option>

                            <span hidden id="dui{{ $cliente->id}}"> {{ $cliente->DUI }}</span>
                            <span hidden id="dir{{ $cliente->id}}"> {{ $cliente->Direccion }}</span>
                            <span hidden id="cor{{ $cliente->id}}"> {{ $cliente->Correo }}</span>
                            @endforeach

                        </select>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">NIT/DUI</span>
                        <input type="text" class="form-control" id="dui" name="dui" >
                    </div>
                    </div>

    
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Direccion</span>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="">
                    </div>
                    </div>


                    
        </div>
         <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Correo</span>
                        <input type="text" class="form-control" id="correo" name="correo" placeholder="">
                    </div>
                    </div>


                    
        </div>


        



        @foreach($productos as $producto)
        
        <input type="text" hidden id="det{{ $producto->id }}" value="{{ $producto->Descripcion }}"> 
        <input type="text" hidden id="can{{ $producto->id }}" value="{{ $producto->Cantidad }}"> 
        <input type="text" hidden id="pre{{ $producto->id }}" value="{{ $producto->Precio }}"> 
        
        @endforeach
<hr>
        <div class="row">
            
                  
                  
                    <div class=" col-3 " >
                    
                    <button type="button" class="btn btn-primary " style="margin-top: 33px;" onClick="habitacion()">Habitacion</button>
                     
                    </div>   
                
        </div>
        
        <div class="row">
            <div class="mb-3 col-2">
                <label class="form-label">Descripcion </label>
                        <input type="text" class="form-control" id="detalle" name="detalle" >
            </div>
            <div class=" col-1 " >
            
                <label class="form-label">Cantidad </label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" onChange="totalizar()">
                
            </div>  
            

            <div class=" col-1 " >
            
                <label class="form-label">Existencia</label>
                        <input type="text" class="form-control" id="existencia" name="existencia" readonly>
                
            </div>  
            <div class=" col-1 " >
            
                <label class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio"  onChange="totalizar()">
                
            </div> 
            <div class=" col-1 " >
            
                <label class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total">
                
            </div> 
            
            <div class=" col-3 " >
            
            <button type="submit" class="btn btn-success mt-4" >Agregar</button>
        </form>
            </div>   
</div>
                    
<hr>
<a href="/facturacion">
                    <button type="button" class="btn btn-danger">Cancelar</button> </a>
&nbsp; &nbsp; &nbsp;
                    <button type="submit" class="btn btn-primary">Guardar</button>

                </form>
                </div>
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
   
       $(document).ready(function(){
           $(document).on('click', '.edit', function(){
              var cod=$(this).val();
                 var duis=$('#dui'+cod).text();
                 var dir=$('#dir'+cod).text();
                 var correo=$('#cor'+cod).text();

                 document.getElementById("dui").value = duis;
                 document.getElementById("direccion").value = dir;
                 document.getElementById("correo").value = correo;


                  });
       });
        
</script>



<script>

function habitacion() {
    
//alert("producto");


   // alert("Hola habitacion");
    
document.getElementById("existencia").value = 1;
document.getElementById("detalle").value = "Habitacion";
document.getElementById("precio").value = " ";
document.getElementById("total").value = " " ;
document.getElementById("cantidad").value = 1;


}
    function getComboA(selectObject) {
var id = selectObject.value;  
//var cant = document.getElementById('can1').text; 
var canti = document.getElementById('can' + id).value ;

document.getElementById("existencia").value = canti;

var deta = document.getElementById('det' + id).value ;

document.getElementById("detalle").value = deta;

var preci = document.getElementById('pre' + id).value ;

document.getElementById("precio").value = preci;

document.getElementById("total").value = preci * canti ;




}

function totalizar() {
    var deta = document.getElementById("detalle").value;
    var canti = document.getElementById("cantidad").value ;
    var preci = document.getElementById('precio').value ;
    if (deta == "Habitacion") {
        var impu2 = preci / 1.18 ;
        var impu3 = impu2 * 0.13 ;
        var impu5 = impu2 + impu3;
        var impu4 = impu2 * 0.05 ;

        impu6 = impu4.toFixed(2);
       var impu = parseFloat(impu6);
       // var impu = impu4 ;

        document.getElementById("total").value = preci - impu ;
    }else{
        document.getElementById("total").value = preci * canti ;
    }
    


}

function preciounit() {

                 const preuni = parseFloat(document.getElementById("precio").value); 
                 const subtotal2 = parseFloat(document.getElementById("recarga").value); 
                
                 const total = preuni * subtotal2 ;
                 //const total = subtotal;               
                 

document.getElementById("unirecarga").value = total ;

}

</script>




<script>
        

        $(document).ready(function() {
         
                              $("#recarga").change(function() {
                                                                            
                                
        
                           });
        

                        });
    </script>

@endsection


