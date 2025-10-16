<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Piezas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }

        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .project-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .project-title {
            background-color: #3498db;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .block-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .block-title {
            background-color: #95a5a6;
            color: white;
            padding: 8px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table thead {
            background-color: #34495e;
            color: white;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            font-weight: bold;
            font-size: 11px;
        }

        table td {
            font-size: 10px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #ecf0f1;
        }

        .status-pending {
            color: #f39c12;
            font-weight: bold;
        }

        .status-manufactured {
            color: #27ae60;
            font-weight: bold;
        }

        .summary {
            background-color: #ecf0f1;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .summary p {
            margin: 5px 0;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Reporte de Piezas</h1>
        <p>Generado el: {{ $generatedDate }}</p>
        <p>Total de Piezas: {{ $totalPieces }}</p>
    </div>

    @forelse($piecesByProject as $projectName => $blocks)
        <div class="project-section">
            <div class="project-title">
                Proyecto: {{ $projectName }}
            </div>

            @foreach ($blocks as $blockName => $pieces)
                <div class="block-section">
                    <div class="block-title">
                        Bloque: {{ $blockName }} ({{ count($pieces) }} pieza(s))
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Peso Teórico (kg)</th>
                                <th>Peso Real (kg)</th>
                                <th>Diferencia (kg)</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pieces as $piece)
                                <tr>
                                    <td>{{ $piece->id }}</td>
                                    <td>{{ $piece->name }}</td>
                                    <td>{{ number_format($piece->theorical_weight, 2) }}</td>
                                    <td>{{ $piece->real_weight ? number_format($piece->real_weight, 2) : 'N/A' }}</td>
                                    <td>
                                        @if ($piece->real_weight)
                                            {{ number_format($piece->real_weight - $piece->theorical_weight, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-{{ $piece->status->value }}">
                                            {{ ucfirst($piece->status->value) }}
                                        </span>
                                    </td>
                                    <td>{{ $piece->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="summary">
                        <p>Resumen del Bloque:</p>
                        <p>• Total Peso Teórico: {{ number_format($pieces->sum('theorical_weight'), 2) }} kg</p>
                        <p>• Total Peso Real:
                            {{ number_format($pieces->where('real_weight', '!=', null)->sum('real_weight'), 2) }} kg
                        </p>
                        <p>• Piezas Pendientes:
                            {{ $pieces->filter(fn($p) => $p->status->value === 'pending')->count() }}</p>
                        <p>• Piezas Fabricadas:
                            {{ $pieces->filter(fn($p) => $p->status->value === 'manufactured')->count() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="no-data">
            No hay piezas registradas en el sistema.
        </div>
    @endforelse

    <div class="footer">
        <p>Sistema de Gestión de Piezas - COTECMAR | Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>

</html>
