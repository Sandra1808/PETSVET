@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Solicitudes de Citas Pendientes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Mascota</th>
                    <th>Veterinario</th>
                    <th>Propietario</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas->where('estado', 'Pendiente') as $cita)
                    <tr>
                        <td>{{ $cita->fecha }}</td>
                        <td>{{ $cita->hora ?? '-' }}</td>
                        <td>{{ $cita->mascota->nombre ?? '-' }}</td>
                        <td>{{ $cita->veterinario->name ?? '-' }}</td>
                        <td>{{ $cita->mascota->propietario->name ?? '-' }}</td>
                        <td>{{ $cita->motivo ?? '-' }}</td>
                        <td>
                            <form action="{{ route('admin.citas.confirmar', $cita->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
                            </form>
                            <form action="{{ route('admin.citas.rechazar', $cita->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-5">Calendario de todas las citas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Mascota</th>
                    <th>Veterinario</th>
                    <th>Propietario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ $cita->fecha }}</td>
                        <td>{{ $cita->hora ?? '-' }}</td>
                        <td>{{ $cita->mascota->nombre ?? '-' }}</td>
                        <td>{{ $cita->veterinario->name ?? '-' }}</td>
                        <td>{{ $cita->mascota->propietario->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection 