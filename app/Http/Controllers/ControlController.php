<?php

namespace App\Http\Controllers;

use App\Models\Control;
use App\Models\Producto;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF; 

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $controles = Control::all();
        return view('control.index', compact('controles'));
    }

    public function reporte()
    {
        $controles = Control::all();
        return view('reporte.index', compact('controles'));
    }
    public function reportediario()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        //dd($hoy);
        $inicio= $hoy;
        $fin= $hoy;
        $controles = Control::whereBetween('fecha', [$inicio, $fin])
       ->get();
       return view('reporte.indexdatos', compact('controles', 'inicio', 'fin'));
    }

    public function reportedatos(Request $request)
    {
        $inicio = $request->get('inicio');
        $fin = $request->get('fin');
        //dd($inicio);
        $controles = Control::whereBetween('fecha', [$inicio, $fin])
       ->get();
      //  $controles = Control::all();


        return view('reporte.indexdatos', compact('controles', 'inicio', 'fin'));
    }
    public function reportedatospdf(Request $request)
    {
        $inicio = $request->get('inicio');
        $fin = $request->get('fin');
        //dd($inicio);
        $controles = Control::whereBetween('fecha', [$inicio, $fin])
       ->get();
       // $controles = Control::all();

        $pdf = PDF::loadView('reporte.indexdatospdf', ['controles'=>$controles])->setPaper('letter', 'landscape');;

       return $pdf->stream();
      //  return view('reporte.indexdatos', compact('controles', 'inicio', 'fin'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $habitaciones = Habitacion::all();
        return view('control.crear', compact('habitaciones'));
    }

    public function guardar(Request $request)
    {
        $date= Carbon::parse( $request->get('fecha'));
        $fecha = $date->format('Y-m-d');
       // $fechabuena = $fecha->format('Y-m-d');
      //  $fecha1 = Carbon::createFromFormat('jmY', $fecha);;
//dd($fecha);

        $control = new Control();
        $control->vehiculo = $request->get('vehiculo');
        $control->placa = $request->get('placa');
        $control->habitacion = $request->get('habitacion');
        $control->entrada = $request->get('entrada');
        $control->tarifa = $request->get('tarifa');
        $control->estado = 1;
        $control->fecha = $fecha;
        $control->save();

        $habitacion = Habitacion::find($request->get('habitacion'));
        $habitacion->estado = 1;
        $habitacion->save();
        $controles = Control::all();
        return view('control.index', compact('controles'));
    } 

    public function salida($id, $habi)
    {
        date_default_timezone_set('America/El_Salvador');


        $ticketc = Control::find($id);
        $ticketc->salida = date('h:i:s A');
        $ticketc->estado = 0;

        
        $ticketc->save();

        $habitacion = Habitacion::find($habi);
        $habitacion->estado = 0;
        $habitacion->save();

        $controles = Control::all();
        return view('control.index', compact('controles'));
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
    public function show(Control $control)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Control $control)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Control $control)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Control $control)
    {
        //
    }
}
