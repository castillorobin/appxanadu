<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitaciones = Habitacion::all();
        return view('habitacion.index', compact('habitaciones'));
    }

    public function guardar(Request $request)
    {
        $habitacion = new Habitacion();
        $habitacion->numero = $request->get('numero');
        $habitacion->save();
        $habitaciones = Habitacion::all();
        return view('habitacion.index', compact('habitaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $habitaciones = Habitacion::all();
        return view('habitacion.crear', compact('habitaciones'));
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
    public function show(Habitacion $habitacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitacion $habitacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitacion $habitacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitacion $habitacion)
    {
        //
    }
}
