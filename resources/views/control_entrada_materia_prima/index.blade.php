@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entradas de Materia Prima</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('control_entrada_materia_prima.create') }}" class="btn btn-primary mb-3">Añadir Nueva Entrada</a>

    <table class="table">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Materia Prima</th>
                <th>Cantidad</th>
                <th>Encargado</th>
                <th>Fecha de Llegada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    @foreach($entradas as $entrada)
        <tr>
            <td>{{ $entrada->proveedor->nombre }}</td>
            <td>{{ $entrada->almacenSinFiltro ? $entrada->almacenSinFiltro->materia_prima : 'No disponible' }}</td>
            <td>{{ $entrada->cantidad }}</td>
            <td>{{ $entrada->encargado }}</td>
            <td>{{ $entrada->fecha_llegada }}</td>
            <td>
                <a href="{{ route('control_entrada_materia_prima.edit', $entrada->id) }}" class="btn btn-warning">Editar</a>
            </td>
        </tr>
    @endforeach
</tbody>


    </table>
</div>
@endsection
