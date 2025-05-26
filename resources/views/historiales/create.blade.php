@extends('layouts.app')

@section('content')
<h1>Crear Historial Médico</h1>

<form action="{{ route('historiales.store') }}" method="POST">
    @csrf
    <label>Mascota:</label>
    @if(isset($mascota))
        <input type="hidden" name="mascota_id" value="{{ $mascota->id }}">
        <span>{{ $mascota->nombre }}</span><br>
    @else
        <select name="mascota_id">
            @foreach($mascotas as $mascota)
                <option value="{{ $mascota->id }}">{{ $mascota->nombre }}</option>
            @endforeach
        </select><br>
    @endif

    <label>Diagnóstico:</label>
    <textarea name="diagnostico"></textarea><br>

    <label>Procedimientos:</label>
    <textarea name="procedimientos"></textarea><br>

    <label>Medicamentos:</label>
    <textarea name="medicamentos"></textarea><br>

    <label>Tratamiento:</label>
    <textarea name="tratamiento"></textarea><br>

    <label>Recomendaciones:</label>
    <textarea name="recomendaciones"></textarea><br>

    <label>Observaciones:</label>
    <textarea name="observaciones"></textarea><br>

    <label>Próxima cita:</label>
    <input type="date" name="proxima_cita"><br>

    <label>Fecha:</label>
    <input type="date" name="fecha"><br>

    <button type="submit">Guardar</button>
</form>
@endsection
