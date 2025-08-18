<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php

use App\Models\DocumentoDTE;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
       // mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}

function numeroALetras($numero) {
    $unidad = [
        '', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
        'diez', 'once', 'doce', 'trece', 'catorce', 'quince',
        'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte'
    ];

    $decenas = [
        '', '', 'veinti', 'treinta', 'cuarenta', 'cincuenta',
        'sesenta', 'setenta', 'ochenta', 'noventa'
    ];

    $centenas = [
        '', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos',
        'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'
    ];

    if ($numero == 0) return 'Cero dólares 00/100';

    $entero = floor($numero);
    $centavos = round(($numero - $entero) * 100);

    $letras = '';

    if ($entero >= 1000000) {
        $millones = floor($entero / 1000000);
        $letras .= numeroALetras($millones) . ' millón' . ($millones > 1 ? 'es' : '') . ' ';
        $entero %= 1000000;
    }

    if ($entero >= 1000) {
        $miles = floor($entero / 1000);
        if ($miles == 1) {
            $letras .= 'mil ';
        } else {
            $letras .= numeroALetras($miles) . ' mil ';
        }
        $entero %= 1000;
    }

    if ($entero > 0) {
        if ($entero == 100) {
            $letras .= 'cien';
        } else {
            $c = floor($entero / 100);
            $d = floor(($entero % 100) / 10);
            $u = $entero % 10;

            $letras .= $centenas[$c];

            if ($d == 1 || ($d == 2 && $u == 0)) {
                $letras .= ($c > 0 ? ' ' : '') . $unidad[$d * 10 + $u];
            } elseif ($d == 2) {
                $letras .= 'i' . $unidad[$u];
            } elseif ($d > 2) {
                $letras .= ($c > 0 ? ' ' : '') . $decenas[$d];
                if ($u > 0) {
                    $letras .= ' y ' . $unidad[$u];
                }
            } elseif ($u > 0) {
                $letras .= ($c > 0 ? ' ' : '') . $unidad[$u];
            }
        }
    }

    $letras = trim(ucfirst($letras)) . ' dólares';

    $letras .= ' con ' . str_pad($centavos, 2, '0', STR_PAD_LEFT) . '/100';

    return $letras;
}

function sacarivas($detalles){
    $iva = 0;
    foreach ($detalles as $detalle) {
        $iva += $detalle->preciouni;

    }
   $ivatotal = (($iva / 1.13) * 0.13);
    return $ivatotal;
}

function sacartotal($detalles){
    $total = 0;
    foreach ($detalles as $detalle) {
        $total += $detalle->preciouni;

    }
    return $total;
}



// Clases para estructurar el DTE
class Identificacion {
    public $version = 1;
    public $ambiente = "00";
    public $tipoDte = "01"; 
    public $numeroControl;
    public $codigoGeneracion;
    public $tipoModelo = 1;
    public $tipoOperacion = 1;
    public $tipoContingencia = null;
    public $motivoContin = null;
    public $fecEmi;
    public $horEmi;
    public $tipoMoneda = "USD";
}

class Direccion {
    public $departamento;
    public $municipio;
    public $complemento;
}

class Emisor {
    public $nit;
    public $nrc;
    public $nombre;
    public $codActividad;
    public $descActividad;
    public $nombreComercial;
    public $tipoEstablecimiento;
    public $direccion;
    public $telefono;
    public $codEstableMH;
    public $codEstable;
    public $codPuntoVentaMH;
    public $codPuntoVenta;
    public $correo;
    //public $tributos;
}

class Receptor {
    public $nrc;
    public $tipoDocumento;
    public $numDocumento;
    public $nombre;
    public $codActividad;
    public $descActividad;
    public $direccion;
    public $telefono;
    public $correo;
}

class ItemDocumento {
    public $numItem;
    public $tipoItem;
    public $numeroDocumento;
    public $cantidad;
    public $codigo;
    public $codTributo;
    public $uniMedida;
    public $descripcion;
    public $precioUni;
    public $montoDescu;
    public $ventaNoSuj;
    public $ventaExenta;
    public $ventaGravada;
    public $tributos;
    public $psv;
    public $ivaItem;
    public $noGravado;

}

