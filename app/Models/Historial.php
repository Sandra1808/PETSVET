<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'propietario_id',
        'n_historial',
        'tipo',
        'descripcion',
        'fecha',
        'archivo_pdf',
    ];

    protected $table = 'historiales';

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

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function informes()
    {
        return $this->hasMany(\App\Models\Informe::class);
    }

    public static function generarCodigoHistorial()
    {
        $ultimo = self::orderBy('id', 'desc')->first();
        $num = $ultimo && $ultimo->n_historial ? intval(substr($ultimo->n_historial, 1)) + 1 : 1;
        return 'H' . str_pad($num, 5, '0', STR_PAD_LEFT);
    }
}
