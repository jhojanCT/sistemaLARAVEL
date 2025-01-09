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
                <th>Cuenta</th>
                <th>Venta a Crédito</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->materiaPrima->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>{{ number_format($venta->precio_unitario, 2) }}</td>
                    <td>{{ number_format($venta->precio_total, 2) }}</td>
                    <td>{{ $venta->cliente ? $venta->cliente->nombre : 'N/A' }}</td>
                    <td>{{ $venta->cuenta->nombre }}</td>
                    <td>{{ $venta->a_credito ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('ventas.materia_prima.edit', $venta->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('ventas.materia_prima.destroy', $venta->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
