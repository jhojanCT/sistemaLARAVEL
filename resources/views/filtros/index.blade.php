<!-- resources/views/filtros/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Filtros de Almacén</h1>
        
        <!-- Botón para crear un nuevo filtro -->
        <a href="{{ route('filtros.create') }}" class="btn btn-primary">Agregar Nuevo Filtro</a>
        
        <!-- Tabla con los registros de filtros -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Proveedor</th>
                    <th>Cantidad Inicial</th>
                    <th>Cantidad Final</th>
                    <th>Desperdicio</th>
                    <th>Supervisor</th>
                    <th>Fecha del Filtro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filtros as $filtro)
                    <tr>
                        <td>{{ $filtro->producto->nombre }}</td>
                        <td>{{ $filtro->proveedor->nombre }}</td>
                        <td>{{ $filtro->cantidad_inicial }}</td>
                        <td>{{ $filtro->cantidad_final }}</td>
                        <td>{{ $filtro->desperdicio }}</td>
                        <td>{{ $filtro->supervisor }}</td>
                        <td>{{ $filtro->fecha_filtro }}</td>
                        <td>
                            <!-- Botones para editar y eliminar -->
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
