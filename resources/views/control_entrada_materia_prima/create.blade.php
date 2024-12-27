@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Agregar Nueva Entrada de Materia Prima</h2>

        <form action="{{ route('control_entrada_materia_prima.store') }}" method="POST">
            @csrf
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
                <label for="cantidad">Cantidad (kg)</label>
                <input type="number" name="cantidad" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="precio_unitario_por_kilo">Precio Unitario (por kg)</label>
                <input type="number" name="precio_unitario_por_kilo" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="precio_total">Precio Total</label>
                <input type="number" name="precio_total" class="form-control" step="0.01" readonly>
            </div>

            <div class="form-group">
                <label for="encargado">Encargado</label>
                <input type="text" name="encargado" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha_llegada">Fecha de Llegada</label>
                <input type="date" name="fecha_llegada" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
