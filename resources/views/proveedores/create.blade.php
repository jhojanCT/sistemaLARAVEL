@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Proveedor</h1>

    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="correo_electronico">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}">
            @error('correo_electronico')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
            @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea class="form-control" id="direccion" name="direccion">{{ old('direccion') }}</textarea>
            @error('direccion')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection
