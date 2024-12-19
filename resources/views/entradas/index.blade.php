@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Entradas</h1>

    <a href="{{ route('entradas.create') }}" class="btn btn-primary mb-3">Nueva Entrada</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Existencia Total</th>
                <th>Precio de Venta</th>
                <th>Fecha de Entrada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->id }}</td>
                    <td>{{ $entrada->producto->nombre }}</td>
                    <td>{{ $entrada->proveedor->nombre }}</td>
                    <td>{{ $entrada->cantidad }}</td>
                    <td>{{ $entrada->existencia_total }}</td>
                    <td>{{ number_format($entrada->precio_venta, 2) }}</td>
                    <td>{{ $entrada->fecha_entrada->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta entrada?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
