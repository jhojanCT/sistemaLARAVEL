@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Cuentas</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Saldo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
            <tr>
                <td>{{ $cuenta->nombre }}</td>
                <td>Bs{{ number_format($cuenta->saldo, 2) }}</td>
                <td>
                    <!-- Botón de Ver detalles -->
                    <a href="{{ route('cuentas.show', $cuenta->id) }}" class="btn btn-info">Ver detalles</a>
                    
                    <!-- Botón de Editar -->
                    <a href="{{ route('cuentas.edit', $cuenta->id) }}" class="btn btn-warning">Editar</a>
                    
                    <!-- Formulario para Eliminar -->
                </td>
            </tr>
            @endforeach

            <!-- Fila para mostrar la Cuenta General -->
            <tr>
                <td><strong>Cuenta General</strong></td>
                <td><strong>Bs{{ number_format($totalSaldo, 2) }}</strong></td>
                <td>
                    <!-- Botón de Ver detalles para la Cuenta General -->
                    <button class="btn btn-info" disabled>Ver detalles</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
