<?php

namespace App\Http\Controllers;

use App\Models\AlmacenFiltrado;
use Illuminate\Http\Request;

class AlmacenFiltradoController extends Controller
{
    public function index()
    {
        $almacenFiltrado = AlmacenFiltrado::with(['producto'])->get();
        return view('almacen-filtrado.index', compact('almacenFiltrado'));
    }

    public function create()
    {
        return view('almacen-filtrado.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0',
        ]);

        $almacenFiltrado = AlmacenFiltrado::firstOrCreate(
            ['producto_id' => $request->producto_id],
            ['cantidad' => 0]
        );

        $almacenFiltrado->cantidad += $request->cantidad;
        $almacenFiltrado->save();

        return redirect()->route('almacen-filtrado.index')->with('success', 'Materia filtrada añadida correctamente.');
    }

    public function edit(AlmacenFiltrado $almacenFiltrado)
    {
        return view('almacen-filtrado.edit', compact('almacenFiltrado'));
    }

    public function update(Request $request, AlmacenFiltrado $almacenFiltrado)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:0',
        ]);

        $almacenFiltrado->update($request->all());

        return redirect()->route('almacen-filtrado.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(AlmacenFiltrado $almacenFiltrado)
    {
        $almacenFiltrado->delete();

        return redirect()->route('almacen-filtrado.index')->with('success', 'Registro eliminado correctamente.');
    }
}
