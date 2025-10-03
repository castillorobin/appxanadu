<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Cotidetalle;
use App\Models\Producto;
use App\Models\Municipio;
use App\Models\Actividad;
use App\Models\Departamento;
use App\Models\Fiscal;
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

    public function verpdf($id, $ambiente, $codigo, $fechaemi)
    {
       
//dd($codigo); 
        //$proveedores = Proveedor::all();
        $detalles = Cotidetalle::where('coticode', $id)->get();
        $cotiactual = Factura::where('codigo', $id)->get();

        return view('facturacion.facturacoti', compact('cotiactual', 'detalles', "codigo", 'ambiente', 'fechaemi'));
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

     public function crearfiscal()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
         $actividades = Actividad::all();
        return view('facturacion.crearcreditofiscal', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades'));
    }

     public function creditofiscaldte(Request $request)
    {
        $codigo =$request->get('codigo');
         $factura = Factura::where('codigo', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();

        $cliente = Cliente::where('nombre', $factura[0]->cliente)->get() ;
        
        

        $actual = $factura[0]->codigo;
        return view('facturacion.generardtefiscal', compact('actual', 'detalles', 'cliente'));
    }

     public function fiscalenca(Request $request)
    {
        $dui =$request->get('dui');
        $nrc =$request->get('nrc');
        $nombre =$request->get('nombre');
        $comercial =$request->get('comercial');
        $actividad =$request->get('actividad');
        $acti = Actividad::where('codigo', $actividad)->get();

        $descripcion = $acti[0]->descripcion;
        $depa = $request->get('departamento');
        $muni =$request->get('municipio');
        $direccion =$request->get('direccion');
        $telefono =$request->get('telefono');
        $correo =$request->get('correo');

        $fiscal = new Fiscal();
        $fiscal->nit = $dui;
        $fiscal->nrc = $nrc;
        $fiscal->nombre = $nombre;
        $fiscal->comercial = $comercial ; 
        $fiscal->codactividad = $actividad;
        $fiscal->actividad = $descripcion;
        $fiscal->departamento =$depa ;
        $fiscal->municipio =$muni ;
        $fiscal->direccion = $direccion;
        $fiscal->telefono = $telefono;
        $fiscal->correo = $correo;

        $fiscal->save();

        $ultimoid = Fiscal::latest('id')->first();
        $codigo = $ultimoid->id;
        $linea = new Cotidetalle();
       $linea->coticode = $ultimoid->id;
       $linea->descripcion = $request->get('detalle');
       $linea->cantidad = $request->get('cantidad');
       $linea->preciouni = $request->get('precio');
       $linea->total = $request->get('total');
       $linea->save();


        $cotiactual = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
        $actividades = Actividad::all();

        return view('facturacion.crearcreditofiscaldetalles', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades', 'detalles', 'cotiactual'));


        
    }

    public function detalleaddfiscal(Request $request)
    {

        $codigo = $request->get('codigo');

       // dd($codigo);

         $linea = new Cotidetalle();
       $linea->coticode = $codigo;
       $linea->descripcion = $request->get('detalle');
       $linea->cantidad = $request->get('cantidad');
       $linea->preciouni = $request->get('precio');
       $linea->total = $request->get('total');
       $linea->save();

        $cotiactual = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
        $actividades = Actividad::all();

        return view('facturacion.crearcreditofiscaldetalles', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades', 'detalles', 'cotiactual'));
        
    }


    public function generardtefiscal($codigo)
    {
        $factura = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();

       // $cliente = Cliente::where('nombre', $factura[0]->cliente)->get() ;

        $actual = $factura[0]->codigo;
        return view('facturacion.generardtefiscal', compact('factura', 'detalles'));
    }

     public function borrardetfiscal($id)
    {
        $detalle = Cotidetalle::where('id', $id)->get();
        //dd($detalle);
        $codigo = $detalle[0]->coticode;
        Cotidetalle::find($id)->delete();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
       $clientes = Cliente::all();
        $productos = Producto::all();


        $cotiactual = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
        $actividades = Actividad::all();

        return view('facturacion.crearcreditofiscaldetalles', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades', 'detalles', 'cotiactual'));
    }

    public function crearfiscaltur()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
         $actividades = Actividad::all();
        return view('facturacion.crearcreditofiscaltur', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades'));
    }

    public function fiscalencatur(Request $request)
    {
        $dui =$request->get('dui');
        $nrc =$request->get('nrc');
        $nombre =$request->get('nombre');
        $comercial =$request->get('comercial');
        $actividad =$request->get('actividad');
        $acti = Actividad::where('codigo', $actividad)->get();

        $descripcion = $acti[0]->descripcion;
        $depa = $request->get('departamento');
        $muni =$request->get('municipio');
        $direccion =$request->get('direccion');
        $telefono =$request->get('telefono');
        $correo =$request->get('correo');

        $fiscal = new Fiscal();
        $fiscal->nit = $dui;
        $fiscal->nrc = $nrc;
        $fiscal->nombre = $nombre;
        $fiscal->comercial = $comercial ; 
        $fiscal->codactividad = $actividad;
        $fiscal->actividad = $descripcion;
        $fiscal->departamento =$depa ;
        $fiscal->municipio =$muni ;
        $fiscal->direccion = $direccion;
        $fiscal->telefono = $telefono;
        $fiscal->correo = $correo;

        $fiscal->save();

        $ultimoid = Fiscal::latest('id')->first();
        $codigo = $ultimoid->id;
        $linea = new Cotidetalle();
       $linea->coticode = $ultimoid->id;
       $linea->descripcion = $request->get('detalle');
       $linea->cantidad = $request->get('cantidad');
       $linea->preciouni = $request->get('precio');
       $linea->total = $request->get('total');
       $linea->save();


        $cotiactual = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
        $actividades = Actividad::all();

        return view('facturacion.crearcreditofiscaldetallestur', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades', 'detalles', 'cotiactual'));


        
    }

    public function detalleaddfiscaltur(Request $request)
    {

        $codigo = $request->get('codigo');

       // dd($codigo);

         $linea = new Cotidetalle();
       $linea->coticode = $codigo;
       $linea->descripcion = $request->get('detalle');
       $linea->cantidad = $request->get('cantidad');
       $linea->preciouni = $request->get('precio');
       $linea->total = $request->get('total');
       $linea->save();

        $cotiactual = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $municipios = Municipio::all();
        $departamentos = Departamento::all();
        $actividades = Actividad::all();

        return view('facturacion.crearcreditofiscaldetallestur', compact('productos', 'clientes', 'municipios', 'departamentos', 'actividades', 'detalles', 'cotiactual'));
        
    }

    public function generardtefiscaltur($codigo)
    {
        $factura = Fiscal::where('id', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();

       // $cliente = Cliente::where('nombre', $factura[0]->cliente)->get() ;

        $actual = $factura[0]->codigo;
        return view('facturacion.generardtefiscaltur', compact('factura', 'detalles'));
    }

    public function productos()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        
        return view('facturacion.crearconsumidorproducto', compact('productos', 'clientes'));
    }

    public function detalleconcabeproducto(Request $request)
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
        return view('facturacion.agregardetalleproducto', compact('productos', 'detalles', 'cotiactual'));
    }

    public function detalleaddproducto(Request $request)
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
       return view('facturacion.agregardetalleproducto', compact('productos', 'detalles', 'cotiactual'));
         
     }

     public function generardteconsumidorproducto($codigo)
    {
        $factura = Factura::where('codigo', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();

        $cliente = Cliente::where('nombre', $factura[0]->cliente)->get() ;

        $actual = $factura[0]->codigo;
        return view('facturacion.generardteconsumidorproducto', compact('actual', 'detalles', 'cliente'));
    }

    public function crearexenta()
    {
        $clientes = Cliente::all();
       // $productos = Producto::all();
        
        return view('facturacion.crearconsumidorexenta', compact('clientes'));
    }
     public function detalleconcabeexenta(Request $request)
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
       // $productos = Producto::all();
        return view('facturacion.agregardetalleexenta', compact('detalles', 'cotiactual'));
    }

    public function detalleaddexenta(Request $request)
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
       // $productos = Producto::all();
       return view('facturacion.agregardetalleexenta', compact('detalles', 'cotiactual'));
         
     }

     public function generardteconsumidorexenta($codigo)
    {
        $factura = Factura::where('codigo', $codigo)->get();
        $detalles = Cotidetalle::where('coticode', $codigo)->get();

        $cliente = Cliente::where('nombre', $factura[0]->cliente)->get() ;

        $actual = $factura[0]->codigo;
        return view('facturacion.generardteconsumidorexenta', compact('actual', 'detalles', 'cliente'));
    }

    /**
     * Store a newly created resource in storage.  crearfiscal
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
