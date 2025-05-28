<?php

namespace App\Http\Controllers;

use App\Models\Cita;
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

    public function generarInforme($id)  
{  
    // Buscar el informe con todas las relaciones necesarias  
    $informe = \App\Models\Informe::with([  
        'historial.mascota.propietario',  
        'historial.veterinario',   
        'cita'  
    ])->findOrFail($id);  
      
    // Usar el historial del informe para el template  
    $historial = $informe->historial;
    
    //Datos especificos del informe
    $historial->procedimientos = $informe->procedimientos;  
    $historial->diagnostico = $informe->diagnostico;  
    $historial->tratamiento = $informe->tratamiento;  
    $historial->medicamentos = $informe->medicamentos;  
    $historial->recomendaciones = $informe->recomendaciones;  
    $historial->observaciones = $informe->observaciones;  
    $historial->proxima_cita = $informe->proxima_cita;
      
    // Generar el PDF usando el template existente  
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.historial_informe', compact('historial'));  
      
    return $pdf->download('informe_' . $id . '.pdf');  
}

    public function generarHistorialPDF($id)
    {
        $historial = \App\Models\Historial::with(['mascota.propietario', 'cita', 'veterinario'])->findOrFail($id);
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.historial_informe', compact('historial'))->download('informe_historial_' . $id . '.pdf');
    }
}
