@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Cuenta: {{ $cuenta->nombre }}</h1>

    @if($cuenta->nombre == 'Cuenta General')
        <h2>Ventas de Materia Prima (Todas las Cuentas)</h2>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventasMateriaPrima as $venta)
                <tr>
                    <td>{{ $venta->materiaPrima->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>Bs{{ number_format($venta->precio_unitario, 2) }}</td>
                    <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
                    <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                    <td>{{ $venta->fecha_venta }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Total Ventas de Materia Prima:</strong> Bs{{ number_format($ventasMateriaPrima->sum('precio_total'), 2) }}</p>

        <h2>Ventas de Productos (Todas las Cuentas)</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventasProducto as $venta)
                <tr>
                    <td>{{ $venta->Producto->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>Bs{{ number_format($venta->precio_unitario, 2) }}</td>
                    <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
                    <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                    <td>{{ $venta->fecha_venta }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Total Ventas de Productos:</strong> Bs{{ number_format($ventasProducto->sum('precio_total'), 2) }}</p>
    @else
        @if($ventasMateriaPrima->isEmpty() && $ventasProducto->isEmpty())
            <div class="alert alert-info">
                No hay ventas registradas para esta cuenta.
            </div>
        @else
            @if($ventasMateriaPrima->isNotEmpty())
                <h2>Ventas de Materia Prima</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Precio Total</th>
                            <th>Cliente</th>
                            <th>Fecha de Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventasMateriaPrima as $venta)
                        <tr>
                            <td>{{ $venta->materiaPrima->nombre }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td>Bs{{ number_format($venta->precio_unitario, 2) }}</td>
                            <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
                            <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                            <td>{{ $venta->fecha_venta }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p><strong>Total Ventas de Materia Prima:</strong> Bs{{ number_format($ventasMateriaPrima->sum('precio_total'), 2) }}</p>
            @endif

            @if($ventasProducto->isNotEmpty())
                <h2>Ventas de Productos</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Precio Total</th>
                            <th>Cliente</th>
                            <th>Fecha de Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventasProducto as $venta)
                        <tr>
                            <td>{{ $venta->Producto->nombre }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td>Bs{{ number_format($venta->precio_unitario, 2) }}</td>
                            <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
                            <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                            <td>{{ $venta->fecha_venta }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p><strong>Total Ventas de Productos:</strong> Bs{{ number_format($ventasProducto->sum('precio_total'), 2) }}</p>
            @endif
        @endif
    @endif
</div>
@endsection
