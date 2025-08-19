@extends('adminlte::page')

@section('title', 'Administrar DTEs')

@section('content_header')
    <h1></h1>
  

@stop

@section('content')

<div class="container">
<h3>Contingencia DTE</h3>


<form method="GET" class="mb-3">
<div class="form-row">
<div class="col">
<label>Estado</label>
<select name="estado" class="form-control">
<option value="">Todos</option>
<option value="pendientes" {{ request('estado')==='pendientes'?'selected':'' }}>Pendientes</option>
<option value="regularizados" {{ request('estado')==='regularizados'?'selected':'' }}>Regularizados</option>
</select>
</div>
<div class="col">
<label>Desde</label>
<input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
</div>
<div class="col">
<label>Hasta</label>
<input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
</div>
<div class="col align-self-end">
<button class="btn btn-primary btn-block">Filtrar</button>
</div>
</div>
</form>
<a href="">
<button type="button" class="btn btn-success mb-3" >Crear contingencia habitacion</button>
</a>
<a href="">
<button type="button" class="btn btn-success mb-3" >Crear contingencia producto</button>
</a>
<!-- regularizar en lote 
<form method="POST" action="{{ route('contingencia.regularizarPendientes') }}" class="mb-3">
@csrf
<div class="form-row">
<div class="col">
<input type="date" name="desde" class="form-control" placeholder="Desde">
</div>
<div class="col">
<input type="date" name="hasta" class="form-control" placeholder="Hasta">
</div>
<div class="col">
<button class="btn btn-success btn-block">Regularizar pendientes (lote)</button>
</div>
</div>
</form>
-->
<table class="table table-bordered table-sm">
<thead>
<tr>
<th>Código</th><th>N° Control</th><th>Fecha Contingencia</th><th>Motivo</th><th>Estado</th><th>Acciones</th>
</tr>
</thead>
<tbody>
@forelse($dtes as $doc)
<tr>
<td>{{ $doc->codigo_generacion }}</td>
<td>{{ $doc->numero_control }}</td>
<td>{{ optional($doc->fecha_contingencia)->format('d/m/Y H:i') }}</td>
<td>{{ $doc->motivo_contingencia }}</td>
<td>
@if(!$doc->regularizado)
<span class="badge badge-warning">Pendiente</span>
@else
<span class="badge badge-success">Regularizado</span>
@endif
</td>
<td class="text-nowrap">
<a href="{{ route('contingencia.pdf', $doc->id) }}" target="_blank" class="btn btn-info btn-sm">PDF</a>
@if(!$doc->regularizado)
<form method="POST" action="{{ route('contingencia.regularizar', $doc->id) }}" class="d-inline">
@csrf
<button class="btn btn-success btn-sm">Regularizar</button>
</form>
@endif
</td>
</tr>
@empty
<tr><td colspan="6" class="text-center">Sin documentos en contingencia</td></tr>
@endforelse
</tbody>
</table>


{{ $dtes->links() }}
</div>


@endsection