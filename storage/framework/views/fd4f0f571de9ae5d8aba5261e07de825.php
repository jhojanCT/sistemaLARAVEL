

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Crear Salidas de Produccion</h1>

    <form action="<?php echo e(route('salidas_produccion.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="entrada_produccion_id">Entrada de Producción</label>
            <select name="entrada_produccion_id" id="entrada_produccion_id" class="form-control" required>
                <option value="">Seleccione una entrada de producción</option>
                <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($entrada->id); ?>"><?php echo e($entrada->producto->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    
        <div class="form-group">
            <label for="cantidad_materia_prima_en_uso">Cantidad de Materia Prima en Uso</label>
            <input type="number" name="cantidad_materia_prima_en_uso" id="cantidad_materia_prima_en_uso" class="form-control" readonly>
        </div>
    
        <div class="form-group">
            <label for="cantidad_productos_hechos">Cantidad de Productos Hechos</label>
            <input type="number" name="cantidad_productos_hechos" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="precio_produccion">Precio de Producción</label>
            <input type="number" name="precio_produccion" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="fecha_salida">Fecha de Salida</label>
            <input type="date" name="fecha_salida" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Registrar Salida</button>
    </form>

<script>
    document.getElementById('entrada_produccion_id').addEventListener('change', function() {
        let entradaId = this.value;

        if (entradaId) {
            fetch(`/salidas-produccion/obtener-materia-prima-en-uso?entrada_produccion_id=${entradaId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cantidad_materia_prima_en_uso').value = data.cantidad_materia_prima_en_uso;
                });
        }
    });
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/salidas_produccion/create.blade.php ENDPATH**/ ?>