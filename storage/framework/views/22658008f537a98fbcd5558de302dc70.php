<div class="mb-4">
    <a href="<?php echo e(route('mascotas.create')); ?>" class="btn" style="background: #FF7F32; color: #fff; font-weight: bold; border-radius: 20px; padding: 10px 30px;">
        Añade a tu mascota
    </a>
</div>
<div id="propietario-calendar"></div>
<?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card-mascota mb-4">
    <div class="row align-items-center g-0">
        <div class="col-auto">
            <img src="<?php echo e($mascota->imagen ? asset('storage/' . $mascota->imagen) : asset('img/mascotas.png')); ?>" alt="<?php echo e($mascota->nombre); ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
        </div>
        <div class="col ps-3">
            <div class="fw-bold" style="font-size: 1.2rem;"><?php echo e($mascota->nombre); ?></div>
            <div><?php echo e($mascota->sexo); ?>, <?php echo e($mascota->calcularEdad()); ?>, Nº Microchip: <?php echo e($mascota->microchip ?? '0000000000'); ?></div>
            <div class="mt-2">
                <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#modalHistorialMascota<?php echo e($mascota->id); ?>">Mi historial</a>
                <?php if($mascota->proximaCita()): ?>
                    <a href="#" class="me-3" title="<?php echo e($mascota->proximaCita()->fecha); ?> <?php echo e($mascota->proximaCita()->hora); ?>">Mi próxima cita: <?php echo e($mascota->proximaCita()->fecha); ?> <?php echo e($mascota->proximaCita()->hora); ?></a>
                <?php endif; ?>
                <?php if($mascota->proximaVacuna()): ?>
                    <a href="#" class="me-3" title="<?php echo e($mascota->proximaVacuna()); ?>">Próxima Vacuna: <?php echo e($mascota->proximaVacuna()); ?></a>
                <?php endif; ?>
                <?php if($mascota->proximaDesparasitacion()): ?>
                    <a href="#" class="me-3" title="<?php echo e($mascota->proximaDesparasitacion()); ?>">Próxima Desparasitación: <?php echo e($mascota->proximaDesparasitacion()); ?></a>
                <?php endif; ?>
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

<?php $__env->startPush('styles'); ?>
<style>
  #propietario-calendar, .fc {
    background: #fff !important;
    border-radius: 16px 16px 16px 16px;
    box-shadow: 0 2px 8px #0001;
    padding: 24px 18px 18px 18px;
    border: 2px solid #FFA500;
    margin-bottom: 32px;
    margin-top: 0 !important;
  }
  .fc-toolbar, .fc-col-header, .fc-timegrid-axis, .fc-scrollgrid-section-header {
    background: #FFE5D0 !important;
    color: #222 !important;
    border-bottom: 2px solid #FFA500 !important;
  }
  .fc-toolbar-title {
    font-size: 1.5em !important;
    padding: 0;
  }
  .fc-button, .fc-button-primary {
    font-size: 1em !important;
    padding: 4px 14px !important;
    height: 36px !important;
  }
  .fc-col-header-cell-cushion, .fc-daygrid-day-number {
    color: #222 !important;
    text-decoration: none !important;
    cursor: default !important;
    font-weight: bold;
    font-size: 1.1em;
    padding: 4px 0 !important;
    pointer-events: none;
  }
  .fc-timegrid-axis {
    background: #F7F7F7 !important;
    color: #333 !important;
    font-size: 1.1em;
    font-weight: bold;
    border-right: 2px solid #FFA500 !important;
  }
  .fc-scrollgrid, .fc-scrollgrid-section, .fc-daygrid-day, .fc-timegrid-slot, .fc-timegrid-axis, .fc-timegrid-col {
    border-color: #c3e3d3 !important;
    border-width: 1.5px !important;
  }
  .fc-timegrid-col, .fc-daygrid-day {
    border-right: 2px solid #8bb7a0 !important;
    background: #fff !important;
  }
  .fc-timegrid-col:last-child, .fc-daygrid-day:last-child {
    border-right: none !important;
  }
  .fc-timegrid-slot, .fc-daygrid-day {
    border-bottom: 1.5px solid #c3e3d3 !important;
  }
  .fc-timegrid-slot-label {
    color: #222 !important;
    font-size: 1.1em;
    font-weight: bold;
  }
  .fc-event.fc-event .fc-event-title, .fc-event .fc-event-time  {
    color: #222 !important;
    font-weight: bold;
    text-shadow: none !important;
    opacity: 0.95 !important;
    border: none !important;
  }
  .cita-cancelada .fc-event-title,
  .cita-cancelada .fc-event-time {
    text-decoration: line-through !important;
    opacity: 0.7 !important;
  }
  .cita-cancelada {
    cursor: not-allowed !important;
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
let propietarioCalendar = null;
function inicializarCalendarioPropietario() {
    var calendarEl = document.getElementById('propietario-calendar');
    if(calendarEl && !propietarioCalendar) {
        var eventos = [
            <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $mascota->citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    id: <?php echo e($cita->id); ?>,
                    title: '<?php echo e(addslashes(($mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? ""))); ?>',
                    start: '<?php echo e($cita->fecha); ?>T<?php echo e($cita->hora ?? "00:00"); ?>',
                    color: <?php if($cita->estado === 'Pendiente'): ?> '#808080' <?php elseif($cita->estado === 'Cancelada'): ?> '#FFB3B3' <?php elseif($cita->informes->count() > 0): ?> '#43b581' <?php else: ?> '#4A90E2' <?php endif; ?>,
                    extendedProps: {
                        mascota: '<?php echo e(addslashes($mascota->nombre ?? "")); ?>',
                        motivo: '<?php echo e(addslashes($cita->motivo ?? "")); ?>',
                        con_informe: <?php echo e($cita->informes->count() > 0 ? 'true' : 'false'); ?>,
                        fecha: '<?php echo e($cita->fecha); ?>',
                        hora: '<?php echo e($cita->hora ?? ""); ?>',
                        estado: '<?php echo e($cita->estado); ?>',
                    }
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];
        propietarioCalendar = new FullCalendar.Calendar(calendarEl, {
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
            firstDay: 1,
            hiddenDays: [],
            events: eventos,
            eventDidMount: function(info) {
                if(info.event.extendedProps && info.event.extendedProps.con_informe) {
                    info.el.classList.add('cita-realizada');
                }
                if(info.event.extendedProps && info.event.extendedProps.estado === 'Cancelada') {
                    info.el.classList.add('cita-cancelada');
                }
            },
        });
        propietarioCalendar.render();
    }
}

$(document).ready(function() {
    inicializarCalendarioPropietario();
});
</script>
<?php $__env->stopPush(); ?>

<style>
.card-mascota {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px #0001;
    border: 2px solid #FFA500;
    padding: 18px 22px;
    margin-bottom: 28px;
    transition: box-shadow 0.2s, border 0.2s;
}
.card-mascota:hover {
    box-shadow: 0 4px 24px #0002;
    border-color: #FF7F32;
}
</style> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/mascotas/index.blade.php ENDPATH**/ ?>