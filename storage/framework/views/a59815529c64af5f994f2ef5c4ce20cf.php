<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet"> <!-- Enlace al CSS personalizado -->
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand ms-3" href="#">Inventario</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-3">
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('categorias.index')); ?>">Categorías</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('productos.index')); ?>">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('proveedores.index')); ?>">Proveedores</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('clientes.index')); ?>">Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('entradas.index')); ?>">Entradas</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('roles.index')); ?>">Roles</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('salidas.index')); ?>">Salidas</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('usuarios.index')); ?>">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('filtros.index')); ?>">Filtros</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('almacen_sin_filtro.index')); ?>">Almacen sin filtro</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('almacen_filtrado.index')); ?>">Almacen filtrado</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('control_entrada_materia_prima.index')); ?>">Control De Entrada</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        <?php echo $__env->yieldContent('content'); ?> <!-- Aquí se carga el contenido de cada vista -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\sistemaLARAVEL\resources\views/layouts/app.blade.php ENDPATH**/ ?>