@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Rol</h1>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Rol</button>
    </form>
</div>
@endsection
