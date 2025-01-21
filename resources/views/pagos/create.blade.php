@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Nuevo Pago</h1>
    
    <form action="{{ route('pagos.store', [$venta->id, $venta->getMorphClass()]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="number" name="monto" id="monto" class="form-control" required step="0.01">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Pago</button>
    </form>
</div>
@endsection
