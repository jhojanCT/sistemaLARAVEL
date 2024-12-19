

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Salidas de Producción</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('salidas_produccion.create')); ?>" class="btn btn-primary mb-3">Agregar Nueva Salida</a>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad Hecha</th>
                <th>Cantidad Materia Prima en Uso</th>
                <th>Precio de Producción</th>
                <th>Esperado Aprobación</th>
                <th>Fecha de Salida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $salidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($salida->entradaProduccion->producto->nombre); ?></td>
                    <td><?php echo e($salida->cantidad_productos_hechos); ?></td>
                    <td><?php echo e($salida->cantidad_materia_prima_en_uso); ?></td>
                    <td><?php echo e($salida->precio_produccion); ?></td>
                    <td><?php echo e($salida->esperado_aprobacion); ?></td>
                    <td><?php echo e($salida->fecha_salida); ?></td>
                    <td>
                        <?php if($salida->esperado_aprobacion == 'esperando aprobacion'): ?>
                            <form action="<?php echo e(route('salidas_produccion.aprobar', $salida)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit" class="btn btn-success">Aprobar</button>
                            </form>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('salidas_produccion.eliminar', $salida)); ?>" method="POST" style="display:inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/salidas_produccion/index.blade.php ENDPATH**/ ?>