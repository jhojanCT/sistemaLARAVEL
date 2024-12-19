<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Filtro; 
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    public function index()
    {
        $entradas = Entrada::with(['producto', 'proveedor', 'filtro'])->get();
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $filtros = Filtro::with('producto')->get();
        return view('entradas.create', compact('productos', 'proveedores', 'filtros'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // Buscar el filtro relacionado
        $filtro = $this->getFiltro($validated['producto_id'], $validated['existencia_filtrada']);

        // Crear la entrada
        Entrada::create([
            'producto_id' => $validated['producto_id'],
            'proveedor_id' => $validated['proveedor_id'],
            'cantidad' => $validated['cantidad'],
            'precio_venta' => $validated['precio_venta'],
            'fecha_entrada' => $validated['fecha_entrada'],
            'existencia_total' => $filtro->existencia_total_inicial + $validated['existencia_filtrada'],
            'existencia_actual' => $validated['existencia_filtrada'],
            'existencia_actual_en_uso' => 0,
            'porcentaje_elaboracion' => 0,
            'supervisor' => $validated['supervisor'] ?? 'Desconocido',
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
        $validated = $this->validateRequest($request);

        // Buscar el filtro relacionado
        $filtro = $this->getFiltro($validated['producto_id'], $validated['existencia_filtrada']);

        // Actualizar la entrada
        $entrada = Entrada::findOrFail($id);
        $entrada->update([
            'producto_id' => $validated['producto_id'],
            'proveedor_id' => $validated['proveedor_id'],
            'cantidad' => $validated['cantidad'],
            'precio_venta' => $validated['precio_venta'],
            'fecha_entrada' => $validated['fecha_entrada'],
            'existencia_total' => $filtro->existencia_total_inicial + $validated['existencia_filtrada'],
            'existencia_actual' => $validated['existencia_filtrada'],
            'existencia_actual_en_uso' => $entrada->existencia_actual_en_uso,
            'porcentaje_elaboracion' => $entrada->porcentaje_elaboracion,
            'supervisor' => $validated['supervisor'] ?? $entrada->supervisor,
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();
        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada exitosamente.');
    }

    /**
     * Valida los datos de una solicitud.
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'cantidad' => 'required|integer|min:1',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_entrada' => 'required|date',
            'existencia_filtrada' => 'required|numeric|min:0',
        ]);
    }

    /**
     * Obtiene el filtro más reciente y verifica la cantidad filtrada.
     */
    private function getFiltro($productoId, $existenciaFiltrada)
    {
        $filtro = Filtro::where('producto_id', $productoId)
            ->latest('fecha_filtro')
            ->first();

        if (!$filtro || $filtro->existencia_total_filtrada < $existenciaFiltrada) {
            abort(400, 'La cantidad filtrada no es válida.');
        }

        return $filtro;
    }
}
