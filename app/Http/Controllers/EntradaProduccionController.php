<?php

namespace App\Http\Controllers;

use App\Models\EntradaProduccion;
use App\Models\Producto;
use App\Models\AlmacenFiltrado;
use Illuminate\Http\Request;

class EntradaProduccionController extends Controller
{
    public function index()
    {
        $entradas = EntradaProduccion::with('producto', 'almacenFiltrado')->get();
        return view('entradas_produccion.index', compact('entradas'));
    }

    public function create()
    {
        $almacenFiltrado = AlmacenFiltrado::all(); // Recuperamos todas las materias primas en almacen_filtrado
        $productos = Producto::all(); // Recuperamos todos los productos
    
        return view('entradas_produccion.create', compact('almacenFiltrado', 'productos'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'almacen_filtrado_id' => 'required|exists:almacen_filtrado,id',
            'materia_prima_en_uso' => 'required|numeric|min:0',
            'cantidad_producto' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_entrada' => 'required|date',
        ]);
    
        // Crear nueva entrada de producción
        $entradaProduccion = new EntradaProduccion();
        $entradaProduccion->producto_id = $request->producto_id;
        $entradaProduccion->almacen_filtrado_id = $request->almacen_filtrado_id;
        $entradaProduccion->materia_prima_en_uso = $request->materia_prima_en_uso;
        $entradaProduccion->cantidad_producto = $request->cantidad_producto;
        $entradaProduccion->precio_venta = $request->precio_venta;
        $entradaProduccion->fecha_entrada = $request->fecha_entrada;
    
        // Actualizar la cantidad en almacen filtrado
        $almacenFiltrado = AlmacenFiltrado::find($request->almacen_filtrado_id);
    
        if ($almacenFiltrado) {
            // Restar la cantidad de materia prima utilizada
            $almacenFiltrado->cantidad_materia_prima_filtrada -= $request->materia_prima_en_uso;
            $almacenFiltrado->save();
        } else {
            return back()->with('error', 'Materia Prima no encontrada en el almacén filtrado.');
        }
    
        // Guardar la entrada de producción
        $entradaProduccion->save();
    
        return redirect()->route('entradas_produccion.index')->with('success', 'Entrada de producción agregada exitosamente');
    }
    
    
    
    

    public function edit(EntradaProduccion $entrada)
    {
        $productos = Producto::all();
        $almacenes = AlmacenFiltrado::all();
        return view('entradas_produccion.edit', compact('entrada', 'productos', 'almacenes'));
    }

    public function update(Request $request, EntradaProduccion $entrada)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'almacen_filtrado_id' => 'required|exists:almacen_filtrado,id',
            'materia_prima_en_uso' => 'required|numeric|min:0.01',
            'cantidad_producto' => 'nullable|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
        ]);
    
        // Actualizar la entrada de producción
        $entrada->update($validated);
    
        // Actualizar el stock del almacen filtrado
        $almacen = AlmacenFiltrado::findOrFail($validated['almacen_filtrado_id']);
        $almacen->existencia_actual -= $validated['materia_prima_en_uso'];
        $almacen->save();
    
        return redirect()->route('entradas_produccion.index')->with('success', 'Entrada actualizada con éxito.');
    }
    

    public function destroy(EntradaProduccion $entrada)
    {
        // Restaurar el stock del almacen filtrado antes de eliminar
        $almacen = AlmacenFiltrado::findOrFail($entrada->almacen_filtrado_id);
        $almacen->existencia_actual += $entrada->materia_prima_en_uso;
        $almacen->save();

        // Eliminar la entrada de producción
        $entrada->delete();

        return redirect()->route('entradas_produccion.index')->with('success', 'Entrada eliminada con éxito.');
    }
}
