@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($credito) ? 'Editar Crédito de Compra' : 'Nuevo Crédito de Compra' }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ isset($credito) ? route('credito_compras.update', $credito->id) : route('credito_compras.store') }}" method="POST">
            @csrf
            @isset($credito)
                @method('PUT')
            @endisset

            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                    <option value="">Seleccionar proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ isset($credito) && $credito->proveedor_id == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="control_entrada_id">Entrada de Materia Prima</label>
                <select class="form-control" id="control_entrada_id" name="control_entrada_id" required>
                    <option value="">Seleccionar entrada</option>
                    @foreach($entradas as $entrada)
                        <option value="{{ $entrada->id }}" {{ isset($credito) && $credito->control_entrada_id == $entrada->id ? 'selected' : '' }}>{{ $entrada->materiaPrima->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="monto_total">Monto Total</label>
                <input type="number" class="form-control" id="monto_total" name="monto_total" value="{{ isset($credito) ? $credito->monto_total : old('monto_total') }}" required>
            </div>

            <div class="form-group">
                <label for="monto_pagado">Monto Pagado</label>
                <input type="number" class="form-control" id="monto_pagado" name="monto_pagado" value="{{ isset($credito) ? $credito->monto_pagado : old('monto_pagado') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ isset($credito) ? $credito->fecha : old('fecha') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('credito_compras.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
