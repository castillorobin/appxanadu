<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\DocumentoDTE;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class DTEController extends Controller {
public function index(Request $request) {
$query = DocumentoDTE::query();

    // Filtro por rango de fechas si se envía
    if ($request->filled('desde') && $request->filled('hasta')) {
        $query->whereBetween('created_at', [
            Carbon::parse($request->desde)->startOfDay(),
            Carbon::parse($request->hasta)->endOfDay()
        ]);
    } else {
        // Por defecto mostrar solo los de HOY (en la zona horaria configurada)
        $query->whereBetween('created_at', [
            Carbon::today()->startOfDay(),
            Carbon::today()->endOfDay()
        ]);
    }

    $dtes = $query->orderByDesc('created_at')->paginate(15)->withQueryString();;

    return view('dtes.index', compact('dtes'));


}


public function descargarJson($id) {
$dte = DocumentoDTE::findOrFail($id);
// Preferir entregar el "legible" si existe, de lo contrario el firmado
$path = $dte->json_legible_path ?: $dte->json_firmado_path;
//dd($path);
return Storage::download($path);

}


public function verPdf($id) {
 $dte = \App\Models\DocumentoDTE::findOrFail($id);

    // 1) Carga el JSON legible desde storage
    if (!$dte->json_legible_path || !Storage::exists($dte->json_legible_path)) {
        abort(404, 'No hay JSON legible para generar PDF.');
    }

    $json = Storage::get($dte->json_legible_path);
    $legible = json_decode($json, true);

    if (!is_array($legible)) {
        abort(500, 'JSON legible inválido.');
    }

    // 2) Genera PDF desde la vista (sin guardar en disco)
    $pdf = Pdf::loadView('dtes.plantilla_pdf', ['dte' => $legible]);

    // 3) Devuelve el PDF en línea (inline)
    $nombre = 'dte_'.$legible['identificacion']['codigoGeneracion'].'.pdf';
    return $pdf->stream($nombre); // o ->download($nombre) si prefieres forzar descarga
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




public function descargarJsonLote(Request $request)
{
    $tipo = $request->input('tipo', 'legible'); // legible | firmado | original
    if (!in_array($tipo, ['legible','firmado','original'])) {
        $tipo = 'legible';
    }

    // === armar query con mismos filtros que tu index ===
    $query = DocumentoDTE::query();

    $desde = $request->input('desde');
    $hasta = $request->input('hasta');
    $tz    = 'America/El_Salvador';

    if ($desde || $hasta) {
        $desdeC = $desde ? Carbon::parse($desde, $tz)->startOfDay() : Carbon::minValue();
        $hastaC = $hasta ? Carbon::parse($hasta, $tz)->endOfDay()   : Carbon::now($tz)->endOfDay();
        $query->whereBetween('created_at', [$desdeC, $hastaC]);
    } else {
        // si quieres restringir por defecto a HOY
        $query->whereBetween('created_at', [Carbon::today($tz)->startOfDay(), Carbon::today($tz)->endOfDay()]);
    }

    // === preparar ZIP temporal ===
    Storage::makeDirectory('tmp');
    $zipName = 'dtes_json_'.now($tz)->format('Ymd_His').'.zip';
    $zipPath = storage_path('app/tmp/'.$zipName);

    $zip = new \ZipArchive();
    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
        abort(500, 'No se pudo crear el ZIP.');
    }

    // Manifest de faltantes
    $faltantes = [];

    // === recorrer TODOS los registros filtrados (no solo la página) ===
    $query->orderBy('id')->chunkById(500, function($chunk) use ($zip, $tipo, &$faltantes) {
        foreach ($chunk as $doc) {
            // elegir la ruta según el tipo
            $ruta = match ($tipo) {
                'firmado'  => $doc->json_firmado_path,
                'original' => $doc->json_original_path,
                default    => $doc->json_legible_path,
            };

            // nombre de archivo amigable
            $base = trim(($doc->codigo_generacion ?: 'SIN_CODIGO'));
            $numc = trim(($doc->numero_control ?: 'SIN_NUMCTRL'));
            $fname = sprintf('%s_%s.json', $base, $numc);

            if ($ruta && Storage::exists($ruta)) {
                // ruta absoluta del storage
                $abs = Storage::path($ruta);
                $zip->addFile($abs, $fname);
            } else {
                $faltantes[] = $fname.' => no encontrado ('.$ruta.')';
            }
        }
    });

    if (!empty($faltantes)) {
        $zip->addFromString('faltantes.txt', implode(PHP_EOL, $faltantes));
    }

    $zip->close();

    // === descarga y elimina ===
    return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
}




}