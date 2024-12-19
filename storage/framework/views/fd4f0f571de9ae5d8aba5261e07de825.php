<!-- resources/views/salidas_produccion/create.blade.php -->


<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Crear Nueva Salida de Producción</h1>

        <!-- Mostrar errores de validación -->
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formulario de Salida de Producción -->
        <form action="<?php echo e(route('salidas_produccion.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="entrada_produccion_id">Entrada de Producción</label>
                <select name="entrada_produccion_id" id="entrada_produccion_id" class="form-control">
                    <option value="">Seleccione una entrada de producción</option>
                    <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($entrada->id); ?>"><?php echo e($entrada->id); ?> - <?php echo e($entrada->producto->nombre); ?></option> <!-- Muestra el producto asociado a la entrada -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad_productos_hechos">Cantidad de Productos Hechos</label>
                <input type="number" name="cantidad_productos_hechos" id="cantidad_productos_hechos" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="precio_produccion">Precio de Producción</label>
                <input type="number" name="precio_produccion" id="precio_produccion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha_salida">Fecha de Salida</label>
                <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Registrar Salida</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/salidas_produccion/create.blade.php ENDPATH**/ ?>