@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5" style="color:#C62828; font-size:2.5rem; font-weight:bold;">Contacto</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-white shadow rounded-4 p-4" style="font-size:1.15rem;">
                <ul class="list-unstyled mb-4">
                    <li class="mb-2">
                        <span class="fw-bold" style="color:#B71C1C;"><i class="bi bi-geo-alt-fill me-2"></i>Dirección:</span>
                        Calle Ejemplo, Nº 0, Ciudad Ficticia
                    </li>
                    <li class="mb-2">
                        <span class="fw-bold" style="color:#B71C1C;"><i class="bi bi-telephone-fill me-2"></i>Teléfono:</span>
                        999 999 999
                    </li>
                    <li class="mb-2">
                        <span class="fw-bold" style="color:#B71C1C;"><i class="bi bi-envelope-fill me-2"></i>Correo Electrónico:</span>
                        contacto@petsvet.fake
                    </li>
                    <li class="mb-2">
                        <span class="fw-bold" style="color:#B71C1C;"><i class="bi bi-clock-fill me-2"></i>Horario de la Clínica:</span> <br>
                        <span class="ms-3"><i class="bi bi-clock me-1"></i>Lunes a Viernes: 00:00 - 00:00</span> <br>
                        <span class="ms-3"><i class="bi bi-clock me-1"></i>Sábados: 00:00 - 00:00</span> <br>
                        <span class="ms-3 text-danger"><i class="bi bi-slash-circle me-1"></i>Domingos cerrado</span>
                    </li>
                </ul>
                <div class="mb-2">
                    <span class="fw-bold" style="color:#B71C1C;"><i class="bi bi-share-fill me-2"></i>Redes Sociales:</span>
                    <span class="ms-2"><i class="bi bi-instagram" style="color:#1976D2;"></i> <span class="badge bg-light text-dark">@petsvet_falso</span></span>
                    <span class="ms-3"><i class="bi bi-facebook" style="color:#1976D2;"></i> <span class="badge bg-light text-dark">Pet's Vet Fake</span></span>
                    <span class="ms-3"><i class="bi bi-twitter-x" style="color:#1976D2;"></i> <span class="badge bg-light text-dark">@PetsVet_000</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 