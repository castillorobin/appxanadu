<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DteEmitidoController;
use App\Http\Controllers\DTEController;
use App\Http\Controllers\ContingenciaController;
/*
Route::prefix('dtes')->group(function () {
    Route::get('/', [DteEmitidoController::class, 'index'])->name('dtes.index');
    Route::get('/{id}', [DteEmitidoController::class, 'show'])->name('dtes.show');
    Route::post('/{id}/anular', [DteEmitidoController::class, 'anular'])->name('dtes.anular');
});
*/

Route::prefix('contingencia')->name('contingencia.')->group(function () {
Route::get('/', [ContingenciaController::class, 'index'])->name('index');
Route::post('/emitir', [ContingenciaController::class, 'emitirEnContingencia'])->name('emitir');
Route::get('/{id}/pdf', [ContingenciaController::class, 'verPdfContingencia'])->name('pdf');
Route::post('/{id}/regularizar', [ContingenciaController::class, 'regularizar'])->name('regularizar');
Route::post('/regularizar/pendientes', [ContingenciaController::class, 'regularizarPendientes'])->name('regularizarPendientes');
});


Route::get('/', function () {
    return view('/auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Clientes
Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('indexc');
Route::get('/cliente/crear', [App\Http\Controllers\ClienteController::class, 'create'])->name('crearc');
Route::get('/cliente/guardar', [App\Http\Controllers\ClienteController::class, 'store'])->name('guardarc');
Route::get('/cliente/borrar/{id}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('borrarc');
Route::get('/cliente/editar/{id}', [App\Http\Controllers\ClienteController::class, 'edit'])->name('editarc');
Route::get('/cliente/update/{id}', [App\Http\Controllers\ClienteController::class, 'update'])->name('updatec');


//Productos
Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('indexpr');
Route::get('/producto/ver/{id}', [App\Http\Controllers\ProductoController::class, 'ver'])->name('verpr');
Route::get('/producto/crear', [App\Http\Controllers\ProductoController::class, 'create'])->name('crearpr');
Route::get('/producto/guardar', [App\Http\Controllers\ProductoController::class, 'store'])->name('guardarpr');
Route::get('/producto/borrar/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('borrarpr');
Route::get('/producto/editar/{id}', [App\Http\Controllers\ProductoController::class, 'editar'])->name('editarpr');
Route::get('/producto/update/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('updatepr');
Route::get('/producto/editando', [App\Http\Controllers\ProductoController::class, 'editando'])->name('editandopr');

//Compras
Route::get('/compras', [App\Http\Controllers\CompraController::class, 'index'])->name('indexcomp');
Route::get('/compra/ver/{id}', [App\Http\Controllers\CompraController::class, 'ver'])->name('vercomp');
Route::get('/compra/verpdf/{id}', [App\Http\Controllers\CompraController::class, 'verpdf'])->name('verpdfc');
Route::get('/compra/crear', [App\Http\Controllers\CompraController::class, 'create'])->name('crearcomp');
Route::get('/compra/guardarenc', [App\Http\Controllers\CompraController::class, 'guardarenc'])->name('guardarenc');
Route::get('/compra/guardardet', [App\Http\Controllers\CompraController::class, 'guardardet'])->name('guardardet');
Route::get('/compra/borrar/{id}', [App\Http\Controllers\CompraController::class, 'destroy'])->name('borrarcomp');
Route::get('/compra/editar/{id}', [App\Http\Controllers\CompraController::class, 'edit'])->name('editarcomp');
Route::get('/compra/update/{id}', [App\Http\Controllers\CompraController::class, 'update'])->name('updatecomp');
Route::get('/compra/guardartodo', [App\Http\Controllers\CompraController::class, 'guardartodo'])->name('guardartodo');

//Proveedores
Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('indexp');
Route::get('/proveedor/ver', [App\Http\Controllers\ProveedorController::class, 'ver'])->name('verp');
Route::get('/proveedor/crear', [App\Http\Controllers\ProveedorController::class, 'create'])->name('crearp');
Route::get('/proveedor/guardar', [App\Http\Controllers\ProveedorController::class, 'store'])->name('guardarp');
Route::get('/proveedor/borrar/{id}', [App\Http\Controllers\ProveedorController::class, 'destroy'])->name('borrarp');
Route::get('/proveedor/editar/{id}', [App\Http\Controllers\ProveedorController::class, 'edit'])->name('editarp');
Route::get('/proveedor/update/{id}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('updatep');

// Facturacion
Route::get('/facturacion', [App\Http\Controllers\FacturaController::class, 'index'])->name('indexco');
Route::get('/facturacion/crear', [App\Http\Controllers\FacturaController::class, 'create'])->name('crearco');
Route::get('/facturacion/detalleconcabe', [App\Http\Controllers\FacturaController::class, 'detalleconcabe'])->name('detalleconcabe');
Route::get('/facturacion/detalleadd', [App\Http\Controllers\FacturaController::class, 'detalleadd'])->name('detalleadd');
Route::get('/facturacion/ver/{id}', [App\Http\Controllers\FacturaController::class, 'ver'])->name('verco');
Route::get('/facturacion/verpdf/{id}', [App\Http\Controllers\FacturaController::class, 'verpdf'])->name('verpdf');


Route::get('/facturacion/borrardet/{id}', [App\Http\Controllers\FacturaController::class, 'borrardet'])->name('borrardet');
Route::get('/facturacion/generardteconsumidor/{id}', [App\Http\Controllers\FacturaController::class, 'generardteconsumidor'])->name('generardteconsumidor');
Route::get('/facturacion/generardtefiscal/{id}', [App\Http\Controllers\FacturaController::class, 'generardtefiscal'])->name('generardtefiscal');

Route::get('/facturacion/crearfiscal', [App\Http\Controllers\FacturaController::class, 'crearfiscal'])->name('crearfiscal');
Route::get('/facturacion/creditofiscaldte', [App\Http\Controllers\FacturaController::class, 'creditofiscaldte'])->name('creditofiscaldte');
Route::get('/facturacion/fiscalenca', [App\Http\Controllers\FacturaController::class, 'fiscalenca'])->name('fiscalenca');
Route::get('/facturacion/detalleaddfiscal', [App\Http\Controllers\FacturaController::class, 'detalleaddfiscal'])->name('detalleaddfiscal');
Route::get('/facturacion/borrardetfiscal/{id}', [App\Http\Controllers\FacturaController::class, 'borrardetfiscal'])->name('borrardetfiscal');

Route::get('/facturacion/crearfiscaltur', [App\Http\Controllers\FacturaController::class, 'crearfiscaltur'])->name('crearfiscaltur');
Route::get('/facturacion/fiscalencatur', [App\Http\Controllers\FacturaController::class, 'fiscalencatur'])->name('fiscalencatur');
Route::get('/facturacion/detalleaddfiscaltur', [App\Http\Controllers\FacturaController::class, 'detalleaddfiscaltur'])->name('detalleaddfiscaltur');
Route::get('/facturacion/generardtefiscaltur/{id}', [App\Http\Controllers\FacturaController::class, 'generardtefiscaltur'])->name('generardtefiscaltur');

Route::get('/facturacion/productos', [App\Http\Controllers\FacturaController::class, 'productos'])->name('productos');
Route::get('/facturacion/detalleconcabeproducto', [App\Http\Controllers\FacturaController::class, 'detalleconcabeproducto'])->name('detalleconcabeproducto');
Route::get('/facturacion/detalleaddproducto', [App\Http\Controllers\FacturaController::class, 'detalleaddproducto'])->name('detalleaddproducto');
Route::get('/facturacion/generardteconsumidorproducto/{id}', [App\Http\Controllers\FacturaController::class, 'generardteconsumidorproducto'])->name('generardteconsumidorproducto');


Route::get('/facturacion/crearexenta', [App\Http\Controllers\FacturaController::class, 'crearexenta'])->name('crearexenta');
Route::get('/facturacion/detalleconcabeexenta', [App\Http\Controllers\FacturaController::class, 'detalleconcabeexenta'])->name('detalleconcabeexenta');
Route::get('/facturacion/detalleaddexenta', [App\Http\Controllers\FacturaController::class, 'detalleaddexenta'])->name('detalleaddexenta');
Route::get('/facturacion/generardteconsumidorexenta/{id}', [App\Http\Controllers\FacturaController::class, 'generardteconsumidorexenta'])->name('generardteconsumidorexenta');

// Control
Route::get('/control', [App\Http\Controllers\ControlController::class, 'index'])->name('indexcontrol');
Route::get('/control/crear', [App\Http\Controllers\ControlController::class, 'create'])->name('crearcon');
Route::get('/control/guardar', [App\Http\Controllers\ControlController::class, 'guardar'])->name('guardarcon');
Route::get('/control/salida/{id}/{habi}', [App\Http\Controllers\ControlController::class, 'salida'])->name('salidacon');

// Reporte
Route::get('/reporte', [App\Http\Controllers\ControlController::class, 'reporte'])->name('reportecontrol');
Route::get('/reportecontrol', [App\Http\Controllers\ControlController::class, 'reportedatos'])->name('reportecontroldatos');
Route::get('/reportecontrolpdf', [App\Http\Controllers\ControlController::class, 'reportedatospdf'])->name('reportecontroldatospdf');
Route::get('/reporte/diario', [App\Http\Controllers\ControlController::class, 'reportediario'])->name('reportediario');

// Habitaciones
Route::get('/habitacion', [App\Http\Controllers\HabitacionController::class, 'index'])->name('indexhabita');
Route::get('/habitacion/crear', [App\Http\Controllers\HabitacionController::class, 'create'])->name('crearhabita');
Route::get('/habitacion/guardar', [App\Http\Controllers\HabitacionController::class, 'guardar'])->name('guardarhabita');


//Admin DTE's
Route::get('/dtes', [DTEController::class, 'index'])->name('dtes.index');
Route::get('/dtes/{id}/json', [DTEController::class, 'descargarJson'])->name('dtes.descargarJson');
Route::get('/dtes/{id}/pdf', [DTEController::class, 'verPdf'])->name('dtes.verPdf');
