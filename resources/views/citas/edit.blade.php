@extends('layouts.app')

@section('content')
<h1>Editar Cita</h1>

<form action="{{ route('citas.update', $cita->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Mascota:</label>
    <select name="mascota_id">
        @foreach($mascotas as $mascota)
            <option value="{{ $mascota->id }}" @if($cita->mascota_id == $mascota->id) selected @endif>{{ $mascota->nombre }}</option>
        @endforeach
    </select><br>

    <label>Motivo:</label>
    <input type="text" name="motivo" value="{{ $cita->motivo }}"><br>

    <label>Fecha:</label>
    <input type="datetime-local" name="fecha" value="{{ \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d\TH:i') }}"><br>

    <button type="submit">Actualizar</button>
</form>
@endsection
