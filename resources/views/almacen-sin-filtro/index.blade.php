@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Almacén Sin Filtro</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('almacen-sin-filtro.create') }}" class="btn btn-primary mb-3">Añadir Materia Prima</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Encargado</th>
                <th>Fecha de Llegada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($almacenSinFiltro as $item)
                <tr>
                    <td>{{ $item->proveedor->nombre }}</td>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ $item->categoria->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->encargado }}</td>
                    <td>{{ $item->fecha_llegada }}</td>
                    <td>
                        <a href="{{ route('almacen-sin-filtro.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('almacen-sin-filtro.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
