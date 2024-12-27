{{-- resources/views/ventas/productos/create.blade.php --}}
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
                        <option value="{{ $producto->id }}" 
                            @if(old('producto_id') == $producto->id) selected @endif>
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
                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="{{ old('cantidad') }}" required>
                @error('cantidad')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio_unitario">Precio Unitario</label>
                <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" min="0" step="0.01" value="{{ old('precio_unitario') }}" required>
                @error('precio_unitario')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @if(old('cliente_id') == $cliente->id) selected @endif>
                            {{ $cliente->nombre }} - {{ $cliente->email }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>
@endsection
