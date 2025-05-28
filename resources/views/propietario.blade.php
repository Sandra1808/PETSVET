@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center align-items-end mb-4" style="min-height: 140px;">
        <div class="col-auto text-center">
            <button class="icon-nav-btn active" id="btn-mis-mascotas" onclick="showSection('mascotas')">
                <img src="{{ asset('img/huella.png') }}" alt="Mis mascotas" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold nav-text">Mis mascotas</div>
            </button>
        </div>
        <div class="col-auto text-center">
            <button class="icon-nav-btn" id="btn-historial" onclick="showSection('historial')">
                <img src="{{ asset('img/historial.png') }}" alt="Historial" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold nav-text">Historial</div>
            </button>
        </div>
        <div class="col-auto text-center">
            <button class="icon-nav-btn" id="btn-citas" onclick="showSection('citas')">
                <img src="{{ asset('img/citas.png') }}" alt="Citas" class="rounded-circle p-3 mb-2" style="background: #F7A6A6; width:120px; height:120px; object-fit:contain;">
                <div class="fw-bold nav-text">Citas / Nueva Cita</div>
            </button>
        </div>
    </div>
    <div class="admin-content-box tab-content mt-3" style="min-height: 400px;">
        <div id="section-mascotas" class="section-propietario">
            <div class="mb-4">
                <a href="{{ route('mascotas.create') }}" class="btn" style="background: #FF7F32; color: #fff; font-weight: bold; border-radius: 20px; padding: 10px 30px;">
                    Añade a tu mascota
                </a>
            </div>
            @foreach ($mascotas as $mascota)
            <div class="card-mascota mb-4">
                <div class="row align-items-center g-0">
                    <div class="col-auto">
                        <img src="{{ $mascota->imagen ? asset('storage/' . $mascota->imagen) : asset('img/mascotas.jpg') }}" alt="{{ $mascota->nombre }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                    </div>
                    <div class="col ps-3">
                        <div class="fw-bold" style="font-size: 1.2rem;">{{ $mascota->nombre }}</div>
                        <div>{{ $mascota->sexo }}, {{ $mascota->calcularEdad() }}, Nº Microchip: {{ $mascota->microchip ?? '0000000000' }}</div>
                        <div class="mt-2">  
                            @if($mascota->proximaCita())  
                                <span class="me-3 text-info">  
                                    <strong>Mi próxima cita:</strong> {{ $mascota->proximaCita()->fecha }} {{ $mascota->proximaCita()->hora }}  
                                </span>  
                            @endif  
                              
                            @if($mascota->proximaVacuna())  
                                <span class="me-3 text-warning">  
                                    <strong>Mi próxima vacuna:</strong> {{ $mascota->proximaVacuna() }}  
                                </span>  
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
                        @foreach($historiales->unique('n_historial') as $historial)
                        <tr>
                            <td>{{ $historial->mascota->nombre ?? '-' }}</td>
                            <td>{{ $historial->n_historial ?? '-' }}</td>
                            <td>{{ $historial->updated_at ? $historial->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorial{{ $historial->n_historial }}">Ver</button>
                                <a href="{{ route('pdf.historiales.mascota', ['mascota_id' => $historial->mascota_id]) }}" class="btn btn-secondary btn-sm" target="_blank">Imprimir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach($historiales->unique('n_historial') as $historial)
            <div class="modal fade" id="modalHistorial{{ $historial->n_historial }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Histórico de informes - {{ $historial->mascota->nombre }} ({{ $historial->n_historial }})</h5>
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
                                        @foreach($historial->informes->sortByDesc('created_at') as $informe)
                                        <tr>
                                            <td>{{ $informe->cita && $informe->cita->fecha ? $informe->cita->fecha : ($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-') }}</td>
                                            <td>{{ $informe->cita->motivo ?? '-' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm btn-ver-detalle-informe" data-informe-id="{{ $informe->id }}">Ver detalles</button>
                                                <a href="{{ route('pdf.informe', ['id' => $informe->id]) }}" class="btn btn-secondary btn-sm" target="_blank">Imprimir</a>  
                                            </td>
                                        </tr>
                                        <tr id="detalle-informe-{{ $informe->id }}" style="display:none; background:#FFF7E6;">
                                            <td colspan="3">
                                                <div class="card card-body p-3">
                                                    <b>Diagnóstico:</b> {{ $informe->diagnostico ?? '-' }}<br>
                                                    <b>Procedimientos:</b> {{ $informe->procedimientos ?? '-' }}<br>
                                                    <b>Medicamentos:</b> {{ $informe->medicamentos ?? '-' }}<br>
                                                    <b>Tratamiento:</b> {{ $informe->tratamiento ?? '-' }}<br>
                                                    <b>Recomendaciones:</b> {{ $informe->recomendaciones ?? '-' }}<br>
                                                    <b>Observaciones:</b> {{ $informe->observaciones ?? '-' }}<br>
                                                    <b>Próxima cita:</b> {{ $informe->proxima_cita ?? '-' }}<br>
                                                    <b>Fecha creación:</b> {{ $informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-' }}<br>
                                                    <b>Fecha última actualización:</b> {{ $informe->updated_at ? $informe->updated_at->format('d/m/Y H:i') : '-' }}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
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
            @endforeach
        </div>
        <div id="section-citas" class="section-propietario" style="display:none;">
            <div class="mb-4">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSolicitarCita">Nueva cita</button>
            </div>
            <!-- Modal Solicitar Cita -->
            <div class="modal fade" id="modalSolicitarCita" tabindex="-1" aria-labelledby="modalSolicitarCitaLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalSolicitarCitaLabel">Solicitar cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                  </div>
                  <form method="POST" action="{{ route('citas.store') }}">
                    @csrf
                    <input type="hidden" name="estado" value="Pendiente">
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="mascota_id" class="form-label">Mascota</label>
                        <select id="mascota_id" name="mascota_id" class="form-control" required>
                          <option value="">Selecciona una mascota</option>
                          @foreach(Auth::user()->mascotas as $mascota)
                            <option value="{{ $mascota->id }}">{{ $mascota->nombre }}</option>
                          @endforeach
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
                          @foreach(\App\Models\User::where('role', 'veterinario')->get() as $vet)
                            <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                          @endforeach
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
    @foreach($citas as $cita)
    {
        id: {{ $cita->id }},
        title: '{{ addslashes(($cita->mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? "")) }}',
        start: '{{ $cita->fecha }}T{{ $cita->hora ?? "00:00" }}',
        color: @if($cita->informes->count() > 0) '#43b581' @elseif($cita->estado === 'Confirmada') '#4A90E2' @elseif($cita->estado === 'Pendiente') '#BDBDBD' @else '#FFB3B3' @endif,
        extendedProps: {
            con_informe: {{ $cita->informes->count() > 0 ? 'true' : 'false' }},
            estado: '{{ $cita->estado }}',
        }
    },
    @endforeach
];
</script>
<!-- FullCalendar CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
@endsection 

@push('scripts')
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
@endpush 