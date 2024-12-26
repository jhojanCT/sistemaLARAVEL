<!-- resources/views/salidas_produccion/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Salida de Producción</h1>

        <!-- Mostrar errores de validación -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de edición de Salida de Producción -->
        <form action="{{ route('salidas_produccion.update', $salida->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="entrada_produccion_id">Entrada de Producción</label>
                <select name="entrada_produccion_id" id="entrada_produccion_id" class="form-control">
                    <option value="">Seleccione una entrada de producción</option>
                    @foreach($entradas as $entrada)
                        <option value="{{ $entrada->id }}" @if($entrada->id == $salida->entrada_produccion_id) selected @endif>
                            {{ $entrada->id }} - {{ $entrada->producto->nombre }} <!-- Muestra el producto asociado a la entrada -->
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad_productos_hechos">Cantidad de Productos Hechos</label>
                <input type="number" name="cantidad_productos_hechos" id="cantidad_productos_hechos" class="form-control" value="{{ $salida->cantidad_productos_hechos }}" required>
            </div>

            <div class="form-group">
                <label for="precio_produccion">Precio de Producción</label>
                <input type="number" name="precio_produccion" id="precio_produccion" class="form-control" value="{{ $salida->precio_produccion }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_salida">Fecha de Salida</label>
                <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" value="{{ $salida->fecha_salida }}" required>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Salida</button>
        </form>
    </div>
@endsection
