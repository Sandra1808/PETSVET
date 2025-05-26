<?php $__env->startSection('title', 'Bienvenido a Pet\'s Vet'); ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center mt-5">
        <h1 class="fw-bold text-danger">Bienvenido a Pet's Vet 🐾</h1>
        <p class="text-muted">Cuidamos de tu mascota con amor.</p>

        <img src="<?php echo e(asset('img/veterinarios.jpg')); ?>" class="img-fluid rounded shadow-lg mt-4" alt="Veterinarios atendiendo mascotas">
        <div class="mt-3">
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/welcome.blade.php ENDPATH**/ ?>