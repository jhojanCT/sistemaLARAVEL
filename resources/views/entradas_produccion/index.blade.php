@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Entradas de Producción</h2>

    <a href="{{ route('entradas_produccion.create') }}" class="btn btn-primary mb-3">Agregar Nueva Entrada</a>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad de Materia Prima en Uso</th>
                <th>Cantidad Producto</th>
                <th>Precio Venta</th>
                <th>Fecha de Entrada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
            <tr>
                <td>{{ $entrada->producto->nombre }}</td>
                <td>{{ $entrada->materia_prima_en_uso }}</td>    
                <td>{{ $entrada->cantidad_producto }}</td>
                <td>{{ $entrada->precio_venta }}</td>
                <td>{{ $entrada->fecha_entrada }}</td>
                <td>
                    <a href="{{ route('entradas_produccion.edit', $entrada->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('entradas_produccion.destroy', $entrada->id) }}" method="POST" class="d-inline-block">
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
