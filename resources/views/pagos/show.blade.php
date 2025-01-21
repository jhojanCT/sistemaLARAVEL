@extends('layouts.app')

@section('title', 'Detalles de Pago')

@section('content')
<div class="container">
    <h1>Detalles de la Venta - {{ $venta->cliente->nombre }}</h1>
    <p><strong>Saldo Deuda:</strong> ${{ number_format($venta->saldo_deuda, 2) }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($venta->estado) }}</p>

    <hr>

    <h3>Pagos Realizados</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>N° de Cuota</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagosPorCuota as $pago)
                <tr>
                    <td>{{ $pago->cuota_numero }}</td>
                    <td>${{ number_format($pago->monto, 2) }}</td>
                    <td>{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : 'Pendiente' }}</td>
                    <td>
                        @if($pago->fecha_pago)
                            <span class="badge bg-success">Pago Completo</span>
                        @else
                            <span class="badge bg-warning">Pendiente</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay pagos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    <h3>Realizar un Nuevo Pago</h3>
    <form action="{{ route('pagos.store', ['id' => $venta->id, 'type' => $type]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="monto" class="form-label">Monto del Pago</label>
            <input type="number" class="form-control" name="monto" id="monto" value="{{ old('monto') }}" required min="0.01" step="0.01">
        </div>
        
        <div class="mb-3">
            <label for="cuota_numero" class="form-label">Número de Cuota</label>
            <input type="number" class="form-control" name="cuota_numero" id="cuota_numero" value="{{ old('cuota_numero') }}" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Registrar Pago</button>
    </form>

    @if(session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
