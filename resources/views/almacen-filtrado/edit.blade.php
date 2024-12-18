<!-- resources/views/almacen-filtrado/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Entrada al Almacén Filtrado</h1>

        <!-- Formulario para editar la entrada -->
        <form action="{{ route('almacen-filtrado.update', $almacenFiltrado->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Selección del proveedor -->
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $almacenFiltrado->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Selección del producto -->
            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ $almacenFiltrado->producto_id == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo para cantidad -->
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $almacenFiltrado->cantidad }}" required>
            </div>

            <!-- Campo para desperdicio -->
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" value="{{ $almacenFiltrado->desperdicio }}" required>
            </div>

            <!-- Campo para encargado -->
            <div class="form-group">
                <label for="encargado">Encargado</label>
                <input type="text" name="encargado" id="encargado" class="form-control" value="{{ $almacenFiltrado->encargado }}" required>
            </div>

            <!-- Campo para fecha de llegada -->
            <div class="form-group">
                <label for="fecha_llegada">Fecha de Llegada</label>
                <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control" value="{{ $almacenFiltrado->fecha_llegada }}" required>
            </div>

            <!-- Botón para actualizar -->
            <button type="submit" class="btn btn-warning mt-3">Actualizar Entrada</button>
        </form>
    </div>
@endsection
