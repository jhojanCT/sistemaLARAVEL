@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Rol</h1>

    <form action="{{ route('roles.update', $rol->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del Rol</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $rol->nombre) }}" required>
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Rol</button>
    </form>
</div>
@endsection
