@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agregar Nueva Entrada de Producción</h2>

    <form action="{{ route('entradas_produccion.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

                <!-- Selección de Materia Prima en Uso -->
                <div class="mb-3">
                    <label for="almacen_filtrado_id" class="form-label">Materia Prima en Uso</label>
                    <select id="almacen_filtrado_id" name="almacen_filtrado_id" class="form-select" required>
                        <option value="">Selecciona Materia Prima Filtrada</option>
                        @foreach ($almacenFiltrado as $almacen)
                            <option value="{{ $almacen->id }}">
                                {{ $almacen->materiaPrima->nombre }} - {{ $almacen->cantidad_materia_prima_filtrada }} en existencia
                            </option>
                        @endforeach
                    </select>
                </div>

        <div class="mb-3">
            <label for="materia_prima_en_uso" class="form-label">Cantidad de Materia Prima en Uso</label>
            <input type="number" name="materia_prima_en_uso" id="materia_prima_en_uso" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('entradas_produccion.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection













