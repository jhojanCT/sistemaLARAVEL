@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Almacén Filtrado Consolidado</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Proveedor</th>
                <th>Materia Prima Filtrada</th>
                <th>Cantidad Total Filtrada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($almacenFiltrado as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->proveedor->nombre }}</td>
                <td>{{ $item->materiaPrima->nombre }}</td>
                <td>{{ $item->cantidad_materia_prima_filtrada }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
