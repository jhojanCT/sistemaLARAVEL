<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\Producto;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    public function index()
    {
        $salidas = Salida::all();
        return view('salidas.index', compact('salidas'));
    }

    public function create()
    {
        $productos = Producto::all(); // Obtén todos los productos disponibles
        return view('salidas.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'fecha_salida' => 'required|date',
        ]);

        Salida::create($request->all());
        return redirect()->route('salidas.index')->with('success', 'Salida registrada exitosamente.');
    }

    public function edit($id)
    {
        $salida = Salida::findOrFail($id);
        $productos = Producto::all(); // Obtén los productos disponibles para editar la salida
        return view('salidas.edit', compact('salida', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'fecha_salida' => 'required|date',
        ]);

        $salida = Salida::findOrFail($id);
        $salida->update($request->all());

        return redirect()->route('salidas.index')->with('success', 'Salida actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $salida = Salida::findOrFail($id);
        $salida->delete();
        return redirect()->route('salidas.index')->with('success', 'Salida eliminada exitosamente.');
    }
}
