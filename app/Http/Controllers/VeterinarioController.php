<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Historial;

class VeterinarioController extends Controller
{
    public function panel()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $mascotas = Mascota::with(['propietario', 'historiales'])->get();
        $historiales = Historial::with('mascota')->get();
        $citas = \App\Models\Cita::where('veterinario_id', $user->id)
            ->with(['mascota.propietario', 'informes'])
            ->get();
        return view('veterinarios.index', compact('mascotas', 'historiales', 'citas'));
    }
} 