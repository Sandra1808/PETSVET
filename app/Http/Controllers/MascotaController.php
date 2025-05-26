<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use Illuminate\Support\Facades\Auth;

class MascotaController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'veterinario') {
            return redirect()->route('veterinario.panel');
        }
        $mascotas = Mascota::where('propietario_id', Auth::id())->get(); // Filtrar por propietario autenticado
        return view('mascotas.index', compact('mascotas'));
    }

    public function create()
    {
        return view('mascotas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string',
            'raza' => 'nullable|string',
            'microchip' => 'required|string|unique:mascotas',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
            'sexo' => 'required|string',
            'domicilio' => 'required|string',
        ]);

        // Capturar automáticamente el propietario autenticado
        $validated['propietario_id'] = Auth::id();

        // Guardar imagen si se sube
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('mascotas', 'public');
            $validated['imagen'] = $path;
        }

        Mascota::create($validated);

        if (Auth::user()->role === 'propietario') {
            return redirect('/home#mascotas')->with('success', 'Mascota registrada correctamente.');
        }
        return redirect()->route('mascotas.index')->with('success', 'Mascota registrada correctamente.');
    }

    public function edit($id)
    {
        $mascota = Mascota::where('propietario_id', Auth::id())->findOrFail($id); // Asegurar que el propietario pueda editar solo sus mascotas
        return view('mascotas.edit', compact('mascota'));
    }

    public function update(Request $request, $id)
    {
        $mascota = Mascota::where('propietario_id', Auth::id())->findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string',
            'raza' => 'nullable|string',
            'microchip' => 'required|string|unique:mascotas,microchip,'.$mascota->id, // Evitar conflicto al actualizar
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
            'sexo' => 'required|string',
            'domicilio' => 'required|string',
        ]);

        // Guardar imagen si se sube
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('mascotas', 'public');
            $validated['imagen'] = $path;
        }

        $mascota->update($validated);

        if (Auth::user()->role === 'propietario') {
            return redirect('/home#mascotas')->with('success', 'Mascota actualizada correctamente.');
        }
        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada correctamente.');
    }

    public function destroy($id)
    {
        $mascota = Mascota::where('propietario_id', Auth::id())->findOrFail($id);
        $mascota->delete();

        return redirect()->route('mascotas.index')->with('success', 'Mascota eliminada correctamente.');
    }

    public function byPropietario($id)
    {
        $mascotas = \App\Models\Mascota::where('propietario_id', $id)
            ->select('id', 'nombre')
            ->get();
        return response()->json($mascotas);
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $mascotas = \App\Models\Mascota::with('propietario')
            ->where('nombre', 'like', "%{$query}%")
            ->orWhereHas('propietario', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get();
        $result = $mascotas->map(function($m) {
            return [
                'id' => $m->id,
                'nombre' => $m->nombre,
                'propietario' => $m->propietario->name ?? '-',
            ];
        });
        return response()->json($result);
    }
}
