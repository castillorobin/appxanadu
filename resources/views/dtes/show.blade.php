@extends('adminlte::page')

@section('title', 'Administrar DTEs')

@section('content_header')
    <h1></h1>
  

@stop

@section('content')


<h2>Detalle DTE: {{ $dte->codigo_generacion }}</h2>
<p><strong>Tipo:</strong> {{ $dte->tipo_documento }}</p>
<p><strong>Fecha:</strong> {{ $dte->fecha_emision->format('d/m/Y') }}</p>
<p><strong>Estado:</strong> {{ $dte->estado }}</p>

@if($dte->estado !== 'INVALIDADO')
<h4>Anular este DTE</h4>
<form method="POST" action="{{ route('dtes.anular', $dte->id) }}">
    @csrf
    <div class="form-group">
        <label>Motivo:</label>
        <input type="text" name="descripcion" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Tipo Invalidación (cat-024):</label>
        <select name="tipo_invalidacion" class="form-control">
            <option value="1">Error en la información</option>
            <option value="2">Rescindir operación</option>
            <option value="3">Otro</option>
        </select>
    </div>
    <div class="form-group">
        <label>Responsable (Nombre, Tipo Doc, N° Doc):</label>
        <input type="text" name="responsable" class="form-control" required>
        <input type="text" name="tipo_doc" class="form-control" required>
        <input type="text" name="n_doc" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Solicitante (Nombre, Tipo Doc, N° Doc):</label>
        <input type="text" name="solicitante" class="form-control" required>
        <input type="text" name="tipo_doc_sol" class="form-control" required>
        <input type="text" name="n_doc_sol" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Código del DTE que lo reemplaza (si aplica):</label>
        <input type="text" name="codigo_reemplazo" class="form-control">
    </div>
    <button class="btn btn-danger">Invalidar DTE</button>
</form>
@endif
@endsection
