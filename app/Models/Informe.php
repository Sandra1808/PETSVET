<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $fillable = [
        'historial_id',
        'cita_id',
        'veterinario_id',
        'diagnostico',
        'procedimientos',
        'medicamentos',
        'tratamiento',
        'recomendaciones',
        'observaciones',
        'proxima_cita',
        'archivo_pdf',
    ];

    public function historial()
    {
        return $this->belongsTo(\App\Models\Historial::class);
    }
    public function cita()
    {
        return $this->belongsTo(\App\Models\Cita::class);
    }
    public function veterinario()
    {
        return $this->belongsTo(\App\Models\User::class, 'veterinario_id');
    }
}
