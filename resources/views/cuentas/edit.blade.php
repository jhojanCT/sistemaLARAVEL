@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cuenta: {{ $cuenta->nombre }}</h1>
    <form action="{{ route('cuentas.update', $cuenta->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre de la Cuenta</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cuenta->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="saldo">Saldo</label>
            <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" value="{{ $cuenta->saldo }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
