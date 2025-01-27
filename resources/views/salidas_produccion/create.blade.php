<!-- resources/views/salidas_produccion/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Nueva Salida de Producción</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('salidas_produccion.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="entrada_produccion_id">Entrada de Producción</label>
                <select name="entrada_produccion_id" id="entrada_produccion_id" class="form-control">
                    <option value="">Seleccione una entrada de producción</option>
                    @foreach($entradas as $entrada)
                        <option value="{{ $entrada->id }}">{{ $entrada->id }} - {{ $entrada->producto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad_productos_hechos">Cantidad de Productos Hechos</label>
                <input type="number" name="cantidad_productos_hechos" id="cantidad_productos_hechos" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="precio_produccion">Costo de Producción por Unidad</label> <!-- Cambiado aquí -->
                <input type="number" step="0.01" name="precio_produccion" id="precio_produccion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha_salida">Fecha de Salida</label>
                <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Registrar Salida</button>
        </form>
    </div>
@endsection
