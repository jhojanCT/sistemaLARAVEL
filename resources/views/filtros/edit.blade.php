<!-- resources/views/filtros/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Filtro</h1>

        <!-- Formulario para editar el filtro -->
        <form action="{{ route('filtros.update', $filtro->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Selección del producto -->
            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ $filtro->producto_id == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Selección del proveedor -->
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $filtro->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo para cantidad inicial -->
            <div class="form-group">
                <label for="cantidad_inicial">Cantidad Inicial</label>
                <input type="number" name="cantidad_inicial" id="cantidad_inicial" class="form-control" value="{{ $filtro->cantidad_inicial }}" required>
            </div>

            <!-- Campo para cantidad final -->
            <div class="form-group">
                <label for="cantidad_final">Cantidad Final</label>
                <input type="number" name="cantidad_final" id="cantidad_final" class="form-control" value="{{ $filtro->cantidad_final }}" required>
            </div>

            <!-- Campo para desperdicio -->
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" value="{{ $filtro->desperdicio }}" required>
            </div>

            <!-- Campo para supervisor -->
            <div class="form-group">
                <label for="supervisor">Supervisor</label>
                <input type="text" name="supervisor" id="supervisor" class="form-control" value="{{ $filtro->supervisor }}" required>
            </div>

            <!-- Campo para fecha del filtro -->
            <div class="form-group">
                <label for="fecha_filtro">Fecha del Filtro</label>
                <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" value="{{ $filtro->fecha_filtro }}" required>
            </div>

            <!-- Botón para actualizar -->
            <button type="submit" class="btn btn-warning mt-3">Actualizar Filtro</button>
        </form>
    </div>
@endsection
