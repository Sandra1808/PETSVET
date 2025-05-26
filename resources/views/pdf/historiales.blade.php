<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Médico - PetsVet</title>
    <style>
        @page { size: A4 landscape; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222; }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #FFA500;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .logo {
            height: 60px;
            margin-right: 20px;
        }
        .title {
            font-size: 1.7em;
            font-weight: bold;
            color: #FFA500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
            word-break: break-word;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 7px;
            text-align: left;
            vertical-align: top;
            font-size: 12px;
            word-break: break-word;
            white-space: pre-line;
        }
        th {
            background: #eee;
        }
        th { font-size: 12px; }
        .section-title { font-size: 1.1em; font-weight: bold; margin-top: 18px; color: #FFA500; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">PetsVet</div>
            <div>Informe Médico Veterinario</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">Mascota</th>
                <th style="width: 8%">Fecha</th>
                <th style="width: 15%">Diagnóstico</th>
                <th style="width: 15%">Procedimientos</th>
                <th style="width: 15%">Medicamentos</th>
                <th style="width: 15%">Tratamiento</th>
                <th style="width: 15%">Recomendaciones</th>
                <th style="width: 12%">Observaciones</th>
                <th style="width: 10%">Próxima cita</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historiales as $historial)
                @foreach($historial->informes as $informe)
                <tr>
                    <td>{{ $historial->mascota->nombre ?? '-' }}</td>
                    <td>{{ $informe->created_at ? $informe->created_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $informe->diagnostico }}</td>
                    <td>{{ $informe->procedimientos }}</td>
                    <td>{{ $informe->medicamentos }}</td>
                    <td>{{ $informe->tratamiento }}</td>
                    <td>{{ $informe->recomendaciones }}</td>
                    <td>{{ $informe->observaciones }}</td>
                    <td>{{ $informe->proxima_cita }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 40px; text-align: right; font-size: 0.95em; color: #888;">
        Generado por PetsVet - {{ date('d/m/Y H:i') }}
    </div>
    @include('pdf.contacto_clinica')
</body>
</html> 