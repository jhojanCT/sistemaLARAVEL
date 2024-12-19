@extends('layouts.app') <!-- Usa el layout principal -->

@section('content')
    <div class="container">
        <h1>Crear Nueva Categoría</h1>
        <form action="{{ route('categorias.store') }}" method="POST" class="mt-4">
            @csrf <!-- Token de seguridad obligatorio -->
            
            <div class="form-group">
                <label for="nombre">Nombre de la Categoría</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa el nombre de la categoría" required>
            </div>
            
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
