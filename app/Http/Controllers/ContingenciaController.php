<?php

namespace App\Http\Controllers;


use App\Models\DocumentoDTE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ContingenciaController extends Controller
{
// Vista principal: lista DTE en contingencia (pendientes y regularizados)
public function index(Request $request)
{
$query = DocumentoDTE::query()->where('es_contingencia', true);


if ($request->filled('estado')) {
if ($request->estado === 'pendientes') {
$query->where('regularizado', false);
} elseif ($request->estado === 'regularizados') {
$query->where('regularizado', true);
}
}


if ($request->filled('desde') && $request->filled('hasta')) {
$query->whereBetween('fecha_contingencia', [$request->desde, $request->hasta]);
}


$dtes = $query->orderByDesc('fecha_contingencia')->paginate(15);
return view('contingencia.index', compact('dtes'));
}

/**
* Crear un DTE en modo contingencia (no se transmite). Se generan y guardan JSON original/legible.
* Espera un payload $dteOriginal (array/objeto) ya armado como en tu flujo normal.
*/
public function emitirEnContingencia(Request $request)
{
// 1) Validar entradas mínimas
$request->validate([
'dte' => 'required', // JSON del DTE original (antes de firmar)
'tipo_contingencia' => 'nullable|string|max:5',
'motivo_contingencia' => 'nullable|string|max:255',
]);


$dteOriginal = json_decode($request->input('dte'), true);
if (!is_array($dteOriginal)) {
return back()->withErrors('Estructura DTE inválida');
}


// 2) Preparar identificadores
$codigo = $dteOriginal['identificacion']['codigoGeneracion'] ?? (string) Str::uuid();
$numControl = $dteOriginal['identificacion']['numeroControl'] ?? null;


// 3) Marcar bandera de contingencia en la estructura de identificación (esto viaja también en JSON legible)
$dteOriginal['identificacion']['tipoContingencia'] = $request->input('tipo_contingencia', '1');
$dteOriginal['identificacion']['motivoContin'] = $request->input('motivo_contingencia', 'Contingencia operativa');


// 4) Guardar artefactos (JSON original + legible SIN firma/sello)
Storage::makeDirectory('dtes_json');
$rutaOriginal = "dtes_json/original_{$codigo}.json";
Storage::put($rutaOriginal, json_encode($dteOriginal, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


// El legible en contingencia NO tiene firma ni sello
$legible = $dteOriginal;
$rutaLegible = "dtes_json/legible_{$codigo}.json";
Storage::put($rutaLegible, json_encode($legible, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


// (Opcional) PDF al vuelo: no almacenar, se puede generar desde verPdfContingencia


// 5) Persistir registro marcado como contingencia
$doc = DocumentoDTE::create([
'codigo_generacion' => $codigo,
'numero_control' => $numControl,
'fecha_generacion' => now(),
'tipo_dte' => $dteOriginal['identificacion']['tipoDte'] ?? null,
'json_original_path' => $rutaOriginal,
'json_legible_path' => $rutaLegible,
'es_contingencia' => true,
'tipo_contingencia' => $request->input('tipo_contingencia','1'),
'motivo_contingencia' => $request->input('motivo_contingencia','Contingencia operativa'),
'fecha_contingencia' => now(),
]);


return redirect()->route('contingencia.index')->with('ok', 'DTE creado en contingencia.');
}


// Genera PDF al vuelo para un DTE en contingencia (sin firma/sello)
public function verPdfContingencia($id)
{
$doc = DocumentoDTE::where('es_contingencia', true)->findOrFail($id);
if (!$doc->json_legible_path || !Storage::exists($doc->json_legible_path)) {
abort(404, 'No hay JSON legible');
}
$legible = json_decode(Storage::get($doc->json_legible_path), true);
$pdf = Pdf::loadView('dtes.plantilla_pdf', ['dte' => $legible]);
return $pdf->stream('dte_contingencia_'.$doc->codigo_generacion.'.pdf');
}

/**
* Regularizar un DTE en contingencia: firma y transmisión.
* Integra con tu función existente enviarDTEAPI($dteOriginal) que devuelve selloRecibido, dteFirmado, etc.
*/
public function regularizar($id)
{
$doc = DocumentoDTE::where('es_contingencia', true)->where('regularizado', false)->findOrFail($id);
if (!$doc->json_original_path || !Storage::exists($doc->json_original_path)) {
return back()->withErrors('JSON original no encontrado.');
}
$dteOriginal = json_decode(Storage::get($doc->json_original_path)); // objeto stdClass


try {
// 1) Llamar a tu API de firma/transmisión
$respuestaAPI = enviarDTEAPI($dteOriginal); // Debes tenerla disponible (como en tu flujo actual)


// 2) Extraer artefactos de respuesta y reconstruir legible FINAL (con firma y sello AL FINAL)
$dteArray = json_decode(json_encode($dteOriginal), true);
$codigoGeneracion = $respuestaAPI->codigoGeneracion ?? ($dteArray['identificacion']['codigoGeneracion'] ?? (string) Str::uuid());
$numControl = $respuestaAPI->numControl ?? ($dteArray['identificacion']['numeroControl'] ?? null);
$selloRecibido = $respuestaAPI->selloRecibido ?? null;
$jwsFirmado = $respuestaAPI->dteFirmado ?? null;


// Actualizar identificacion
$dteArray['identificacion']['codigoGeneracion'] = $codigoGeneracion;
if ($numControl) { $dteArray['identificacion']['numeroControl'] = $numControl; }


// Armar legible final
$legible = $dteArray;
if ($jwsFirmado) { $legible['firmaElectronica'] = $jwsFirmado; }
if ($selloRecibido) { unset($legible['selloRecibido']); $legible = array_merge($legible, ['selloRecibido' => $selloRecibido]); }


// Guardar artefactos
Storage::makeDirectory('dtes_json');
$rutaLegible = "dtes_json/legible_{$codigoGeneracion}.json";
Storage::put($rutaLegible, json_encode($legible, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


$rutaFirmado = null;
if ($jwsFirmado) {
$rutaFirmado = "dtes_json/firmado_{$codigoGeneracion}.json";
Storage::put($rutaFirmado, $jwsFirmado);
}


// Actualizar registro
$doc->update([
'sello_recibido' => $selloRecibido,
'numero_control' => $numControl,
'json_legible_path' => $rutaLegible,
'json_firmado_path' => $rutaFirmado,
'regularizado' => true,
'fecha_regularizacion' => now(),
'error_regularizacion' => null,
]);


return back()->with('ok', 'DTE regularizado correctamente.');
} catch (\Throwable $e) {
$doc->update([
'error_regularizacion' => $e->getMessage(),
]);
return back()->withErrors('Error al regularizar: '.$e->getMessage());
}
}


// Regularización masiva (por rango de fechas o todos los pendientes)
public function regularizarPendientes(Request $request)
{
$query = DocumentoDTE::where('es_contingencia', true)->where('regularizado', false);
if ($request->filled('desde') && $request->filled('hasta')) {
$query->whereBetween('fecha_contingencia', [$request->desde, $request->hasta]);
}
$pendientes = $query->limit(50)->get(); // limitar por lote


$ok = 0; $err = 0;
foreach ($pendientes as $doc) {
try {
$this->regularizar($doc->id); // reutiliza lógica
$ok++;
} catch (\Throwable $e) { $err++; }
}


return back()->with('ok', "Regularización finalizada. OK: {$ok}, ERR: {$err}");
}


}