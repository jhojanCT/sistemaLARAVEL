<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Mostrar lista de roles
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    // Formulario para crear un nuevo rol
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    // Almacenar un nuevo rol
    public function store(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'permissions' => 'array|nullable',
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
            'permissions.array' => 'Los permisos seleccionados no son válidos.',
        ]);

        // Crear el rol
        $role = Role::create(['name' => $request->name]);

        // Asignar permisos si existen
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    // Formulario para editar un rol
    public function edit(Role $role)
    {
        $permissions = Permission::all(); // Obtener todos los permisos
        return view('roles.edit', compact('role', 'permissions'));
    }

    // Actualizar un rol existente
    public function update(Request $request, Role $role)
    {
        // Validar el formulario
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array|nullable',
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe otro rol con este nombre.',
        ]);

        // Actualizar el rol
        $role->update(['name' => $request->name]);

        // Sincronizar permisos
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    // Eliminar un rol
    public function destroy(Role $role)
    {
        // Evitar eliminar un rol crítico, si aplica
        if (in_array($role->name, ['Super Admin', 'Admin'])) {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar este rol.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
