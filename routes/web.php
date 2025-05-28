<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Landing page pública
Route::get('/', function () {
    return view('welcome');
})->name('homepage');

// Mostrar formulario de login (lo gestiona Laravel, pero si quieres vista custom)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Mostrar formulario de registro
Route::get('/register', function () {
    return view('auth.register');
})->name('register');


//Rutas Protegidas (requieren login)
Route::middleware(['auth'])->group(function () {

    // Home/dashboard tras login
    Route::get('/home', [HomeController::class, 'index'])
         ->name('home');

    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Perfiles de usuario
    Route::get('/propietarios/{user}/edit', [UserController::class, 'editPropietario'])
         ->name('propietarios.edit');
    Route::post('/propietarios/{user}', [UserController::class, 'updatePropietario'])
         ->name('propietarios.update');

    Route::get('/veterinarios/{user}/edit', [UserController::class, 'editVeterinario'])
         ->name('veterinarios.edit');
    Route::post('/veterinarios/{user}', [UserController::class, 'updateVeterinario'])
         ->name('veterinarios.update');

    // Recursos principales
    Route::resource('mascotas', MascotaController::class);
    Route::resource('citas', CitaController::class);
    Route::resource('historiales', HistorialController::class);

    // Endpoints AJAX para autocomplete y mascotas por propietario
    Route::get('/api/propietarios/autocomplete', [UserController::class, 'autocompletePropietarios']);
    Route::get('/api/mascotas/by-propietario/{id}', [MascotaController::class, 'byPropietario']);
    Route::get('/api/mascotas/buscar', [MascotaController::class, 'buscar']);
});

//Panel de Administración
Route::get('/admin', function() {
    $veterinarios = \App\Models\User::where('role', 'veterinario')->get();
    $mascotas = \App\Models\Mascota::with('propietario')->get();
    $citas = \App\Models\Cita::with(['veterinario', 'mascota.propietario', 'informes'])->get();
    return view('admin.index', compact('veterinarios', 'mascotas', 'citas'));
})->name('admin');

// Rutas para gestión de usuarios por el admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/usuarios/crear', [AdminUserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/admin/usuarios', [AdminUserController::class, 'store'])->name('admin.usuarios.store');
    Route::post('/admin/usuarios/verpw', [AdminUserController::class, 'verPw'])->name('admin.usuarios.verpw');
    Route::get('/admin/citas', [App\Http\Controllers\CitaController::class, 'adminIndex'])->name('admin.citas');
    Route::get('/admin/mascotas', function() {
        $veterinarios = \App\Models\User::where('role', 'veterinario')->get();
        $mascotas = \App\Models\Mascota::with('propietario')->get();
        $tab = 'mascotas';
        return view('admin.index', compact('veterinarios', 'mascotas', 'tab'));
    })->name('admin.mascotas');
    Route::get('/admin/citas/json', [App\Http\Controllers\CitaController::class, 'adminCitasJson'])->name('admin.citas.json');
    Route::post('/admin/citas/{cita}/confirmar', [App\Http\Controllers\CitaController::class, 'confirmar'])->name('admin.citas.confirmar');
    Route::post('/admin/citas/{cita}/rechazar', [App\Http\Controllers\CitaController::class, 'rechazar'])->name('admin.citas.rechazar');

    // Rutas AJAX para Select2 y detalles de cita
    Route::get('/admin/propietarios/autocomplete', [AdminUserController::class, 'propietariosAutocomplete'])->name('admin.propietarios.autocomplete');
    Route::get('/admin/mascotas/by-propietario/{id}', [AdminUserController::class, 'mascotasByPropietario'])->name('admin.mascotas.byPropietario');
    Route::get('/admin/citas/{id}/detalle', [AdminUserController::class, 'citaDetalle'])->name('admin.citas.detalle');
});

// Login exclusivo para administración
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Panel de Veterinario
Route::get('/veterinario', [App\Http\Controllers\VeterinarioController::class, 'panel'])
    ->middleware(['auth', 'role:veterinario'])
    ->name('veterinario.panel');

//Rutas de Autenticación de Laravel
Auth::routes();

Route::get('/historiales/pdf/{id}', [App\Http\Controllers\PDFController::class, 'generarHistorialesPDF'])->name('pdf.historiales');
Route::get('/pdf/informe/{id}', [App\Http\Controllers\PDFController::class, 'generarInforme'])->name('pdf.informe');
Route::get('/pdf/informe/{id}', [App\Http\Controllers\PDFController::class, 'generarInforme'])->name('pdf.informe');



Route::post('/citas/{id}/informe', [App\Http\Controllers\CitaController::class, 'guardarInforme'])->name('citas.guardarInforme');

// Formulario para crear informe de cita (GET)
Route::get('/citas/{id}/informe', [App\Http\Controllers\CitaController::class, 'formInforme'])->name('citas.formInforme');

Route::get('/mascotas/{mascota_id}/historiales/pdf', [App\Http\Controllers\PDFController::class, 'generarHistorialesMascotaPDF'])->name('pdf.historiales.mascota');

Route::get('/historiales/{id}/pdf', [App\Http\Controllers\PDFController::class, 'generarHistorialPDF'])->name('pdf.historial.uno');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

