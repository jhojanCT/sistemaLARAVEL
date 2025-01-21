<!-- resources/views/filtros/finalizar.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Finalizar Filtro</h2>

        <form action="{{ route('filtros.finalizar', $filtro->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="existencia_filtrada">Cantidad Filtrada</label>
                <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Finalizar Filtro</button>
        </form>
    </div>
@endsection
