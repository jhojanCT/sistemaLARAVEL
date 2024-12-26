<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Filtros</h1>
        <a href="<?php echo e(route('filtros.create')); ?>" class="btn btn-primary">Agregar Filtro</a>
        
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Materia Prima</th>
                    <th>Cantidad Usada</th>
                    <th>Desperdicio</th>
                    <th>Existencia Filtrada</th>
                    <th>Supervisor</th>
                    <th>Fecha de Filtro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $filtros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filtro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($filtro->proveedor->nombre); ?></td>
                        <td><?php echo e($filtro->almacenSinFiltro->materiaPrima->nombre); ?></td>
                        <td><?php echo e($filtro->cantidad_usada); ?></td>
                        <td><?php echo e($filtro->desperdicio); ?></td>
                        <td><?php echo e($filtro->existencia_filtrada); ?></td>
                        <td><?php echo e($filtro->supervisor); ?></td>
                        <td><?php echo e($filtro->fecha_filtro); ?></td>
                        <td>
                            <a href="<?php echo e(route('filtros.edit', $filtro)); ?>" class="btn btn-warning">Editar</a>
                            <form action="<?php echo e(route('filtros.destroy', $filtro)); ?>" method="POST" style="display:inline;">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemaLARAVEL\resources\views/filtros/index.blade.php ENDPATH**/ ?>