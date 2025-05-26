<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Historial;
use App\Models\Mascota;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generarCitasPDF()
    {
        $citas = Cita::with('mascota', 'user')->get();
        $pdf = PDF::loadView('pdf.citas', compact('citas'));
        return $pdf->download('citas.pdf');
    }

    public function generarHistorialesPDF($id)
    {
        $historiales = \App\Models\Historial::with('mascota')->where('id', $id)->get();
        $pdf = Pdf::loadView('pdf.historiales', compact('historiales'));
        return $pdf->download('historiales.pdf');
    }

    public function generarHistorialesMascotaPDF($mascota_id)
    {
        $historiales = \App\Models\Historial::with(['mascota', 'informes'])
            ->where('mascota_id', $mascota_id)
            ->orderBy('created_at', 'asc')
            ->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.historiales', compact('historiales'));
        return $pdf->download('historiales_mascota_' . $mascota_id . '.pdf');
    }

    public function generarHistorialPDF($id)
    {
        $historial = \App\Models\Historial::with(['mascota.propietario', 'cita', 'veterinario'])->findOrFail($id);
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.historial_informe', compact('historial'))->download('informe_historial_' . $id . '.pdf');
    }
}
