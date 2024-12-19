@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Añadir Cliente</h1>


            <form action="{{ route('entradas_produccion.store') }}" method="POST">
                @csrf
            
                <!-- Producto Seleccionado -->
                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <select id="producto_id" name="producto_id" class="form-select" required>
                        <option value="">Selecciona un Producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Selección de Materia Prima en Uso -->
                <div class="mb-3">
                    <label for="almacen_filtrado_id" class="form-label">Materia Prima en Uso</label>
                    <select id="almacen_filtrado_id" name="almacen_filtrado_id" class="form-select" required>
                        <option value="">Selecciona Materia Prima</option>
                        @foreach ($almacenFiltrado as $almacen)
                            <option value="{{ $almacen->id }}">
                                {{ $almacen->materia_prima_filtrada }} - {{ $almacen->cantidad_materia_prima_filtrada }} en existencia
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Materia Prima en Uso (cantidad) -->
                <div class="mb-3">
                    <label for="materia_prima_en_uso" class="form-label">Materia Prima en Uso (cantidad)</label>
                    <input type="number" step="0.01" id="materia_prima_en_uso" name="materia_prima_en_uso" class="form-control" required>
                </div>
            
            
                <!-- Cantidad de Producto -->
                <div class="mb-3">
                    <label for="cantidad_producto" class="form-label">Cantidad de Producto</label>
                    <input type="number" id="cantidad_producto" name="cantidad_producto" class="form-control" required>
                </div>
            
                <!-- Precio de Venta -->
                <div class="mb-3">
                    <label for="precio_venta" class="form-label">Precio de Venta</label>
                    <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="form-control" required>
                </div>
            
                <!-- Fecha de Entrada (sin hora) -->
                <div class="mb-3">
                    <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                    <input type="date" id="fecha_entrada" name="fecha_entrada" class="form-control" required>
                </div>
            
                <button type="submit" class="btn btn-primary">Agregar Entrada</button>
            </form>
        </div>
        @endsection