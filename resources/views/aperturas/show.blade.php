<!-- aperturas/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Apertura</h1>
    <p><strong>Fecha:</strong> {{ $apertura->fecha }}</p>
    <p><strong>Estado:</strong> {{ $apertura->estado }}</p>
    <p><strong>Descripción:</strong> {{ $apertura->descripcion }}</p>
    <a href="{{ route('aperturas.index') }}" class="btn btn-primary">Volver a la lista</a>
</div>
@endsection
