

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Lista de Proveedores</h1>
    <a href="<?php echo e(route('proveedores.create')); ?>" class="btn btn-primary mb-3">Crear Proveedor</a>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($proveedor->id); ?></td>
                    <td><?php echo e($proveedor->nombre); ?></td>
                    <td><?php echo e($proveedor->correo_electronico); ?></td>
                    <td><?php echo e($proveedor->telefono); ?></td>
                    <td><?php echo e($proveedor->direccion); ?></td>
                    <td>
                        <a href="<?php echo e(route('proveedores.edit', $proveedor->id)); ?>" class="btn btn-warning btn-sm">Editar</a>
                        <form action="<?php echo e(route('proveedores.destroy', $proveedor->id)); ?>" method="POST" style="display: inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/proveedores/index.blade.php ENDPATH**/ ?>