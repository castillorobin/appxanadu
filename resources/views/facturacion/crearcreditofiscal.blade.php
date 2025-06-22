@extends('adminlte::page')

@section('title', 'Cotización')

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

                    
                    
                    <form action="/facturacion/creditofiscaldte" method="get">
                        @csrf
                                @method('GET')
<div class="container">
<input type="text" name="codigo" id="codigo" value="20253">
<button type="submit">Facturar</button>

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


