<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Panel de Administración</h2>
    <div class="admin-content-box tab-content mt-3" id="adminTabsContent">
        <div class="tab-pane fade show active" id="citas" role="tabpanel">
            <div class="d-flex align-items-start position-relative" style="gap: 32px;">
                <div style="flex:1; min-width:0;">
                    <div class="d-flex justify-content-end mb-2">
                        <button id="toggle-leyenda" class="btn btn-light border" type="button" title="Mostrar/Ocultar leyenda" style="box-shadow:0 1px 4px #0001;">
                            <i class="bi bi-brush-fill"></i>
                        </button>
                    </div>
                    <div id="admin-calendar"></div>
                </div>
                <div id="leyenda-veterinarios" style="min-width:120px;max-width:150px;display:none;">
                    <div class="mb-2 fw-bold" style="font-size:0.95em;">Colores</div>
                    <div class="d-flex flex-column" style="gap: 8px;">
                        <?php $__currentLoopData = $veterinarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:<?php echo e($vet->color_calendario); ?>;border:1px solid #888;"></span>
                                <span style="font-size: 0.95em;"><?php echo e($vet->name); ?></span>
                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:#808080;border:1px solid #888;"></span>
                            <span style="font-size: 0.95em;">Pendiente</span>
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:#fff;border:1px solid #888;position:relative;">
                                <span style="position:absolute;top:7px;left:2px;width:12px;height:2px;background:#222;transform:rotate(-20deg);"></span>
                            </span>
                            <span style="font-size: 0.95em;text-decoration:line-through;">Cancelada</span>
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:#43b581;border:2px solid #2e8b57;position:relative;">
                                <i class="bi bi-file-earmark-medical-fill" style="color:#fff;position:absolute;left:2px;top:2px;font-size:12px;"></i>
                            </span>
                            <span style="font-size: 0.95em;">Realizada (con informe)</span>
                        </span>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('toggle-leyenda');
                    const leyenda = document.getElementById('leyenda-veterinarios');
                    btn.addEventListener('click', function() {
                        if (leyenda.style.display === 'none' || leyenda.style.display === '') {
                            leyenda.style.display = 'block';
                        } else {
                            leyenda.style.display = 'none';
                        }
                    });
                });
            </script>
        </div>
        <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="tab-personal">
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoPersonal">Añadir Personal</button>
            
            <?php echo $__env->make('admin.usuarios.tabla-personal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="tab-pane fade" id="mascotas" role="tabpanel" aria-labelledby="tab-mascotas">
            <div class="mb-3 d-flex align-items-center" style="gap: 10px;">
                <input id="input-buscador-mascotas" class="form-control" style="width: 300px;" placeholder="Buscar mascota o propietario...">
                <button id="btn-buscar-mascotas" class="btn btn-primary">Buscar</button>
                <button id="btn-limpiar-busqueda-mascotas" class="btn btn-secondary">Limpiar</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabla-mascotas-admin">
                    <thead>
                        <tr>
                            <th class="sortable" data-col="nombre">Nombre Mascota <span class="sort-arrow"></span></th>
                            <th class="sortable" data-col="especie">Tipo <span class="sort-arrow"></span></th>
                            <th class="sortable" data-col="propietario">Propietario <span class="sort-arrow"></span></th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($mascota->nombre); ?></td>
                            <td><?php echo e($mascota->especie); ?></td>
                            <td><?php echo e($mascota->propietario->name ?? '-'); ?></td>
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
                                                    <button type="button" class="btn btn-primary btn-sm btn-ver-detalle" data-informe-id="<?php echo e($informe->id); ?>">Ver detalle</button>
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
    </div>
</div>

<!-- Modal para añadir personal -->
<div class="modal fade" id="modalNuevoPersonal" tabindex="-1" aria-labelledby="modalNuevoPersonalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNuevoPersonalLabel">Añadir Personal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" action="<?php echo e(route('admin.usuarios.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <?php echo e($errors->first()); ?>

          </div>
        <?php endif; ?>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Rol</label>
            <select name="puesto" class="form-control" id="rolSelect" required onchange="toggleCamposPersonal()">
              <option value="">Selecciona un rol</option>
              <option value="veterinario">Veterinario/a</option>
              <option value="peluquero">Peluquero/a</option>
              <option value="administracion">Personal administración</option>
              <option value="otros">Otros</option>
            </select>
          </div>
          <div class="mb-3" id="dniField" style="display:none;">
            <label id="dniLabel">DNI</label>
            <input type="text" name="dni" class="form-control" id="dniInput" placeholder="" >
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Crear</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php if(isset($tab)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tab = <?php echo json_encode($tab, 15, 512) ?>;
            if(tab) {
                var trigger = document.querySelector('[href="#' + tab + '"]');
                if(trigger) {
                    var tabInstance = new bootstrap.Tab(trigger);
                    tabInstance.show();
                }
            }
        });
    </script>
<?php endif; ?>

<!-- Modal para crear cita (fuera del section content) -->
<div class="modal fade" id="modalCrearCita" tabindex="-1" aria-labelledby="modalCrearCitaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearCitaLabel">Crear Cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" action="<?php echo e(route('citas.store')); ?>" id="form-crear-cita">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <label for="propietario_id" class="form-label">Propietario</label>
            <select id="propietario_id" name="propietario_id" class="form-control" required style="width:100%"></select>
          </div>
          <div class="mb-3">
            <label for="mascota_id" class="form-label">Mascota</label>
            <select id="mascota_id" name="mascota_id" class="form-control" required>
              <option value="">Selecciona una mascota</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <select id="motivo" name="motivo" class="form-control" required>
              <option value="">Selecciona un motivo</option>
              <option value="Primera consulta">Primera consulta</option>
              <option value="Revisión">Revisión</option>
              <option value="Vacunación">Vacunación</option>
              <option value="Cirugía">Cirugía</option>
              <option value="Pruebas">Pruebas</option>
              <option value="Otros">Otros</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="veterinario_id" class="form-label">Veterinario</label>
            <select id="veterinario_id" name="veterinario_id" class="form-control" required>
              <option value="">Selecciona un veterinario</option>
              <?php $__currentLoopData = $veterinarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($vet->id); ?>"><?php echo e($vet->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" id="hora" name="hora" class="form-control" required min="08:00" max="22:00">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Crear Cita</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para editar cita (fuera del section content) -->
<div class="modal fade" id="modalEditarCita" tabindex="-1" aria-labelledby="modalEditarCitaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarCitaLabel">Detalle de la Cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div id="cita-detalle-loading" style="display:none;">Cargando...</div>
        <form id="form-editar-cita" style="display:none;">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>
          <input type="hidden" id="edit-mascota_id" name="mascota_id">
          <input type="hidden" id="edit-propietario_id" name="propietario_id">
          <div class="mb-2"><b>Mascota:</b> <input type="text" class="form-control" id="edit-mascota_nombre" readonly></div>
          <div class="mb-2"><b>Propietario:</b> <input type="text" class="form-control" id="edit-propietario_nombre" readonly></div>
          <div class="mb-2"><b>Veterinario:</b> <select class="form-control" id="edit-veterinario_id" name="veterinario_id"></select></div>
          <div class="mb-2"><b>Motivo:</b> <input type="text" class="form-control" id="edit-motivo" name="motivo" readonly></div>
          <div class="mb-2"><b>Fecha:</b> <input type="date" class="form-control" id="edit-fecha" name="fecha"></div>
          <div class="mb-2"><b>Hora:</b> <input type="time" class="form-control" id="edit-hora" name="hora" min="08:00" max="22:00"></div>
          <div class="mb-2"><b>Estado:</b> <select class="form-control" id="edit-estado" name="estado">
            <option value="Confirmada">Confirmada</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Cancelada">Cancelada</option>
          </select></div>
        </form>
        <div id="cita-detalle-content" style="display:none;">
          <div class="mb-2"><b>Mascota:</b> <span id="cita-mascota"></span></div>
          <div class="mb-2"><b>Propietario:</b> <span id="cita-propietario"></span></div>
          <div class="mb-2"><b>Veterinario:</b> <span id="cita-veterinario"></span></div>
          <div class="mb-2"><b>Motivo:</b> <span id="cita-motivo"></span></div>
          <div class="mb-2"><b>Fecha:</b> <span id="cita-fecha"></span></div>
          <div class="mb-2"><b>Hora:</b> <span id="cita-hora"></span></div>
          <div class="mb-2"><b>Estado:</b> <span id="cita-estado"></span></div>
        </div>
        <div id="cita-detalle-error" class="alert alert-danger" style="display:none;"></div>
      </div>
      <div class="modal-footer" id="cita-detalle-footer" style="display:none;">
        <button type="button" class="btn btn-primary" id="btn-modificar-cita">Modificar</button>
        <button type="button" class="btn btn-success" id="btn-guardar-cita" style="display:none;">Guardar cambios</button>
        <button type="button" class="btn btn-success" id="btn-confirmar-cita">Confirmar</button>
        <button type="button" class="btn btn-warning" id="btn-cancelar-cita">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btn-borrar-cita">Borrar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
function toggleCamposPersonal() {
    var rol = document.getElementById('rolSelect').value;
    var dniField = document.getElementById('dniField');
    var dniInput = document.getElementById('dniInput');
    var dniLabel = document.getElementById('dniLabel');
    if (rol === 'veterinario') {
        dniField.style.display = '';
        dniInput.required = true;
        dniLabel.textContent = 'Nº colegiado';
        dniInput.placeholder = 'Número de colegiado';
    } else if (rol) {
        dniField.style.display = '';
        dniInput.required = true;
        dniLabel.textContent = 'DNI';
        dniInput.placeholder = 'DNI';
    } else {
        dniField.style.display = 'none';
        dniInput.required = false;
        dniInput.value = '';
    }
}
</script>

<?php $__env->startSection('scripts'); ?>
<!-- jQuery debe ir antes de Select2 y de tu script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="<?php echo e(asset('css/main.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/fullcalendar-custom.css')); ?>" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<style>
  #admin-calendar, .fc {
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
let adminCalendar = null;
function inicializarCalendarioAdmin() {
    var calendarEl = document.getElementById('admin-calendar');
    if(calendarEl && !adminCalendar) {
        var eventos = [
            <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                id: <?php echo e($cita->id); ?>,
                title: '<?php echo e(addslashes(($cita->mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? ""))); ?>',
                start: '<?php echo e($cita->fecha); ?>T<?php echo e($cita->hora ?? "00:00"); ?>',
                color: <?php if($cita->estado === 'Pendiente'): ?> '#808080' <?php elseif($cita->estado === 'Cancelada'): ?> '#FFB3B3' <?php elseif($cita->informes->count() > 0): ?> '#43b581' <?php else: ?> $cita->veterinario ? $cita->veterinario->color_calendario : '#4A90E2' <?php endif; ?>,
                extendedProps: {
                    mascota: '<?php echo e(addslashes($cita->mascota->nombre ?? "")); ?>',
                    propietario: '<?php echo e(addslashes($cita->mascota->propietario->name ?? "")); ?>',
                    veterinario: '<?php echo e(addslashes($cita->veterinario->name ?? "")); ?>',
                    motivo: '<?php echo e(addslashes($cita->motivo ?? "")); ?>',
                    con_informe: <?php echo e($cita->informes->count() > 0 ? 'true' : 'false'); ?>,
                    fecha: '<?php echo e($cita->fecha); ?>',
                    hora: '<?php echo e($cita->hora ?? ""); ?>',
                    estado: '<?php echo e($cita->estado); ?>',
                    veterinario_id: '<?php echo e($cita->veterinario_id); ?>',
                    mascota_id: '<?php echo e($cita->mascota_id); ?>',
                    propietario_id: '<?php echo e($cita->mascota->propietario_id ?? ''); ?>'
                }
            },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];
        adminCalendar = new FullCalendar.Calendar(calendarEl, {
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
            eventClick: function(info) {
                abrirModalEditarCita(info.event);
            },
            eventDidMount: function(info) {
                if(info.event.extendedProps && info.event.extendedProps.con_informe) {
                    info.el.classList.add('cita-realizada');
                }
                if(info.event.extendedProps && info.event.extendedProps.estado === 'Cancelada') {
                    info.el.classList.add('cita-cancelada');
                }
            },
        });
        adminCalendar.render();
    }
}

$(document).ready(function() {
    // Inicializar calendario solo si la pestaña de citas está visible al cargar
    if($('#citas').hasClass('show active')) {
        inicializarCalendarioAdmin();
    }
    // Al pulsar la pestaña Citas, destruir e inicializar el calendario SIEMPRE
    $("[data-bs-target='#citas']").on('shown.bs.tab', function() {
        if(adminCalendar) {
            adminCalendar.destroy();
            adminCalendar = null;
        }
        inicializarCalendarioAdmin();
    });
});
</script>
<script>
$(document).ready(function() {
    // Buscador por botón
    $('#btn-buscar-mascotas').on('click', function() {
        var search = $('#input-buscador-mascotas').val().toLowerCase();
        $('#tabla-mascotas-admin tbody tr').each(function() {
            var nombre = $(this).find('td').eq(0).text().toLowerCase();
            var tipo = $(this).find('td').eq(1).text().toLowerCase();
            var propietario = $(this).find('td').eq(2).text().toLowerCase();
            if (nombre.includes(search) || propietario.includes(search) || tipo.includes(search)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    $('#btn-limpiar-busqueda-mascotas').on('click', function() {
        $('#input-buscador-mascotas').val('');
        $('#tabla-mascotas-admin tbody tr').show();
    });
    // Ordenar columnas
    $('.sortable').on('click', function() {
        var col = $(this).data('col');
        var table = $(this).parents('table');
        var rows = table.find('tbody > tr').get();
        var asc = $(this).hasClass('asc');
        rows.sort(function(a, b) {
            var A = $(a).find('td').eq($('.sortable').index($(this))).text().toUpperCase();
            var B = $(b).find('td').eq($('.sortable').index($(this))).text().toUpperCase();
            if(A < B) return asc ? 1 : -1;
            if(A > B) return asc ? -1 : 1;
            return 0;
        }.bind(this));
        $.each(rows, function(index, row) {
            table.children('tbody').append(row);
        });
        $('.sortable').removeClass('asc desc');
        $(this).addClass(asc ? 'desc' : 'asc');
    });
    $('.btn-ver-detalle').on('click', function() {
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
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/admin/index.blade.php ENDPATH**/ ?>