<?php

namespace App\Http\Controllers;

use App\Models\Filtro;
use App\Models\AlmacenSinFiltro;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Models\AlmacenFiltrado;
use Illuminate\Support\Facades\DB;

class FiltroController extends Controller
{
    /**
     * Mostrar una lista de los filtros.
     */
    public function index()
    {
        $filtros = Filtro::with(['proveedor', 'almacenSinFiltro', 'almacenFiltrado'])->get();
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
        DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'almacen_sin_filtro_id' => 'required|exists:almacen_sin_filtro,id',
                'cantidad_usada' => 'required|numeric|min:0',
                'desperdicio' => 'required|numeric|min:0',
                'existencia_filtrada' => 'required|numeric|min:0',
                'supervisor' => 'required|string|max:255',
                'fecha_filtro' => 'required|date',
            ]);

            $almacen = AlmacenSinFiltro::findOrFail($request->almacen_sin_filtro_id);

            // Validar que hay suficiente cantidad para filtrar
            if ($almacen->cantidad_total < $request->cantidad_usada) {
                abort(400, 'Cantidad insuficiente en el almacén para realizar este filtro.');
            }

            $almacen->cantidad_total -= $request->cantidad_usada;
            $almacen->save();

            $almacenFiltrado = AlmacenFiltrado::firstOrCreate(
                [
                    'proveedor_id' => $request->proveedor_id,
                    'materia_prima_filtrada' => $almacen->materia_prima_id,
                ],
                [
                    'cantidad_materia_prima_filtrada' => 0,
                ]
            );

            $almacenFiltrado->cantidad_materia_prima_filtrada += $request->existencia_filtrada;
            $almacenFiltrado->save();

            Filtro::create(array_merge($validated, [
                'almacen_filtrado_id' => $almacenFiltrado->id,
            ]));
        });

        return redirect()->route('filtros.index')->with('success', 'Filtro registrado correctamente.');
    }

    public function edit($id)
    {
        $filtro = Filtro::findOrFail($id);

    // Convertir la fecha a un formato compatible para el campo "date"
         if ($filtro->fecha_filtro instanceof \Carbon\Carbon) {
        $filtro->fecha_filtro = $filtro->fecha_filtro->format('Y-m-d');
         }

         $proveedores = Proveedor::all();
         $almacenesSinFiltro = AlmacenSinFiltro::all();

         return view('filtros.edit', compact('filtro', 'proveedores', 'almacenesSinFiltro'));
        
    }

    /**
     * Actualizar un filtro.
     */
    public function update(Request $request, Filtro $filtro)
    {
        DB::transaction(function () use ($request, $filtro) {
            $validated = $request->validate([
                'proveedor_id' => 'required|exists:proveedores,id',
                'almacen_sin_filtro_id' => 'required|exists:almacen_sin_filtro,id',
                'cantidad_usada' => 'required|numeric|min:0',
                'desperdicio' => 'required|numeric|min:0',
                'existencia_filtrada' => 'required|numeric|min:0',
                'supervisor' => 'required|string|max:255',
                'fecha_filtro' => 'required|date',
            ]);

            // Revertir el impacto del filtro anterior
            $almacenPrevio = $filtro->almacenSinFiltro;
            $almacenPrevio->cantidad_total += $filtro->cantidad_usada;
            $almacenPrevio->save();

            $almacenFiltradoPrevio = $filtro->almacenFiltrado;
            $almacenFiltradoPrevio->cantidad_materia_prima_filtrada -= $filtro->existencia_filtrada;
            if ($almacenFiltradoPrevio->cantidad_materia_prima_filtrada <= 0) {
                $almacenFiltradoPrevio->delete();
            } else {
                $almacenFiltradoPrevio->save();
            }

            // Aplicar los cambios actualizados
            $almacenNuevo = AlmacenSinFiltro::findOrFail($request->almacen_sin_filtro_id);
            $almacenNuevo->cantidad_total -= $request->cantidad_usada;
            $almacenNuevo->save();

            $almacenFiltradoNuevo = AlmacenFiltrado::firstOrCreate(
                [
                    'proveedor_id' => $request->proveedor_id,
                    'materia_prima_filtrada' => $almacenNuevo->materia_prima_id,
                ],
                [
                    'cantidad_materia_prima_filtrada' => 0,
                ]
            );

            $almacenFiltradoNuevo->cantidad_materia_prima_filtrada += $request->existencia_filtrada;
            $almacenFiltradoNuevo->save();

            $filtro->update(array_merge($validated, [
                'almacen_filtrado_id' => $almacenFiltradoNuevo->id,
            ]));
        });

        return redirect()->route('filtros.index')->with('success', 'Filtro actualizado correctamente.');
    }

    /**
     * Eliminar un filtro.
     */
    public function destroy(Filtro $filtro)
    {
        DB::transaction(function () use ($filtro) {
            $almacen = $filtro->almacenSinFiltro;
            $almacen->cantidad_total += $filtro->cantidad_usada;
            $almacen->save();

            $almacenFiltrado = $filtro->almacenFiltrado;
            $almacenFiltrado->cantidad_materia_prima_filtrada -= $filtro->existencia_filtrada;
            if ($almacenFiltrado->cantidad_materia_prima_filtrada <= 0) {
                $almacenFiltrado->delete();
            } else {
                $almacenFiltrado->save();
            }

            $filtro->delete();
        });

        return redirect()->route('filtros.index')->with('success', 'Filtro eliminado correctamente.');
    }
}
