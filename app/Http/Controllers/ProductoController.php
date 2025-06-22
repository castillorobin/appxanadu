<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return view('producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // $proveedores = Proveedor::all();
        return view('producto.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $producto = new Producto();

        $producto->Nombre = $request->get('nombre');
        $producto->Descripcion = $request->get('descripcion');
        $producto->Categoria = $request->get('categoria');
        $producto->Proveedor = $request->get('proveedor');
        $producto->Precio = $request->get('precio');
        $producto->Cantidad = $request->get('cantidad');
        $producto->Unidad_medida = $request->get('unidad');
        
        $producto->save();

        $productos = Producto::all();
        return view('producto.index', compact('productos'));
    }

    public function editar($id)
    {
       // $proveedores = Proveedor::all();

       $producto = Producto::find($id);

        return view('producto.editar', compact('producto'));
    }

     public function editando(Request $request)
    {
       // $proveedores = Proveedor::all();
        $id = $request->get('id');
         $envio = Producto::find($id);
        $envio->Nombre = $request->get('nombre');
        $envio->Descripcion = $request->get('descripcion');
        $envio->Categoria = $request->get('categoria');
        $envio->Proveedor = $request->get('proveedor');
        $envio->Precio = $request->get('precio');
        $envio->Cantidad = $request->get('cantidad');
        $envio->Unidad_medida = $request->get('unidad');
        $envio->save();

      // $producto = Producto::find($id);

        $productos = Producto::all();
        return view('producto.index', compact('productos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($producto)
    {
        Producto::find($producto)->delete();
        return redirect()->route('indexpr');
    }
}
