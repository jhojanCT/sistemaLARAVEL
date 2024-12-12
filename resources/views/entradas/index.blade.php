@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entradas</h1>
    <a href="{{ route('entradas.create') }}" class="btn btn-primary">Añadir Entrada</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Existencia Total</th>
                <th>Existencia Actual</th>
                <th>Existencia Filtrada</th> <!-- Dato recuperado de Filtros -->
                <th>Supervisor</th>
                <th>Fecha de Entrada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
            <tr>
                <td>{{ $entrada->categoria }}</td>
                <td>{{ $entrada->producto }}</td>
                <td>{{ $entrada->proveedor }}</td>
                <td>{{ $entrada->existencia_total }} kg</td>
                <td>{{ $entrada->existencia_actual }} kg</td>
                
                <!-- Recuperar información de filtros relacionados -->
                <td>
                    @php
                        $filtro = $filtros->firstWhere('producto', $entrada->producto);
                    @endphp
                    {{ $filtro ? $filtro->existencia_filtrada : 'N/A' }} kg
                </td>

                <td>{{ $entrada->supervisor }}</td>
                <td>{{ $entrada->fecha_entrada }}</td>
                <td>
                    <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display:inline;">
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
