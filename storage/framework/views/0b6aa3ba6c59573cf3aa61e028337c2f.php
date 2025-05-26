<h2>Historiales Médicos</h2>
<div class="table-responsive mb-2">
    <table class="table table-bordered align-middle" id="tabla-mascotas-prop">
        <thead>
            <tr>
                <th>Nombre Mascota</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($mascota->nombre); ?></td>
                <td><?php echo e($mascota->especie); ?></td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorialMascota<?php echo e($mascota->id); ?>">
                        Ver historial
                    </button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="modalHistorialMascota<?php echo e($mascota->id); ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de <?php echo e($mascota->nombre); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tabla-historico-<?php echo e($mascota->id); ?>">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $mascota->historiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $h->informes()->orderByDesc('created_at')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $informe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-informe-id="<?php echo e($informe->id); ?>"
                                    data-diagnostico="<?php echo e($informe->diagnostico); ?>"
                                    data-procedimientos="<?php echo e($informe->procedimientos); ?>"
                                    data-medicamentos="<?php echo e($informe->medicamentos); ?>"
                                    data-tratamiento="<?php echo e($informe->tratamiento); ?>"
                                    data-recomendaciones="<?php echo e($informe->recomendaciones); ?>"
                                    data-observaciones="<?php echo e($informe->observaciones); ?>"
                                    data-proxima_cita="<?php echo e($informe->proxima_cita); ?>"
                                    data-fecha_cita="<?php echo e($informe->cita->fecha ?? ''); ?>"
                                    data-hora_cita="<?php echo e($informe->cita->hora ?? ''); ?>"
                                    data-motivo_cita="<?php echo e($informe->cita->motivo ?? ''); ?>"
                                    data-veterinario="<?php echo e($informe->cita->veterinario->name ?? ''); ?>"
                                    data-ncolegiado="<?php echo e($informe->cita->veterinario->dni ?? ''); ?>"
                                >
                                    <td><?php echo e($informe->cita && $informe->cita->fecha ? $informe->cita->fecha : ($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-')); ?></td>
                                    <td><?php echo e($informe->cita->motivo ?? '-'); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-ver-detalle-informe" data-informe-id="<?php echo e($informe->id); ?>">Ver detalle</button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div id="detalle-historial-<?php echo e($mascota->id); ?>" class="mt-4" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).on('click', '.btn-ver-detalle-informe', function() {
    var fila = $(this).closest('tr');
    var fecha = fila.find('td').eq(0).text();
    var diagnostico = fila.data('diagnostico');
    var procedimientos = fila.data('procedimientos');
    var medicamentos = fila.data('medicamentos');
    var tratamiento = fila.data('tratamiento');
    var recomendaciones = fila.data('recomendaciones');
    var observaciones = fila.data('observaciones');
    var proxima_cita = fila.data('proxima_cita');
    var fecha_cita = fila.data('fecha_cita');
    var hora_cita = fila.data('hora_cita');
    var motivo_cita = fila.data('motivo_cita');
    var veterinario = fila.data('veterinario');
    var ncolegiado = fila.data('ncolegiado');
    var html = `<div class='card'><div class='card-body'>
        <h6>Detalle del informe</h6>
        <p><b>Fecha creación:</b> ${fecha}</p>
        <p><b>Fecha cita:</b> ${fecha_cita ?? '-'} ${hora_cita ?? ''}</p>
        <p><b>Motivo cita:</b> ${motivo_cita ?? '-'}</p>
        <p><b>Veterinario:</b> ${veterinario ?? '-'}</p>
        <p><b>Nº Colegiado:</b> ${ncolegiado ?? '-'}</p>
        <p><b>Diagnóstico:</b> ${diagnostico}</p>
        <p><b>Procedimientos:</b> ${procedimientos}</p>
        <p><b>Medicamentos:</b> ${medicamentos}</p>
        <p><b>Tratamiento:</b> ${tratamiento}</p>
        <p><b>Recomendaciones:</b> ${recomendaciones}</p>
        <p><b>Observaciones:</b> ${observaciones}</p>
        <p><b>Próxima cita:</b> ${proxima_cita}</p>
    </div></div>`;
    var mascotaId = $(this).closest('table').attr('id').replace('tabla-historico-', '');
    var detalleDiv = $('#detalle-historial-' + mascotaId);
    detalleDiv.html(html).show();
});
// Ocultar el detalle al cerrar el modal
$('[id^=modalHistorialMascota]').on('hidden.bs.modal', function () {
    $(this).find('[id^=detalle-historial-]').hide().html('');
});
</script>
<?php $__env->stopPush(); ?> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/historiales/index.blade.php ENDPATH**/ ?>