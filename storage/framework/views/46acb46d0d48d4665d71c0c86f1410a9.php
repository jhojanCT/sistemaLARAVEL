<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Entradas de Materia Prima</h1>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('control_entrada_materia_prima.create')); ?>" class="btn btn-primary mb-3">Añadir Nueva Entrada</a>

    <table class="table">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Materia Prima</th>
                <th>Cantidad</th>
                <th>Encargado</th>
                <th>Fecha de Llegada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($entrada->proveedor->nombre); ?></td>
            <td><?php echo e($entrada->almacenSinFiltro ? $entrada->almacenSinFiltro->materia_prima : 'No disponible'); ?></td>
            <td><?php echo e($entrada->cantidad); ?></td>
            <td><?php echo e($entrada->encargado); ?></td>
            <td><?php echo e($entrada->fecha_llegada); ?></td>
            <td>
                <a href="<?php echo e(route('control_entrada_materia_prima.edit', $entrada->id)); ?>" class="btn btn-warning">Editar</a>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>


    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/control_entrada_materia_prima/index.blade.php ENDPATH**/ ?>