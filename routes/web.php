<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Proveedores
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
Route::get('/producto/editar/{id}', [App\Http\Controllers\ProductoController::class, 'edit'])->name('editarpr');
Route::get('/producto/update/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('updatepr');

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

// Control
Route::get('/control', [App\Http\Controllers\ControlController::class, 'index'])->name('indexcontrol');
Route::get('/control/crear', [App\Http\Controllers\ControlController::class, 'create'])->name('crearcon');
Route::get('/control/guardar', [App\Http\Controllers\ControlController::class, 'guardar'])->name('guardarcon');
Route::get('/control/salida/{id}', [App\Http\Controllers\ControlController::class, 'salida'])->name('salidacon');

// Reporte
Route::get('/reporte', [App\Http\Controllers\ControlController::class, 'reporte'])->name('reportecontrol');
Route::get('/reportecontrol', [App\Http\Controllers\ControlController::class, 'reportedatos'])->name('reportecontroldatos');
Route::get('/reportecontrolpdf', [App\Http\Controllers\ControlController::class, 'reportedatospdf'])->name('reportecontroldatospdf');