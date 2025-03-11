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
                    @if($cuenta->nombre !== 'Bóveda')
                        <form action="{{ route('cuentas.destroy', $cuenta->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta cuenta?')">Eliminar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
