<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Entradas de Producción</h2>

    <a href="<?php echo e(route('entradas_produccion.create')); ?>" class="btn btn-primary mb-3">Agregar Nueva Entrada</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad de Materia Prima en Uso</th>
                <th>Estado de Producción</th>
                <th>Fecha de Entrada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($entrada->id); ?></td>
                <td><?php echo e($entrada->producto->nombre); ?></td>
                <td><?php echo e($entrada->materia_prima_en_uso); ?></td>
                <td><?php echo e($entrada->estado_produccion); ?></td>
                <td><?php echo e($entrada->fecha_entrada); ?></td>
                <td>
                    <?php if($entrada->estado_produccion === 'en proceso'): ?>
                        <form action="<?php echo e(route('entradas_produccion.finalizar', $entrada->id)); ?>" method="POST" class="d-inline-block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success">Finalizar</button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo e(route('entradas_produccion.edit', $entrada->id)); ?>" class="btn btn-warning">Editar</a>
                    <form action="<?php echo e(route('entradas_produccion.destroy', $entrada->id)); ?>" method="POST" class="d-inline-block">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/entradas_produccion/index.blade.php ENDPATH**/ ?>