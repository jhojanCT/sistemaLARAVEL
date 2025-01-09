@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Nueva Venta de Materia Prima</h1>

    <form action="{{ route('ventas.materia_prima.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="materia_prima_filtrada_id">Materia Prima</label>
            <select class="form-control" name="materia_prima_filtrada_id" required>
                @foreach($materiasPrimas as $materiaPrima)
                    <option value="{{ $materiaPrima->id }}">{{ $materiaPrima->materiaPrima->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" step="0.01" name="precio_unitario" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select class="form-control" name="cliente_id">
                <option value="">Seleccionar Cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cuenta_id">Cuenta</label>
            <select class="form-control" name="cuenta_id" required>
                @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="a_credito">Venta a Crédito</label>
            <select class="form-control" name="a_credito" required>
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        <div class="form-group" id="credit-info" style="display: none;">
            <label for="cuota_inicial">Cuota Inicial</label>
            <input type="number" step="0.01" name="cuota_inicial" class="form-control">
            
            <label for="saldo_deuda">Saldo de Deuda</label>
            <input type="number" step="0.01" name="saldo_deuda" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Registrar Venta</button>
    </form>
</div>

<script>
    const creditoSelect = document.querySelector('select[name="a_credito"]');
    const creditInfo = document.getElementById('credit-info');

    creditoSelect.addEventListener('change', function() {
        if (this.value == '1') {
            creditInfo.style.display = 'block';
        } else {
            creditInfo.style.display = 'none';
        }
    });
</script>
@endsection
