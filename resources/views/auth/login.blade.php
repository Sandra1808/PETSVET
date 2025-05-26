@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 350px; background-color: #E0F7FA;">
            <h3 class="text-center fw-bold text-danger">Registro / Inicio Sesión</h3>

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Campo Correo -->
                <div class="mb-3">
                    <label for="login" class="form-label text-success">Usuario o Correo Electrónico</label>
                    <input type="text" name="login" id="login" class="form-control" required>
                </div>

                <!-- Campo Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label text-success">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <!-- Botón Iniciar Sesión -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning w-100">Iniciar Sesión</button>
                </div>
            </form>

            <!-- Enlace para usuarios no registrados -->
            <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="text-success fw-bold">No estoy registrado</a>
            </div>
        </div>
    </div>
@endsection
