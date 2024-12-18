<!-- resources/views/almacen-filtrado/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Almacén Filtrado</h1>
        
        <!-- Botón para crear una nueva entrada -->
        <a href="{{ route('almacen-filtrado.create') }}" class="btn btn-primary">Agregar Nueva Entrada</a>
        
        <!-- Tabla con los registros del almacen filtrado -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Desperdicio</th>
                    <th>Encargado</th>
                    <th>Fecha de Llegada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($almacenFiltrado as $registro)
                    <tr>
                        <td>{{ $registro->proveedor->nombre }}</td>
                        <td>{{ $registro->producto->nombre }}</td>
                        <td>{{ $registro->producto->categoria->nombre }}</td>
                        <td>{{ $registro->cantidad }}</td>
                        <td>{{ $registro->desperdicio }}</td>
                        <td>{{ $registro->encargado }}</td>
                        <td>{{ $registro->fecha_llegada }}</td>
                        <td>
                            <!-- Botones para editar y eliminar -->
                            <a href="{{ route('almacen-filtrado.edit', $registro->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('almacen-filtrado.destroy', $registro->id) }}" method="POST" style="display:inline;">
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
