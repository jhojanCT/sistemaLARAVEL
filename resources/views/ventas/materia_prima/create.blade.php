@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Venta de Materia Prima</h1>
    <form action="{{ route('ventas.materia_prima.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="materia_prima_filtrada_id" class="form-label">Materia Prima</label>
            <select class="form-control" id="materia_prima_filtrada_id" name="materia_prima_filtrada_id" required>
                <option value="" disabled selected>Seleccione una materia prima</option>
                @foreach($materiasPrimas as $materiaPrima)
                    <option value="{{ $materiaPrima->id }}">{{ $materiaPrima->materiaPrima->nombre }} (Stock: {{ $materiaPrima->cantidad_materia_prima_filtrada }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
        </div>
        <div class="mb-3">
            <label for="precio_unitario" class="form-label">Precio Unitario</label>
            <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente (Opcional)</label>
            <select class="form-control" id="cliente_id" name="cliente_id">
                <option value="" selected>Sin cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="cuenta_id" class="form-label">Cuenta</label>
            <select class="form-control" id="cuenta_id" name="cuenta_id" required>
                <option value="" disabled selected>Seleccione una cuenta</option>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="a_credito" class="form-label">¿Venta a Crédito?</label>
            <select class="form-control" id="a_credito" name="a_credito" required>
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="form-group">
    <label for="encargado">Encargado de la Venta</label>
    <input type="text" name="encargado" id="encargado" class="form-control" value="{{ old('encargado', $venta->encargado ?? '') }}" required>
</div>

        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>
@endsection
