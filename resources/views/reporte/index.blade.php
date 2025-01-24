@extends('adminlte::page')

@section('title', 'Reporte de controles')

@section('content_header')
    <h1>Control</h1>
@stop

@section('content')
    

    
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Reporte de controles</span>
                    
                    <p></p>

                </div>
                <div class="card-body bg-white">
                <form action="/reportecontrol" method="get">
@csrf
        @method('GET')
                        
                    <div class="row">
                    
                  <div class="col-3">
                  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Inicio</span>
  </div>
  <input type="date" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="inicio">
</div>
                  </div>
                                      
                  <div class="col-3">
                  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Fin</span>
  </div>
  <input type="date" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="fin">
</div>
                  </div>
                  <div class="col-3">
                
                 <button type="submit" class="btn btn-success"><i class="fas fa-file-alt"></i> &nbsp; Enviar</button>
                 </form>  
                 <a href="/reporte/diario">
                 <button type="button" class="btn btn-warning" style="margin-left: 20px;">Reporte Diario</button>
                 </a>
                  </div>
                    </div>
                    <table id="clientes" class="table table-bordered shadow-lg mt-4 cell-border">
                        <thead >
                            <tr >
                                <th scope="col">Fecha</th>
                                <th scope="col">Vehiculo</th>
                                <th scope="col">Placa</th>
                                <th scope="col">Habitacion</th>
                                <th scope="col">Entrada</th>
                                <th scope="col">Tarifa</th>
                                <th scope="col">Salida</th>
                            </tr>
                        </thead>
                        <tbody>      
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="opciones text-center" style="">
                            </td>
                            </tr>
                           
                       
                        </tbody>

                        </table>
                               
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
     </script>
@stop
