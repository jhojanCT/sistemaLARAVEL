<?php

namespace App\Http\Controllers;

use App\Models\Filtro;
use App\Models\AlmacenSinFiltro;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class FiltroController extends Controller
{
    /**
     * Mostrar una lista de los filtros.
     */
    public function index()
    {
        $filtros = Filtro::with(['proveedor', 'almacenSinFiltro'])->get();
        return view('filtros.index', compact('filtros'));
    }

    /**
     * Mostrar el formulario para crear un nuevo filtro.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $almacenesSinFiltro = AlmacenSinFiltro::all();
        return view('filtros.create', compact('proveedores', 'almacenesSinFiltro'));
    }

    /**
     * Almacenar un nuevo filtro.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'almacen_sin_filtro_id' => 'required|exists:almacen_sin_filtro,id',
            'cantidad_usada' => 'required|numeric|min:0',
            'desperdicio' => 'required|numeric|min:0',
            'existencia_filtrada' => 'required|numeric|min:0',
            'supervisor' => 'required|string|max:255',
            'fecha_filtro' => 'required|date',
        ]);

        // Actualizar el registro de almacen sin filtro al restar la cantidad usada de cantidad_total
        $almacen = AlmacenSinFiltro::findOrFail($request->almacen_sin_filtro_id);
        $almacen->cantidad_total -= $request->cantidad_usada;  // Cambiado a cantidad_total
        $almacen->save();

        Filtro::create($validated);
        return redirect()->route('filtros.index')->with('success', 'Filtro registrado correctamente.');
    }

    /**
     * Mostrar el formulario para editar un filtro.
     */
    public function edit(Filtro $filtro)
    {
        $proveedores = Proveedor::all();
        $almacenesSinFiltro = AlmacenSinFiltro::all();
        return view('filtros.edit', compact('filtro', 'proveedores', 'almacenesSinFiltro'));
    }

    /**
     * Actualizar un filtro.
     */
    public function update(Request $request, Filtro $filtro)
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'almacen_sin_filtro_id' => 'required|exists:almacen_sin_filtro,id',
            'cantidad_usada' => 'required|numeric|min:0',
            'desperdicio' => 'required|numeric|min:0',
            'existencia_filtrada' => 'required|numeric|min:0',
            'supervisor' => 'required|string|max:255',
            'fecha_filtro' => 'required|date',
        ]);

        // Recuperar el almacen antes de actualizar
        $almacen = AlmacenSinFiltro::findOrFail($request->almacen_sin_filtro_id);

        // Si el filtro se actualiza, primero revertimos los cambios en cantidad_total
        if ($filtro->almacen_sin_filtro_id !== $request->almacen_sin_filtro_id) {
            $almacen->cantidad_total += $filtro->cantidad_usada; // Revertir el valor antes de la actualización
            $almacen->save();

            // Después de revertir, actualizamos la nueva entrada
            $almacen = AlmacenSinFiltro::findOrFail($request->almacen_sin_filtro_id);
        }

        // Restamos la cantidad usada del nuevo almacén
        $almacen->cantidad_total -= $request->cantidad_usada;
        $almacen->save();

        // Actualizamos el filtro con los nuevos datos
        $filtro->update($validated);
        return redirect()->route('filtros.index')->with('success', 'Filtro actualizado correctamente.');
    }

    /**
     * Eliminar un filtro.
     */
    public function destroy(Filtro $filtro)
    {
        // Recuperar la cantidad usada y sumarla de nuevo al almacén sin filtro
        $almacen = $filtro->almacenSinFiltro;
        $almacen->cantidad_total += $filtro->cantidad_usada;  // Aseguramos que se actualice cantidad_total
        $almacen->save();

        $filtro->delete();
        return redirect()->route('filtros.index')->with('success', 'Filtro eliminado correctamente.');
    }
}
