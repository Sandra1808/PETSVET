@extends('layouts.app')

@section('content')
<h2>Editar Perfil Veterinario</h2>
<form method="POST" action="{{ route('veterinarios.update', ['user' => $user->id]) }}">
    @csrf
    <label>Nombre:</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

    <label>DNI:</label>
    <input type="text" name="dni" value="{{ old('dni', $user->dni) }}">

    <label>Especialidad:</label>
    <input type="text" name="especialidad" value="{{ old('especialidad', $user->especialidad) }}" required>

    <label>Contraseña (opcional):</label>
    <input type="password" name="password">
    <input type="password" name="password_confirmation">

    <button type="submit">Guardar Cambios</button>
</form>
@endsection
