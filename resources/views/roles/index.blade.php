@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Roles</h1>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Añadir Rol</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
