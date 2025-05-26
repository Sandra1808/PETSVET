@extends('layouts.app')

@section('content')
<h1>Editar Historial Médico</h1>

<form action="{{ route('historiales.update', $historial->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Mascota:</label>
    <select name="mascota_id">
        @foreach($mascotas as $mascota)
            <option value="{{ $mascota->id }}" @if($historial->mascota_id == $mascota->id) selected @endif>{{ $mascota->nombre }}</option>
        @endforeach
    </select><br>

    <label>Diagnóstico:</label>
    <textarea name="diagnostico">{{ $historial->diagnostico }}</textarea><br>

    <label>Procedimientos:</label>
    <textarea name="procedimientos">{{ $historial->procedimientos }}</textarea><br>

    <label>Medicamentos:</label>
    <textarea name="medicamentos">{{ $historial->medicamentos }}</textarea><br>

    <label>Tratamiento:</label>
    <textarea name="tratamiento">{{ $historial->tratamiento }}</textarea><br>

    <label>Recomendaciones:</label>
    <textarea name="recomendaciones">{{ $historial->recomendaciones }}</textarea><br>

    <label>Observaciones:</label>
    <textarea name="observaciones">{{ $historial->observaciones }}</textarea><br>

    <label>Próxima cita:</label>
    <input type="date" name="proxima_cita" value="{{ $historial->proxima_cita }}"><br>

    <label>Fecha:</label>
    <input type="date" name="fecha" value="{{ $historial->fecha }}"><br>

    <button type="submit">Actualizar</button>
</form>
@endsection
