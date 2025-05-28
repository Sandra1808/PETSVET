<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/main.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/fullcalendar-custom.css')); ?>" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Panel de Administración</h2>
    <div class="admin-tabs-underline"></div>
    
    <div id="citas-section" class="admin-tab-section">
        <div class="admin-content-box mt-3">
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
                            <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:#FFB3B3;border:1px solid #888;"></span>
                            <span style="font-size: 0.95em;">Cancelada</span>
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
        </div>
    </div>
    
    <div id="personal-section" class="admin-tab-section" style="display:none;">
        <div class="admin-content-box admin-content-style mt-3">
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoPersonal">Añadir Personal</button>
            <?php echo $__env->make('admin.usuarios.tabla-personal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    
    <div id="mascotas-section" class="admin-tab-section" style="display:none;">
      <div class="admin-content-box admin-content-style mt-3">
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

<!-- Modal para crear cita -->
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
              <option value="Desparasitación">Desparasitación</option>
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

<!-- Modal para editar cita -->
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
          <div class="mb-2"><b>Veterinario:</b> <select class="form-control" id="edit-veterinario_id" name="veterinario_id">
            <option value="">Selecciona un veterinario</option>
            <?php $__currentLoopData = $veterinarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($vet->id); ?>"><?php echo e($vet->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select></div>
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
        <a href="#" class="btn btn-info" id="btn-imprimir-informe" style="display:none;">Imprimir Informe</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
let adminCalendar = null;
function inicializarCalendarioAdmin() {
    var calendarEl = document.getElementById('admin-calendar');
    if(calendarEl && !adminCalendar && typeof FullCalendar !== 'undefined') {
        var eventos = [
            <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                id: <?php echo e($cita->id); ?>,
                title: '<?php echo e(addslashes(($cita->mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? ""))); ?>',
                start: '<?php echo e($cita->fecha); ?>T<?php echo e($cita->hora ?? "00:00"); ?>',
                color: <?php if($cita->estado === 'Pendiente'): ?> '#808080'
                       <?php elseif($cita->estado === 'Cancelada'): ?> '#FFB3B3'
                       <?php elseif($cita->informes->count() > 0): ?> '#43b581'
                       <?php else: ?> '<?php echo e($cita->veterinario ? $cita->veterinario->color_calendario : '#4A90E2'); ?>'
                       <?php endif; ?>,
                extendedProps: {
                    mascota: '<?php echo e(addslashes($cita->mascota->nombre ?? "")); ?>',
                    propietario: '<?php echo e(addslashes($cita->mascota->propietario->name ?? "")); ?>',
                    veterinario: '<?php echo e(addslashes($cita->veterinario->name ?? "")); ?>',
                    motivo: '<?php echo e(addslashes($cita->motivo ?? "")); ?>',
                    con_informe: <?php echo e($cita->informes->count() > 0 ? 'true' : 'false'); ?>,
                    informe_id: <?php echo e($cita->informes->count() > 0 ? $cita->informes->first()->id : 'null'); ?>,
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
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            events: eventos,
            dateClick: function(info) {
                // Abre el modal de crear cita y rellena la fecha/hora
                $('#modalCrearCita').modal('show');
                $('#fecha').val(info.dateStr.split('T')[0]);
                $('#hora').val(info.dateStr.split('T')[1] ? info.dateStr.split('T')[1].substring(0,5) : '');
            },
            eventClick: function(info) {
                // Llama a la función AJAX para cargar los datos completos de la cita
                window.abrirModalEditarCita(info.event);
            },
            eventDidMount: function(info) {
                if(info.event.extendedProps && info.event.extendedProps.con_informe) {
                    info.el.classList.add('cita-realizada');
                }
                if(info.event.extendedProps && info.event.extendedProps.estado === 'Cancelada') {
                    info.el.classList.add('cita-cancelada');
                }
            }
        });
        adminCalendar.render();
    }
}

$(document).ready(function() {
    if (typeof FullCalendar !== 'undefined') {
        inicializarCalendarioAdmin();
    } else {
        console.error('FullCalendar no está disponible');
    }
    // Leyenda
    const btn = document.getElementById('toggle-leyenda');
    const leyenda = document.getElementById('leyenda-veterinarios');
    if(btn && leyenda) {
        btn.addEventListener('click', function() {
            if (leyenda.style.display === 'none' || leyenda.style.display === '') {
                leyenda.style.display = 'block';
            } else {
                leyenda.style.display = 'none';
            }
        });
    }
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

    // Inicializar Select2 para propietarios en crear cita
    $('#propietario_id').select2({
        placeholder: 'Buscar propietario...',
        ajax: {
            url: '/admin/propietarios/autocomplete', // Debes tener esta ruta en tu backend
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        },
        width: '100%'
    });

    // Al seleccionar propietario, cargar mascotas
    $('#propietario_id').on('change', function() {
        var propietarioId = $(this).val();
        $.ajax({
            url: '/admin/mascotas/by-propietario/' + propietarioId, // Debes tener esta ruta en tu backend
            type: 'GET',
            success: function(data) {
                var $mascota = $('#mascota_id');
                $mascota.empty();
                $mascota.append('<option value="">Selecciona una mascota</option>');
                $.each(data, function(i, mascota) {
                    $mascota.append('<option value="'+mascota.id+'">'+mascota.nombre+'</option>');
                });
            }
        });
    });

    // --- HANDLERS PARA BOTONES DEL MODAL DE CITA ---
    let citaIdActual = null;

    // Al abrir el modal, guardar el id de la cita actual
    window.abrirModalEditarCita = function(event) {
        var props = event.extendedProps;
        citaIdActual = event.id;
        // Rellenar campos del modal
        $('#cita-mascota').text(props.mascota);
        $('#cita-propietario').text(props.propietario);
        $('#cita-veterinario').text(props.veterinario);
        $('#cita-motivo').text(props.motivo);
        $('#cita-fecha').text(props.fecha);
        $('#cita-hora').text(props.hora);
        $('#cita-estado').text(props.con_informe ? 'Realizada' : props.estado);
        // También rellenar el formulario de edición
        $('#edit-mascota_nombre').val(props.mascota);
        $('#edit-propietario_nombre').val(props.propietario);
        $('#edit-veterinario_id').val(props.veterinario_id);
        $('#edit-motivo').val(props.motivo);
        $('#edit-fecha').val(props.fecha);
        $('#edit-hora').val(props.hora);
        $('#edit-estado').val(props.estado);
        $('#edit-mascota_id').val(props.mascota_id);
        $('#edit-propietario_id').val(props.propietario_id);
        // Mostrar solo la vista
        $('#form-editar-cita').hide();
        $('#btn-guardar-cita').hide();
        $('#btn-modificar-cita').show();
        $('#cita-detalle-content').show();
        $('#cita-detalle-footer').show();

        // Gestionar visibilidad de botones según estado
        if (props.con_informe) {
            // Si tiene informe (realizada), solo mostrar botón de imprimir
            $('#btn-modificar-cita').hide();
            $('#btn-confirmar-cita').hide();
            $('#btn-cancelar-cita').hide();
            $('#btn-borrar-cita').hide();
            if (props.informe_id) {
                $('#btn-imprimir-informe').show().attr('href', '/pdf/informe/' + props.informe_id);
            } else {
                $('#btn-imprimir-informe').hide();
            }
        } else {
            // Si no tiene informe, mostrar botones normales
            $('#btn-modificar-cita').show();
            $('#btn-imprimir-informe').hide();
            if (props.estado === 'Confirmada') {
                $('#btn-confirmar-cita').hide();
            } else {
                $('#btn-confirmar-cita').show();
            }
            $('#btn-cancelar-cita').show();
            $('#btn-borrar-cita').show();
        }
        $('#modalEditarCita').modal('show');
    }

    // Botón Modificar
    $('#btn-modificar-cita').on('click', function() {
        $('#cita-detalle-content').hide();
        $('#form-editar-cita').show();
        $('#btn-guardar-cita').show();
        $('#btn-modificar-cita').hide();
    });

    // Botón Guardar cambios
    $('#btn-guardar-cita').on('click', function(e) {
        e.preventDefault();
        if (!citaIdActual) return;
        var data = {
            _token: $('input[name="_token"]').val(),
            _method: 'PUT',
            veterinario_id: $('#edit-veterinario_id').val(),
            motivo: $('#edit-motivo').val(),
            fecha: $('#edit-fecha').val(),
            hora: $('#edit-hora').val(),
            estado: $('#edit-estado').val(),
            mascota_id: $('#edit-mascota_id').val(),
            propietario_id: $('#edit-propietario_id').val()
        };
        $.ajax({
            url: '/citas/' + citaIdActual,
            type: 'POST',
            data: data,
            success: function(resp) {
                location.reload(); // Recargar para ver cambios
            },
            error: function(xhr) {
                alert('Error al guardar los cambios.');
            }
        });
    });

    // Botón Confirmar
    $('#btn-confirmar-cita').on('click', function() {
        if (!citaIdActual) return;
        $.ajax({
            url: '/admin/citas/' + citaIdActual + '/confirmar',
            type: 'POST',
            data: { _token: $('input[name="_token"]').val() },
            success: function(resp) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error al confirmar la cita.');
            }
        });
    });

    // Botón Cancelar
    $('#btn-cancelar-cita').on('click', function() {
        if (!citaIdActual) return;
        $.ajax({
            url: '/admin/citas/' + citaIdActual + '/rechazar',
            type: 'POST',
            data: { _token: $('input[name="_token"]').val() },
            success: function(resp) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error al cancelar la cita.');
            }
        });
    });

    // Botón Borrar
    $('#btn-borrar-cita').on('click', function() {
        if (!citaIdActual) return;
        if (!confirm('¿Seguro que quieres borrar esta cita?')) return;
        $.ajax({
            url: '/citas/' + citaIdActual,
            type: 'POST',
            data: { _token: $('input[name="_token"]').val(), _method: 'DELETE' },
            success: function(resp) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error al borrar la cita.');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\petsvet\resources\views/admin/index.blade.php ENDPATH**/ ?>