@extends('layouts.app')  <!-- Usa tu layout principal aquí -->

@section('title', 'Iniciar sesión')

@section('content')
<form action="{{ route('login') }}" method="POST" class="w-full max-w-sm mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
    <h2 class="text-xl font-bold text-gray-700 text-center mb-6">Iniciar Sesión</h2>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 font-bold mb-2">Correo Electrónico:</label>
        <input type="email" id="email" name="email" 
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
               placeholder="ejemplo@correo.com" required>
    </div>
    <div class="mb-6">
        <label for="password" class="block text-gray-700 font-bold mb-2">Contraseña:</label>
        <input type="password" id="password" name="password" 
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
               placeholder="********" required>
    </div>
    <div class="flex items-center justify-between">
        <button type="submit" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Iniciar Sesión
        </button>
        <a href="#" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
            ¿Olvidaste tu contraseña?
        </a>
    </div>
</form>
@endsection
