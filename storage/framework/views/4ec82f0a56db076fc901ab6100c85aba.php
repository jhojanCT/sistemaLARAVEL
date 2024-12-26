<!-- resources/views/salidas_produccion/index.blade.php -->


<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Salidas de Producción</h1>

        <!-- Mostrar mensaje de éxito -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <a href="<?php echo e(route('salidas_produccion.create')); ?>" class="btn btn-primary">Crear Nueva Salida</a>
        <!-- Tabla de salidas de producción -->
        <table class="table">
            <thead>
                <tr>

                    <th>Entrada de Producción</th>
                    <th>Producto</th> <!-- Nueva columna para mostrar el producto -->
                    <th>Cantidad Productos Hechos</th>
                    <th>Precio Producción</th>
                    <th>Fecha de Salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $salidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($salida->entradaProduccion->id); ?></td>
        <td><?php echo e($salida->entradaProduccion->producto->nombre); ?></td>
        <td><?php echo e($salida->cantidad_productos_hechos); ?></td>
        <td><?php echo e($salida->precio_produccion); ?></td>
        <td><?php echo e($salida->fecha_salida); ?></td>
        <td>
            <?php if($salida->esperado_aprobacion !== 'aprobado'): ?> <!-- Verifica si no está aprobado -->
                <form action="<?php echo e(route('salidas_produccion.aprobar', $salida)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <button type="submit" class="btn btn-success">Aprobar</button>
                </form>
            <?php else: ?>
                <span class="text-success">Aprobado</span> <!-- Muestra "Aprobado" si ya está aprobado -->
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/salidas_produccion/index.blade.php ENDPATH**/ ?>