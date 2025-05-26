<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id', 'propietario_id', 'veterinario_id', 'fecha', 'hora', 'motivo', 'estado'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function propietario()
    {
        return $this->belongsTo(User::class, 'propietario_id');
    }

    public function veterinario()
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }

    public function informes()
    {
        return $this->hasMany(\App\Models\Informe::class);
    }

}
