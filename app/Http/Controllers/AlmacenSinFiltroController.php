<?php

namespace App\Http\Controllers;

use App\Models\AlmacenSinFiltro;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AlmacenSinFiltroController extends Controller
{
    public function index()
    {
        $almacenSinFiltro = AlmacenSinFiltro::with(['proveedor', 'producto', 'categoria'])->get();
        return view('almacen-sin-filtro.index', compact('almacenSinFiltro'));
    }
    

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $categorias = Categoria::all();

        return view('almacen-sin-filtro.create', compact('proveedores', 'productos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required',
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'cantidad' => 'required|numeric|min:0',
            'encargado' => 'required|string',
            'fecha_llegada' => 'required|date',
        ]);

        AlmacenSinFiltro::create($request->all());

        return redirect()->route('almacen-sin-filtro.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit(AlmacenSinFiltro $almacen)
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $categorias = Categoria::all();

        return view('almacen-sin-filtro.edit', compact('almacen', 'proveedores', 'productos', 'categorias'));
    }

    public function update(Request $request, AlmacenSinFiltro $almacen)
    {
        $request->validate([
            'proveedor_id' => 'required',
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'cantidad' => 'required|numeric|min:0',
            'encargado' => 'required|string',
            'fecha_llegada' => 'required|date',
        ]);

        $almacen->update($request->all());

        return redirect()->route('almacen-sin-filtro.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(AlmacenSinFiltro $almacen)
    {
        $almacen->delete();

        return redirect()->route('almacen-sin-filtro.index')->with('success', 'Registro eliminado correctamente.');
    }
}
