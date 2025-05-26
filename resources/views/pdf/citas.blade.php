<!DOCTYPE html>
<html>
<head>
    <title>Citas</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Listado de Citas</h2>
    <table>
        <thead>
            <tr>
                <th>Mascota</th>
                <th>Dueño</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $cita->mascota->nombre }}</td>
                    <td>{{ $cita->user->name ?? 'N/A' }}</td>
                    <td>{{ $cita->fecha }}</td>
                    <td>{{ $cita->hora }}</td>
                    <td>{{ $cita->motivo }}</td>
                    <td>{{ $cita->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
