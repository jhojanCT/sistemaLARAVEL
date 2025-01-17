@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h4>Editar Rol: {{ $role->name }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('PUT')

                <!-- Nombre del Rol -->
                <div class="form-group mb-4">
                    <label for="roleName" class="form-label"><strong>Nombre del Rol</strong></label>
                    <input type="text" class="form-control" id="roleName" name="name" value="{{ $role->name }}" required>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-center mt-4 gap-3">
                    <!-- Botón de actualización -->
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-save"></i> Actualizar Rol
                    </button>
                    
                    <!-- Botón de cancelar -->
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
