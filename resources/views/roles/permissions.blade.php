@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4>Otorgar Permisos al Rol: {{ $role->name }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('roles.permissions.update', $role->id) }}">
                @csrf
                @method('PUT')

                <!-- Lista de Permisos -->
                <h5 class="mb-3">Permisos Disponibles</h5>
                <div class="row">
                    @foreach ($allPermissions as $permission)
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch d-flex align-items-center">
                                <input 
                                    class="form-check-input me-2" 
                                    type="checkbox" 
                                    id="permission-{{ $permission->id }}" 
                                    name="permissions[]" 
                                    value="{{ $permission->name }}" 
                                    {{ $permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission-{{ $permission->id }}" style="font-size: 16px;">
                                    {{ ucfirst($permission->name) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-center mt-4 gap-3">
                    <!-- Botón de actualización -->
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-save"></i> Actualizar Permisos
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
