@extends('adminlte::page')

@section('title', 'Administrar DTEs')

@section('content_header')
    <h1></h1>
  

@stop

@section('content')
<div class="container">
<h3>Documentos Tributarios Electrónicos (DTE)</h3>
<form method="GET" class="mb-3">
<div class="row">
<div class="col-md-4">
<input type="date" name="desde" class="form-control" value="{{ request('desde') }}" placeholder="Desde">
</div>
<div class="col-md-4">
<input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}" placeholder="Hasta">
</div>
<div class="col-md-4">
<button type="submit" class="btn btn-primary">Filtrar</button>
</div>
</div>
</form>


<table class="table table-bordered">
<thead>
<tr>
<th>Número Control</th>
<th>Código Generación</th>
<th>Fecha</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach ($dtes as $dte)
<tr>
<td>{{ $dte->numero_control }}</td>
<td>{{ $dte->codigo_generacion }}</td>
<td>{{ $dte->created_at->format('d/m/Y H:i') }}</td>
<td>

<a href="{{ route('dtes.verPdf', $dte->id) }}" target="_blank" class="btn btn-sm btn-info">Ver PDF</a>

@if($dte->json_legible_path || $dte->json_firmado_path)
<a href="{{ route('dtes.descargarJson', $dte->id) }}" class="btn btn-sm btn-success">Descargar JSON</a>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>


{{ $dtes->links() }}


</div>
@endsection