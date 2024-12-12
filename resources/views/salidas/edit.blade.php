@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Salida</h1>

    <form action="{{ route('salidas.update', $salida->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select class="form-control" id="producto_id" name="producto_id" required>
                <option value="">Selecciona un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $salida->producto_id == $producto->id ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                @endforeach
            </select>
            @error('producto_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ old('cantidad', $salida->cantidad) }}" required>
            @error('cantidad')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="fecha_salida">Fecha de Salida</label>
            <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="{{ old('fecha_salida', $salida->fecha_salida) }}" required>
            @error('fecha_salida')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Salida</button>
    </form>
</div>
@endsection
