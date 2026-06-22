<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Analitica y Reportes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        h1, h2, h3 { margin: 0; }
        .muted { color: #6b7280; }
        .section { margin-top: 24px; }
        .grid { width: 100%; border-collapse: separate; border-spacing: 10px; margin-top: 12px; }
        .card { border: 1px solid #d1d5db; border-radius: 10px; padding: 14px; vertical-align: top; }
        .metric { font-size: 22px; font-weight: bold; margin-top: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Analitica y Reportes</h1>
    <p class="muted">Periodo: {{ $periodoLabel }} | Desde {{ $rangoActualInicio->format('d/m/Y') }} hasta {{ $rangoActualFin->format('d/m/Y') }}</p>
    <p class="muted">Exportado el {{ $fechaExportacion->format('d/m/Y H:i') }}</p>

    <table class="grid">
        <tr>
            <td class="card">
                <h3>Produccion Total</h3>
                <div class="metric">@decimal($produccionTotal) L</div>
                <div class="muted">{{ $tendenciaProduccion['texto'] }}</div>
            </td>
            <td class="card">
                <h3>Ingresos Totales</h3>
                <div class="metric">${{ number_format((float) $ingresosTotales, 0) }}</div>
                <div class="muted">{{ $tendenciaIngresos['texto'] }}</div>
            </td>
            <td class="card">
                <h3>Produccion Promedio</h3>
                <div class="metric">@decimal($produccionPromedio) L</div>
                <div class="muted">{{ $tendenciaProduccionPromedio['texto'] }}</div>
            </td>
        </tr>
    </table>

    <div class="section">
        <h2>Ingresos por Categoria</h2>
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Leche</td>
                    <td>${{ number_format((float) $ingresosLecheTotales, 0) }}</td>
                </tr>
                <tr>
                    <td>Ganado</td>
                    <td>${{ number_format((float) $ingresosGanadoTotales, 0) }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>${{ number_format((float) $ingresosTotales, 0) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>{{ $serieProduccionPeriodoTitulo }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Etiqueta</th>
                    <th>{{ $serieProduccionPeriodoColumna }}</th>
                    <th>Litros</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($serieProduccionPeriodo as $item)
                    <tr>
                        <td>{{ $item['label'] }}</td>
                        <td>{{ $item['tooltip'] }}</td>
                        <td>@decimal($item['valor'])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
