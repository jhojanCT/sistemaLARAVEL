@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalles del Cierre Diario - {{ $cierre->fecha->format('Y-m-d') }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h4>Resumen Financiero</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Saldo Inicial:</strong>Bs{{ number_format($cierre->saldo_inicial, 2) }}</li>
                <li class="list-group-item"><strong>Total Ventas Materia Prima:</strong> Bs{{ number_format($cierre->total_ventas_materia_prima, 2) }}</li>
                <li class="list-group-item"><strong>Total Ventas Producto:</strong> Bs{{ number_format($cierre->total_ventas_producto, 2) }}</li>
                <li class="list-group-item"><strong>Total Compras Materia Prima:</strong> Bs{{ number_format($cierre->total_compras_materia_prima, 2) }}</li>
                <li class="list-group-item"><strong>Total Pagos:</strong> Bs{{ number_format($cierre->total_pagos, 2) }}</li>
                <li class="list-group-item"><strong>Saldo Final:</strong> Bs{{ number_format($cierre->saldo_final, 2) }}</li>
            </ul>
        </div>
    </div>

    <h4 class="mb-3">Ventas de Materia Prima</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventasMateriaPrima as $venta)
            <tr>
                <td>{{ $venta->materiaPrima->nombre }}</td>
                <td>{{ $venta->cantidad }}</td>
                <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mb-3">Ventas de Productos</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventasProducto as $venta)
            <tr>
                <td>{{ $venta->producto->nombre }}</td>
                <td>{{ $venta->cantidad }}</td>
                <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mb-3">Compras de Materia Prima</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Materia Prima</th>
                <th>Cantidad (kg)</th>
                <th>Precio Unitario por Kg</th>
                <th>Costo Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comprasMateriaPrima as $compra)
            <tr>
                <td>{{ $compra->proveedor->nombre }}</td>
                <td>{{ $compra->materiaPrima->nombre }}</td>
                <td>{{ $compra->cantidad }}</td>
                <td>Bs{{ number_format($compra->precio_unitario_por_kilo, 2) }}</td>
                <td>Bs{{ number_format($compra->precio_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mb-3">Pagos</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $pago)
            <tr>
                <td>{{ $pago->concepto }}</td>
                <td>${{ number_format($pago->monto, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('cierres.index') }}" class="btn btn-secondary mt-3">Volver a la Lista</a>
</div>
@endsection
