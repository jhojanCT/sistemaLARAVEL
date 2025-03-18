@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Apertura Diaria</h2>

    <form action="{{ route('aperturas.abrir') }}" method="POST">
        @csrf
        <label>Saldo Inicial:</label>
        <input type="number" name="saldo_inicial" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-2">Abrir Día</button>
    </form>
</div>
@endsection
