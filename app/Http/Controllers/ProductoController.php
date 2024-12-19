<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->get(); // Obtiene los productos con su categoría
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all(); // Obtiene todas las categorías para el formulario
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'detalles' => 'nullable|string|max:500',
            'cantidad' => 'required|numeric|min:0', // Validación para el campo cantidad
        ]);

        Producto::create($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all(); // Obtiene todas las categorías para el formulario
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $id,
            'detalles' => 'nullable|string|max:500',
            'cantidad' => 'required|numeric|min:0', // Validación para el campo cantidad
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
