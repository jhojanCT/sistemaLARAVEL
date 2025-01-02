@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Cuenta</h2>
    <form action="{{ route('cuentas.update', $cuenta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre de la Cuenta</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $cuenta->nombre) }}" required>
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="saldo">Saldo</label>
            <input type="number" step="0.01" name="saldo" id="saldo" class="form-control" value="{{ old('saldo', $cuenta->saldo) }}">
            @error('saldo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Cuenta</button>
        <a href="{{ route('cuentas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
