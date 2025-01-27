@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Venta de Producto</h1>
    <form action="{{ route('ventas.productos.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Producto -->
        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $producto->id == $venta->producto_id ? 'selected' : '' }}>
                        {{ $producto->nombre }} (Stock: {{ $producto->cantidad }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Cantidad -->
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $venta->cantidad }}" min="1" required>
        </div>

        <!-- Precio Unitario -->
        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" value="{{ $venta->precio_unitario }}" min="0" required>
        </div>

        <!-- Cliente -->
        <div class="form-group">
            <label for="cliente_id">Cliente (Opcional)</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Cuenta -->
        <div class="form-group">
            <label for="cuenta_id">Cuenta</label>
            <select name="cuenta_id" id="cuenta_id" class="form-control" required>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}" {{ $venta->cuenta_id == $cuenta->id ? 'selected' : '' }}>
                        {{ $cuenta->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Venta a Crédito -->
        <div class="form-group">
            <label for="a_credito">Venta a Crédito</label>
            <select name="a_credito" id="a_credito" class="form-control" required>
                <option value="0" {{ $venta->a_credito ? '' : 'selected' }}>No</option>
                <option value="1" {{ $venta->a_credito ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        <!-- Encargado -->
        <div class="form-group">
            <label for="encargado">Encargado</label>
            <input type="text" name="encargado" id="encargado" class="form-control" value="{{ $venta->encargado }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
    </form>
</div>
@endsection
