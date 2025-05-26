@extends('layouts.app')

@section('title', 'Bienvenido a Pet\'s Vet')

@section('content')
    <div class="text-center mt-5">
        <h1 class="fw-bold text-danger">Bienvenido a Pet's Vet 🐾</h1>
        <p class="text-muted">Cuidamos de tu mascota con amor.</p>

        <img src="{{ asset('img/veterinarios.jpg') }}" class="img-fluid rounded shadow-lg mt-4" alt="Veterinarios atendiendo mascotas">
        <div class="mt-3">
        </div>
    </div>
@endsection
