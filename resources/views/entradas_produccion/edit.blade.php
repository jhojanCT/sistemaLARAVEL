@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Entrada de Producción</h2>

    <form action="{{ route('entradas_produccion.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Selección de Producto -->
        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select id="producto_id" name="producto_id" class="form-select" required>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $producto->id == $entrada->producto_id ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de Materia Prima en Uso -->
        <div class="mb-3">
            <label for="almacen_filtrado_id" class="form-label">Materia Prima en Uso</label>
            <select id="almacen_filtrado_id" name="almacen_filtrado_id" class="form-select" required>
                @foreach ($almacenes as $almacen)
                    <option value="{{ $almacen->id }}" {{ $almacen->id == $entrada->almacen_filtrado_id ? 'selected' : '' }}>{{ $almacen->producto->nombre }} - {{ $almacen->cantidad }} en existencia</option>
                @endforeach
            </select>
        </div>

        <!-- Materia Prima en Uso (cantidad) -->
        <div class="mb-3">
            <label for="materia_prima_en_uso" class="form-label">Materia Prima en Uso (cantidad)</label>
            <input type="number" step="0.01" id="materia_prima_en_uso" name="materia_prima_en_uso" class="form-control" value="{{ old('materia_prima_en_uso', $entrada->materia_prima_en_uso) }}" required>
        </div>

        <!-- Porcentaje de Producción -->
        <div class="mb-3">
            <label for="porcentaje_produccion" class="form-label">Porcentaje de Producción</label>
            <input type="number" id="porcentaje_produccion" name="porcentaje_produccion" class="form-control" min="0" max="100" value="{{ old('porcentaje_produccion', $entrada->porcentaje_produccion) }}" required>
        </div>

        <!-- Cantidad de Producto -->
        <div class="mb-3">
            <label for="cantidad_producto" class="form-label">Cantidad de Producto</label>
            <input type="number" id="cantidad_producto" name="cantidad_producto" class="form-control" value="{{ old('cantidad_producto', $entrada->cantidad_producto) }}">
        </div>

        <!-- Precio de Venta -->
        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de Venta</label>
            <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="form-control" value="{{ old('precio_venta', $entrada->precio_venta) }}" required>
        </div>

        <!-- Fecha y Hora de Entrada -->
        <div class="mb-3">
            <label for="fecha_hora_entrada" class="form-label">Fecha y Hora de Entrada</label>
            <input type="datetime-local" id="fecha_hora_entrada" name="fecha_hora_entrada" class="form-control" value="{{ old('fecha_hora_entrada', $entrada->fecha_hora_entrada) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Entrada</button>
    </form>
</div>
@endsection
