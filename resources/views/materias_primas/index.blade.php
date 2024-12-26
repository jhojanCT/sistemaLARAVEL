<!-- resources/views/materias_primas/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Materias Primas</h1>
    <a href="{{ route('materias_primas.create') }}" class="btn btn-primary mb-3">Agregar Materia Prima</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materiasPrimas as $materiaPrima)
                <tr>
                    <td>{{ $materiaPrima->nombre }}</td>
                    <td>
                        <a href="{{ route('materias_primas.edit', $materiaPrima) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('materias_primas.destroy', $materiaPrima) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta materia prima?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
