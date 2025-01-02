@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Lista de Ventas de Productos</h2>
        <a href="{{ route('ventas.productos.create') }}" class="btn btn-success mb-3">Registrar Nueva Venta</a>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                    <th>Cliente</th>
                    <th>Cuenta</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td>Bs{{ number_format($venta->precio_unitario, 2) }}</td>
                        <td>Bs{{ number_format($venta->precio_total, 2) }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->cuenta->nombre }} (Saldo: ${{ number_format($venta->cuenta->saldo, 2) }})</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>
                            <a href="{{ route('ventas.productos.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ventas.productos.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta venta?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
