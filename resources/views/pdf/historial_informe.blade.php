<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Médico - PetsVet</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        .header { display: flex; align-items: center; border-bottom: 2px solid #FFA500; margin-bottom: 20px; padding-bottom: 10px; }
        .logo { height: 60px; margin-right: 20px; }
        .title { font-size: 1.7em; font-weight: bold; color: #FFA500; }
        .section { margin-bottom: 18px; }
        .label { font-weight: bold; color: #FFA500; }
        .datos { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <span class="title">PetsVet - Informe Médico Veterinario</span>
    </div>
    <div class="section">
        <span class="label">Propietario:</span> {{ $historial->mascota->propietario->name ?? '-' }}<br>
        <span class="label">DNI:</span> {{ $historial->mascota->propietario->dni ?? '-' }}<br>
        <span class="label">Dirección:</span> {{ $historial->mascota->propietario->direccion ?? '-' }}
    </div>
    <div class="section">
        <span class="label">Mascota:</span> {{ $historial->mascota->nombre ?? '-' }}<br>
        <span class="label">Especie:</span> {{ $historial->mascota->especie ?? '-' }}<br>
        <span class="label">Fecha de nacimiento:</span> {{ $historial->mascota->fecha_nacimiento ?? '-' }}
    </div>
    <div class="section">
        <span class="label">Veterinario responsable:</span> {{ $historial->veterinario->name ?? '-' }}<br>
        <span class="label">Nº Colegiado:</span> {{ $historial->veterinario->dni ?? '-' }}
    </div>
    <div class="section">
        <span class="label">Fecha y hora de la cita:</span> {{ $historial->cita->fecha ?? '-' }} {{ $historial->cita->hora ?? '' }}<br>
        <span class="label">Motivo de la consulta:</span> {{ $historial->cita->motivo ?? '-' }}
    </div>
    <div class="section">
        <p>Acude a consulta el propietario <b>{{ $historial->mascota->propietario->name ?? '-' }}</b>, con DNI <b>{{ $historial->mascota->propietario->dni ?? '-' }}</b> y dirección <b>{{ $historial->mascota->propietario->direccion ?? '-' }}</b>, responsable de la mascota <b>{{ $historial->mascota->nombre ?? '-' }}</b> de especie <b>{{ $historial->mascota->especie ?? '-' }}</b> y fecha de nacimiento <b>{{ $historial->mascota->fecha_nacimiento ?? '-' }}</b>. La consulta se realiza el día <b>{{ $historial->cita->fecha ?? '-' }}</b> a las <b>{{ $historial->cita->hora ?? '-' }}</b> por el motivo: <b>{{ $historial->cita->motivo ?? '-' }}</b>.</p>
        <p>Durante la consulta se realizan los siguientes procedimientos: <b>{{ $historial->procedimientos ?? '-' }}</b>.</p>
        <p>El diagnóstico es: <b>{{ $historial->diagnostico ?? '-' }}</b>.</p>
        <p>Se aplican los siguientes tratamientos: <b>{{ $historial->tratamiento ?? '-' }}</b> y medicamentos: <b>{{ $historial->medicamentos ?? '-' }}</b>.</p>
        <p>Las recomendaciones dadas al propietario son: <b>{{ $historial->recomendaciones ?? '-' }}</b>.</p>
        <p>Observaciones adicionales: <b>{{ $historial->observaciones ?? '-' }}</b>.</p>
        <p>Próxima revisión recomendada: <b>{{ $historial->proxima_cita ?? '-' }}</b>.</p>
    </div>
    <div class="section" style="margin-top:40px;">
        <span class="label">Firma del veterinario:</span>
        <div style="height:60px;"></div>
        <span>{{ $historial->veterinario->name ?? '-' }}</span>
    </div>
    @include('pdf.contacto_clinica')
</body>
</html> 