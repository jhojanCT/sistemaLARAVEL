@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Nueva Entrada</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entradas.store') }}" method="POST">
        @csrf

        <!-- Producto -->
        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select class="form-control" id="producto_id" name="producto_id" required>
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Proveedor -->
        <div class="mb-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Seleccionar Filtro -->
        <div class="mb-3">
            <label for="filtro_id" class="form-label">Seleccionar Filtro</label>
            <select class="form-control" id="filtro_id" name="filtro_id" required>
                <option value="">Seleccione un filtro</option>
                @foreach($filtros as $filtro)
                    <option value="{{ $filtro->id }}">
                        Producto: {{ $filtro->producto->nombre }} | Existencia filtrada: {{ $filtro->existencia_total_filtrada }} | Fecha: {{ $filtro->fecha_filtro->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Los datos del filtro seleccionado se llenarán automáticamente.</small>
        </div>

        <!-- Cantidad -->
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
        </div>

        <!-- Existencia Total (rellenado automáticamente según el filtro) -->
        <div class="mb-3">
            <label for="existencia_filtrada" class="form-label">Existencia Filtrada</label>
            <input type="number" class="form-control" id="existencia_filtrada" name="existencia_filtrada" min="0" step="0.01" readonly>
        </div>

        <!-- Porcentaje de Elaboración (rellenado automáticamente según el filtro) -->
        <div class="mb-3">
            <label for="porcentaje_elaboracion" class="form-label">Porcentaje de Elaboración</label>
            <input type="number" class="form-control" id="porcentaje_elaboracion" name="porcentaje_elaboracion" min="0" step="0.01" require>
        </div>

        <!-- Precio de Venta -->
        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de Venta</label>
            <input type="number" class="form-control" id="precio_venta" name="precio_venta" min="0" step="0.01" required>
        </div>

        <!-- Fecha de Entrada -->
        <div class="mb-3">
            <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
            <input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" required>
        </div>

        <!-- Supervisor -->
        <div class="mb-3">
            <label for="supervisor" class="form-label">Supervisor</label>
            <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Opcional">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    // Script para rellenar los campos automáticamente según el filtro seleccionado
    document.getElementById('filtro_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const existenciaFiltrada = selectedOption.getAttribute('data-existencia-filtrada');
        const porcentajeElaboracion = selectedOption.getAttribute('data-porcentaje-elaboracion');

        document.getElementById('existencia_filtrada').value = existenciaFiltrada || '';
        document.getElementById('porcentaje_elaboracion').value = porcentajeElaboracion || '';
    });
</script>
@endsection
