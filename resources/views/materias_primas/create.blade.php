<!-- resources/views/materias_primas/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Materia Prima</h1>
    <form action="{{ route('materias_primas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('materias_primas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
