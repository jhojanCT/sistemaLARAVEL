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
    <select name="cuenta_id" id="cuenta_id" class="form-control" required>
        @foreach($cuentas as $cuenta)
            <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
        @endforeach
    </select>
</div>

        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>

<script>
    const creditoSelect = document.querySelector('select[name="a_credito"]');
    const creditInfo = document.getElementById('credit-info');
    const cantidadInput = document.querySelector('input[name="cantidad"]');
    const precioUnitarioInput = document.querySelector('input[name="precio_unitario"]');
    const cuotaInicialInput = document.querySelector('input[name="cuota_inicial"]');
    const saldoDeudaInput = document.getElementById('saldo_deuda');

    // Mostrar u ocultar la cuota inicial y saldo de deuda según la selección de crédito
    creditoSelect.addEventListener('change', function() {
        if (this.value == '1') {
            creditInfo.style.display = 'block';
        } else {
            creditInfo.style.display = 'none';
            saldoDeudaInput.value = ""; // Resetear el saldo de deuda cuando no es a crédito
        }
    });

    // Escuchar cambios en los campos que afectan el saldo de deuda
    cantidadInput.addEventListener('input', calcularSaldoDeuda);
    precioUnitarioInput.addEventListener('input', calcularSaldoDeuda);
    cuotaInicialInput.addEventListener('input', calcularSaldoDeuda);

    function calcularSaldoDeuda() {
        const cantidad = parseFloat(cantidadInput.value) || 0;
        const precioUnitario = parseFloat(precioUnitarioInput.value) || 0;
        const cuotaInicial = parseFloat(cuotaInicialInput.value) || 0;
        const aCredito = creditoSelect.value === '1';

        const precioTotal = cantidad * precioUnitario;
        let saldoDeuda = 0;

        if (aCredito) {
            saldoDeuda = precioTotal - cuotaInicial;
        } else {
            saldoDeuda = precioTotal;
        }

        saldoDeudaInput.value = saldoDeuda.toFixed(2);
    }
</script>
@endsection
