 <!-- Usa el layout principal -->

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Crear Nueva Categoría</h1>
        <form action="<?php echo e(route('categorias.store')); ?>" method="POST" class="mt-4">
            <?php echo csrf_field(); ?> <!-- Token de seguridad obligatorio -->
            
            <div class="form-group">
                <label for="nombre">Nombre de la Categoría</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa el nombre de la categoría" required>
            </div>
            
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="<?php echo e(route('categorias.index')); ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/categorias/create.blade.php ENDPATH**/ ?>