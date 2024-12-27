@extends('layouts.app2') <!-- Si tienes un diseño base -->

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h4>Iniciar sesión</h4>
            </div>
            <div class="card-body">
                <!-- Formulario de inicio de sesión -->
                <form name="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf <!-- Token de seguridad -->
                    
                    <!-- Campo para el correo electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            required>
                        <!-- Mensaje de error para el correo -->
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo para la contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            required>
                        <!-- Mensaje de error para la contraseña -->
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botón de inicio de sesión -->
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </div>
                </form>

                <!-- Enlace para recuperar contraseña -->
                <div class="text-center">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
