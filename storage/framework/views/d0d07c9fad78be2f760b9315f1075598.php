

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center align-items-end mb-4" style="min-height: 140px;">
        <div class="col-auto text-center">
            <button class="icon-nav-btn active" id="btn-mis-mascotas" onclick="showSection('mascotas')">
                <img src="<?php echo e(asset('img/huella.png')); ?>" alt="Mis mascotas" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold nav-text">Mis mascotas</div>
            </button>
        </div>
        <div class="col-auto text-center">
            <button class="icon-nav-btn" id="btn-historial" onclick="showSection('historial')">
                <img src="<?php echo e(asset('img/historial.png')); ?>" alt="Historial" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold nav-text">Historial</div>
            </button>
        </div>
        <div class="col-auto text-center">
            <button class="icon-nav-btn" id="btn-citas" onclick="showSection('citas')">
                <img src="<?php echo e(asset('img/citas.png')); ?>" alt="Citas" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold nav-text">Citas / Nueva Cita</div>
            </button>
        </div>
    </div>
    <div class="admin-content-box tab-content mt-3" style="min-height: 400px;">
        <div id="section-mascotas" class="section-propietario">
            <div class="mb-4">
                <a href="<?php echo e(route('mascotas.create')); ?>" class="btn" style="background: #FF7F32; color: #fff; font-weight: bold; border-radius: 20px; padding: 10px 30px;">
                    Añade a tu mascota
                </a>
            </div>
            <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card-mascota mb-4">
                <div class="row align-items-center g-0">
                    <div class="col-auto">
                        <img src="<?php echo e($mascota->imagen ? asset('storage/' . $mascota->imagen) : asset('img/mascotas.jpg')); ?>" alt="<?php echo e($mascota->nombre); ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                    </div>
                    <div class="col ps-3">
                        <div class="fw-bold" style="font-size: 1.2rem;"><?php echo e($mascota->nombre); ?></div>
                        <div><?php echo e($mascota->sexo); ?>, <?php echo e($mascota->calcularEdad()); ?>, Nº Microchip: <?php echo e($mascota->microchip ?? '0000000000'); ?></div>
                        <div class="mt-2">
                            <a href="<?php echo e(route('mascotas.edit', $mascota->id)); ?>">Editar mi perfil</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        </div>
        <div id="section-historial" class="section-propietario" style="display:none;">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabla-historiales-propietario">
                    <thead>
                        <tr>
                            <th>Mascota</th>
                            <th>Nombre del historial</th>
                            <th>Fecha de última actualización</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $historiales->unique('n_historial'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($historial->mascota->nombre ?? '-'); ?></td>
                            <td><?php echo e($historial->n_historial ?? '-'); ?></td>
                            <td><?php echo e($historial->updated_at ? $historial->updated_at->format('d/m/Y H:i') : '-'); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorial<?php echo e($historial->n_historial); ?>">Ver</button>
                                <a href="<?php echo e(route('pdf.historiales.mascota', ['mascota_id' => $historial->mascota_id])); ?>" class="btn btn-secondary btn-sm" target="_blank">Imprimir</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php $__currentLoopData = $historiales->unique('n_historial'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="modalHistorial<?php echo e($historial->n_historial); ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Histórico de informes - <?php echo e($historial->mascota->nombre); ?> (<?php echo e($historial->n_historial); ?>)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Fecha de la cita</th>
                                            <th>Motivo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $historial->informes->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $informe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($informe->cita && $informe->cita->fecha ? $informe->cita->fecha : ($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-')); ?></td>
                                            <td><?php echo e($informe->cita->motivo ?? '-'); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm btn-ver-detalle-informe" data-informe-id="<?php echo e($informe->id); ?>">Ver detalles</button>
                                            </td>
                                        </tr>
                                        <tr id="detalle-informe-<?php echo e($informe->id); ?>" style="display:none; background:#FFF7E6;">
                                            <td colspan="3">
                                                <div class="card card-body p-3">
                                                    <b>Diagnóstico:</b> <?php echo e($informe->diagnostico ?? '-'); ?><br>
                                                    <b>Procedimientos:</b> <?php echo e($informe->procedimientos ?? '-'); ?><br>
                                                    <b>Medicamentos:</b> <?php echo e($informe->medicamentos ?? '-'); ?><br>
                                                    <b>Tratamiento:</b> <?php echo e($informe->tratamiento ?? '-'); ?><br>
                                                    <b>Recomendaciones:</b> <?php echo e($informe->recomendaciones ?? '-'); ?><br>
                                                    <b>Observaciones:</b> <?php echo e($informe->observaciones ?? '-'); ?><br>
                                                    <b>Próxima cita:</b> <?php echo e($informe->proxima_cita ?? '-'); ?><br>
                                                    <b>Fecha creación:</b> <?php echo e($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-'); ?><br>
                                                    <b>Fecha última actualización:</b> <?php echo e($informe->updated_at ? $informe->updated_at->format('d/m/Y H:i') : '-'); ?>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div id="section-citas" class="section-propietario" style="display:none;">
            <div class="mb-4">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSolicitarCita">Nueva cita</button>
            </div>
            <div id="propietario-calendar"></div>
        </div>
    </div>
</div>

<style>
.icon-nav-btn {
    background: none;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 0;
    transition: box-shadow 0.2s, border 0.2s;
    border-radius: 20px;
    box-shadow: none;
    position: relative;
}
.icon-nav-btn.active,
.icon-nav-btn:focus {
    /* Sin fondo ni borde para el botón activo */
    box-shadow: none;
    border: none;
    background: none;
}
.icon-nav-btn .fw-bold.nav-text {
    color: #222;
    font-weight: bold;
    font-size: 1.1em;
    text-decoration: none;
    transition: color 0.2s, text-decoration 0.2s;
}
.icon-nav-btn.active .fw-bold.nav-text {
    color: #222;
    text-decoration: underline;
}
.admin-content-box.tab-content {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 8px #0001;
    padding: 24px 18px 18px 18px;
    border: 2px solid #FFA500;
    margin-bottom: 32px;
    margin-top: 0 !important;
}
/* Días de la semana en negro y no clickables */
.fc-col-header-cell-cushion, .fc-daygrid-day-number {
    color: #222 !important;
    text-decoration: none !important;
    cursor: default !important;
    font-weight: bold;
    font-size: 1.1em;
    pointer-events: none;
}
.cita-realizada {
    border: 2.5px solid #2e8b57 !important;
    box-shadow: 0 0 8px #43b58155;
    position: relative;
}
.cita-realizada::after {
    content: '\f478'; /* Bootstrap icon file-earmark-medical-fill */
    font-family: 'bootstrap-icons';
    color: #fff;
    background: #43b581;
    border-radius: 50%;
    font-size: 13px;
    position: absolute;
    top: 2px;
    right: 2px;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}
</style>
<script>
function showSection(section) {
    document.querySelectorAll('.section-propietario').forEach(div => div.style.display = 'none');
    document.getElementById('section-' + section).style.display = '';
    document.querySelectorAll('.icon-nav-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById('btn-' + (section === 'mascotas' ? 'mis-mascotas' : section)).classList.add('active');
    window.location.hash = section;
    // Si es la sección de citas, reinicializar el calendario si es necesario
    if(section === 'citas') {
        setTimeout(() => {
            if (typeof FullCalendar !== 'undefined' && document.getElementById('propietario-calendar')) {
                // Destruir instancia previa si existe
                if (window.userCalendarInstance) {
                    window.userCalendarInstance.destroy();
                    window.userCalendarInstance = null;
                }
                window.userCalendarInstance = new FullCalendar.Calendar(document.getElementById('propietario-calendar'), {
                    initialView: 'timeGridWeek',
                    locale: 'es',
                    height: 700,
                    slotMinTime: '08:00:00',
                    slotMaxTime: '22:00:00',
                    allDaySlot: false,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    buttonText: {
                        today:    'Hoy',
                        month:    'Mes',
                        week:     'Semana',
                        day:      'Día',
                        list:     'Lista'
                    },
                    weekText: 'Sem',
                    allDayText: 'Todo el día',
                    moreLinkText: 'más',
                    noEventsText: 'No hay citas para mostrar',
                    dayHeaderFormat: { weekday: 'short', day: 'numeric', month: 'short' },
                    events: window.citasEventos || [],
                    firstDay: 1, // Lunes
                    hiddenDays: [], // Mostrar todos los días de la semana
                    eventDidMount: function(info) {
                        if(info.event.extendedProps && info.event.extendedProps.con_informe) {
                            info.el.classList.add('cita-realizada');
                        }
                    },
                });
                window.userCalendarInstance.render();
            }
        }, 100);
    }
}
window.addEventListener('DOMContentLoaded', function() {
    let hash = window.location.hash.replace('#','');
    if(['mascotas','historial','citas'].includes(hash)) {
        showSection(hash);
    } else {
        showSection('mascotas');
    }
    // Inicializar el calendario si la sección de citas está visible al cargar
    if(hash === 'citas') {
        showSection('citas');
    }
});

window.citasEventos = [
    <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    {
        id: <?php echo e($cita->id); ?>,
        title: '<?php echo e(addslashes(($cita->mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? ""))); ?>',
        start: '<?php echo e($cita->fecha); ?>T<?php echo e($cita->hora ?? "00:00"); ?>',
        color: <?php if($cita->informes->count() > 0): ?> '#43b581' <?php elseif($cita->estado === 'Confirmada'): ?> '#4A90E2' <?php elseif($cita->estado === 'Pendiente'): ?> '#BDBDBD' <?php else: ?> '#FFB3B3' <?php endif; ?>,
        extendedProps: {
            con_informe: <?php echo e($cita->informes->count() > 0 ? 'true' : 'false'); ?>,
            estado: '<?php echo e($cita->estado); ?>',
        }
    },
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
];
</script>
<!-- FullCalendar CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<?php $__env->stopSection(); ?> 

<?php $__env->startPush('scripts'); ?>
<script>
$('.btn-ver-detalle-informe').on('click', function() {
    var id = $(this).data('informe-id');
    var fila = $('#detalle-informe-' + id);
    if(fila.is(':visible')) {
        fila.hide();
    } else {
        $(this).closest('tbody').find('tr[id^="detalle-informe-"]').hide();
        fila.show();
    }
});
$('[id^=modalHistorial]').on('hidden.bs.modal', function () {
    $(this).find('tr[id^="detalle-informe-"]').hide();
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/propietario.blade.php ENDPATH**/ ?>