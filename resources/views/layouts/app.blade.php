<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Enlace al CSS personalizado -->
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="#">Inventario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-3">
                @auth
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gestion de Productos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('categorias.index') }}"> Categorías </a></li>
                            <li><a class="dropdown-item" href="{{ route('productos.index') }}">Productos</a></li>
                            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Proveedores</a></li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Control de ventas
                        </a>
                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Clientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('ventas.materia_prima.index') }}">Venta de Mteria Prima</a></li>
                            <li><a class="dropdown-item" href="{{ route('ventas.productos.index') }}">Venta de Productos</a></li>

                        </ul>
                    </li>

                    <!-- Menú desplegable de Procesos, solo si está autenticado -->
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Producción
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('entradas_produccion.index') }}">Entradas de Producción</a></li>
                            <li><a class="dropdown-item" href="{{ route('salidas_produccion.index') }}">Salidas de Producción</a></li>
                        </ul>
                    </li>

                    <!-- Menú desplegable de Almacenes, solo si está autenticado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Almacenes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('almacen_sin_filtro.index') }}">Almacén sin filtro</a></li>
                            <li><a class="dropdown-item" href="{{ route('almacen_filtrado.index') }}">Almacén filtrado</a></li>
                            <li><a class="dropdown-item" href="{{ route('filtros.index') }}">Filtros</a></li>
                        </ul>
                    </li>



                    <!-- Menú desplegable de Entradas, solo si está autenticado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Entradas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('control_entrada_materia_prima.index') }}">Control de Entrada</a></li>
                            <li><a class="dropdown-item" href="{{ route('materias_primas.index') }}">Materias Primas</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Gestion de usuarios
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('roles.index') }}"> Roles </a></li>
                            <li><a class="dropdown-item" href="{{ route('users.index') }}"> usuarios</a></li>
                        </ul>
                    </li>

                    <!-- Botón de Cerrar sesión -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Cerrar sesión</button>
                        </form>
                    </li>
                    @endauth

                    <!-- Menú de inicio de sesión o registro para usuarios no autenticados -->
                    @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        @yield('content') <!-- Aquí se carga el contenido de cada vista -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
