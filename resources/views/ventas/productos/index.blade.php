@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ventas de Productos</h1>
    <a href="{{ route('ventas.productos.create') }}" class="btn btn-success mb-3">Registrar Nueva Venta</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
                <th>Cliente</th>
                <th>Cuenta</th>
                <th>Crédito</th>
                <th>Saldo Deuda</th>
                <th>Encargado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->producto->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>{{ $venta->precio_unitario }}</td>
                    <td>{{ $venta->precio_total }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $venta->cuenta->nombre }}</td>
                    <td>{{ $venta->a_credito ? 'Sí' : 'No' }}</td>
                    <td>{{ $venta->saldo_deuda }}</td>
                    <td>{{ $venta->encargado }}</td>
                    <td>
                        <a href="{{ route('ventas.productos.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('ventas.productos.destroy', $venta->id) }}" method="POST" style="display:inline-block;">
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
