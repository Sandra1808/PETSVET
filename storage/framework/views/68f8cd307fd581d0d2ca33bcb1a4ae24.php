

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 400px;">
    <div class="card mt-5 shadow">
        <div class="card-body">
            <h3 class="text-center text-danger mb-4">Acceso Administración</h3>
            <p class="text-center text-muted mb-4">Exclusivo para personal autorizado del centro veterinario.</p>
            <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Entrar</button>
            </form>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger mt-2">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>