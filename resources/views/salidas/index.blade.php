@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Salidas</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('salidas.create') }}" class="btn btn-primary mb-3">Registrar Salida</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha de Salida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidas as $salida)
                <tr>
                    <td>{{ $salida->id }}</td>
                    <td>{{ $salida->producto->nombre }}</td>
                    <td>{{ $salida->cantidad }}</td>
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>
                        <a href="{{ route('salidas.edit', $salida->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('salidas.destroy', $salida->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta salida?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
