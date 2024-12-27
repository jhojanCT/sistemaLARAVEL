@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Rol: {{ $role->name }}</h1>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre del Rol -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
        </div>

        <!-- Asignación de Permisos -->
        <div class="mb-3">
            <label for="permissions" class="form-label">Permisos</label>
            <select name="permissions[]" id="permissions" class="form-control" multiple>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}" 
                            @if($role->hasPermissionTo($permission->name)) selected @endif>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Rol</button>
    </form>
</div>
@endsection
