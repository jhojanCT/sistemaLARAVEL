<!-- resources/views/almacen-filtrado/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Agregar Nueva Entrada al Almacén Filtrado</h1>

        <!-- Formulario para agregar una nueva entrada -->
        <form action="{{ route('almacen-filtrado.store') }}" method="POST">
            @csrf
            <!-- Selección del proveedor -->
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control" required>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Selección del producto -->
            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Campo para cantidad -->
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required>
            </div>

            <!-- Campo para desperdicio -->
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" required>
            </div>

            <!-- Campo para encargado -->
            <div class="form-group">
                <label for="encargado">Encargado</label>
                <input type="text" name="encargado" id="encargado" class="form-control" required>
            </div>

            <!-- Campo para fecha de llegada -->
            <div class="form-group">
                <label for="fecha_llegada">Fecha de Llegada</label>
                <input type="date" name="fecha_llegada" id="fecha_llegada" class="form-control" required>
            </div>

            <!-- Botón para guardar -->
            <button type="submit" class="btn btn-success mt-3">Guardar Entrada</button>
        </form>
    </div>
@endsection
