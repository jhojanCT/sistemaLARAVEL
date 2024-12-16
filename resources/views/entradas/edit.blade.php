@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Entrada</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entradas.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select class="form-control" id="producto_id" name="producto_id" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $entrada->producto_id == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="proveedor_id" class="form-label">Proveedor</label>
            <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ $entrada->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $entrada->cantidad }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de Venta</label>
            <input type="number" class="form-control" id="precio_venta" name="precio_venta" value="{{ $entrada->precio_venta }}" min="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
            <input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" value="{{ $entrada->fecha_entrada->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="existencia_filtrada" class="form-label">Existencia Filtrada</label>
            <input type="number" class="form-control" id="existencia_filtrada" name="existencia_filtrada" value="{{ $entrada->existencia_actual }}" min="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="supervisor" class="form-label">Supervisor</label>
            <input type="text" class="form-control" id="supervisor" name="supervisor" value="{{ $entrada->supervisor }}" placeholder="Opcional">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
