@extends('adminlte::page')

@section('title', 'Proveedor')

@section('content_header')
    <h1>Listado de Productos</h1>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@stop

@section('content')



<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Productos</span>
                 
                    
                   
                      

                    <a href="/producto/crear">
                    <button type="button" class="btn btn-success mx-3" style="float: right;"><i class="fas fa-plus-circle"></i> Agregar Producto</button>
                </a>
                </div>
                <div class="card-body bg-white">

                    @foreach($productos as $producto)
        
                    <input type="text" hidden id="det{{ $producto->id }}" value="{{ $producto->Descripcion }}"> 
                    <input type="text" hidden id="can{{ $producto->id }}" value="{{ $producto->Cantidad }}"> 
             
                    
                    @endforeach

                    <table id="prove" class="table table-bordered shadow-lg mt-4 cell-border">
                        <thead >
                            <tr >
                                
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @for ($i=0; $i< count($productos); $i++)
                            <tr >
                            <td>{{ $productos[$i]->id }}</td>
                           
                            <td>{{ $productos[$i]->Nombre }}</td>
                            <td>{{ $productos[$i]->Descripcion }}</td>
                            <td>{{ $productos[$i]->Proveedor }}</td>
                            <td>{{ $productos[$i]->Cantidad }}</td> 
                        
                            <td class="opciones text-center" style="">
                                       

                            <a href="/producto/editar/{{ $productos[$i]->id }}">
                                <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                            </a>

                                <a href="/producto/borrar/{{ $productos[$i]->id }}">
                                <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </a>
 
                            </td>
                            </tr>
                            @endfor
                        </tbody>

                        </table>
                        



                    
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Cargar-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Cargar producto</h1>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/producto/cargar" method="get">
                @csrf
                        @method('GET')
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Seleccionar producto</label>
                <select class="form-control" aria-label="exampleFormControlInput1" name="producto" id="producto" onChange="getComboA(this)">
                    <option value="seleccionar">Seleccionar</option>
                    @foreach($productos as $producto)
                    <option value="{{$producto->id}}">{{$producto->Nombre}}</option>
                    
                    
                    @endforeach
                  </select>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" readonly>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Existencia</label>
                <input type="text" class="form-control" id="cantidad" name="cantidad" readonly>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Cargar</label>
                <input type="text" class="form-control" id="cargando"  name="cargando">
                <input type="text" class="form-control" id="idcarga" name="idcarga" hidden>
              </div>

         
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </form>
        </div>
      </div>
    </div>
  </div>
<!-- Termina Modal Cargar-->

<!-- Modal Descargar-->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel2">Descargar producto</h1>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/producto/descarga" method="get">
                @csrf
                        @method('GET')
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Seleccionar producto</label>
                <select class="form-control" aria-label="exampleFormControlInput1" name="productodes" id="productodes" onChange="getComboB(this)">
                   <option value="seleccionar">Seleccionar</option>
                    @foreach($productos as $producto)
                    <option value="{{$producto->id}}">{{$producto->Nombre}}</option>
                    
                    
                    @endforeach
                  </select>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripciondes" readonly>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Existencia</label>
                <input type="text" class="form-control" id="cantidaddes" name="cantidaddes" readonly>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Descargar</label>
                <input type="text" class="form-control" id="cargandodes"  name="cargandodes">
                <input type="text" class="form-control" id="iddesca" name="iddesca" hidden>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nota</label>
                <input type="text" class="form-control" id="notades"  name="notades">
                
              </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </form>
        </div>
      </div>
    </div>
  </div>
<!-- Termina Modal Cargar-->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>


<script>
     /*
$(document).ready( function () {
    $('#prove').DataTable();
} );
*/

new DataTable('#prove', {
    
    
});

</script>

<script>
function getComboA(selectObject) {
    var id = selectObject.value;  
    //var cant = document.getElementById('can1').text; 
    var canti = document.getElementById('can' + id).value ;
    
    document.getElementById("cantidad").value = canti;
    
    var deta = document.getElementById('det' + id).value ;
    
    document.getElementById("descripcion").value = deta;
    document.getElementById("idcarga").value = id;
    
    
    }

    function getComboB(selectObject) {
    var id = selectObject.value;  
    //var cant = document.getElementById('can1').text; 
    var canti = document.getElementById('can' + id).value ;
    
    document.getElementById("cantidaddes").value = canti;
    
    var deta = document.getElementById('det' + id).value ;
    
    document.getElementById("descripciondes").value = deta;
    document.getElementById("iddesca").value = id;
    
    
    }
</script>

@endsection


