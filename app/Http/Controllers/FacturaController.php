<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Cotidetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cotizaciones2 = Factura::all();
        $cotizaciones = $cotizaciones2->sortByDesc('created_at');

        return view('facturacion.index', compact('cotizaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* $marca=Cotidetalle::all();
     foreach($marca as $mar){
        $mar->delete();
     }*/

        //$clientes = Cliente::all();
        $ultimoid = Factura::latest('id')->first();
       $idcompr = $ultimoid->id + 1;

       $date = Carbon::now();
       $date = $date->format('Y');
       $codigocoti = "C"."".$date."".$idcompr;

        $productos = Producto::all();
        $clientes = Cliente::all();
        return view('facturacion.crear', compact('productos', 'codigocoti', 'clientes'));
    }
    public function ver($id)
    {
        //$proveedores = Proveedor::all();
        $detalles = Cotidetalle::where('coticode', $id)->get();
        $cotiactual = Factura::where('codigo', $id)->get();
        return view('facturacion.ver', compact('cotiactual', 'detalles'));
    }

    public function verpdf($id)
    {
        //$proveedores = Proveedor::all();
        $detalles = Cotidetalle::where('coticode', $id)->get();
        $cotiactual = Factura::where('codigo', $id)->get();

        return view('facturacion.facturacoti', compact('cotiactual', 'detalles'));
/*
        $pdf = Dompdf::loadHtml('facturacion.facturacoti', ['detalles'=>$detalles, 'cotiactual'=>$cotiactual]);
        $pdf->render();

        return $pdf->stream(); 
        */

            /*
        $html = view('facturacion.facturacoti',['detalles'=>$detalles, 'cotiactual'=>$cotiactual] )->render();

        // Instantiate Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (important step!)
        $dompdf->render();
        //$dompdf->output();

        // Output PDF to browser
       
       return $dompdf->stream('facturacion.facturacoti');
*/
       
   
        //return view('cotizacion.ver', compact('cotiactual', 'detalles'));
    }
    public function detalleconcabe(Request $request)
    {
$ultimoid = Factura::latest('id')->first();
       $idcompr = $ultimoid->id + 1;
       $date = Carbon::now();
            $date = $date->format('Y');
            $codigo = "$date".$idcompr;
        
            //$newDate = date("Y-m-d", strtotime($request->get('fecha')));
         //   $newDate = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->get('fecha'))));





        //  dd($newDate->format('Y-m-d'));


        $cotienca = new Factura();
        $cotienca->cliente = $request->get('cliente');
        $cotienca->codigo = $codigo;
       // $cotienca->fecha = $newDate->format('Y-m-d');
        
        $cotienca->DUI = $request->get('dui');
        $cotienca->direccion = $request->get('direccion');
        

        $cotienca->save();
        $cotiactual = Factura::where('codigo', $codigo)->get();

       $linea = new Cotidetalle();
       $linea->coticode = $codigo;
       $linea->descripcion = $request->get('detalle');
       $linea->cantidad = $request->get('cantidad');
       $linea->preciouni = $request->get('precio');
       $linea->total = $request->get('total');
      

       $linea->save();
       $detalles = Cotidetalle::where('coticode', $codigo)->get();


        //$detalles=Cotidetalle::all();
        //$clientes = Cliente::all();
        $productos = Producto::all();
        return view('facturacion.agregardetalle', compact('productos', 'detalles', 'cotiactual'));
    }

  
    

    /**
     * Store a newly created resource in storage. 
     */

     public function detalleadd(Request $request)
     {
        //$detalles = new Cotidetalle();

        $codigo = $request->get('codigo');

        $detalle = new Cotidetalle();
        
        $detalle->coticode = $codigo;
        $detalle->descripcion = $request->get('detalle');
        $detalle->cantidad = $request->get('cantidad');
        $detalle->preciouni = $request->get('precio');
        $detalle->total = $request->get('total');
       
        $detalle->save();
         
        

        $cotiactual = Factura::where('codigo', $codigo)->get();
       //$detalles = Cotidetalle::all();
       $detalles = Cotidetalle::where('coticode', $codigo)->get();
       //$clientes = Cliente::all();
        $productos = Producto::all();
       return view('facturacion.agregardetalle', compact('productos', 'detalles', 'cotiactual'));
         
     }

     public function borrardet($id)
    {
        $detalle = Cotidetalle::where('id', $id)->get();
        //dd($detalle);
        $codigo = $detalle[0]->coticode;
        Cotidetalle::find($id)->delete();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
       $clientes = Cliente::all();
        $productos = Producto::all();

        $cotiactual = Factura::where('codigo', $codigo)->get();
       return view('facturacion.agregardetalle', compact('clientes', 'productos', 'detalles', 'cotiactual'));
    }

    public function generardteconsumidor($codigo)
    {
        $factura = Factura::where('codigo', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();

        $cliente = Cliente::where('nombre', $factura[0]->cliente)->get() ;

        $actual = $factura[0]->codigo;
        return view('facturacion.generardteconsumidor', compact('actual', 'detalles', 'cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Factura $factura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factura $factura)
    {
        //
    }
}
