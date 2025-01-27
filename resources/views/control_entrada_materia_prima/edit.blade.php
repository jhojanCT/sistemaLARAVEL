@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Entrada de Materia Prima</h1>

        <form action="{{ route('control_entrada_materia_prima.update', $entrada->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                    <option value="">Seleccione un proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $entrada->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="materia_prima_id">Materia Prima</label>
                <select name="materia_prima_id" id="materia_prima_id" class="form-control" required>
                    <option value="">Seleccione una materia prima</option>
                    @foreach($materiasPrimas as $materiaPrima)
                        <option value="{{ $materiaPrima->id }}" {{ $entrada->materia_prima_id == $materiaPrima->id ? 'selected' : '' }}>
                            {{ $materiaPrima->nombre }}
                        </option>
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

            <div class="form-group">
                <label for="precio_unitario_por_kilo">Precio Unitario por Kilo</label>
                <input type="number" step="0.01" name="precio_unitario_por_kilo" id="precio_unitario_por_kilo" class="form-control" value="{{ $entrada->precio_unitario_por_kilo }}" required>
            </div>

            <div class="form-group">
                <label for="compra_credito">¿Es a Crédito?</label>
                <select name="compra_credito" id="compra_credito" class="form-control" required>
                    <option value="1" {{ $entrada->compra_credito ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$entrada->compra_credito ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning mt-3">Actualizar Entrada</button>
        </form>
    </div>
@endsection
