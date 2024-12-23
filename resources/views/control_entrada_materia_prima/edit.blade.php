@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Entrada de Materia Prima</h1>

    <form action="{{ route('control_entrada_materia_prima.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
        <label for="proveedor_id">Proveedor</label>
        <select name="proveedor_id" class="form-control" required>
            @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
            @endforeach
        </select>
        </div>

        <div class="form-group">
            <label for="materia_prima_id">Materia Prima</label>
            <select name="materia_prima_id" class="form-control" required>
                @foreach($materiasPrimas as $materiaPrima)
                    <option value="{{ $materiaPrima->id }}">{{ $materiaPrima->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $entrada->cantidad }}" required>
        </div>

        <div class="form-group">
            <label for="encargado">Encargado</label>
            <input type="text" name="encargado" id="encargado" class="form-control" value="{{ $entrada->encargado }}" required>
        </div>

        <div class="form-group">
            <label for="fecha_llegada">Fecha de Llegada</label>
            <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control" value="{{ $entrada->fecha_llegada }}" required>
        </div>

        <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
    </form>
</div>
@endsection
