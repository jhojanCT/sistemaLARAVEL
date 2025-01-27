@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Venta</h1>
    <form action="{{ route('ventas.productos.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }} (cantidad: {{ $producto->cantidad }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente (Opcional)</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cuenta_id">Cuenta</label>
            <select name="cuenta_id" id="cuenta_id" class="form-control" required>
                <option value="">Seleccione una cuenta</option>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="a_credito">¿Venta a crédito?</label>
            <select name="a_credito" id="a_credito" class="form-control" required>
                <option value="0">No</option>
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
