{{-- resources/views/ventas/materia_prima/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Venta de Materia Prima</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('ventas.materia_prima.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="materia_prima_filtrada_id" class="form-label">Materia Prima Filtrada</label>
            <select name="materia_prima_filtrada_id" id="materia_prima_filtrada_id" class="form-control" required>
                <option value="">Seleccione una materia prima</option>
                @foreach($materiasPrimas as $materia)
                    <option value="{{ $materia->id }}">{{ $materia->materiaPrima->nombre }} - Stock: {{ $materia->cantidad_materia_prima_filtrada }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
        </div>

        <div class="mb-3">
            <label for="precio_unitario" class="form-label">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" required min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Seleccione un Cliente (Opcional)</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
    <label for="cuenta_id">Cuenta</label>
    <select name="cuenta_id" id="cuenta_id" class="form-control" required>
        @foreach($cuentas as $cuenta)
            <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
        @endforeach
    </select>
</div>

        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>
@endsection
