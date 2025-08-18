@extends('adminlte::page')

@section('title', 'Administrar DTEs')

@section('content_header')
    <h1></h1>
  

@stop

@section('content')
<h2>Listado de DTE Emitidos</h2>
<table class="table">
    <thead>
        <tr>
            <th>Código Generación</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dtes as $dte)
        <tr>
            <td>{{ $dte->codigo_generacion }}</td>
            <td>{{ $dte->tipo_documento }}</td>
            <td>{{ $dte->fecha_emision->format('d/m/Y') }}</td>
            <td>{{ $dte->estado }}</td>
            <td>
                <a href="{{ route('dtes.show', $dte->id) }}" class="btn btn-primary btn-sm">Ver</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $dtes->links() }}
@endsection