@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Filtros</h1>
    <a href="{{ route('filtros.create') }}" class="btn btn-primary mb-3">Añadir Filtro</a>
    <table class="table">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Existencia Total Inicial</th>
                <th>Desperdicio</th>
                <th>Existencia Filtrada</th>
                <th>Supervisor</th>
                <th>Fecha del Filtro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filtros as $filtro)
                <tr>
                    <td>{{ $filtro->categoria }}</td>
                    <td>{{ $filtro->producto }}</td>
                    <td>{{ $filtro->proveedor }}</td>
                    <td>{{ $filtro->existencia_total_inicial }} kg</td>
                    <td>{{ $filtro->desperdicio }} kg</td>
                    <td>{{ $filtro->existencia_total_filtrada }} kg</td>
                    <td>{{ $filtro->filtrado_supervisor }}</td>
                    <td>{{ $filtro->fecha_filtro }}</td>
                    <td>
                        <a href="{{ route('filtros.edit', $filtro->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('filtros.destroy', $filtro->id) }}" method="POST" style="display:inline;">
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
