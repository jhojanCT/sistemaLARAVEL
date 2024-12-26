@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Filtros</h1>
        <a href="{{ route('filtros.create') }}" class="btn btn-primary">Agregar Filtro</a>
        
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Materia Prima</th>
                    <th>Cantidad Usada</th>
                    <th>Desperdicio</th>
                    <th>Existencia Filtrada</th>
                    <th>Supervisor</th>
                    <th>Fecha de Filtro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filtros as $filtro)
                    <tr>
                        <td>{{ $filtro->proveedor->nombre }}</td>
                        <td>{{ $filtro->almacenSinFiltro->materiaPrima->nombre }}</td>
                        <td>{{ $filtro->cantidad_usada }}</td>
                        <td>{{ $filtro->desperdicio }}</td>
                        <td>{{ $filtro->existencia_filtrada }}</td>
                        <td>{{ $filtro->supervisor }}</td>
                        <td>{{ $filtro->fecha_filtro }}</td>
                        <td>
                            <a href="{{ route('filtros.edit', $filtro) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('filtros.destroy', $filtro) }}" method="POST" style="display:inline;">
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
