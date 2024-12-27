<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);  // Obtener el rol por ID
        $permissions = Permission::all();  // Obtener todos los permisos

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);  // Obtener el rol por ID

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array|required',
        ]);

        // Actualizar el nombre del rol
        $role->update(['name' => $request->name]);

        // Asignar los permisos seleccionados al rol
        $role->syncPermissions($request->permissions);  // Actualiza los permisos del rol

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $permissions = $request->permissions;
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')->with('success', 'Permisos asignados.');
    }
}