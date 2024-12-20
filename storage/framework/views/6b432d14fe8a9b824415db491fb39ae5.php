<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Agregar Nueva Entrada de Materia Prima</h2>

        <form action="<?php echo e(route('control_entrada_materia_prima.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="proveedor_id">Proveedor</label>
        <select name="proveedor_id" class="form-control" required>
            <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($proveedor->id); ?>"><?php echo e($proveedor->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="materia_prima_id">Materia Prima</label>
        <select name="materia_prima_id" class="form-control" required>
            <?php $__currentLoopData = $materiasPrimas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materiaPrima): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($materiaPrima->id); ?>"><?php echo e($materiaPrima->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="encargado">Encargado</label>
        <input type="text" name="encargado" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="fecha_llegada">Fecha de Llegada</label>
        <input type="date" name="fecha_llegada" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/control_entrada_materia_prima/create.blade.php ENDPATH**/ ?>