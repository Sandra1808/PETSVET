<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 350px; background-color: #E0F7FA;">
            <h3 class="text-center fw-bold text-danger">Registro / Inicio Sesión</h3>

            <!-- Formulario -->
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                
                <!-- Campo Correo -->
                <div class="mb-3">
                    <label for="login" class="form-label text-success">Usuario o Correo Electrónico</label>
                    <input type="text" name="login" id="login" class="form-control" required>
                </div>

                <!-- Campo Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label text-success">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <!-- Botón Iniciar Sesión -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning w-100">Iniciar Sesión</button>
                </div>
            </form>

            <!-- Enlace para usuarios no registrados -->
            <div class="text-center mt-3">
                <a href="<?php echo e(route('register')); ?>" class="text-success fw-bold">No estoy registrado</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/auth/login.blade.php ENDPATH**/ ?>