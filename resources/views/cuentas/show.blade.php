@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Cuenta: {{ $cuenta->nombre }}</h2>

    <h3>Ventas de Materia Prima</h3>

    @if($ventasMateriaPrima->isEmpty())
        <p>No hay ventas registradas.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Materia Prima</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                    <th>Pagos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventasMateriaPrima as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                        <td>{{ $venta->materiaPrima ? $venta->materiaPrima->nombre : 'N/A' }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td>{{ $venta->precio_total }}</td>
                        <td>
                            @if($venta->pagos->isNotEmpty())
                                <ul>
                                    @foreach($venta->pagos as $pago)
                                        <li>{{ $pago->monto }}</li>
                                    @endforeach
                                </ul>
                            @else
                                Sin pagos
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h3>Ventas de Productos</h3>

    @if($ventasProducto->isEmpty())
        <p>No hay ventas registradas.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                    <th>Pagos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventasProducto as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                        <td>{{ $venta->producto ? $venta->producto->nombre : 'N/A' }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td>{{ $venta->precio_total }}</td>
                        <td>
                            @if($venta->pagos->isNotEmpty())
                                <ul>
                                    @foreach($venta->pagos as $pago)
                                        <li>{{ $pago->monto }}</li>
                                    @endforeach
                                </ul>
                            @else
                                Sin pagos
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