class Pago {
    public $codigo;
    public $montoPago;
    public $referencia;
    public $periodo;
    public $plazo;
}

class Tributo {
    public $codigo;
    public $descripcion;
    public $valor;
}

class Resumen {
    public $totalNoSuj;
    public $totalExenta;
    public $totalGravada;
    public $subTotalVentas;
    public $descuNoSuj;
    public $descuExenta;
    public $descuGravada;
    public $porcentajeDescuento;
    public $totalDescu;
    public $subTotal;
    public $ivaRete1;
    public $reteRenta;
    public $montoTotalOperacion;
    public $totalNoGravado;
    public $totalPagar;
    public $totalLetras;
    public $saldoFavor;
    public $condicionOperacion;
    public $pagos;
    public $tributos;
    public $numPagoElectronico;
    public $totalIva;
}

class Extension {
    public $nombEntrega;
    public $docuEntrega;
    public $nombRecibe;
    public $docuRecibe;
    public $observaciones;
    public $placaVehiculo;
}

class DocumentoTributarioElectronico {
    public $identificacion;
    public $documentoRelacionado;
    public $emisor;
    public $receptor;
    public $ventaTercero;
    public $cuerpoDocumento;
    public $resumen;
    public $extension;
    public $otrosDocumentos;
    public $apendice;
}
date_default_timezone_set('America/El_Salvador');
$fecha_actual = date("Y-m-d");
$hora_actual = date("h:i:s");

