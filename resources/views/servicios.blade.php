@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5" style="color:#C62828; font-size:2.8rem; font-weight:bold;">Nuestros Servicios</h1>
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card shadow border-0 rounded-4 w-100 text-center p-3">
                <img src="/img/revisión.png" class="card-img-top mx-auto" alt="Consultas Generales" style="height:400px; width:100%; object-fit:cover; border-radius:18px;">
                <div class="card-body">
                    <h4 class="card-title mt-3 mb-2" style="color:#B71C1C; font-weight:bold;">Consultas Generales</h4>
                    <p class="card-text">Ofrecemos consultas de salud general para perros, gatos y otras mascotas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card shadow border-0 rounded-4 w-100 text-center p-3">
                <img src="/img/vacunacion.png" class="card-img-top mx-auto" alt="Vacunación" style="height:400px; width:100%; object-fit:cover; border-radius:18px;">
                <div class="card-body">
                    <h4 class="card-title mt-3 mb-2" style="color:#B71C1C; font-weight:bold;">Vacunación</h4>
                    <p class="card-text">Proporcionamos un programa completo de vacunación para proteger a tu mascota.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card shadow border-0 rounded-4 w-100 text-center p-3">
                <img src="/img/cirugia.png" class="card-img-top mx-auto" alt="Cirugía" style="height:400px; width:100%; object-fit:cover; border-radius:18px;">
                <div class="card-body">
                    <h4 class="card-title mt-3 mb-2" style="color:#B71C1C; font-weight:bold;">Cirugía</h4>
                    <p class="card-text">Realizamos cirugías con equipos avanzados y técnicas seguras.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 