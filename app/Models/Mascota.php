<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'especie', 'raza', 'microchip', 'fecha_nacimiento', 'sexo', 'domicilio', 'propietario_id', 'imagen'
    ];

    public function propietario()
    {
        return $this->belongsTo(User::class, 'propietario_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }   

    public function historiales()
    {
        return $this->hasMany(Historial::class);
    }
    
    public function calcularEdad()
    {
        if (!$this->fecha_nacimiento) {
            return '-';
        }
        $fechaNacimiento = \Carbon\Carbon::parse($this->fecha_nacimiento);
        $ahora = \Carbon\Carbon::now();
        $anios = (int) $fechaNacimiento->diffInYears($ahora);
        if ($anios < 1) {
            $meses = $fechaNacimiento->diffInMonths($ahora);
            return $meses . ' mes' . ($meses == 1 ? '' : 'es');
        } else {
            return $anios . ' año' . ($anios == 1 ? '' : 's');
        }
    }

    /**
     * Devuelve la próxima cita futura confirmada de la mascota (o null si no hay).
     */
    public function proximaCita()
    {
        return $this->citas()
            ->where('fecha', '>=', now()->toDateString())
            ->where('estado', 'Confirmada')
            ->orderBy('fecha')
            ->orderBy('hora')
            ->first();
    }

    /**
     * Devuelve la fecha de la próxima vacuna (anual) según el último historial de tipo Vacunación.
     */
    public function proximaVacuna()
    {
        $ultimaVacuna = $this->historiales()
            ->where('tipo', 'Vacunación')
            ->orderByDesc('fecha')
            ->first();
        if ($ultimaVacuna) {
            return \Carbon\Carbon::parse($ultimaVacuna->fecha)->addYear()->toDateString();
        }
        return null;
    }

    /**
     * Devuelve la fecha de la próxima desparasitación (trimestral) según el último historial de tipo Desparasitación.
     */
    public function proximaDesparasitacion()
    {
        $ultimaDesparasitacion = $this->historiales()
            ->where('tipo', 'Desparasitación')
            ->orderByDesc('fecha')
            ->first();
        if ($ultimaDesparasitacion) {
            return \Carbon\Carbon::parse($ultimaDesparasitacion->fecha)->addMonths(3)->toDateString();
        }
        return null;
    }
}
