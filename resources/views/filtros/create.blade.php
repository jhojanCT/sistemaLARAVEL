@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Agregar Filtro</h1>
        
        <form action="{{ route('filtros.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control">
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="almacen_sin_filtro_id">Almacén Sin Filtrar</label>
                <select name="almacen_sin_filtro_id" id="almacen_sin_filtro_id" class="form-control">
                    @foreach($almacenesSinFiltro as $almacen)
                        <option value="{{ $almacen->id }}">{{ $almacen->materia_prima }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad_usada">Cantidad Usada</label>
                <input type="number" name="cantidad_usada" id="cantidad_usada" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="existencia_filtrada">Existencia Filtrada</label>
                <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control" step="0.01" required readonly>
            </div>
            <div class="form-group">
                <label for="supervisor">Supervisor</label>
                <input type="text" name="supervisor" id="supervisor" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha_filtro">Fecha de Filtro</label>
                <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Guardar</button>
        </form>
    </div>

    <script>
        // Escuchar los cambios en los campos 'cantidad_usada' y 'desperdicio'
        document.getElementById('cantidad_usada').addEventListener('input', calcularExistenciaFiltrada);
        document.getElementById('desperdicio').addEventListener('input', calcularExistenciaFiltrada);

        function calcularExistenciaFiltrada() {
            // Obtener los valores de los campos
            let cantidadUsada = parseFloat(document.getElementById('cantidad_usada').value) || 0;
            let desperdicio = parseFloat(document.getElementById('desperdicio').value) || 0;

            // Calcular la existencia filtrada
            let existenciaFiltrada = cantidadUsada - desperdicio;

            // Mostrar el resultado en el campo 'existencia_filtrada'
            document.getElementById('existencia_filtrada').value = existenciaFiltrada.toFixed(2);
        }
    </script>
@endsection
