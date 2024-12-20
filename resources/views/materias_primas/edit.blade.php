@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Materia Prima</h1>
<form action="{{ route('materias_primas.update', $materiaPrima->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $materiaPrima->nombre) }}" required>
    </div>

    <button type="submit" class="btn btn-primary" >Guardar cambios</button>
</form>

</div>
@endsection
