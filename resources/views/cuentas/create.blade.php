@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Nueva Cuenta</h1>
    <form action="{{ route('cuentas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre de la Cuenta</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="saldo">Saldo Inicial</label>
            <input type="number" step="0.01" class="form-control" id="saldo" name="saldo">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
