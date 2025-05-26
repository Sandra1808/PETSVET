@extends('layouts.app')

@push('styles')
<style>
  #user-calendar, .fc {
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

  .nav-tabs {
    border-bottom: none;
    background: #FFE5D0;
    border-radius: 16px 16px 0 0;
    padding: 4px 8px 0 8px;
    display: flex;
    gap: 2px;
    margin-bottom: 0 !important;
  }
  .nav-tabs .nav-link {
    color: #222;
    font-weight: bold;
    background: #FFE5D0;
    border: none;
    border-radius: 12px 12px 0 0;
    margin-right: 2px;
    padding: 10px 28px 8px 28px;
    transition: background 0.2s, color 0.2s;
    box-shadow: none;
    position: relative;
    top: 2px;
  }
  .nav-tabs .nav-link.active {
    background: #fff;
    color: #222;
    border: 2px solid #FFA500;
    z-index: 2;
    box-shadow: 0 2px 8px #0001;
  }
  .nav-tabs .nav-link:not(.active):hover {
    background: #FFD2A6;
    color: #222;
  }
  .nav-tabs .nav-link:focus {
    outline: none;
    box-shadow: 0 0 0 2px #FFA50033;
  }
  .tab-content {
    background: #fff;
    border-radius: 0 0 16px 16px;
    box-shadow: 0 2px 8px #0001;
    padding: 24px 18px 18px 18px;
    border: 2px solid #FFA500;
    margin-bottom: 32px;
    margin-top: 0 !important;
  }

  .sortable { cursor: pointer; user-select: none; }
  .sort-arrow { font-size: 0.9em; margin-left: 4px; color: #888; }
  .sortable.asc .sort-arrow::after { content: "▲"; color: #222; }
  .sortable.desc .sort-arrow::after { content: "▼"; color: #222; }
  .sortable:not(.asc):not(.desc) .sort-arrow::after { content: "⇅"; }

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

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Panel de Veterinario</h2>
    {{-- Sección Citas --}}
    <div id="citas-section" class="vet-tab-section">
        <div class="admin-content-box mt-3">
            <div class="d-flex align-items-start position-relative" style="gap: 32px;">
                <div style="flex:1; min-width:0;">
                    <div class="d-flex justify-content-end mb-2"></div>
                    <div id="user-calendar"></div>
                </div>
                <div id="leyenda-veterinarios" style="min-width:120px;max-width:150px;display:none;">
                    <div class="d-flex flex-column" style="gap: 8px;">
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:#4A90E2;border:1px solid #888;"></span>
                            <span style="font-size: 0.95em;">Confirmada</span>
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:#BDBDBD;border:1px solid #888;"></span>
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
            <!-- Modal para cumplimentar informe de cita -->
            <div class="modal fade" id="modalInformeCita" tabindex="-1" aria-labelledby="modalInformeCitaLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalInformeCitaLabel">Informe de Cita Veterinaria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                  </div>
                  <form id="form-informe-cita" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                      <div class="row mb-2">
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Nombre Mascota:</label>
                          <input type="text" class="form-control" id="informe-nombre-mascota" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Propietario:</label>
                          <input type="text" class="form-control" id="informe-propietario" readonly>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4">
                          <label class="form-label fw-bold">Especie:</label>
                          <input type="text" class="form-control" id="informe-especie" readonly>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label fw-bold">Raza:</label>
                          <input type="text" class="form-control" id="informe-raza" readonly>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label fw-bold">Edad:</label>
                          <input type="text" class="form-control" id="informe-edad" readonly>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Fecha y hora de la cita:</label>
                          <input type="text" class="form-control" id="informe-fecha-hora" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Motivo de la cita:</label>
                          <input type="text" class="form-control" id="informe-motivo" readonly>
                        </div>
                      </div>
                      <hr>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Diagnóstico</label>
                        <textarea class="form-control" name="diagnostico" id="informe-diagnostico" rows="2"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Procedimientos realizados</label>
                        <textarea class="form-control" name="procedimientos" id="informe-procedimientos" rows="2"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Medicamentos aplicados</label>
                        <textarea class="form-control" name="medicamentos" id="informe-medicamentos" rows="2"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Tratamiento a seguir</label>
                        <textarea class="form-control" name="tratamiento" id="informe-tratamiento" rows="2"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Recomendaciones dadas al propietario</label>
                        <textarea class="form-control" name="recomendaciones" id="informe-recomendaciones" rows="2"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Observaciones adicionales</label>
                        <textarea class="form-control" name="observaciones" id="informe-observaciones" rows="2"></textarea>
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Próxima cita recomendada</label>
                        <input type="date" class="form-control" name="proxima_cita" id="informe-proxima-cita">
                      </div>
                      <div class="mb-2">
                        <label class="form-label fw-bold">Adjuntar archivo (opcional)</label>
                        <input type="file" class="form-control" name="archivo_adjunto" id="informe-archivo-adjunto">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Guardar informe</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>

    {{-- Sección Historiales --}}
    <div id="historiales-section" class="vet-tab-section" style="display:none;">
        <div class="admin-content-box tab-content mt-3">
            <div class="mb-3 d-flex align-items-center" style="gap: 10px;">
                <input id="input-buscador-historiales" class="form-control" style="width: 300px;" placeholder="Buscar mascota o propietario...">
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabla-historiales-vet">
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
                                <a href="{{ route('pdf.historiales', ['id' => $historial->id]) }}" class="btn btn-secondary btn-sm" target="_blank">Imprimir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach($historiales->unique('n_historial') as $historial)
            <!-- Modal de historial con tabla de informes -->
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
                                        @foreach($historial->informes()->orderByDesc('created_at')->get() as $informe)
                                        <tr>
                                            <td>{{ $informe->cita && $informe->cita->fecha ? $informe->cita->fecha : ($informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-') }}</td>
                                            <td>{{ $informe->cita->motivo ?? '-' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm btn-ver-detalle-informe" data-informe-id="{{ $informe->id }}">Ver detalles</button>
                                                {{-- Aquí puedes enlazar a PDF del informe si lo tienes --}}
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
    </div>

    {{-- Sección Mascotas --}}
    <div id="mascotas-section" class="vet-tab-section" style="display:none;">
        <div class="admin-content-box tab-content mt-3">
          <div class="mb-3 d-flex align-items-center" style="gap: 10px;">
                <input id="input-buscador-mascotas" class="form-control" style="width: 300px;" placeholder="Buscar mascota o propietario...">
            </div>  
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabla-mascotas-vet">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Especie</th>
                            <th>Propietario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mascotas as $mascota)
                        <tr>
                            <td>{{ $mascota->nombre }}</td>
                            <td>{{ $mascota->especie }}</td>
                            <td>{{ $mascota->propietario->name ?? '-' }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalHistorialMascota{{ $mascota->id }}">Ver historial</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @foreach($mascotas as $mascota)
            <!-- Modal con el histórico de informes/citas de la mascota -->
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
                                    <tr data-historial-id="{{ $h->id }}">
                                        <td>{{ $h->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $h->diagnostico ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btn-ver-detalle" data-historial-id="{{ $h->id }}">Ver detalle</button>
                                            <a href="{{ route('pdf.historial.uno', ['id' => $h->id]) }}" class="btn btn-secondary btn-sm" target="_blank">Imprimir</a>
                                        </td>
                                    </tr>
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
    </div>
</div>
@endsection

@push('scripts')
<script>
let calendar = null;
function inicializarCalendarioVet() {
    console.log("Inicializando calendario...");
    var calendarEl = document.getElementById('user-calendar');
    if(calendarEl && !calendar) {
        var eventos = [
            @foreach($citas as $cita)
            {
                id: {{ $cita->id }},
                title: '{{ addslashes(($cita->mascota->nombre ?? "Mascota") . " - " . ($cita->motivo ?? "")) }}',
                start: '{{ $cita->fecha }}T{{ $cita->hora ?? "00:00" }}',
                color: @if($cita->estado === 'Pendiente') '#BDBDBD' @elseif($cita->estado === 'Cancelada') '#FFB3B3' @elseif($cita->informes->count() > 0) '#43b581' @else '#4A90E2' @endif,
                extendedProps: {
                    mascota_nombre: '{{ addslashes($cita->mascota->nombre ?? "") }}',
                    propietario_nombre: '{{ addslashes($cita->mascota->propietario->name ?? "") }}',
                    mascota_especie: '{{ addslashes($cita->mascota->especie ?? "") }}',
                    mascota_raza: '{{ addslashes($cita->mascota->raza ?? "") }}',
                    mascota_edad: '{{ $cita->mascota ? $cita->mascota->calcularEdad() : "" }}',
                    motivo: '{{ addslashes($cita->motivo ?? "") }}',
                    con_informe: {{ $cita->informes->count() > 0 ? 'true' : 'false' }}
                }
            },
            @endforeach
        ];
        console.log("Eventos para el calendario:", eventos);
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
            firstDay: 1,
            hiddenDays: [],
            events: eventos,
            eventClick: function(info) {
                var event = info.event;
                var props = event.extendedProps || {};
                $('#informe-nombre-mascota').val(props.mascota_nombre || '');
                $('#informe-propietario').val(props.propietario_nombre || '');
                $('#informe-especie').val(props.mascota_especie || '');
                $('#informe-raza').val(props.mascota_raza || '');
                $('#informe-edad').val(props.mascota_edad || '');
                $('#informe-fecha-hora').val(event.start ? event.start.toLocaleString() : '');
                $('#informe-motivo').val(props.motivo || '');
                $('#informe-diagnostico').val('');
                $('#informe-procedimientos').val('');
                $('#informe-medicamentos').val('');
                $('#informe-tratamiento').val('');
                $('#informe-recomendaciones').val('');
                $('#informe-observaciones').val('');
                $('#informe-proxima-cita').val('');
                $('#informe-archivo-adjunto').val('');
                $('#form-informe-cita').attr('action', '/citas/' + event.id + '/informe');
                var modal = new bootstrap.Modal(document.getElementById('modalInformeCita'));
                modal.show();
            },
            eventDidMount: function(info) {
                if(info.event.extendedProps && info.event.extendedProps.con_informe) {
                    info.el.classList.add('cita-realizada');
                }
            },
        });
        calendar.render();
    }
}

$(document).ready(function() {
    // Inicializar calendario solo si la sección de citas está visible al cargar
    if(window.location.hash === '#citas' || window.location.hash === '' || window.location.hash === '#') {
        inicializarCalendarioVet();
    }
    // Al pulsar la pestaña Citas, destruir e inicializar el calendario SIEMPRE
    $('#btn-citas').on('click', function(e) {
        setTimeout(function() {
            if(calendar) {
                calendar.destroy();
                calendar = null;
            }
            inicializarCalendarioVet();
        }, 100);
    });
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
        var historialId = $(this).data('historial-id');
        var mascotaId = $(this).closest('table').attr('id').replace('tabla-historico-', '');
        var detalleDiv = $('#detalle-historial-' + mascotaId);
        var historiales = @json($historiales);
        var historial = historiales.find(h => h.id == historialId);
        if(historial) {
            var html = `<div class='card'><div class='card-body'>
                <h6>Detalle del informe</h6>
                <p><b>Fecha creación:</b> ${historial.created_at}</p>
                <p><b>Diagnóstico:</b> ${historial.diagnostico ?? '-'}</p>
                <p><b>Procedimientos:</b> ${historial.procedimientos ?? '-'}</p>
                <p><b>Medicamentos:</b> ${historial.medicamentos ?? '-'}</p>
                <p><b>Tratamiento:</b> ${historial.tratamiento ?? '-'}</p>
                <p><b>Recomendaciones:</b> ${historial.recomendaciones ?? '-'}</p>
                <p><b>Observaciones:</b> ${historial.observaciones ?? '-'}</p>
                <p><b>Próxima cita:</b> ${historial.proxima_cita ?? '-'}</p>
            </div></div>`;
            detalleDiv.html(html).show();
        }
    });
    // Ocultar el detalle al cerrar el modal
    $('[id^=modalHistorialMascota]').on('hidden.bs.modal', function () {
        $(this).find('[id^=detalle-historial-]').hide().html('');
    });
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
    // Buscador para historiales
    $('#input-buscador-historiales').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#tabla-historiales-vet tbody tr').filter(function() {
            $(this).toggle($(this).find('td').eq(0).text().toLowerCase().indexOf(value) > -1 ||
                           $(this).find('td').eq(2).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Buscador para mascotas
    $('#input-buscador-mascotas').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#tabla-mascotas-vet tbody tr').filter(function() {
            $(this).toggle($(this).find('td').eq(0).text().toLowerCase().indexOf(value) > -1 ||
                           $(this).find('td').eq(2).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

<link href="{{ asset('css/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/fullcalendar-custom.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
@endpush