// Función para crear el DTE
function crearDTE($fecha_actual, $cliente, $hora_actual, $detalles) {
    $paradte = 90000000000 + $detalles[0]->id;
    
    $dte = new DocumentoTributarioElectronico();

    // Identificación
    $dte->identificacion = new Identificacion();
    $dte->identificacion->numeroControl = "DTE-01-M001P001-0000". $paradte;
    $dte->identificacion->codigoGeneracion = getGUID();
    $dte->identificacion->fecEmi = $fecha_actual;
    $dte->identificacion->horEmi = $hora_actual;

    // Emisor
    $dte->emisor = new Emisor();
    $dte->emisor->nit = "05090211591010";
    $dte->emisor->nrc = "1834284";
    $dte->emisor->nombre = "Santos Guerrero";
    $dte->emisor->codActividad = "55101";
    $dte->emisor->descActividad = "ALOJAMIENTO PARA ESTANCIAS CORTAS";
    $dte->emisor->nombreComercial = "AUTOMOTEL XANADU";
    $dte->emisor->tipoEstablecimiento = "02";
    $dte->emisor->direccion = new Direccion();
    $dte->emisor->direccion->departamento = "02";
    $dte->emisor->direccion->municipio = "01";
    $dte->emisor->direccion->complemento = "Carretera a los naranjos, Lotificacion San Fernando #3 Poligono B";
    $dte->emisor->telefono = "2429-0920";
    $dte->emisor->correo = "clientesfrecuentes01@gmail.com";

    // Receptor
    $dte->receptor = new Receptor();
    $dte->receptor->tipoDocumento = "37";
    $dte->receptor->numDocumento = "012345678";
    $dte->receptor->nombre = $cliente[0]->Nombre;
    $dte->receptor->direccion = new Direccion();
    $dte->receptor->direccion->departamento = "02";
    $dte->receptor->direccion->municipio = "01";
    $dte->receptor->direccion->complemento = $cliente[0]->Direccion;
    $dte->receptor->telefono = $cliente[0]->Telefono;
    $dte->receptor->correo = $cliente[0]->Correo;

    // Cuerpo Documento
$cuerpo = [];
$totalGravada = 0;
$totalTurismo = 0;
$totalIva = 0;
$itemnum = 1;

foreach ($detalles as $detalle) {
    $precioFinal = round($detalle->preciouni, 5); // Precio final con IVA y Turismo
    $cantidad = $detalle->cantidad;
    $precioFinalTotal = $precioFinal * $cantidad;

    // Cálculos basados en precio final
    $base = $precioFinalTotal / 1.18;
    $ivaItem = $base * 0.13;
    $turismo = $base * 0.05;

    // Redondeo a dos decimales como exige Hacienda
    $ivaItem = round($ivaItem, 2);
    $turismo = round($turismo, 2);

    $item = new ItemDocumento();
    $item->numItem = $itemnum++;
    $item->tipoItem = 2;
    $item->numeroDocumento = null;
    $item->cantidad = $cantidad;
    $item->codigo = null;
    $item->codTributo = null;
    $item->uniMedida = 59;
    $item->descripcion = $detalle->descripcion ;
    $item->precioUni = $precioFinal - $turismo;
    $item->montoDescu = 0;
    $item->ventaNoSuj = 0;
    $item->ventaExenta = 0;
    $item->ventaGravada = round($precioFinalTotal, 2) - $turismo;
    $item->tributos = ["59"];
    $item->psv = 0;
    $item->ivaItem = $ivaItem;
    $item->noGravado = 0;

    $cuerpo[] = $item;

    $totalGravada += $item->ventaGravada;
    $totalTurismo += $turismo;
    $totalIva += $ivaItem;
}

$dte->cuerpoDocumento = $cuerpo;

    // Resumen
  $dte->resumen = new Resumen();
$dte->resumen->totalNoSuj = 0;
$dte->resumen->totalExenta = 0;
$dte->resumen->totalGravada = round($totalGravada, 2);
$dte->resumen->subTotalVentas = round($totalGravada, 2);
$dte->resumen->descuNoSuj = 0;
$dte->resumen->descuExenta = 0;
$dte->resumen->descuGravada = 0;
$dte->resumen->porcentajeDescuento = 0;
$dte->resumen->totalDescu = 0;
$dte->resumen->tributos = [
    [
        "codigo" => "59",
        "descripcion" => "Turismo: Por alojamiento(5%)",
        "valor" => round($totalTurismo, 2)
    ]
];
$dte->resumen->subTotal = round($totalGravada, 2);
$dte->resumen->ivaRete1 = 0;
$dte->resumen->reteRenta = 0;
$dte->resumen->montoTotalOperacion = round($totalGravada, 2) + $turismo;
$dte->resumen->totalNoGravado = 0;
$dte->resumen->totalPagar = round($totalGravada, 2) + $turismo;
$dte->resumen->totalLetras =numeroALetras(round($dte->resumen->totalPagar, 2)); 
$dte->resumen->totalIva = round($totalIva, 2);
$dte->resumen->saldoFavor = 0;
$dte->resumen->condicionOperacion = 1;

$dte->resumen->pagos = [
    [
        "codigo" => "01",
        "montoPago" => round($totalGravada, 2) + $turismo,
        "referencia" => null,
        "plazo" => null,
        "periodo" => null
    ]
];



$dte->resumen->numPagoElectronico = "";

    // Extensión
    $dte->extension = null;

    return $dte;
}
//$dte = crearDTE($fecha_actual, $cliente, $hora_actual);


// Función para enviar DTE a la API

function enviarDTEAPI($dte) {
    $datos = [
        'Usuario' => "05090211591010",
        'Password' => "Santos25.",
        'Ambiente' => '00',
        'DteJson' => json_encode($dte),
        'Nit' => "005207550",
        'PasswordPrivado' => "20Xanadu25.",
        'TipoDte' => '01',
        'CodigoGeneracion' => $dte->identificacion->codigoGeneracion,
        'NumControl' => $dte->identificacion->numeroControl,
        'VersionDte' => 1,
        //'CorreoCliente' => "clientesfrecuentes01@gmail.com"
        'CorreoCliente' => "poncemarito2019@gmail.com"
    ];

  // echo "<pre>JSON generado:<br>" . json_encode($dte, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";

   // echo "<pre>JSON enviado a la API:<br>" . json_encode($datos, JSON_PRETTY_PRINT) . "</pre>";

    $ch = curl_init('http://34.198.24.200:7122/api/procesar-dte');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    if ($response === false) {
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        throw new Exception("Error cURL: $error (Código: $errno)");
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpCode != 200) {
        throw new Exception("Error al procesar DTE: " . $response . " (HTTP $httpCode)");
    }

    return json_decode($response);
}


