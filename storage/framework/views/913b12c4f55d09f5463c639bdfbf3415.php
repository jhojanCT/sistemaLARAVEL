  <!-- Aquí se usa el layout principal -->

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Categorías</h1>
        <a href="<?php echo e(route('categorias.create')); ?>" class="btn btn-primary">Nueva Categoría</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($categoria->nombre); ?></td>
                        <td>
                            <a href="<?php echo e(route('categorias.edit', $categoria->id)); ?>" class="btn btn-warning">Editar</a>
                            <form action="<?php echo e(route('categorias.destroy', $categoria->id)); ?>" method="POST" style="display:inline;">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/categorias/index.blade.php ENDPATH**/ ?>