<div class="mb-4">
    <a href="{{ route('mascotas.create') }}" class="btn" style="background: #FF7F32; color: #fff; font-weight: bold; border-radius: 20px; padding: 10px 30px;">
        Añade a tu mascota
    </a>
</div>
<div id="propietario-calendar"></div>
@foreach ($mascotas as $mascota)
<div class="card-mascota mb-4">
    <div class="row align-items-center g-0">
        <div class="col-auto">
            <img src="{{ $mascota->imagen ? asset('storage/' . $mascota->imagen) : asset('img/mascotas.png') }}" alt="{{ $mascota->nombre }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
        </div>
        <div class="col ps-3">
            <div class="fw-bold" style="font-size: 1.2rem;">{{ $mascota->nombre }}</div>
            <div>{{ $mascota->sexo }}, {{ $mascota->calcularEdad() }}, Nº Microchip: {{ $mascota->microchip ?? '0000000000' }}</div>
            <div class="mt-2">
                <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#modalHistorialMascota{{ $mascota->id }}">Mi historial</a>
                @if($mascota->proximaCita())
                    <a href="#" class="me-3" title="{{ $mascota->proximaCita()->fecha }} {{ $mascota->proximaCita()->hora }}">Mi próxima cita: {{ $mascota->proximaCita()->fecha }} {{ $mascota->proximaCita()->hora }}</a>
                @endif
                @if($mascota->proximaVacuna())
                    <a href="#" class="me-3" title="{{ $mascota->proximaVacuna() }}">Próxima Vacuna: {{ $mascota->proximaVacuna() }}</a>
                @endif
                @if($mascota->proximaDesparasitacion())
                    <a href="#" class="me-3" title="{{ $mascota->proximaDesparasitacion() }}">Próxima Desparasitación: {{ $mascota->proximaDesparasitacion() }}</a>
                @endif
                <a href="{{ route('mascotas.edit', $mascota->id) }}">Editar mi perfil</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($mascotas as $mascota)
    <div class="modal fade" id="modalHistorialMascota{{ $mascota->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de {{ $mascota->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tabla-historico-{{ $mascota->id }}">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->historiales as $h)
                                @foreach($h->informes()->orderByDesc('created_at')->get() as $informe)
                                <tr data-informe-id="{{ $informe->id }}"
                                    data-diagnostico="{{ $informe->diagnostico }}"
                                    data-procedimientos="{{ $informe->procedimientos }}"
                                    data-medicamentos="{{ $informe->medicamentos }}"
                                    data-tratamiento="{{ $informe->tratamiento }}"
                                    data-recomendaciones="{{ $informe->recomendaciones }}"
                                    data-observaciones="{{ $informe->observaciones }}"
                                    data-proxima_cita="{{ $informe->proxima_cita }}"
                                    data-fecha_cita="{{ $informe->cita->fecha ?? '' }}"
                                    data-hora_cita="{{ $informe->cita->hora ?? '' }}"
                                    data-motivo_cita="{{ $informe->cita->motivo ?? '' }}"
                                    data-veterinario="{{ $informe->cita->veterinario->name ?? '' }}"
                                    data-ncolegiado="{{ $informe->cita->veterinario->dni ?? '' }}"
                                >
                                    <td>{{ $informe->cita && $informe->cita->fecha ? $informe->cita->fecha : ($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-') }}</td>
                                    <td>{{ $informe->cita->motivo ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-ver-detalle-informe" data-informe-id="{{ $informe->id }}">Ver detalle</button>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <div id="detalle-historial-{{ $mascota->id }}" class="mt-4" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@push('styles')
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
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
let propietarioCalendar = null;
function inicializarCalendarioPropietario() {
    var calendarEl = document.getElementById('propietario-calendar');
    if(calendarEl && !propietarioCalendar) {
        var eventos = [
            @foreach($mascotas as $mascota)
                @foreach($mascota->citas as $cita)
                {
                    id: {{ $cita->id }},
                    title: '{{ addslashes(($mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? "")) }}',
                    start: '{{ $cita->fecha }}T{{ $cita->hora ?? "00:00" }}',
                    color: @if($cita->estado === 'Pendiente') '#808080' @elseif($cita->estado === 'Cancelada') '#FFB3B3' @elseif($cita->informes->count() > 0) '#43b581' @else '#4A90E2' @endif,
                    extendedProps: {
                        mascota: '{{ addslashes($mascota->nombre ?? "") }}',
                        motivo: '{{ addslashes($cita->motivo ?? "") }}',
                        con_informe: {{ $cita->informes->count() > 0 ? 'true' : 'false' }},
                        fecha: '{{ $cita->fecha }}',
                        hora: '{{ $cita->hora ?? "" }}',
                        estado: '{{ $cita->estado }}',
                    }
                },
                @endforeach
            @endforeach
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
@endpush

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
</style> 