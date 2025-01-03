@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center text-success">Gestión de Roles</h1>

    <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Añadir Rol
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-success">
                <tr>
                    <th>Nombre</th>
                    <th>Permisos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if ($role->permissions->isEmpty())
                                <span class="text-muted">Sin permisos</span>
                            @else
                                {{ implode(', ', $role->permissions->pluck('name')->toArray()) }}
                            @endif
                        </td>
                        <td>
                            <!-- Botón para editar -->
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <!-- Botón para eliminar -->
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de eliminar este rol?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted">No hay roles disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
