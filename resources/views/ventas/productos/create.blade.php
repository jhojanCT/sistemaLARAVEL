@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Registrar Venta de Producto</h2>
        <form action="{{ route('ventas.productos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" class="form-control" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }} (Stock: {{ $producto->cantidad }})
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad') }}" required>
                @error('cantidad')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio_unitario">Precio Unitario</label>
                <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" value="{{ old('precio_unitario') }}" required>
                @error('precio_unitario')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cuenta_id">Cuenta</label>
                <select name="cuenta_id" id="cuenta_id" class="form-control" required>
                    <option value="">Seleccione una cuenta</option>
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}" {{ old('cuenta_id') == $cuenta->id ? 'selected' : '' }}>
                            {{ $cuenta->nombre }} (Saldo: ${{ $cuenta->saldo }})
                        </option>
                    @endforeach
                </select>
                @error('cuenta_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>
@endsection
