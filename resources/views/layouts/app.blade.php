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
                    <li class="nav-item"><a class="nav-link" href="{{ route('categorias.index') }}">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Productos</a></li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('proveedores.index') }}">Proveedores</a></li>

                    <!-- Menú desplegable de Procesos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produccion
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('entradas_produccion.index') }}">Entradas de Produccion</a></li>
                            <li><a class="dropdown-item" href="{{ route('salidas_produccion.index') }}">Salidas de Produccion</a></li>
                        </ul>
                    </li>
                    


                    <!-- Menú desplegable de Almacenes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Almacenes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('almacen_sin_filtro.index') }}">Almacén sin filtro</a></li>
                            <li><a class="dropdown-item" href="{{ route('almacen_filtrado.index') }}">Almacén filtrado</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('filtros.index') }}">Filtros</a></li>


                    <li class="nav-item"><a class="nav-link" href="{{ route('control_entrada_materia_prima.index') }}">Control De Entrada</a></li>
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
