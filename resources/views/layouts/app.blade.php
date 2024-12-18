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
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand ms-3" href="#">Inventario</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-3">
                <li class="nav-item"><a class="nav-link" href="{{ route('categorias.index') }}">Categorías</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('proveedores.index') }}">Proveedores</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('entradas.index') }}">Entradas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('filtros.index') }}">Filtros</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('salidas.index') }}">Salidas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('almacen-sin-filtro.index') }}">Almacen sin filtro</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('almacen-filtrado.index') }}">Almacen filtrado</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        @yield('content') <!-- Aquí se carga el contenido de cada vista -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
