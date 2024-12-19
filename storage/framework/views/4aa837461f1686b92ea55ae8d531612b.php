<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Almacén Filtrado Consolidado</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Proveedor</th>
                <th>Materia Prima Filtrada</th>
                <th>Cantidad Total Filtrada</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $almacenFiltrado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->id); ?></td>
                <td><?php echo e($item->proveedor->nombre); ?></td>
                <td><?php echo e($item->materia_prima_filtrada); ?></td>
                <td><?php echo e($item->cantidad_materia_prima_filtrada); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/almacen_filtrado/index.blade.php ENDPATH**/ ?>