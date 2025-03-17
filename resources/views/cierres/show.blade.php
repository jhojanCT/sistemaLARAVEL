@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Cierre - {{ $cierre->fecha->format('d/m/Y') }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Resumen del día</h5>
            <p><strong>Saldo Inicial:</strong> Bs{{ number_format($apertura->saldo_inicial ?? 0, 2) }}</p>
            <p><strong>Total Ventas Materia Prima:</strong> Bs{{ number_format($cierre->total_ventas_materia_prima, 2) }}</p>
            <p><strong>Total Ventas Productos:</strong> Bs{{ number_format($cierre->total_ventas_producto, 2) }}</p>
            <p><strong>Total Pagos:</strong> Bs{{ number_format($cierre->total_pagos, 2) }}</p>
            <p><strong>Saldo Final:</strong> Bs{{ number_format($cierre->saldo_final, 2) }}</p>
        </div>
    </div>

    <h3 class="mt-4">Detalles de Ventas y Pagos</h3>

    <h4>Ventas de Materia Prima</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventasMateriaPrima as $venta)
                <tr>
                    <td>{{ $venta->materiaPrima ? $venta->materiaPrima->nombre : 'N/A' }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Ventas de Productos</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventasProducto as $venta)
                <tr>
                    <td>{{ $venta->producto->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>${{ number_format($venta->precio_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Pagos</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->concepto }}</td>
                    <td>${{ number_format($pago->monto, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('cierres.index') }}" class="btn btn-primary mt-3">Volver</a>
</div>
@endsection
