<?php

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use Illuminate\Http\Request;

class MateriaPrimaController extends Controller
{
    public function index()
    {
        $materiasPrimas = MateriaPrima::all();
        return view('materias_primas.index', compact('materiasPrimas'));
    }

    public function create()
    {
        return view('materias_primas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:materias_primas|max:255',
            'descripcion' => 'nullable',
        ]);

        MateriaPrima::create($request->all());
        return redirect()->route('materias_primas.index')->with('success', 'Materia prima creada exitosamente.');
    }

    public function edit($id)
    {
        $materiaPrima = MateriaPrima::findOrFail($id);
        return view('materias_primas.edit', compact('materiaPrima'));
    }
    

    public function update(Request $request, $materias_prima)
    {
        $materiaPrima = MateriaPrima::findOrFail($materias_prima);
        $materiaPrima->update($request->all());
        return redirect()->route('materias_primas.index');
    }
    
    

    public function destroy(MateriaPrima $materiaPrima)
    {
        $materiaPrima->delete();
        return redirect()->route('materias_primas.index')->with('success', 'Materia prima eliminada exitosamente.');
    }
}
