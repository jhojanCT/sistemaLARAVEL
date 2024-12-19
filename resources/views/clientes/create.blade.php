@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Añadir Cliente</h1>

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico</label>
                <input type="email" name="correo_electronico" id="correo_electronico" class="form-control">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
@endsection