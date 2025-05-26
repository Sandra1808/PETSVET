@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center" style="color:#FFA500;">Registrar Mascota</h2>
                    <form method="POST" action="{{ route('mascotas.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="especie" class="form-label fw-bold">Especie</label>
                            <input type="text" class="form-control" id="especie" name="especie" value="{{ old('especie') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="raza" class="form-label fw-bold">Raza</label>
                            <input type="text" class="form-control" id="raza" name="raza" value="{{ old('raza') }}">
                        </div>
                        <div class="mb-3">
                            <label for="microchip" class="form-label fw-bold">Microchip</label>
                            <input type="text" class="form-control" id="microchip" name="microchip" value="{{ old('microchip') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="sexo" class="form-label fw-bold">Sexo</label>
                            <select class="form-control" id="sexo" name="sexo" required>
                                <option value="">Selecciona...</option>
                                <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                                <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label fw-bold">Domicilio</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{ old('domicilio') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label fw-bold">Foto de la mascota</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-warning px-4 fw-bold" style="background:#FFA500; color:#fff;">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
