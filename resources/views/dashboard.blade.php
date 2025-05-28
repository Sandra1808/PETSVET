<x-app-layout>
    <div class="container" ">
        <!-- Navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-primary" href="#">PETSVET</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            @if(Auth::check())
                                <span class="nav-link fw-bold text-success">Bienvenido, {{ Auth::user()->name }}</span>
                            @else
                                <a class="nav-link btn btn-danger text-white px-3" href="{{ route('login') }}">Registro/Iniciar Sesión</a>
                            @endif
                        </li>
                    </ul>
                </div>  
                <!--colocar debajo del boton de inicio sesión-->             
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Servicios</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <div class="text-center">
            @if(Auth::check())
                <h2 class="fw-bold text-primary">Bienvenido, {{ Auth::user()->name }} 👋</h2>

                <!-- Secciones del usuario -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <a href="{{ route('mascotas.index') }}" class="btn btn-info w-100 py-3">Mis Mascotas</a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('historial.index') }}" class="btn btn-success w-100 py-3">Historial Médico</a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('citas.index') }}" class="btn btn-warning w-100 py-3">Mis Citas</a>
                    </div>
                </div>

            @else
                <h1 class="fw-bold text-danger">Bienvenido a PETSVET 🐾</h1>
                <p class="text-muted">Cuidamos de tu mascota con amor.</p>
                <div class="text-center">
                    <img src="{{ asset('img/veterinarios.jpg') }}" class="img-fluid rounded shadow-lg"  alt="Veterinarios atendiendo mascotas">
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
