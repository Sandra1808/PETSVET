<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Médico - PetsVet</title>
    <style>
        @page { size: A4 landscape; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #FFA500;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .logo {
            height: 60px;
            margin-right: 20px;
        }
        .title {
            font-size: 1.7em;
            font-weight: bold;
            color: #FFA500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
            word-break: break-word;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 7px;
            text-align: left;
            vertical-align: top;
            font-size: 12px;
            word-break: break-word;
            white-space: pre-line;
        }
        th {
            background: #eee;
        }
        th { font-size: 12px; }
        .section-title { font-size: 1.1em; font-weight: bold; margin-top: 18px; color: #FFA500; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">PetsVet</div>
            <div>Informe Médico Veterinario</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">Mascota</th>
                <th style="width: 8%">Fecha</th>
                <th style="width: 15%">Diagnóstico</th>
                <th style="width: 15%">Procedimientos</th>
                <th style="width: 15%">Medicamentos</th>
                <th style="width: 15%">Tratamiento</th>
                <th style="width: 15%">Recomendaciones</th>
                <th style="width: 12%">Observaciones</th>
                <th style="width: 10%">Próxima cita</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $historiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $historial->informes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $informe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($historial->mascota->nombre ?? '-'); ?></td>
                    <td><?php echo e($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-'); ?></td>
                    <td><?php echo e($informe->diagnostico); ?></td>
                    <td><?php echo e($informe->procedimientos); ?></td>
                    <td><?php echo e($informe->medicamentos); ?></td>
                    <td><?php echo e($informe->tratamiento); ?></td>
                    <td><?php echo e($informe->recomendaciones); ?></td>
                    <td><?php echo e($informe->observaciones); ?></td>
                    <td><?php echo e($informe->proxima_cita); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="margin-top: 40px; text-align: right; font-size: 0.95em; color: #888;">
        Generado por PetsVet - <?php echo e(date('d/m/Y H:i')); ?>

    </div>
    <?php echo $__env->make('pdf.contacto_clinica', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/pdf/historiales.blade.php ENDPATH**/ ?>