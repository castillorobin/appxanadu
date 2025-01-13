<?php

namespace App\Http\Controllers;

use App\Models\Control;
use App\Models\Producto;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $habitaciones = Producto::all();
        return view('control.crear', compact('habitaciones'));
    }

    public function guardar(Request $request)
    {
        $control = new Control();
        $control->vehiculo = $request->get('vehiculo');
        $control->placa = $request->get('placa');
        $control->habitacion = $request->get('habitacion');
        $control->entrada = $request->get('entrada');
        $control->tarifa = $request->get('tarifa');
        $control->estado = 1;
        $control->save();
        $controles = Control::all();
        return view('control.index', compact('controles'));
    }

    public function salida($id)
    {
        date_default_timezone_set('America/El_Salvador');


        $ticketc = Control::find($id);
        $ticketc->salida = date('h:i:s A');
        $ticketc->estado = 0;

        
        $ticketc->save();
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
