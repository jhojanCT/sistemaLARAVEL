{{-- resources/views/ventas/productos/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Venta</h2>
        <form action="{{ route('ventas.productos.update', $venta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" 
                            @if($producto->id == $venta->producto_id) selected @endif>
                            {{ $producto->nombre }} - {{ $producto->cantidad }} en stock
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="{{ old('cantidad', $venta->cantidad) }}" required>
                @error('cantidad')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio_unitario">Precio Unitario</label>
                <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" min="0" step="0.01" value="{{ old('precio_unitario', $venta->precio_unitario) }}" required>
                @error('precio_unitario')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @if($cliente->id == $venta->cliente_id) selected @endif>
                            {{ $cliente->nombre }} - {{ $cliente->email }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Venta</button>
        </form>
    </div>
@endsection
