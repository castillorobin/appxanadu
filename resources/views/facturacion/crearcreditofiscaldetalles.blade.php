@extends('adminlte::page')

@section('title', 'Credito Fiscal')

@section('content_header')
    <h1>Factura Credito Fiscal</h1>
  

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
                            <input class="form-control form-control-transparent fw-bold pe-5" value="{{ date('d/m/Y') }}" name="fecha" readonly />
 
                        </div>
                    </div>


                  
        </div>

        <div class="row my-2">

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">NIT/DUI</span>
                        <input type="text" class="form-control" id="dui" name="dui" value="{{ $cotiactual[0]->nit}}" readonly>
                    </div>
                    </div>

    
        </div>
         <div class="row my-2">

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">NRC</span>
                        <input type="text" class="form-control" id="nrc" name="nrc" value="{{ $cotiactual[0]->nrc}}" readonly>
                    </div>
                    </div>
        </div>

          <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Nombre</span>
                        <input type="text" name="nombre" class="form-control" value="{{ $cotiactual[0]->nombre}}" readonly>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Nombre comercial</span>
                        <input type="text" name="comercial" class="form-control" value="{{ $cotiactual[0]->comercial}}" readonly>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Actividad</span>
                         <input type="text" value="{{ $cotiactual[0]->codactividad}}" class="form-control" readonly>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Departamento</span>
                         <input type="text" value="{{ $cotiactual[0]->departamento}}" class="form-control" readonly>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Municipio</span>
                         <input type="text" value="{{ $cotiactual[0]->municipio}}" class="form-control" readonly>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Direccion(Complemento)</span>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $cotiactual[0]->direccion}}" readonly>
                    </div>
                    </div>           
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Telefono</span>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $cotiactual[0]->telefono}}" readonly>
                    </div>
                    </div>           
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Correo</span>
                        <input type="text" class="form-control" id="correo" name="correo" value="{{ $cotiactual[0]->correo}}" readonly>
                    </div>
                    </div>           
        </div>



        



<hr>
        <div class="row">
            
                   
                  <form action="/facturacion/detalleaddfiscal" method="get">
                        @csrf
                                @method('GET')
                  
                
        </div>
        
        <div class="row">
            <div class="mb-3 col-2">
                <label class="form-label">Descripcion </label>
                        <input type="text" class="form-control" id="detalle" name="detalle" required>
            </div>
            <div class=" col-1 " >
            
                <label class="form-label">Cantidad </label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" onChange="totalizar()">
                
            </div>  
             <input type="text" class="form-control" id="existencia" name="existencia" readonly hidden>

           
            <div class=" col-1 " >
            
                <label class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio"  onChange="totalizar()">
                
            </div> 
            <div class=" col-1 " >
            
                <label class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total">
                
            </div> 

<input type="text" class="form-control" id="codigo" name="codigo" value="{{ $cotiactual[0]->id}}" hidden>



            
            <div class=" col-3 " >
            
            <button type="submit" class="btn btn-success mt-4" >Agregar</button>
        </form>
            </div>   





<table id="prove" class="table table-bordered shadow-lg mt-4 cell-border">
    <thead >
        <tr >
            
            <th scope="col">Detalle</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Total</th>
            
            <th scope="col">Accion</th>
        </tr>
    </thead>
    <tbody>{{ $subtotal=0 }}{{ $turismo=0 }}
        
        @for ($i=0; $i< count($detalles); $i++)
        <tr >
        <td>{{ $detalles[$i]->descripcion }}</td>
       
        <td>{{ $detalles[$i]->cantidad }}</td>
        <td>${{ $detalles[$i]->total }}</td>
        <td>${{ $detalles[$i]->total }}</td>
        {{ $subtotal = $subtotal + $detalles[$i]->total }}
    
        <td class="opciones text-center" style="">
           
            <a href="/facturacion/borrardet/{{ $detalles[$i]->id }}">
            <button type="button" class="btn btn-danger">Borrar</button>
            </a>
            
       <input type="text" value="{{ $turismo = $turismo  + (($detalles[$i]->total) * 0.13) }}" hidden> 
       
        </td>
        </tr>
        @endfor
           
        <tr >
            <td style="text-align: center; border: 0px solid black; "></td>
            <td style="text-align: center; border: 0px solid black; "></td>
            
           
            <td style="text-align: center;">Subtotal: </td>
            <td style="text-align: center;">$ {{ round($subtotal,2 )}}</td>
          
        
           
            </tr>
            <tr >
                <td style="text-align: center; border: 0px solid black; "></td>
                <td style="text-align: center; border: 0px solid black; "></td>
               
                <td style="text-align: center; font-size:13px;">IVA 13%: </td>
                <td style="text-align: center;">$ {{ round($turismo,2)}}</td>
              
            
               
                </tr>
                <tr >
                    <td style="text-align: center; border: 0px solid black; "></td>
                    <td style="text-align: center; border: 0px solid black; "></td>
                   
                    <td style="text-align: center; ">Total: </td>
                    <td style="text-align: center;">$ {{ round( $subtotal + $turismo, 2)}}</td>
                  
                
                   
                    </tr>    
    </tbody>

    </table>
                    
    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $cotiactual[0]->codigo}}" hidden>
<hr>
<a href="/facturacion">
                    <button type="button" class="btn btn-danger">Cancelar</button> </a>
&nbsp; &nbsp; &nbsp;
<a href="/facturacion/generardtefiscal/{{ $cotiactual[0]->id}}">
                    <button type="button" class="btn btn-primary">Facturar</button></a>





    
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

        document.getElementById("total").value = preci * canti ;
    }else{
        document.getElementById("total").value = preci * canti ;
    }
    

}



</script>






@endsection


