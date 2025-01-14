<!-- resources/views/ventas/productos/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Editar Venta de Producto</h1>

    <form action="{{ route('ventas.productos.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $producto->id == $venta->producto_id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $venta->cantidad }}" required>
        </div>

        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" value="{{ $venta->precio_unitario }}" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Ninguno</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $venta->cliente_id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cuenta_id">Cuenta</label>
            <select name="cuenta_id" id="cuenta_id" class="form-control" required>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}" {{ $cuenta->id == $venta->cuenta_id ? 'selected' : '' }}>
                        {{ $cuenta->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="a_credito">¿A crédito?</label>
            <input type="checkbox" name="a_credito" id="a_credito" class="form-control" {{ $venta->a_credito ? 'checked' : '' }}>
        </div>

        <div class="form-group" id="cuota_inicial_div" style="{{ $venta->a_credito ? 'display:block;' : 'display:none;' }}">
            <label for="cuota_inicial">Cuota Inicial</label>
            <input type="number" name="cuota_inicial" id="cuota_inicial" class="form-control" value="{{ $venta->cuota_inicial }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
    </form>

    <script>
        document.getElementById('a_credito').addEventListener('change', function () {
            document.getElementById('cuota_inicial_div').style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endsection
