<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'role',
        'codigo_personal',
        'puesto',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'colegiado', 
        'password_visible'        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //relaciones con las tablas
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'propietario_id');
    }

    public function historiales()
    {
        return $this->hasMany(Historial::class, 'propietario_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'propietario_id');
    }

    //roles de usuario
    public function isPropietario()
    {
        return $this->role === 'propietario';
    }   

    public function isVeterinario()
    {
        return $this->role === 'veterinario';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
}
