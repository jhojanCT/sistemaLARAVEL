<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Filtro; // Asegúrate de tener el modelo Filtro
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function index()
    {
        $entradas = Entrada::with(['producto', 'proveedor'])->get();
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('entradas.create', compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        // Validaciones de los nuevos campos
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'cantidad' => 'required|integer|min:1',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_entrada' => 'required|date',
            'existencia_filtrada' => 'required|numeric|min:0', // Añadir existencia filtrada
        ]);

        // Obtener la cantidad filtrada de la tabla Filtros
        $filtro = Filtro::where('producto_id', $request->producto_id)
            ->latest('fecha_filtro')
            ->first();

        // Validación para asegurar que haya filtrado antes
        if (!$filtro || $filtro->existencia_total_filtrada < $request->existencia_filtrada) {
            return back()->withErrors('La cantidad filtrada no es válida.');
        }

        // Crear la entrada
        $entrada = Entrada::create([
            'producto_id' => $request->producto_id,
            'proveedor_id' => $request->proveedor_id,
            'cantidad' => $request->cantidad,
            'precio_venta' => $request->precio_venta,
            'fecha_entrada' => $request->fecha_entrada,
            'existencia_total' => $filtro->existencia_total_inicial + $request->existencia_filtrada, // Sumar la cantidad inicial y filtrada
            'existencia_actual' => $request->existencia_filtrada,
            'existencia_actual_en_uso' => 0, // Inicialmente no hay uso
            'porcentaje_elaboracion' => 0, // Este porcentaje puede actualizarse cuando se comience a usar el producto
            'supervisor' => $request->supervisor ?? 'Desconocido', // Si es necesario
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada creada exitosamente.');
    }

    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('entradas.edit', compact('entrada', 'productos', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'cantidad' => 'required|integer|min:1',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_entrada' => 'required|date',
            'existencia_filtrada' => 'required|numeric|min:0', // Añadir existencia filtrada
        ]);

        // Buscar el filtro más reciente
        $filtro = Filtro::where('producto_id', $request->producto_id)
            ->latest('fecha_filtro')
            ->first();

        if (!$filtro || $filtro->existencia_total_filtrada < $request->existencia_filtrada) {
            return back()->withErrors('La cantidad filtrada no es válida.');
        }

        $entrada = Entrada::findOrFail($id);
        $entrada->update([
            'producto_id' => $request->producto_id,
            'proveedor_id' => $request->proveedor_id,
            'cantidad' => $request->cantidad,
            'precio_venta' => $request->precio_venta,
            'fecha_entrada' => $request->fecha_entrada,
            'existencia_total' => $filtro->existencia_total_inicial + $request->existencia_filtrada, // Sumar la cantidad inicial y filtrada
            'existencia_actual' => $request->existencia_filtrada,
            'existencia_actual_en_uso' => $entrada->existencia_actual_en_uso, // Mantener el mismo valor para la existencia en uso
            'porcentaje_elaboracion' => $entrada->porcentaje_elaboracion, // Mantener el mismo valor si no se ha usado
            'supervisor' => $request->supervisor ?? $entrada->supervisor, // Mantener el supervisor anterior si no se pasa uno nuevo
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();
        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada exitosamente.');
    }
}
