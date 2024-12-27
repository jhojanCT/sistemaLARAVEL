{{-- resources/views/ventas/productos/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ventas Registradas</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('ventas.productos.create') }}" class="btn btn-success mb-3">Registrar Nueva Venta</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td>{{ $venta->precio_unitario }}</td>
                        <td>{{ $venta->precio_total }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>
                            <a href="{{ route('ventas.productos.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ventas.productos.destroy', $venta->id) }}" method="POST" class="d-inline">
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
