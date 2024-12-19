@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Filtro</h1>
        
        <form action="{{ route('filtros.update', $filtro) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control">
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $filtro->proveedor_id == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="almacen_sin_filtro_id">Almacén Sin Filtrar</label>
                <select name="almacen_sin_filtro_id" id="almacen_sin_filtro_id" class="form-control">
                    @foreach($almacenesSinFiltro as $almacen)
                        <option value="{{ $almacen->id }}" {{ $filtro->almacen_sin_filtro_id == $almacen->id ? 'selected' : '' }}>{{ $almacen->materia_prima }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad_usada">Cantidad Usada</label>
                <input type="number" name="cantidad_usada" id="cantidad_usada" class="form-control" step="0.01" value="{{ $filtro->cantidad_usada }}" required>
            </div>
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" step="0.01" value="{{ $filtro->desperdicio }}" required>
            </div>
            <div class="form-group">
                <label for="existencia_filtrada">Existencia Filtrada</label>
                <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control" step="0.01" value="{{ $filtro->existencia_filtrada }}" required>
            </div>
            <div class="form-group">
                <label for="supervisor">Supervisor</label>
                <input type="text" name="supervisor" id="supervisor" class="form-control" value="{{ $filtro->supervisor }}" required>
            </div>
            <div class="form-group">
                <label for="fecha_filtro">Fecha de Filtro</label>
                <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" value="{{ $filtro->fecha_filtro }}" required>
            </div>
            <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
        </form>
    </div>
@endsection
