@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Rol</h1>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre del Rol</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Crear Rol</button>
    </form>
</div>
@endsection
