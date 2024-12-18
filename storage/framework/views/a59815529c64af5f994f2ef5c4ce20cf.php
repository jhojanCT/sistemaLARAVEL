<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

         <!-- Scripts -->
         <!-- <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?> -->
         <!-- Bootstrap CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

         <!-- App CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('resources/css/app.css')); ?>">
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

          <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php /**PATH C:\laragon\www\sistemaLARAVEL\resources\views/layouts/app.blade.php ENDPATH**/ ?>