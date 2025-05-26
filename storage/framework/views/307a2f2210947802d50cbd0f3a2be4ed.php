<h2>Citas Veterinarias</h2>
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalSolicitarCita">Solicitar cita</button>
<div class="mb-3 d-flex align-items-center" style="gap: 18px;">
    <span style="display: flex; align-items: center; gap: 6px;">
        <span style="display:inline-block;width:18px;height:18px;border-radius:4px;background:#4A90E2;"></span>
        <span style="font-size: 1em;">Confirmada</span>
    </span>
    <span style="display: flex; align-items: center; gap: 6px;">
        <span style="display:inline-block;width:18px;height:18px;border-radius:4px;background:#BDBDBD;"></span>
        <span style="font-size: 1em;">Pendiente</span>
    </span>
    <span style="display: flex; align-items: center; gap: 6px;">
        <span style="display:inline-block;width:18px;height:18px;border-radius:4px;background:#FFB3B3;"></span>
        <span style="font-size: 1em;">Cancelada</span>
    </span>
    <span style="display: flex; align-items: center; gap: 6px;">
        <span style="display:inline-block;width:18px;height:18px;border-radius:4px;background:#43b581;border:2px solid #2e8b57;position:relative;">
            <i class="bi bi-file-earmark-medical-fill" style="color:#fff;position:absolute;left:2px;top:2px;font-size:13px;"></i>
        </span>
        <span style="font-size: 1em;">Realizada (con informe)</span>
    </span>
</div>
<div id="user-calendar"></div>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<style>
  .fc-col-header-cell-cushion, .fc-daygrid-day-number {
    color: #222 !important;
    text-decoration: none !important;
    cursor: default !important;
    font-weight: bold;
    font-size: 1.1em;
    pointer-events: none;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Modal Solicitar Cita -->
<div class="modal fade" id="modalSolicitarCita" tabindex="-1" aria-labelledby="modalSolicitarCitaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSolicitarCitaLabel">Solicitar cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" action="<?php echo e(route('citas.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <label for="mascota_id" class="form-label">Mascota</label>
            <select id="mascota_id" name="mascota_id" class="form-control" required>
              <option value="">Selecciona una mascota</option>
              <?php $__currentLoopData = Auth::user()->mascotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($mascota->id); ?>"><?php echo e($mascota->nombre); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
              <?php $__currentLoopData = \App\Models\User::where('role', 'veterinario')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
          <button type="submit" class="btn btn-primary">Solicitar cita</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
let calendar = null;
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('user-calendar');
    if(calendarEl) {
        calendar = new FullCalendar.Calendar(calendarEl, {
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
            events: [
                <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    id: <?php echo e($cita->id); ?>,
                    title: '<?php echo e(addslashes(($cita->mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? ""))); ?>',
                    start: '<?php echo e($cita->fecha); ?>T<?php echo e($cita->hora ?? "00:00"); ?>',
                    color: '<?php echo e($cita->estado === 'Confirmada' ? '#4A90E2' : ($cita->estado === 'Pendiente' ? '#BDBDBD' : '#FFB3B3')); ?>',
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            firstDay: 1, // Lunes
            hiddenDays: [], // Mostrar todos los días de la semana
        });
        calendar.render();
    }

    // Envío AJAX del formulario de solicitud de cita
    $('#modalSolicitarCita form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        btn.prop('disabled', true);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#modalSolicitarCita').modal('hide');
                btn.prop('disabled', false);
                // Recargar la página para obtener las nuevas citas (opcional: recargar solo eventos por AJAX si tienes endpoint JSON)
                if(calendar) {
                    // Si tienes endpoint JSON, usa calendar.refetchEvents();
                    // Si no, recarga la página:
                    location.reload();
                }
                // Mensaje de éxito
                setTimeout(function(){
                    alert('Cita solicitada correctamente. Espera confirmación.');
                }, 500);
            },
            error: function(xhr) {
                btn.prop('disabled', false);
                let msg = 'Error al solicitar la cita.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    msg += '\n' + Object.values(xhr.responseJSON.errors).join('\n');
                }
                alert(msg);
            }
        });
    });
});
</script> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/citas/index.blade.php ENDPATH**/ ?>