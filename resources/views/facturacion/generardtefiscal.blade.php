<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php


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
        $base = $detalle->total / 1.13;
        $iva += round($base * 0.13, 2);
    }
    return $iva;
}

function sacartotal($detalles){
    $totalBase = 0;
    foreach ($detalles as $detalle) {
        // Suponiendo que el total viene con IVA incluido
        $base = $detalle->total / 1.13;
        $totalBase += round($base, 2);
    }
    return $totalBase;
}

// Clases para estructurar el DTE
class Identificacion {
    public $version = 3;
    public $ambiente = "00";
    public $tipoDte = "03"; 
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
}

class Receptor {
    public $nit;
    public $nrc;
    public $nombre;
    public $nombreComercial;
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
    public $ivaPerci1;
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
function crearDTE($fecha_actual, $hora_actual, $detalles, $factura) {
    $paradte = 90000000000 + $detalles[0]->id;
    $dte = new DocumentoTributarioElectronico();
    
    // Configurar identificación
    $dte->identificacion = new Identificacion();
    $dte->identificacion->numeroControl = "DTE-03-F0000001-0000". $paradte; //DTE-01-F0000001-000080000000263
    $dte->identificacion->codigoGeneracion = getGUID(); //"7DEEF8AF-7DF6-476F-B9AE-47CA46035F1B";
    $dte->identificacion->fecEmi = $fecha_actual;
    $dte->identificacion->horEmi = $hora_actual;
    
    // Configurar emisor
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
    $dte->emisor->codEstableMH = null;
    $dte->emisor->codEstable = null;
    $dte->emisor->codPuntoVentaMH = null;
    $dte->emisor->codPuntoVenta = null;
    $dte->emisor->correo = "clientesfrecuentes01@gmail.com";

    // Configurar receptor
    $dte->receptor = new Receptor();
    $dte->receptor->nit = $factura[0]->nit;
    $dte->receptor->nrc = $factura[0]->nrc;
    $dte->receptor->nombre = $factura[0]->nombre;
    $dte->receptor->nombreComercial = $factura[0]->comercial;
    $dte->receptor->codActividad = $factura[0]->codactividad;
    $dte->receptor->descActividad = $factura[0]->actividad;
    $dte->receptor->direccion = new Direccion();
    $dte->receptor->direccion->departamento = $factura[0]->departamento;
    $dte->receptor->direccion->municipio = $factura[0]->municipio;
    $dte->receptor->direccion->complemento = $factura[0]->direccion;
    $dte->receptor->telefono = $factura[0]->telefono;
    $dte->receptor->correo = $factura[0]->correo;


   $cuerpo = [];
$totalGravada = 0;
$itemnum = 1;

foreach ($detalles as $detalle) {
    $item = new ItemDocumento();
    $item->numItem = $itemnum++;
    $item->tipoItem = 3;
    $item->numeroDocumento = null;
    $item->cantidad = $detalle->cantidad;

    $precioConIVA = round($detalle->total, 2);
   
    $baseSinIVA = round($precioConIVA / 1.13, 2);
     
    $precioUnitarioBase = $baseSinIVA / $item->cantidad;
    
    $item->codigo = "27";
    $item->codTributo = null;
    $item->uniMedida = 59;
    $item->descripcion = $detalle->descripcion;
    $item->precioUni = round($precioUnitarioBase, 2);
//dd(round($item->precioUni ));
    $item->montoDescu = 0.00;
    $item->ventaNoSuj = 0.00;
    $item->ventaExenta = 0.00;

    $item->ventaGravada = round($baseSinIVA, 2);
   
    $item->psv = $item->ventaGravada;
    
    $item->noGravado = 0.00;
    $item->tributos = ["20"];

    $totalGravada += $item->ventaGravada;
    $cuerpo[] = $item;
}

$dte->cuerpoDocumento = $cuerpo;


// Calcular totales base y IVA
$totalBase = round(sacartotal($detalles), 2);
$totalIVA = round($totalBase * 0.13, 2);
$totalPagar = $totalBase + $totalIVA;

$dte->resumen = new Resumen();
$dte->resumen->totalNoSuj = 0.00;
$dte->resumen->totalExenta = 0.00;
$dte->resumen->totalGravada = round($totalGravada, 2);

$dte->resumen->subTotalVentas = round($totalGravada, 2);

$dte->resumen->descuNoSuj = 0.00;
$dte->resumen->descuExenta = 0.00;
$dte->resumen->descuGravada = 0.00;
$dte->resumen->porcentajeDescuento = 0.00;
$dte->resumen->totalDescu = 0.00;
$dte->resumen->subTotal = round($totalGravada, 2);

$dte->resumen->ivaRete1 = 0.00;
$dte->resumen->ivaPerci1 = 0.00;
$dte->resumen->reteRenta = 0.00;

$dte->resumen->montoTotalOperacion = round($totalPagar, 2);

$dte->resumen->totalNoGravado = 0.00;
$dte->resumen->totalPagar = round($totalPagar, 2);
//dd(round($dte->resumen->totalPagar ));
$dte->resumen->totalLetras = numeroALetras($totalPagar);

$dte->resumen->saldoFavor = 0.00;
$dte->resumen->condicionOperacion = 1;
$dte->resumen->pagos = null;

$dte->resumen->tributos = [
    [
        "codigo" => "20",
        "descripcion" => "Impuesto al Valor Agregado 13%",
        "valor" => $totalIVA
    ]
];

$dte->resumen->numPagoElectronico = null;

    // Configurar extensión
    $dte->extension = new Extension();
    $dte->extension->nombEntrega = null;
    $dte->extension->docuEntrega = null;
    $dte->extension->nombRecibe = null;
    $dte->extension->docuRecibe = null;
    $dte->extension->observaciones = null;
    $dte->extension->placaVehiculo = null;

    return $dte;
}

// Función para enviar DTE a la API
function enviarDTEAPI($dte) {
    $datos = [
        'Usuario' => "05090211591010",
        'Password' => "Santos25.",
        'Ambiente' => '00',
        'DteJson' => json_encode($dte),
        'Nit' => "005207550",
        'PasswordPrivado' => "20Xanadu25.",
        'TipoDte' => '03',
        'CodigoGeneracion' => $dte->identificacion->codigoGeneracion,
        'NumControl' => $dte->identificacion->numeroControl,
        'VersionDte' => 3,
        //'CorreoCliente' => "clientesfrecuentes01@gmail.com"
        'CorreoCliente' => "poncemarito2019@gmail.com"
    ];

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
    $dte = crearDTE($fecha_actual, $hora_actual, $detalles, $factura);
    echo "DTE generado correctamente.<br>";
    echo "Iniciando transferencia a la API...<br>";
    $respuestaAPI = enviarDTEAPI($dte);
    echo "Respuesta recibida de la API.<br>";
    // Imprimir sello de recepción antes de enviar el correo
    if (isset($respuestaAPI->SelloRecepcion)) {
        echo "Sello de recepción: " . $respuestaAPI->SelloRecepcion . "<br>";
    } else if (isset($dte->identificacion->codigoGeneracion)) {
        echo "Sello de recepción: " . $dte->identificacion->codigoGeneracion . "<br>";
    }
    echo "Proceso completado exitosamente.<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}


?>
<p></p>
<a href="/facturacion/crearfiscal" class="btn btn-primary">Regresar</a>