<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:roles|max:255',
        ]);

        $rol = Rol::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function show($id)
    {
        $rol = Rol::findOrFail($id);
        return view('roles.show', compact('rol'));
    }

    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|unique:roles,nombre,' . $id . '|max:255',
        ]);

        $rol = Rol::findOrFail($id);
        $rol->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
