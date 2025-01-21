@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ventas de Materia Prima</h1>
    <a href="{{ route('ventas.materia_prima.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Materia Prima</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Cliente</th>
                <th>Cuentas</th>
                <th>Fecha de Venta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->materiaPrima->nombre }}</td>
                <td>{{ $venta->cantidad }}</td>
                <td>Bs{{ $venta->precio_unitario }}</td>
                <td>Bs{{ $venta->precio_total }}</td>
                <td>{{ $venta->cliente->nombre ?? 'Sin Cliente' }}</td>
                <td>{{ $venta->cuenta->nombre}}</td>
                <td>{{ $venta->fecha_venta }}</td>
                <td>
                    <a href="{{ route('ventas.materia_prima.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('ventas.materia_prima.destroy', $venta->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
