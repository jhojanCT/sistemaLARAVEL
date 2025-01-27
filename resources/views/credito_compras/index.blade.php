@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créditos de Compra</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Monto Total</th>
                    <th>Monto Pagado</th>
                    <th>Lo que se Debe</th>
                    <th>Entrada de Materia Prima</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($creditos as $credito)
                    <tr>
                        <td>{{ $credito->id }}</td>
                        <td>{{ $credito->proveedor->nombre }}</td>
                        <td>{{ $credito->monto_total }}</td>
                        <td>{{ $credito->monto_pagado }}</td>
                        <td>{{ $credito->monto_total - $credito->monto_pagado }}</td> <!-- Lo que se debe -->
                        <td>{{ $credito->controlEntradaMateriaPrima->materiaPrima->nombre }}</td>
                        <td>{{ $credito->fecha }}</td>
                        <td>
                            <a href="{{ route('credito_compras.edit', $credito->id) }}" class="btn btn-warning">Editar</a>
                            <a href="{{ route('credito_compras.show', $credito->id) }}" class="btn btn-info">Ver Detalles</a>
                            <form action="{{ route('credito_compras.destroy', $credito->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('credito_compras.create') }}" class="btn btn-primary">Crear Nuevo Crédito de Compra</a>
    </div>
@endsection
