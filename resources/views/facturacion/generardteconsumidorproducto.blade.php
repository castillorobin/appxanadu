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
    
    // Configurar identificación
    $dte->identificacion = new Identificacion();
    $dte->identificacion->numeroControl = "DTE-01-F0000001-0000". $paradte;  //DTE-01-F0000001-000080000000263
    $dte->identificacion->codigoGeneracion = getGUID(); //"7DEEF1AF-7DF7-436F-B9AE-47CA46035F1B";
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
    $dte->receptor->tipoDocumento = "37";
    $dte->receptor->numDocumento = "012345678";
    $dte->receptor->nrc = null;
    $dte->receptor->nombre = $cliente[0]->Nombre;
    $dte->receptor->codActividad = "41001";
    $dte->receptor->descActividad = "Clientes Frecuentes";
    $dte->receptor->direccion = new Direccion();
    $dte->receptor->direccion->departamento = "02";
    $dte->receptor->direccion->municipio = "01";
    $dte->receptor->direccion->complemento = $cliente[0]->Direccion;
    $dte->receptor->telefono = $cliente[0]->Telefono;
    $dte->receptor->correo = $cliente[0]->Correo;

$cuerpo = [];
$totalGravada = 0;
$itemnum = 1;
    foreach ($detalles as $detalle) {
   

    // Configurar cuerpo del documento
    $item = new ItemDocumento();
    $item->numItem = $itemnum;
    $itemnum += 1;
    $item->tipoItem = 1;
    $item->numeroDocumento = null;
    $item->cantidad = $detalle->cantidad;
    $item->codigo = "1";
    $item->codTributo = null;
    $item->uniMedida = 1;
    $item->descripcion = $detalle->descripcion;
    $item->precioUni = round($detalle->preciouni, 2);
    $item->montoDescu = 0;
    $item->ventaNoSuj = 0;
    $item->ventaExenta = 0;
    $item->ventaGravada = round($detalle->preciouni, 2);
    $totalGravada += $item->ventaGravada;
    $cuerpo[] = $item;
    $item->psv = round($detalle->preciouni, 2);
    $item->noGravado = 0;
    $item->ivaItem = round(($detalle->preciouni / 1.13) * 0.13, 2);  
    $dte->cuerpoDocumento = [$item];
}
$dte->cuerpoDocumento = $cuerpo;


    // Configurar resumen
    $dte->resumen = new Resumen();
    $dte->resumen->totalNoSuj = 0.00;
    $dte->resumen->totalExenta = 0.00;
    $dte->resumen->totalGravada = round($totalGravada, 2);
   //dd(round(sacartotal($detalles), 2));
    $dte->resumen->descuNoSuj = 0.00;
    $dte->resumen->subTotalVentas = round($totalGravada, 2);
    $dte->resumen->descuExenta = 0.00;
    $dte->resumen->descuGravada = 0.00;
    $dte->resumen->porcentajeDescuento = 0.00;
    $dte->resumen->totalDescu = 0.00;
    $dte->resumen->subTotal = round($totalGravada, 2);
    $dte->resumen->ivaRete1 = 0.00;
    $dte->resumen->reteRenta = 0.00;
    $dte->resumen->montoTotalOperacion = round($totalGravada, 2);
    $dte->resumen->totalNoGravado = 0.00;
    $dte->resumen->totalPagar = round($totalGravada, 2);
    $total = round($totalGravada, 2);
    //$dte->resumen->totalLetras = " DÓLARES 00/100";
    $dte->resumen->totalLetras = numeroALetras($total);
    $dte->resumen->totalIva = round(sacarivas($detalles), 2);

    $dte->resumen->saldoFavor = 0.00;
    $dte->resumen->condicionOperacion = 1;
   
    $dte->resumen->pagos = [
        [
            "codigo"=>"01",
            "montoPago"=>$totalGravada,
            "referencia"=>"0000",
            "periodo"=>null,
            "plazo"=>null
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
    if (isset($respuestaAPI->SelloRecepcion)) {
        echo "Sello de recepción: " . $respuestaAPI->SelloRecepcion . "<br>";
    } else if (isset($dte->identificacion->codigoGeneracion)) {
        echo "Sello de recepción: " . $dte->identificacion->codigoGeneracion . "<br>";
    }
    echo "Proceso completado exitosamente.<br>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
///header("Refresh: 3; url=https://xanadusistema.com/facturacion");

?>
<p></p>
<a href="/facturacion/verpdf/{{ $detalles[0]->coticode}}" class="btn btn-primary">Imprimir</a>