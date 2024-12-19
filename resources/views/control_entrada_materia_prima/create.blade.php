@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Agregar Nueva Entrada de Materia Prima</h2>

        <form action="{{ route('control_entrada_materia_prima.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="proveedor_id">Proveedor:</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="materia_prima">Materia Prima:</label>
                <input type="text" name="materia_prima" id="materia_prima" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="encargado">Encargado:</label>
                <input type="text" name="encargado" id="encargado" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha_llegada">Fecha de Llegada:</label>
                <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
