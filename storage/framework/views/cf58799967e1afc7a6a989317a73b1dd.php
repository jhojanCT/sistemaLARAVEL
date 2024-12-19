

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Agregar Filtro</h1>
        
        <form action="<?php echo e(route('filtros.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control">
                    <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($proveedor->id); ?>"><?php echo e($proveedor->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="almacen_sin_filtro_id">Almacén Sin Filtrar</label>
                <select name="almacen_sin_filtro_id" id="almacen_sin_filtro_id" class="form-control">
                    <?php $__currentLoopData = $almacenesSinFiltro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $almacen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($almacen->id); ?>"><?php echo e($almacen->materia_prima); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad_usada">Cantidad Usada</label>
                <input type="number" name="cantidad_usada" id="cantidad_usada" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="desperdicio">Desperdicio</label>
                <input type="number" name="desperdicio" id="desperdicio" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="existencia_filtrada">Existencia Filtrada</label>
                <input type="number" name="existencia_filtrada" id="existencia_filtrada" class="form-control" step="0.01" required readonly>
            </div>
            <div class="form-group">
                <label for="supervisor">Supervisor</label>
                <input type="text" name="supervisor" id="supervisor" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha_filtro">Fecha de Filtro</label>
                <input type="date" name="fecha_filtro" id="fecha_filtro" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Guardar</button>
        </form>
    </div>

    <script>
        // Escuchar los cambios en los campos 'cantidad_usada' y 'desperdicio'
        document.getElementById('cantidad_usada').addEventListener('input', calcularExistenciaFiltrada);
        document.getElementById('desperdicio').addEventListener('input', calcularExistenciaFiltrada);

        function calcularExistenciaFiltrada() {
            // Obtener los valores de los campos
            let cantidadUsada = parseFloat(document.getElementById('cantidad_usada').value) || 0;
            let desperdicio = parseFloat(document.getElementById('desperdicio').value) || 0;

            // Calcular la existencia filtrada
            let existenciaFiltrada = cantidadUsada - desperdicio;

            // Mostrar el resultado en el campo 'existencia_filtrada'
            document.getElementById('existencia_filtrada').value = existenciaFiltrada.toFixed(2);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistema\resources\views/filtros/create.blade.php ENDPATH**/ ?>