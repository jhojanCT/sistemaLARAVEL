@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Almacén Sin Filtrar</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Proveedor</th>
                <th>Materia Prima</th>
                <th>Cantidad Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($almacenSinFiltro as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->proveedor->nombre }}</td>
                <td>{{ $item->materia_prima }}</td>
                <td>{{ $item->cantidad_total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
