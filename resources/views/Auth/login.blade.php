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
                <form method="POST" action="{{ route('login') }}">
                    @csrf <!-- Token de seguridad -->
                    
                    <!-- Campo para el nombre de usuario -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre de usuario</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <!-- Campo para la contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
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
