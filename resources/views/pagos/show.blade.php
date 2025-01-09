@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Venta</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h4>Cliente: {{ $venta->cliente->nombre }}</h4>
            <p><strong>Total:</strong> {{ $venta->precio_total }}</p>
            <p><strong>Pagado:</strong> {{ number_format($venta->pagos->sum('monto'), 2) }}</p>
            <p><strong>Saldo Deuda:</strong> {{ number_format($venta->saldo_deuda, 2) }}</p>

        </div>
    </div>

    <h3>Pagos Realizados</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->pagos as $pago)
            <tr>
                <td>{{ $pago->id }}</td>
                <td>{{ $pago->monto }}</td>
                <td>{{ $pago->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Registrar Nuevo Pago</h3>
    <form action="{{ route('pagos.store', [$venta->id, $type]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="monto">Monto del Pago</label>
            <input type="number" name="monto" id="monto" class="form-control" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Registrar Pago</button>
    </form>
</div>
@endsection
