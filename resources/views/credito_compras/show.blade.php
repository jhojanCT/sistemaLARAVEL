@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles del Crédito de Compra</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Proveedor: {{ $credito->proveedor->nombre }}</h5>
                <p><strong>Materia Prima:</strong> {{ $credito->controlEntradaMateriaPrima->materiaPrima->nombre }}</p>
                <p><strong>Monto Total:</strong> {{ $credito->monto_total }}</p>
                <p><strong>Monto Pagado:</strong> {{ $credito->monto_pagado }}</p>
                <p><strong>Saldo Pendiente:</strong> {{ $credito->monto_total - $credito->monto_pagado }}</p>
                <p><strong>Estado:</strong> {{ $credito->estado ?? 'Pendiente' }}</p>
                <p><strong>Fecha:</strong> {{ $credito->fecha }}</p>
            </div>
        </div>

        <hr>

        <h3>Cuotas Pagadas</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha de Pago</th>
                    <th>Monto Pagado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($credito->pagos as $pago)
                    <tr>
                        <td>{{ $pago->fecha_pago }}</td>
                        <td>{{ $pago->monto_pagado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($credito->estado !== 'Finalizada')
            <form action="{{ route('credito_compras.pay', $credito->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="monto_pagado">Monto a Pagar</label>
                    <input type="number" class="form-control" id="monto_pagado" name="monto_pagado" required>
                </div>

                <button type="submit" class="btn btn-success">Pagar Cuota</button>
            </form>
        @else
            <p><strong>La compra ya ha sido finalizada.</strong></p>
        @endif

        <a href="{{ route('credito_compras.index') }}" class="btn btn-secondary">Volver</a>
    </div>
@endsection
