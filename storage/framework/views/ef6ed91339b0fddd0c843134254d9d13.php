<?php if(!Auth::user()->isVeterinario()): ?>
<div class="container my-4">
    <div class="row justify-content-center align-items-end" style="min-height: 140px;">
        <div class="col-auto text-center">
            <a href="<?php echo e(route('mascotas.index')); ?>" class="d-block">
                <img src="<?php echo e(asset('img/huella.png')); ?>" alt="Mis mascotas" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold">Mis mascotas</div>
            </a>
        </div>
        <div class="col-auto text-center">
            <a href="<?php echo e(route('historiales.index')); ?>" class="d-block">
                <img src="<?php echo e(asset('img/historial.png')); ?>" alt="Historial" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold">Historial</div>
            </a>
        </div>
        <div class="col-auto text-center">
            <a href="<?php echo e(route('citas.index')); ?>" class="d-block">
                <img src="<?php echo e(asset('img/citas.png')); ?>" alt="Citas" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold">Citas / Nueva Cita</div>
            </a>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/components/user-nav.blade.php ENDPATH**/ ?>