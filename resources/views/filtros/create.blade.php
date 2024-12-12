@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Nuevo Filtro</h1>
    <form action="{{ route('filtros.store') }}" method="POST">
        @csrf

        <!-- Selección de Categoría -->
        <div class="form-group">
            <label for="categoria">Categoría</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->nombre }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de Producto -->
        <div class="form-group">
            <label for="producto">Producto</label>
            <select name="producto" id="producto" class="form-control" required>
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->nombre }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de Proveedor -->
        <div class="form-group">
            <label for="proveedor">Proveedor</label>
            <select name="proveedor" id="proveedor" class="form-control" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->nombre }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Datos del Filtro -->
        <div class="mb-3">
            <label for="existencia_total_inicial" class="form-label">Existencia Total Inicial (kg)</label>
            <input type="number" step="0.01" name="existencia_total_inicial" id="existencia_total_inicial" class="form-control" value="{{ old('existencia_total_inicial') }}" required>
        </div>

        <!-- Desperdicio -->
        <div class="mb-3">
            <label for="desperdicio" class="form-label">Desperdicio (kg)</label>
            <input type="number" step="0.01" name="desperdicio" id="desperdicio" class="form-control" value="{{ old('desperdicio') }}" required>
        </div>

        <!-- Existencia Total Filtrada -->
        <div class="mb-3">
            <label for="existencia_total_filtrada" class="form-label">Existencia Total Filtrada (kg)</label>
            <input type="number" step="0.01" name="existencia_total_filtrada" id="existencia_total_filtrada" class="form-control" required>
        </div>

        <!-- Filtrado Supervisor -->
        <div class="mb-3">
            <label for="filtrado_supervisor" class="form-label">Supervisor</label>
            <input type="text" name="filtrado_supervisor" id="filtrado_supervisor" class="form-control" value="{{ old('filtrado_supervisor') }}" required>
        </div>

        <!-- Fecha del Filtro -->
        <div class="mb-3">
            <label for="fecha_filtro" class="form-label">Fecha del Filtro</label>
            <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" value="{{ old('fecha_filtro') }}" required>
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection