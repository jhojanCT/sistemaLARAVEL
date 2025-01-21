@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Filtro</h1>
        
        <form action="{{ route('filtros.update', $filtro) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Proveedor -->
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control">
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $filtro->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Almacén Sin Filtrar -->
            <div class="form-group">
                <label for="almacen_sin_filtro_id">Almacén Sin Filtrar</label>
                <select name="almacen_sin_filtro_id" id="almacen_sin_filtro_id" class="form-control">
                    @foreach($almacenesSinFiltro as $almacen)
                        <option value="{{ $almacen->id }}" {{ $filtro->almacen_sin_filtro_id == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->materia_prima }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Cantidad Usada -->
            <div class="form-group">
                <label for="cantidad_usada">Cantidad Usada</label>
                <input type="number" name="cantidad_usada" id="cantidad_usada" class="form-control" step="0.01" 
                       value="{{ $filtro->cantidad_usada }}" required>
            </div>

            <!-- Desperdicio -->
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" step="0.01" 
                       value="{{ $filtro->desperdicio }}" required>
            </div>

            <!-- Existencia Filtrada -->
            <div class="form-group">
                <label for="existencia_filtrada">Existencia Filtrada</label>
                <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control" 
                       step="0.01" value="{{ $filtro->existencia_filtrada }}" readonly>
            </div>

            <!-- Supervisor -->
            <div class="form-group">
                <label for="supervisor">Supervisor</label>
                <input type="text" name="supervisor" id="supervisor" class="form-control" 
                       value="{{ $filtro->supervisor }}" required>
            </div>

            <!-- Fecha de Filtro -->
            <div class="form-group">
                <label for="fecha_filtro">Fecha de Filtro</label>
                <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" 
                       value="{{ $filtro->fecha_filtro }}" required>
            </div>

            <!-- Botón de actualización -->
            <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
        </form>
    </div>

    <!-- Script para calcular la existencia filtrada -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cantidadUsadaInput = document.getElementById('cantidad_usada');
            const desperdicioInput = document.getElementById('desperdicio');
            const existenciaFiltradaInput = document.getElementById('existencia_filtrada');

            function calcularExistenciaFiltrada() {
                const cantidadUsada = parseFloat(cantidadUsadaInput.value) || 0;
                const desperdicio = parseFloat(desperdicioInput.value) || 0;

                // Calcular la existencia filtrada como: cantidad usada - desperdicio
                const existenciaFiltrada = cantidadUsada - desperdicio;

                // Mostrar el resultado en el campo correspondiente
                existenciaFiltradaInput.value = existenciaFiltrada > 0 ? existenciaFiltrada.toFixed(2) : 0;
            }

            // Asignar eventos para actualizar el cálculo dinámicamente
            cantidadUsadaInput.addEventListener('input', calcularExistenciaFiltrada);
            desperdicioInput.addEventListener('input', calcularExistenciaFiltrada);
        });
    </script>
@endsection
