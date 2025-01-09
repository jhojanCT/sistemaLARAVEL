@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ventas a Crédito</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Ventas de Materia Prima</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasMateriaPrima as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->precio_total }}</td>
                        <td>{{ $venta->pagos->sum('monto') }}</td>
                        <td>{{ $venta->saldo_deuda }}</td>
                        <td><a href="{{ route('pagos.show', [$venta->id, 'materia_prima']) }}" class="btn btn-info">Ver Pagos</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Ventas de Productos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasProducto as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->precio_total }}</td>
                        <td>{{ $venta->pagos->sum('monto') }}</td>
                        <td>{{ $venta->saldo_deuda }}</td>
                        <td><a href="{{ route('pagos.show', [$venta->id, 'producto']) }}" class="btn btn-info">Ver Pagos</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection