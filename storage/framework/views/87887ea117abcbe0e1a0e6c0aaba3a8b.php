<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center" style="color:#FFA500;">Editar Mascota</h2>
                    <form method="POST" action="<?php echo e(route('mascotas.update', $mascota->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo e(old('nombre', $mascota->nombre)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="especie" class="form-label fw-bold">Especie</label>
                            <input type="text" class="form-control" id="especie" name="especie" value="<?php echo e(old('especie', $mascota->especie)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="raza" class="form-label fw-bold">Raza</label>
                            <input type="text" class="form-control" id="raza" name="raza" value="<?php echo e(old('raza', $mascota->raza)); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="microchip" class="form-label fw-bold">Microchip</label>
                            <input type="text" class="form-control" id="microchip" name="microchip" value="<?php echo e(old('microchip', $mascota->microchip)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="sexo" class="form-label fw-bold">Sexo</label>
                            <select class="form-control" id="sexo" name="sexo" required>
                                <option value="">Selecciona...</option>
                                <option value="Macho" <?php echo e(old('sexo', $mascota->sexo) == 'Macho' ? 'selected' : ''); ?>>Macho</option>
                                <option value="Hembra" <?php echo e(old('sexo', $mascota->sexo) == 'Hembra' ? 'selected' : ''); ?>>Hembra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo e(old('fecha_nacimiento', $mascota->fecha_nacimiento)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label fw-bold">Domicilio</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo e(old('domicilio', $mascota->domicilio)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label fw-bold">Foto de la mascota</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            <?php if($mascota->imagen): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(asset('storage/' . $mascota->imagen)); ?>" alt="Foto actual" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                                    <div class="text-muted">Foto actual</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-warning px-4 fw-bold" style="background:#FFA500; color:#fff;">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/mascotas/edit.blade.php ENDPATH**/ ?>