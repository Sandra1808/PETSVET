<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Mascota;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function create()
    {
        // Obtener los datos necesarios para la vista de administración
        $veterinarios = \App\Models\User::where('role', 'veterinario')->get();
        $mascotas = \App\Models\Mascota::with('propietario')->get();
        $tab = 'personal';
        return view('admin.index', compact('veterinarios', 'mascotas', 'tab'));
    }

    public function index()
    {
        $citas = Cita::with(['veterinario', 'mascota.propietario', 'informes'])->get();
        $veterinarios = User::where('puesto', 'veterinario')->get();
        $mascotas = Mascota::with('propietario')->get();

        return view('admin.index', compact('citas', 'veterinarios', 'mascotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'puesto' => 'required|string|max:255',
            'dni' => 'required',
        ]);

        // Generar código de personal único
        $ultimo = User::max('id') + 1;
        $codigo = 'EMP' . str_pad($ultimo, 3, '0', STR_PAD_LEFT);

        // Generar contraseña aleatoria
        $password = Str::random(8);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'password_visible' => Crypt::encryptString($password),
            'codigo_personal' => $codigo,
            'puesto' => $request->puesto,
            'role' => $request->puesto === 'veterinario' ? 'veterinario' : 'trabajador',
            'dni' => $request->dni,
        ]);

        return redirect('/admin')
            ->with('success', 'Usuario creado correctamente. Código: ' . $codigo)
            ->with('pw_real', $password)
            ->with('pw_user_id', $user->id);
    }

    public function verPw(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'admin_password' => 'required',
        ]);

        $admin = Auth::user();
        if (!Hash::check($request->admin_password, $admin->password)) {
            return back()->with('error', 'Contraseña de administrador incorrecta.');
        }

        $user = User::find($request->user_id);
        $pw = $user->password_visible ? Crypt::decryptString($user->password_visible) : 'No disponible';
        return back()->with('pw_real', $pw)->with('pw_user_id', $user->id);
    }

    public function propietariosAutocomplete(Request $request)
    {
        $search = $request->q;
        $propietarios = \App\Models\User::where('role', 'propietario')
            ->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('dni', 'like', "%$search%")
                  ->orWhere('codigo_personal', 'like', "%$search%")
                  ;
            })
            ->select('id', 'name')
            ->limit(20)
            ->get();
        $results = $propietarios->map(function($p) {
            return ['id' => $p->id, 'text' => $p->name];
        });
        return response()->json($results);
    }

    public function mascotasByPropietario($id)
    {
        $mascotas = \App\Models\Mascota::where('propietario_id', $id)->select('id', 'nombre')->get();
        return response()->json($mascotas);
    }

    public function citaDetalle($id)
    {
        $cita = \App\Models\Cita::with(['mascota.propietario', 'veterinario'])
            ->findOrFail($id);
        return response()->json([
            'mascota_nombre' => $cita->mascota->nombre ?? '',
            'propietario_nombre' => $cita->mascota->propietario->name ?? '',
            'veterinario_id' => $cita->veterinario_id,
            'motivo' => $cita->motivo,
            'fecha' => $cita->fecha,
            'hora' => $cita->hora,
            'estado' => $cita->estado,
        ]);
    }
}
