<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\DocumentoDTE;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class DTEController extends Controller {
public function index(Request $request) {
$query = DocumentoDTE::query();


if ($request->filled('desde') && $request->filled('hasta')) {
$query->whereBetween('created_at', [$request->desde, $request->hasta]);
}


$dtes = $query->orderByDesc('created_at')->paginate(15);


return view('dtes.index', compact('dtes'));
}


public function descargarJson($id) {
$dte = DocumentoDTE::findOrFail($id);
// Preferir entregar el "legible" si existe, de lo contrario el firmado
$path = $dte->json_legible_path ?: $dte->json_firmado_path;
return Storage::download($path);
}


public function verPdf($id) {
$dte = DocumentoDTE::findOrFail($id);
return response()->file(storage_path("app/{$dte->pdf_path}"));
}


// Lógica para guardar JSON firmado y generar PDF tras envío exitoso
public function guardarDteExitoso($dte, $respuestaAPI, $jsonFirmado) {
$codigo = $dte->identificacion->codigoGeneracion ?? Str::uuid();
$nombreArchivoJson = "dte_{$codigo}.json";
$rutaJson = "dtes_json/{$nombreArchivoJson}";


Storage::put($rutaJson, json_encode($jsonFirmado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


// Generar PDF usando DomPDF
$pdf = Pdf::loadView('dtes.plantilla_pdf', ['dte' => $dte]);
$nombreArchivoPdf = "dte_{$codigo}.pdf";
$rutaPdf = "dtes_pdfs/{$nombreArchivoPdf}";
Storage::put($rutaPdf, $pdf->output());


DocumentoDTE::create([
'sello_recibido' => $respuestaAPI->selloRecibido ?? null,
'codigo_generacion' => $codigo,
'numero_control' => $dte->identificacion->numeroControl ?? null,
'factura' => $dte->coticode ?? null,
'fecha_generacion' => now(),
'json_firmado_path' => $rutaJson,
'pdf_path' => $rutaPdf,
]);
}
}