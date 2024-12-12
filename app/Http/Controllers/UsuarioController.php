<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all(); // Obtener todos los roles disponibles
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'correo_electronico' => 'required|email|unique:usuarios',
            'password' => 'required|string|min:8',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo_electronico' => $request->correo_electronico,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all(); // Obtener los roles disponibles para editar el usuario
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico,' . $id,
            'password' => 'nullable|string|min:8',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->update([
            'nombre' => $request->nombre,
            'correo_electronico' => $request->correo_electronico,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
            'rol_id' => $request->rol_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
