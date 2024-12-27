{{-- resources/views/ventas/materia_prima/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Venta de Materia Prima</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('ventas.materia_prima.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="materia_prima_filtrada_id" class="form-label">Materia Prima Filtrada</label>
            <select name="materia_prima_filtrada_id" id="materia_prima_filtrada_id" class="form-control" required>
                @foreach($materiasPrimas as $materia)
                    <option value="{{ $materia->id }}" {{ $materia->id == $venta->materia_prima_id ? 'selected' : '' }}>
                        {{ $materia->materia_prima_filtrada }} - Stock: {{ $materia->cantidad_materia_prima_filtrada }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $venta->cantidad }}" required min="1">
        </div>

        <div class="mb-3">
            <label for="precio_unitario" class="form-label">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" value="{{ $venta->precio_unitario }}" required min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Seleccione un Cliente (Opcional)</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $venta->cliente_id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
    </form>
</div>
@endsection
