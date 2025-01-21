@extends('layouts.app')

@section('content')
    <h1>Registrar Venta de Producto</h1>

    <form action="{{ route('ventas.productos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Ninguno</option>
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

        <div class="form-group">
            <label for="a_credito">¿A crédito?</label>
            <select name="a_credito" id="a_credito" class="form-control" required>
                <option value="no">No</option>
                <option value="si">Sí</option>
            </select>
        </div>

        <div class="form-group" id="cuota_inicial_div" style="display:none;">
            <label for="cuota_inicial">Cuota Inicial</label>
            <input type="number" name="cuota_inicial" id="cuota_inicial" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>

    <script>
        document.getElementById('a_credito').addEventListener('change', function () {
            document.getElementById('cuota_inicial_div').style.display = this.value === 'si' ? 'block' : 'none';
        });
    </script>
    
@endsection
