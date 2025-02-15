<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
 
        $cliente->Nombre = $request->get('nombre');
        $cliente->DUI = $request->get('dui');
        $cliente->Telefono = $request->get('telefono');
        $cliente->Correo = $request->get('correo');
        $cliente->Direccion = $request->get('direccion');
        $cliente->placa = $request->get('placa');
        $cliente->nrc = $request->get('nrc');
        $cliente->giro = $request->get('giro');
        $cliente->departamento = $request->get('departamento');
        
        
        $cliente->save();

        $clientes = Cliente::all();
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        Cliente::find($id)->delete();
        return redirect()->route('indexc');
    }
}
