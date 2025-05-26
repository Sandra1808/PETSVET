<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mascota;
use App\Models\Historial;
use App\Models\Cita;

class HomeController extends Controller
{
    /**
     * Mostrar la vista principal del usuario autenticado.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'veterinario') {
            return redirect()->route('citas.index');
        }
        $mascotas = Mascota::where('propietario_id', $user->id)->get();
        $historiales = Historial::whereHas('mascota', function ($query) use ($user) {
            $query->where('propietario_id', $user->id);
        })->with(['mascota', 'informes.cita', 'informes.veterinario'])->get();
        $citas = Cita::where(function ($query) use ($user) {
            $query->where('propietario_id', $user->id)
                  ->orWhere('veterinario_id', $user->id);
        })->with('mascota')->get();

        return view('propietario', compact('user', 'mascotas', 'historiales', 'citas'));
    }
}
