<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que solo usuarios autenticados accedan
    }

    public function propietarios()
    {
        $propietarios = User::where('role', 'propietario')->get();
        return view('propietarios.index', compact('propietarios'));
    }

    public function veterinarios()
    {
        $veterinarios = User::where('role', 'veterinario')->get();
        return view('veterinarios.index', compact('veterinarios'));
    }

    public function editPropietario(User $user)
    {
        return view('propietarios.edit', compact('user'));
    }

    public function editVeterinario(User $user)
    {
        return view('veterinarios.edit', compact('user'));
    }

    public function updatePropietario(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'dni' => 'nullable|string|size:9',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->fill($request->only(['name', 'email', 'dni']));
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('propietarios.edit', $user)->with('success', 'Perfil actualizado correctamente.');
    }

    public function updateVeterinario(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'dni' => 'nullable|string|size:9',
            'especialidad' => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->fill($request->only(['name', 'email', 'dni', 'especialidad']));
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('veterinarios.edit', $user)->with('success', 'Perfil actualizado correctamente.');
    }

    public function autocompletePropietarios(Request $request)
    {
        $query = $request->input('query');
        $propietarios = \App\Models\User::where('role', 'propietario')
            ->where('name', 'like', '%' . $query . '%')
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get();
        return response()->json($propietarios);
    }
}
