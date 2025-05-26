<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;
use App\Models\Mascota;
use Illuminate\Support\Facades\Auth;


class HistorialController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->role === 'veterinario') {
            return redirect()->route('veterinario.panel');
        }
        $query = Historial::query();
        if ($request->filled('mascota_id')) {
            $query->where('mascota_id', $request->mascota_id);
        } else {
            $query->whereHas('mascota', function ($q) {
                $q->where('propietario_id', Auth::id());
            });
        }
        $historiales = $query->with('mascota')->get();
        $mascotas = \App\Models\Mascota::where('propietario_id', Auth::id())->with('historiales.informes')->get();
        return view('historiales.index', compact('historiales', 'mascotas'));
    }

    public function create()
    {
        $mascotas = Mascota::all();
        return view('historiales.create', compact('mascotas'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['propietario_id'] = Auth::id();
        Historial::create($data);
        return redirect()->route('historiales.index')->with('success', 'Informe guardado correctamente.');
    }

    public function edit($id)
    {
        $historial = Historial::findOrFail($id);
        $mascotas = Mascota::all();
        return view('historiales.edit', compact('historial', 'mascotas'));
    }

    public function update(Request $request, $id)
    {
        $historial = Historial::findOrFail($id);
        $historial->update($request->all());
        return redirect()->route('historiales.index')->with('success', 'Historial actualizado.');
    }

    public function destroy($id)
    {
        Historial::destroy($id);
        return redirect()->route('historiales.index')->with('success', 'Historial eliminado.');
    }

    public function show($id)
    {
        // No hay vista show, así que redirigimos al index para evitar confusiones
        return redirect()->route('historiales.index');
    }
}
