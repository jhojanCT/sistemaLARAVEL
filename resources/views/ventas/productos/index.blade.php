<!-- resources/views/ventas/productos/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Ventas de Productos</h1>

    <a href="{{ route('ventas.productos.create') }}" class="btn btn-primary">Registrar Venta</a>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Cliente</th>
                <th>Cuenta</th>
                <th>Fecha de Venta</th>
                <th>Estado de Crédito</th>
                <th>Saldo de Deuda</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->producto->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>{{ $venta->precio_unitario }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'No asignado' }}</td>
                    <td>{{ $venta->cuenta->nombre }}</td>
                    <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                    <td>{{ $venta->a_credito ? 'Sí' : 'No' }}</td>
                    <td>{{ $venta->saldo_deuda }}</td>
                    <td>
                        <a href="{{ route('ventas.productos.edit', $venta->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('ventas.productos.destroy', $venta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        @if($venta->a_credito && $venta->saldo_deuda > 0)
                            <a href="{{ route('ventas.productos.pago', $venta->id) }}" class="btn btn-success">Realizar Pago</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
