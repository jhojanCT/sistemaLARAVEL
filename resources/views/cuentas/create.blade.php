@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nueva Cuenta</h1>
    <form action="{{ route('cuentas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="saldo">Saldo Inicial</label>
            <input type="number" name="saldo" id="saldo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
@endsection
