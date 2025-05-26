<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Médico - PetsVet</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        .header { display: flex; align-items: center; border-bottom: 2px solid #FFA500; margin-bottom: 20px; padding-bottom: 10px; }
        .logo { height: 60px; margin-right: 20px; }
        .title { font-size: 1.7em; font-weight: bold; color: #FFA500; }
        .section { margin-bottom: 18px; }
        .label { font-weight: bold; color: #FFA500; }
        .datos { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <span class="title">PetsVet - Informe Médico Veterinario</span>
    </div>
    <div class="section">
        <span class="label">Propietario:</span> <?php echo e($historial->mascota->propietario->name ?? '-'); ?><br>
        <span class="label">DNI:</span> <?php echo e($historial->mascota->propietario->dni ?? '-'); ?><br>
        <span class="label">Dirección:</span> <?php echo e($historial->mascota->propietario->direccion ?? '-'); ?>

    </div>
    <div class="section">
        <span class="label">Mascota:</span> <?php echo e($historial->mascota->nombre ?? '-'); ?><br>
        <span class="label">Especie:</span> <?php echo e($historial->mascota->especie ?? '-'); ?><br>
        <span class="label">Fecha de nacimiento:</span> <?php echo e($historial->mascota->fecha_nacimiento ?? '-'); ?>

    </div>
    <div class="section">
        <span class="label">Veterinario responsable:</span> <?php echo e($historial->veterinario->name ?? '-'); ?><br>
        <span class="label">Nº Colegiado:</span> <?php echo e($historial->veterinario->dni ?? '-'); ?>

    </div>
    <div class="section">
        <span class="label">Fecha y hora de la cita:</span> <?php echo e($historial->cita->fecha ?? '-'); ?> <?php echo e($historial->cita->hora ?? ''); ?><br>
        <span class="label">Motivo de la consulta:</span> <?php echo e($historial->cita->motivo ?? '-'); ?>

    </div>
    <div class="section">
        <p>Acude a consulta el propietario <b><?php echo e($historial->mascota->propietario->name ?? '-'); ?></b>, con DNI <b><?php echo e($historial->mascota->propietario->dni ?? '-'); ?></b> y dirección <b><?php echo e($historial->mascota->propietario->direccion ?? '-'); ?></b>, responsable de la mascota <b><?php echo e($historial->mascota->nombre ?? '-'); ?></b> de especie <b><?php echo e($historial->mascota->especie ?? '-'); ?></b> y fecha de nacimiento <b><?php echo e($historial->mascota->fecha_nacimiento ?? '-'); ?></b>. La consulta se realiza el día <b><?php echo e($historial->cita->fecha ?? '-'); ?></b> a las <b><?php echo e($historial->cita->hora ?? '-'); ?></b> por el motivo: <b><?php echo e($historial->cita->motivo ?? '-'); ?></b>.</p>
        <p>Durante la consulta se realizan los siguientes procedimientos: <b><?php echo e($historial->procedimientos ?? '-'); ?></b>.</p>
        <p>El diagnóstico es: <b><?php echo e($historial->diagnostico ?? '-'); ?></b>.</p>
        <p>Se aplican los siguientes tratamientos: <b><?php echo e($historial->tratamiento ?? '-'); ?></b> y medicamentos: <b><?php echo e($historial->medicamentos ?? '-'); ?></b>.</p>
        <p>Las recomendaciones dadas al propietario son: <b><?php echo e($historial->recomendaciones ?? '-'); ?></b>.</p>
        <p>Observaciones adicionales: <b><?php echo e($historial->observaciones ?? '-'); ?></b>.</p>
        <p>Próxima revisión recomendada: <b><?php echo e($historial->proxima_cita ?? '-'); ?></b>.</p>
    </div>
    <div class="section" style="margin-top:40px;">
        <span class="label">Firma del veterinario:</span>
        <div style="height:60px;"></div>
        <span><?php echo e($historial->veterinario->name ?? '-'); ?></span>
    </div>
    <?php echo $__env->make('pdf.contacto_clinica', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/pdf/historial_informe.blade.php ENDPATH**/ ?>