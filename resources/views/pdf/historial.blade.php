<!DOCTYPE html>
<html>
<head>
    <title>Historial Médico</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Historial Médico</h2>
    <table>
        <thead>
            <tr>
                <th>Mascota</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historiales as $item)
                <tr>
                    <td>{{ $item->mascota->nombre }}</td>
                    <td>{{ $item->tipo }}</td>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
