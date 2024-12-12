@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Filtro</h1>

    <form action="{{ route('filtros.update', $filtro->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" id="categoria_id" class="form-control">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $filtro->categoria == $categoria->nombre ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control">
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $filtro->producto == $producto->nombre ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="proveedor">Proveedor</label>
            <input type="text" name="proveedor" id="proveedor" class="form-control" value="{{ $filtro->proveedor }}" required>
        </div>

        <div class="form-group">
            <label for="existencia_total_inicial">Existencia Total Inicial</label>
            <input type="number" name="existencia_total_inicial" id="existencia_total_inicial" class="form-control" value="{{ $filtro->existencia_total_inicial }}" required>
        </div>

        <div class="form-group">
            <label for="desperdicio">Desperdicio</label>
            <input type="number" name="desperdicio" id="desperdicio" class="form-control" value="{{ $filtro->desperdicio }}" required>
        </div>

        <div class="form-group">
            <label for="filtrado_supervisor">Supervisor</label>
            <select name="filtrado_supervisor" id="filtrado_supervisor" class="form-control">
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $filtro->filtrado_supervisor == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_filtro">Fecha del Filtro</label>
            <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" value="{{ $filtro->fecha_filtro }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Filtro</button>
    </form>
</div>
@endsection
