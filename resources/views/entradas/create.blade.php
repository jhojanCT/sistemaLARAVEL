@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Entrada</h1>

        <form action="{{ route('entradas.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="producto_id" class="form-label">Producto</label>
                <select name="producto_id" id="producto_id" class="form-control" required>
                    <option value="">Seleccionar Producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="proveedor_id" class="form-label">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                    <option value="">Seleccionar Proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label for="precio_venta" class="form-label">Precio de Venta</label>
                <input type="number" name="precio_venta" id="precio_venta" class="form-control" required min="0" step="0.01">
            </div>

            <div class="mb-3">
                <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                <input type="date" name="fecha_entrada" id="fecha_entrada" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="existencia_filtrada" class="form-label">Existencia Filtrada</label>
                <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control" required min="0" step="0.01">
            </div>

            <button type="submit" class="btn btn-success">Guardar Entrada</button>
        </form>
    </div>
@endsection
