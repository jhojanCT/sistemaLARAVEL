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
        $roles = Role::with('permissions')->get();
    
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
            'permissions.*' => 'exists:permissions,id',
          
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no existen.',
           
        ]);

        // Crear el rol
        $role = Role::create(['name' => $request->name]);

        // Sincronizar permisos si se seleccionaron
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    // Formulario para editar un rol
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Actualizar un rol existente
    public function update(Request $request, Role $role)
    {
        // Validar el formulario
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array|nullable',
            'permissions.*' => 'exists:permissions,name', // Validar que los nombres de permisos existen
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe otro rol con este nombre.',
        ]);
    
        // Actualizar el nombre del rol
        $role->update(['name' => $request->name]);
    
        // Sincronizar permisos por nombre
        $role->syncPermissions($request->permissions ?? []);
    
        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    // Eliminar un rol
    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Superadmin'])) {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar este rol.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    // Mostrar y gestionar permisos del rol
    public function permissions(Role $role)
    {
        $permissions = $role->permissions;
        $allPermissions = Permission::all();

        return view('roles.permissions', compact('role', 'permissions', 'allPermissions'));
    }

    // Actualizar permisos de un rol
    public function updatePermissions(Request $request, Role $role)
    {
        // Validar los permisos enviados
        $validated = $request->validate([
            'permissions' => 'array|required', // Los permisos deben ser un array
            'permissions.*' => 'string|exists:permissions,name', // Cada permiso debe existir
        ]);

        // Asignar los permisos al rol
        $role->syncPermissions($validated['permissions']);

        return response()->json(['message' => 'Permisos actualizados correctamente.']);
    }

    public function __construct()
    {
    $this->middleware('permission:manage roles')->only(['index', 'create', 'edit', 'update', 'destroy']);
    }
}
