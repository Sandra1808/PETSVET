<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Mascota;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Informe;

class CitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'veterinario') {
            return redirect()->route('veterinario.panel');
        }

        if ($user->role === 'propietario') {
            $citas = Cita::where('propietario_id', $user->id)->with('mascota')->get();
        } else {
            $citas = Cita::where(function ($query) use ($user) {
                $query->where('propietario_id', $user->id)
                      ->orWhere('veterinario_id', $user->id);
            })->with('mascota')->get();
        }

        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $mascotas = Mascota::all();
        $veterinarios = User::where('role', 'veterinario')->get(); // Obtener veterinarios
        return view('citas.create', compact('mascotas', 'veterinarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
            'propietario_id' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        $data = $request->all();
        
        // Si es propietario, la cita se crea como pendiente
        if ($user->role === 'propietario') {
            $data['propietario_id'] = $user->id;
            $data['estado'] = 'Pendiente';
        } 
        // Si es admin o veterinario, la cita se crea como confirmada
        else if ($user->role === 'admin' || $user->role === 'veterinario') {
            $data['estado'] = 'Confirmada';
        }

        // Validar que no haya solapamiento de cita para el veterinario solo si es confirmada
        $existe = \App\Models\Cita::where('veterinario_id', $request->veterinario_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('estado', 'Confirmada')
            ->exists();

        if ($existe && (!isset($data['estado']) || $data['estado'] === 'Confirmada')) {
            return back()->withErrors(['hora' => 'El veterinario ya tiene una cita confirmada en esa fecha y hora.'])->withInput();
        }

        \App\Models\Cita::create($data);

        if ($user->role === 'propietario') {
            return redirect()->route('citas.index')->with('success', 'Solicitud de cita enviada. Espera confirmación.');
        }
        return redirect()->route('admin')->with('success', 'Cita creada correctamente.');
    }

    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        $mascotas = Mascota::all();
        $veterinarios = User::where('role', 'veterinario')->get();
        return view('citas.edit', compact('cita', 'mascotas', 'veterinarios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'propietario_id' => 'required|exists:users,id',
            'veterinario_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }

    // Calendario de administración: todas las citas
    public function adminIndex()
    {
        $citas = Cita::with(['veterinario', 'mascota.propietario'])->get();
        return view('admin.citas', compact('citas'));
    }

    // Endpoint JSON para FullCalendar en administración
    public function adminCitasJson()
    {
        $citas = Cita::with(['veterinario', 'mascota.propietario', 'informes'])->get();
        $eventos = $citas->map(function($cita) {
            $tieneInforme = $cita->informes->count() > 0;
            $color = match(true) {
                $cita->estado === 'Pendiente' => '#808080',
                $cita->estado === 'Cancelada' => '#fff',
                $tieneInforme => '#43b581', // Verde profesional para realizadas con informe
                default => $cita->veterinario->color_calendario ?? '#B5D8FF'
            };

            return [
                'id' => $cita->id,
                'title' => ($cita->mascota->nombre ?? 'Mascota') . ' - ' . ($cita->veterinario->name ?? 'Veterinario'),
                'start' => $cita->fecha . 'T' . ($cita->hora ?? '00:00'),
                'color' => $color,
                'className' => $cita->estado === 'Cancelada' ? 'cita-cancelada' : ($tieneInforme ? 'cita-realizada' : ''),
                'extendedProps' => [
                    'mascota_id' => $cita->mascota_id,
                    'mascota' => $cita->mascota->nombre ?? '-',
                    'propietario_id' => $cita->mascota->propietario->id ?? null,
                    'propietario' => $cita->mascota->propietario->name ?? '-',
                    'veterinario_id' => $cita->veterinario_id,
                    'veterinario' => $cita->veterinario->name ?? '-',
                    'motivo' => $cita->motivo ?? '',
                    'fecha' => $cita->fecha,
                    'hora' => $cita->hora,
                    'estado' => $cita->estado ?? 'Pendiente',
                    'con_informe' => $tieneInforme
                ]
            ];
        });
        return response()->json($eventos);
    }

    public function confirmar($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'Confirmada';
        $cita->save();

        // Lógica para crear historial automáticamente si no existe
        $historial = \App\Models\Historial::where('mascota_id', $cita->mascota_id)->first();
        if (!$historial) {
            \App\Models\Historial::create([
                'mascota_id' => $cita->mascota_id,
                'propietario_id' => $cita->mascota->propietario_id,
                'n_historial' => \App\Models\Historial::generarCodigoHistorial(),
                'tipo' => '', // Puedes ajustar según tu lógica
                'descripcion' => '',
                'fecha' => now(),
                'archivo_pdf' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Cita confirmada correctamente.');
    }

    public function rechazar($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'Cancelada';
        $cita->save();
        return redirect()->back()->with('success', 'Cita rechazada correctamente.');
    }

    public function show($id)
    {
        $cita = \App\Models\Cita::with(['mascota.propietario', 'veterinario'])->findOrFail($id);
        return response()->json([
            'id' => $cita->id,
            'mascota_id' => $cita->mascota_id,
            'mascota' => $cita->mascota->nombre,
            'propietario_id' => $cita->mascota->propietario->id ?? null,
            'propietario' => $cita->mascota->propietario->name ?? '',
            'veterinario_id' => $cita->veterinario_id,
            'veterinario' => $cita->veterinario->name ?? '',
            'motivo' => $cita->motivo,
            'fecha' => $cita->fecha,
            'hora' => $cita->hora,
            'estado' => $cita->estado,
        ]);
    }

    public function guardarInforme(Request $request, $id)
    {
        $cita = Cita::with('mascota')->findOrFail($id);
        // Buscar el historial de la mascota (uno por mascota)
        $historial = \App\Models\Historial::where('mascota_id', $cita->mascota_id)->first();
        if (!$historial) {
            // Si no existe, lo creamos (esto solo debería pasar si hay mascotas nuevas sin historial)
            $historial = \App\Models\Historial::create([
                'mascota_id' => $cita->mascota_id,
                'propietario_id' => $cita->mascota->propietario_id,
                'n_historial' => \App\Models\Historial::generarCodigoHistorial(),
                'tipo' => '',
                'descripcion' => '',
                'fecha' => now(),
                'archivo_pdf' => null,
            ]);
        }
        // Crear un nuevo informe asociado al historial y a la cita
        $informe = Informe::create([
            'historial_id' => $historial->id,
            'cita_id' => $cita->id,
            'veterinario_id' => $cita->veterinario_id,
            'diagnostico' => $request->input('diagnostico'),
            'procedimientos' => $request->input('procedimientos'),
            'medicamentos' => $request->input('medicamentos'),
            'tratamiento' => $request->input('tratamiento'),
            'recomendaciones' => $request->input('recomendaciones'),
            'observaciones' => $request->input('observaciones'),
            'proxima_cita' => $request->input('proxima_cita'),
        ]);
        // Guardar archivo adjunto si existe
        if ($request->hasFile('archivo_adjunto')) {
            $file = $request->file('archivo_adjunto');
            $path = $file->store('informes_adjuntos', 'public');
            $informe->archivo_pdf = $path;
            $informe->save();
        }
        return redirect()->back()->with('success', 'Informe de cita guardado correctamente.');
    }

    // Mostrar formulario para crear informe de cita
    public function formInforme($id)
    {
        $cita = Cita::with('mascota')->findOrFail($id);
        $mascota = $cita->mascota;
        // Puedes crear una vista específica o reutilizar la de historiales.create
        return view('historiales.create', compact('mascota', 'cita'));
    }
}
