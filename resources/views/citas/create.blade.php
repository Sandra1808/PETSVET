@extends('layouts.app')

@section('content')
<h1>Crear Cita</h1>

<form action="{{ route('citas.store') }}" method="POST" id="form-cita">
    @csrf
    <div class="mb-3">
        <label for="propietario" class="form-label">Propietario</label>
        <input type="text" id="propietario" name="propietario_nombre" class="form-control" autocomplete="off" required>
        <input type="hidden" id="propietario_id" name="propietario_id">
        <div id="propietario-list" class="list-group position-absolute" style="z-index: 10;"></div>
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
            @foreach($veterinarios as $vet)
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
    <button type="submit" class="btn btn-success">Crear Cita</button>
</form>
@endsection

@section('scripts')
<script>
// Autocomplete de propietario
let propietarioInput = document.getElementById('propietario');
let propietarioList = document.getElementById('propietario-list');
let propietarioIdInput = document.getElementById('propietario_id');

propietarioInput.addEventListener('input', function() {
    let query = this.value;
    if (query.length < 2) {
        propietarioList.innerHTML = '';
        return;
    }
    fetch('/api/propietarios/autocomplete?query=' + encodeURIComponent(query))
        .then(res => res.json())
        .then(data => {
            propietarioList.innerHTML = '';
            data.forEach(function(item) {
                let option = document.createElement('button');
                option.type = 'button';
                option.className = 'list-group-item list-group-item-action';
                option.textContent = item.name + ' (' + item.email + ')';
                option.onclick = function() {
                    propietarioInput.value = item.name;
                    propietarioIdInput.value = item.id;
                    propietarioList.innerHTML = '';
                    cargarMascotas(item.id);
                };
                propietarioList.appendChild(option);
            });
        });
});

// Cargar mascotas del propietario seleccionado
function cargarMascotas(propietarioId) {
    fetch('/api/mascotas/by-propietario/' + propietarioId)
        .then(res => res.json())
        .then(data => {
            let mascotaSelect = document.getElementById('mascota_id');
            mascotaSelect.innerHTML = '<option value="">Selecciona una mascota</option>';
            data.forEach(function(mascota) {
                let option = document.createElement('option');
                option.value = mascota.id;
                option.textContent = mascota.nombre;
                mascotaSelect.appendChild(option);
            });
        });
}
</script>
@endsection
