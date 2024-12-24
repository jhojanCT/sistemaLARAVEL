@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Filtro</h1>

    <form action="{{ route('filtros.store') }}" method="POST">
        @csrf
        
        <!-- Campo Proveedor -->
        <div class="form-group">
            <label for="proveedor_id">Proveedor</label>
            <select name="proveedor_id" id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror">
                <option value="">Selecciona un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
            @error('proveedor_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo Almacén sin Filtro -->
        <div class="form-group">
            <label for="almacen_sin_filtro_id">Almacén sin Filtro</label>
            <select name="almacen_sin_filtro_id" id="almacen_sin_filtro_id" class="form-control @error('almacen_sin_filtro_id') is-invalid @enderror">
                <option value="">Selecciona un almacén sin filtro</option>
                @foreach ($almacenesSinFiltro as $almacen)
                    <option value="{{ $almacen->id }}" {{ old('almacen_sin_filtro_id') == $almacen->id ? 'selected' : '' }}>
                        {{ $almacen->materiaPrima->nombre }} - {{ $almacen->cantidad_total }} unidades
                    </option>
                @endforeach
            </select>
            @error('almacen_sin_filtro_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo Cantidad Usada -->
        <div class="form-group">
            <label for="cantidad_usada">Cantidad Usada</label>
            <input type="number" name="cantidad_usada" id="cantidad_usada" class="form-control @error('cantidad_usada') is-invalid @enderror" value="{{ old('cantidad_usada') }}" step="0.01">
            @error('cantidad_usada')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo Desperdicio -->
        <div class="form-group">
            <label for="desperdicio">Desperdicio</label>
            <input type="number" name="desperdicio" id="desperdicio" class="form-control @error('desperdicio') is-invalid @enderror" value="{{ old('desperdicio') }}" step="0.01">
            @error('desperdicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo Existencia Filtrada -->
        <div class="form-group">
            <label for="existencia_filtrada">Existencia Filtrada</label>
            <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control @error('existencia_filtrada') is-invalid @enderror" value="{{ old('existencia_filtrada') }}" step="0.01">
            @error('existencia_filtrada')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo Supervisor -->
        <div class="form-group">
            <label for="supervisor">Supervisor</label>
            <input type="text" name="supervisor" id="supervisor" class="form-control @error('supervisor') is-invalid @enderror" value="{{ old('supervisor') }}">
            @error('supervisor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo Fecha de Filtro -->
        <div class="form-group">
            <label for="fecha_filtro">Fecha del Filtro</label>
            <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control @error('fecha_filtro') is-invalid @enderror" value="{{ old('fecha_filtro') }}">
            @error('fecha_filtro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Crear Filtro</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cantidadUsada = document.getElementById('cantidad_usada');
        const desperdicio = document.getElementById('desperdicio');
        const existenciaFiltrada = document.getElementById('existencia_filtrada');

        function calcularExistenciaFiltrada() {
            const usada = parseFloat(cantidadUsada.value) || 0;
            const desperd = parseFloat(desperdicio.value) || 0;
            existenciaFiltrada.value = (usada - desperd).toFixed(2);
        }

        cantidadUsada.addEventListener('input', calcularExistenciaFiltrada);
        desperdicio.addEventListener('input', calcularExistenciaFiltrada);
    });
</script>
@endsection
