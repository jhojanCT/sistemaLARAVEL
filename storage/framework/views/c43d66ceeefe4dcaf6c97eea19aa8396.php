<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Agregar Nueva Entrada de Producción</h2>

    <form action="<?php echo e(route('entradas_produccion.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($producto->id); ?>"><?php echo e($producto->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

                <!-- Selección de Materia Prima en Uso -->
                <div class="mb-3">
                    <label for="almacen_filtrado_id" class="form-label">Materia Prima en Uso</label>
                    <select id="almacen_filtrado_id" name="almacen_filtrado_id" class="form-select" required>
                        <option value="">Selecciona Materia Prima</option>
                        <?php $__currentLoopData = $almacenFiltrado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $almacen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($almacen->id); ?>">
                                <?php echo e($almacen->materia_prima_filtrada); ?> - <?php echo e($almacen->cantidad_materia_prima_filtrada); ?> en existencia
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

        <div class="mb-3">
            <label for="materia_prima_en_uso" class="form-label">Cantidad de Materia Prima en Uso</label>
            <input type="number" name="materia_prima_en_uso" id="materia_prima_en_uso" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?php echo e(route('entradas_produccion.index')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>














<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/entradas_produccion/create.blade.php ENDPATH**/ ?>