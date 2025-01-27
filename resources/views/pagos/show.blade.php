@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Venta</h1>

    <table class="table table-bordered">
        <tr>
            <th>Tipo de Venta</th>
            <td>{{ $type === 'producto' ? 'Producto' : 'Materia Prima' }}</td>
        </tr>
        <tr>
            <th>Producto/Materia Prima</th>
            <td>{{ $type === 'producto' ? $venta->producto->nombre : $venta->materiaPrima->nombre }}</td>
        </tr>
        <tr>
            <th>Cliente</th>
            <td>{{ $venta->cliente->nombre ?? 'Sin cliente' }}</td>
        </tr>
        <tr>
            <th>Encargado</th>
            <td>{{ $venta->encargado }}</td>
        </tr>
        <tr>
            <th>Deuda Restante</th>
            <td>Bs{{ number_format($venta->saldo_deuda, 2) }}</td>
        </tr>
        <tr>
            <th>Total Pagado</th>
            <td>Bs{{ number_format($venta->pagos->sum('monto'), 2) }}</td>
        </tr>
    </table>

    <h2>Pagos Realizados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Cuota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagosPorCuota as $pago)
            <tr>
                <td>{{ $pago->id }}</td>
                <td>${{ number_format($pago->monto, 2) }}</td>
                <td>{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $pago->cuota_numero ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Registrar Nuevo Pago</h2>
    <form action="{{ route('pagos.store', ['id' => $venta->id, 'type' => $type]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="number" name="monto" id="monto" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cuota_numero">Número de Cuota (opcional)</label>
            <input type="number" name="cuota_numero" id="cuota_numero" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Registrar Pago</button>
    </form>
</div>
@endsection
