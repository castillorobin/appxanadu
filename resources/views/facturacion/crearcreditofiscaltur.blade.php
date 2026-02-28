@extends('adminlte::page')

@section('title', 'Credito Fiscal')

@section('content_header')
    <h1>Factura Credito Fiscal con turismo</h1>
  

@stop

@section('content')
<style>
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Ingresar Datos</span>
                    
                </div>
                <div class="card-body bg-white">

                    
                    
                    <form action="/facturacion/creditofiscaltur" method="get" id="mainForm">
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

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">NIT/DUI</span>
                        <input type="text" class="form-control" id="dui" name="dui" placeholder="Ingrese el DUI/NIT">
                    </div>
                    </div>

    
        </div>
         <div class="row my-2">

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">NRC</span>
                        <input type="text" class="form-control" id="nrc" name="nrc" placeholder="Ingrese el NRC">
                    </div>
                    </div>
        </div>

          <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Nombre</span>
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre del cliente">
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Nombre comercial</span>
                        <input type="text" name="comercial" class="form-control" placeholder="Ingrese el nombre comercial">
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Actividad</span>
                         <select class="form-control js-example-basic-single" name="actividad" id="actividad">
                            <option value="">Seleccione una actividad...</option>
                            @foreach($actividades as $actividad)
                                <option value="{{$actividad->codigo}}">{{$actividad->descripcion}}</option>
                            @endforeach 
                        </select>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Departamento</span>
                         <select class="form-control js-example-basic-single produ" name="departamento" id="departamento" >
                        
                            @foreach($departamentos as $departamento)
                            <option value="{{$departamento->Codigo}}">{{$departamento->Valor}} </option>
                            
                            
                            @endforeach 
                            
                        </select>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2">

                    <div class=" col-6">
                    <div class="input-group">
                        <span class="input-group-text">Municipio</span>
                         <select class="form-control js-example-basic-single produ" name="municipio" id="municipio" >
                        
                            @foreach($municipios as $municipio)
                            <option value="{{$municipio->Codigo}}">{{$municipio->Valor}} </option>
                            
                            
                            @endforeach 
                            
                        </select>
                    </div>
                    </div>
    
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Direccion(Complemento)</span>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese la direccion">
                    </div>
                    </div>           
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Telefono</span>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el telefono">
                    </div>
                    </div>           
        </div>

        <div class="row my-2" >

                    <div class="col-6">
                    <div class="input-group">
                        <span class="input-group-text">Correo</span>
                        <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo">
                    </div>
                    </div>           
        </div>



        



<hr>
        <div class="row">
            
                   
                  
                  
                
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
            
<input type="text" class="form-control" id="existencia" name="existencia" readonly hidden>
            
            <div class=" col-1 " >
            
                <label class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio"  onChange="totalizar()">
                
            </div> 
            <div class=" col-1 " >
            
                <label class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total">
                
            </div> 
            
            <div class="col-3">
    <button type="button" id="btnAgregar" class="btn btn-success mt-4">Agregar</button>
</div> 

<hr>

<div class="row">
    <div class="col-12">
        <table class="table table-bordered" id="tablaDetalle">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Descripción</th>
                    <th>Cant.</th>
                    <th>Precio U.</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Turismo</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>


<div id="inputsOcultos"></div>

<div class="mt-3">
    <a href="/facturacion" class="btn btn-danger">Cancelar</a>
    <button type="submit" form="mainForm" class="btn btn-primary">Generar Factura</button>
</div>

</form>
    
                </div>
                </div>
            </div>
        </div>
   
</section>

 



@endsection


@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('#actividad').select2({
            placeholder: "Buscar actividad económica...",
            allowClear: true,
            width: '100%'
        });

        // Aplicar también a Depto y Municipio ya que usas la misma clase
        $('#departamento, #municipio').select2({
            width: '100%'
        });
    });

    let itemIndex = 0;

    function totalizar() {
        let cant = parseFloat($('#cantidad').val()) || 0;
        let precio = parseFloat($('#precio').val()) || 0;
        $('#total').val((cant * precio).toFixed(2));
    }

    $('#btnAgregar').click(function() {
        let detalle = $('#detalle').val();
        let cantidad = parseFloat($('#cantidad').val()) || 0;
        let precio = parseFloat($('#precio').val()) || 0;
        let totalBruto = parseFloat($('#total').val()) || 0;

        if (!detalle || cantidad <= 0 || precio <= 0) {
            alert("Por favor complete los campos del producto con valores válidos");
            return;
        }

        let montoSinImpuestos = 0;
        let iva = 0;
        let turismo = 0;

        // Lógica de impuestos solicitada
        if (detalle.toLowerCase().includes("habitacion")) {
            montoSinImpuestos = totalBruto / 1.18;
            iva = montoSinImpuestos * 0.13;
            turismo = montoSinImpuestos * 0.05;
        } else {
            montoSinImpuestos = totalBruto / 1.13;
            iva = montoSinImpuestos * 0.13;
            turismo = 0;
        }

        let fila = `
            <tr id="fila_${itemIndex}">
                <td>${detalle}</td>
                <td>${cantidad}</td>
                <td>$${precio.toFixed(2)}</td>
                <td>$${montoSinImpuestos.toFixed(2)}</td>
                <td>$${iva.toFixed(2)}</td>
                <td>$${turismo.toFixed(2)}</td>
                <td>$${totalBruto.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(${itemIndex})">X</button></td>
            </tr>
        `;
        $('#tablaDetalle tbody').append(fila);

        let inputs = `
            <div id="datos_fila_${itemIndex}">
                <input type="hidden" name="items[${itemIndex}][detalle]" value="${detalle}">
                <input type="hidden" name="items[${itemIndex}][cantidad]" value="${cantidad}">
                <input type="hidden" name="items[${itemIndex}][precio]" value="${precio}">
                <input type="hidden" name="items[${itemIndex}][monto_neto]" value="${montoSinImpuestos.toFixed(4)}">
                <input type="hidden" name="items[${itemIndex}][iva]" value="${iva.toFixed(4)}">
                <input type="hidden" name="items[${itemIndex}][turismo]" value="${turismo.toFixed(4)}">
                <input type="hidden" name="items[${itemIndex}][total]" value="${totalBruto.toFixed(2)}">
            </div>
        `;
        $('#inputsOcultos').append(inputs);

        itemIndex++;
        $('#detalle').val('');
        $('#cantidad').val('');
        $('#precio').val('');
        $('#total').val('');
    });

    function eliminarFila(index) {
        $(`#fila_${index}`).remove();
        $(`#datos_fila_${index}`).remove();
    }
</script>
@stop