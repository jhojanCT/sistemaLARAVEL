<?php

namespace App\Http\Controllers;

use App\Models\Filtro;
use App\Models\AlmacenSinFiltro;
use App\Models\AlmacenFiltrado;
use Illuminate\Http\Request;

class FiltroController extends Controller
{
    public function index()
    {
        $filtros = Filtro::with(['categoria', 'producto', 'proveedor'])->get();
        return view('filtros.index', compact('filtros'));
    }

    public function create()
    {
        $almacenSinFiltro = AlmacenSinFiltro::with(['categoria', 'producto', 'proveedor'])->get();
        return view('filtros.create', compact('almacenSinFiltro'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'almacen_sin_filtro_id' => 'required|exists:almacen_sin_filtro,id',
            'cantidad_usada' => 'required|numeric|min:0',
            'desperdicio' => 'required|numeric|min:0',
            'supervisor' => 'required|string',
            'fecha_filtro' => 'required|date',
        ]);

        $almacen = AlmacenSinFiltro::find($request->almacen_sin_filtro_id);

        if ($request->cantidad_usada > $almacen->cantidad) {
            return back()->withErrors('La cantidad usada no puede ser mayor que la cantidad disponible.');
        }

        // Calcular cantidad filtrada
        $cantidadFiltrada = $request->cantidad_usada - $request->desperdicio;

        // Restar cantidad usada en AlmacenSinFiltro
        $almacen->cantidad -= $request->cantidad_usada;
        $almacen->save();

        // Registrar el filtro
        $filtro = Filtro::create([
            'almacen_sin_filtro_id' => $request->almacen_sin_filtro_id,
            'cantidad_usada' => $request->cantidad_usada,
            'desperdicio' => $request->desperdicio,
            'cantidad_filtrada' => $cantidadFiltrada,
            'supervisor' => $request->supervisor,
            'fecha_filtro' => $request->fecha_filtro,
        ]);

        // Sumar cantidad filtrada al AlmacenFiltrado
        $almacenFiltrado = AlmacenFiltrado::firstOrCreate(
            ['producto_id' => $almacen->producto_id],
            ['cantidad' => 0]
        );

        $almacenFiltrado->cantidad += $cantidadFiltrada;
        $almacenFiltrado->save();

        return redirect()->route('filtros.index')->with('success', 'Filtro aplicado correctamente.');
    }

    public function destroy(Filtro $filtro)
    {
        $filtro->delete();

        return redirect()->route('filtros.index')->with('success', 'Registro eliminado correctamente.');
    }
}