// Ejemplo de uso
// Iniciar proceso automáticamente al abrir el archivo desde el navegador
try {
    echo "Iniciando generación de DTE...<br>";
    $dte = crearDTE($fecha_actual, $cliente, $hora_actual, $detalles);
    echo "DTE generado correctamente.<br>";
    echo "Iniciando transferencia a la API...<br>";
    $respuestaAPI = enviarDTEAPI($dte);
    echo "Respuesta recibida de la API.<br>";
    // Imprimir sello de recepción antes de enviar el correo
    if (isset($respuestaAPI->selloRecibido)) {
    echo "Sello de recepción: " . $respuestaAPI->selloRecibido . "<br>";
} elseif (isset($respuestaAPI->SelloRecepcion)) {
    echo "Sello de recepción (SelloRecepcion): " . $respuestaAPI->SelloRecepcion . "<br>";
} elseif (isset($dte->identificacion->codigoGeneracion)) {
    echo "Código de generación: " . $dte->identificacion->codigoGeneracion . "<br>";
}
    echo "Proceso completado exitosamente.<br>";

/*
echo '<pre>';
print_r($respuestaAPI);
echo '</pre>';
*/
    // Almacenar datos del DTE
$dteArray = json_decode(json_encode($dte), true);
 // Datos de la respuesta MH
    $codigoGeneracion = $respuestaAPI->codigoGeneracion ?? ($dteArray['identificacion']['codigoGeneracion'] ?? (string) Str::uuid());
    $numControl       = $respuestaAPI->numControl       ?? ($dteArray['identificacion']['numeroControl'] ?? null);
    $selloRecibido    = $respuestaAPI->selloRecibido    ?? null;
    $jwsFirmado       = $respuestaAPI->dteFirmado       ?? null;

    // 1) Guardar JSON ORIGINAL
    $rutaOriginal = "dtes_json/original_{$codigoGeneracion}.json";
    Storage::put($rutaOriginal, json_encode($dteArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    // 2) Construir JSON LEGIBLE PARA CONTADOR
    $legible = $dteArray;
    $legible['identificacion']['codigoGeneracion'] = $codigoGeneracion;
    if ($numControl) {
        $legible['identificacion']['numeroControl'] = $numControl;
    }

    //  Ordenar: primero firmaElectronica, luego selloRecibido
    if ($jwsFirmado) {
        $legible['firmaElectronica'] = $jwsFirmado;
    }
    if ($selloRecibido) {
        unset($legible['selloRecibido']); // por si acaso existe
        // Forzar sello al final
        $legible = array_merge($legible, ['selloRecibido' => $selloRecibido]);
    }

    $rutaLegible = "dtes_json/legible_{$codigoGeneracion}.json";
   // Storage::put($rutaLegible, json_encode($legible, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    Storage::put($rutaLegible, json_encode($legible, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    // 3) Guardar JWS firmado crudo
    $rutaFirmado = null;
    if ($jwsFirmado) {
        $rutaFirmado = "dtes_json/firmado_{$codigoGeneracion}.json";
        Storage::put($rutaFirmado, $jwsFirmado);
    }


/*
// 4) Generar PDF versión legible para entrega
$pdf = Pdf::loadView('dtes.plantilla_pdf', ['dte' => $legible]); // $legible = tu JSON legible
$rutaPdf = "dtes_pdfs/dte_{$codigoGeneracion}.pdf";
Storage::put($rutaPdf, $pdf->output());
*/

// 5) Persistir en BD
DocumentoDTE::create([
'sello_recibido' => $selloRecibido,
'codigo_generacion' => $codigoGeneracion,
'numero_control' => $numControl,
'factura' => $detalles[0]->coticode ?? null,
'fecha_generacion' => now(),
'tipo_dte' => $dteArray['identificacion']['tipoDte'] ?? null,
'json_original_path' => $rutaOriginal,
'json_legible_path' => $rutaLegible,
'json_firmado_path' => $rutaFirmado,
//'pdf_path' => $rutaPdf,
]);

//Termina Almacenar datos del DTE

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

?>

<p></p>
<a href="/facturacion/verpdf/{{ $detalles[0]->coticode}}" class="btn btn-primary">Imprimir</a> &nbsp; &nbsp; &nbsp; <a href="/facturacion" class="btn btn-danger">Regresar </a>

