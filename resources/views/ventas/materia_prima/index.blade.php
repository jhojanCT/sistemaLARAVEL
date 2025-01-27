@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ventas de Materia Prima</h1>
    <a href="{{ route('ventas.materia_prima.create') }}" class="btn btn-success mb-3">Registrar Nueva Venta</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Materia Prima</th>
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
            @forelse($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->materiaPrima->nombre }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>{{ $venta->precio_unitario }}</td>
                    <td>{{ $venta->precio_total }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'Sin Cliente' }}</td>
                    <td>{{ $venta->cuenta->nombre }}</td>
                    <td>{{ $venta->a_credito ? 'Sí' : 'No' }}</td>
                    <td>{{ $venta->saldo_deuda }}</td>
                    <td>{{ $venta->encargado }}</td>
                    <td>
                        <a href="{{ route('ventas.materia_prima.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('ventas.materia_prima.destroy', $venta->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta venta?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No se encontraron ventas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
