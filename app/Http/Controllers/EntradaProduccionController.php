<?php

namespace App\Http\Controllers;

use App\Models\EntradaProduccion;
use App\Models\Producto;
use App\Models\AlmacenFiltrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EntradaProduccionController extends Controller            
{
    public function index()
    {
        $entradas = EntradaProduccion::with('producto', 'almacenFiltrado')->get();
        return view('entradas_produccion.index', compact('entradas'));
    }

    public function finalizar($id)
    {
        $entrada = EntradaProduccion::findOrFail($id);
        $entrada->estado_produccion = 'finalizado';
        $entrada->save();

        return redirect()->route('entradas_produccion.index')->with('success', 'Producción finalizada con éxito.');
    }

    public function create()
    {
        $almacenFiltrado = AlmacenFiltrado::all();
        $productos = Producto::all();
        return view('entradas_produccion.create', compact('almacenFiltrado', 'productos'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $entradaProduccion = new EntradaProduccion();
            $entradaProduccion->producto_id = $request->producto_id;
            $entradaProduccion->almacen_filtrado_id = $request->almacen_filtrado_id;
            $entradaProduccion->materia_prima_en_uso = $request->materia_prima_en_uso;
            $entradaProduccion->estado_produccion = 'en proceso';
            $entradaProduccion->fecha_entrada = now();
    
            $almacenFiltrado = AlmacenFiltrado::findOrFail($request->almacen_filtrado_id);
            if ($almacenFiltrado->cantidad_materia_prima_filtrada >= $request->materia_prima_en_uso) {
                $almacenFiltrado->cantidad_materia_prima_filtrada -= $request->materia_prima_en_uso;
                $almacenFiltrado->save();
                $entradaProduccion->save();
                DB::commit();
                return redirect()->route('entradas_produccion.index')->with('success', 'Entrada de producción agregada exitosamente.');
            } else {
                DB::rollBack();
                return back()->with('error', 'Cantidad de materia prima insuficiente en el almacén filtrado.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hubo un error al guardar la entrada de producción: ' . $e->getMessage());
        }
    }
    

    public function edit(EntradaProduccion $entrada)
    {
        $productos = Producto::all();
        $almacenes = AlmacenFiltrado::all();
        return view('entradas_produccion.edit', compact('entrada', 'productos', 'almacenes'));
    }

    public function update(Request $request, EntradaProduccion $entrada)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'almacen_filtrado_id' => 'required|exists:almacen_filtrado,id',
            'materia_prima_en_uso' => 'required|numeric|min:0',
            'estado_produccion' => 'required|in:en proceso,finalizado',
        ]);

        $almacen = AlmacenFiltrado::findOrFail($entrada->almacen_filtrado_id);
        $almacen->cantidad_materia_prima_filtrada += $entrada->materia_prima_en_uso;

        if ($almacen->cantidad_materia_prima_filtrada >= $request->materia_prima_en_uso) {
            $almacen->cantidad_materia_prima_filtrada -= $request->materia_prima_en_uso;
        } else {
            return back()->with('error', 'Cantidad insuficiente en el almacén filtrado.');
        }

        $almacen->save();

        $entrada->update([
            'producto_id' => $request->producto_id,
            'almacen_filtrado_id' => $request->almacen_filtrado_id,
            'materia_prima_en_uso' => $request->materia_prima_en_uso,
            'estado_produccion' => $request->estado_produccion,
        ]);

        return redirect()->route('entradas_produccion.index')->with('success', 'Entrada actualizada con éxito.');
    }

    public function destroy(EntradaProduccion $entrada)
    {
        $almacen = AlmacenFiltrado::findOrFail($entrada->almacen_filtrado_id);
        $almacen->cantidad_materia_prima_filtrada += $entrada->materia_prima_en_uso;
        $almacen->save();

        $entrada->delete();

        return redirect()->route('entradas_produccion.index')->with('success', 'Entrada eliminada con éxito.');
    }
}
