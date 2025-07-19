<?php

namespace App\Http\Controllers;

use App\Models\DteEmitido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class DteEmitidoController extends Controller
{
    public function index()
    {
        $dtes = DteEmitido::latest()->paginate(15);
        return view('dtes.index', compact('dtes'));
    }

    public function show($id)
    {
        $dte = DteEmitido::findOrFail($id);
        return view('dtes.show', compact('dte'));
    }

    public function anular(Request $request, $id)
    {
        $dte = DteEmitido::findOrFail($id);

        $fechaLimite = $dte->tipo_documento === 'Factura'
            ? $dte->fecha_emision->copy()->addMonths(3)
            : $dte->fecha_emision->copy()->addDay();

        if (now()->gt($fechaLimite)) {
            return back()->withErrors('El plazo para invalidar este DTE ha expirado.');
        }

        $evento = [
            'identificacion' => [
                'codigoGeneracionDocumentoInvalidar' => $dte->codigo_generacion,
                'codigoGeneracionDocumentoReemplazo' => $request->input('codigo_reemplazo') ?? 'null',
                'tipoDocumento' => '01',
                'tipoEvento' => '03',
            ],
            'emisor' => [
                'nit' => env('DTE_NIT'),
                'nombre' => env('DTE_NOMBRE')
            ],
            'receptor' => [
                'nombre' => 'null',
                'documento' => 'null'
            ],
            'motivo' => [
                'tipoInvalidacion' => $request->input('tipo_invalidacion'),
                'descripcion' => $request->input('descripcion'),
                'responsable' => [
                    'nombre' => $request->input('responsable'),
                    'tipoDocumento' => $request->input('tipo_doc'),
                    'numeroDocumento' => $request->input('n_doc')
                ],
                'solicitante' => [
                    'nombre' => $request->input('solicitante'),
                    'tipoDocumento' => $request->input('tipo_doc_sol'),
                    'numeroDocumento' => $request->input('n_doc_sol')
                ]
            ]
        ];

        $token = $this->obtenerToken();
        $response = Http::withToken($token)
            ->post(env('DGII_URL') . '/eventos/invalidacion', $evento);

        if ($response->ok()) {
            $dte->update(['estado' => 'INVALIDADO']);
            return redirect()->route('dtes.index')->with('success', 'DTE invalidado exitosamente.');
        } else {
            return back()->withErrors('Error al invalidar: ' . $response->body());
        }
    }

    private function obtenerToken()
    {
        $response = Http::post(env('DGII_URL') . '/autenticacion', [
            'usuario' => env('DGII_USER'),
            'clave' => env('DGII_PASS')
        ]);

        return $response->json('token');
    }
}
