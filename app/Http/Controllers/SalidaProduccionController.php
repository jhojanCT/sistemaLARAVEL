<?php

namespace App\Http\Controllers;

use App\Models\EntradaProduccion;
use App\Models\SalidaProduccion;
use App\Models\Producto;
use Illuminate\Http\Request;

class SalidaProduccionController extends Controller
{
    public function index()
    {
        // Recuperamos todas las salidas de producción
        $salidas = SalidaProduccion::with('entradaProduccion.producto')->get();
        return view('salidas_produccion.index', compact('salidas'));
    }

    public function create()
    {
        // Recuperamos las entradas de producción que tienen productos ya procesados
        $entradas = EntradaProduccion::where('porcentaje_produccion', 100)->get();
        return view('salidas_produccion.create', compact('entradas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entrada_produccion_id' => 'required|exists:entradas_produccion,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_hora_salida' => 'required|date',
        ]);

        // Crear la salida de producción
        $salida = SalidaProduccion::create($validated);

        // Actualizar el stock del producto
        $entrada = EntradaProduccion::findOrFail($validated['entrada_produccion_id']);
        $producto = $entrada->producto;
        $producto->stock += $validated['cantidad'];
        $producto->save();

        return redirect()->route('salidas_produccion.index')->with('success', 'Salida registrada con éxito.');
    }

    public function addToProducts(SalidaProduccion $salida)
    {
        // Recuperar la cantidad producida y añadirla al stock de productos
        $entrada = EntradaProduccion::findOrFail($salida->entrada_produccion_id);
        $producto = $entrada->producto;
        $producto->stock += $salida->cantidad;
        $producto->save();

        return redirect()->route('salidas_produccion.index')->with('success', 'Producto añadido al inventario.');
    }
}
