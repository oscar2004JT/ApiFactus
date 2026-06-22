<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registros del Sistema</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; }
        h1 { font-size: 22px; margin-bottom: 4px; }
        h2 { font-size: 16px; margin: 24px 0 10px; color: #166534; }
        p { margin: 0 0 6px; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; font-weight: bold; }
        .empty { padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <h1>Registros del Sistema</h1>
    <p class="muted">Filtro: {{ ucfirst($tipoSeleccionado) }}</p>
    <p class="muted">Periodo: {{ $periodoSeleccionado === 'todos' ? 'Todo el historial' : 'Ultimos ' . $periodoSeleccionado . ' dias' }}</p>
    <p class="muted">Fecha de exportación: {{ $fechaExportacion->format('d/m/Y H:i') }}</p>

    @if(in_array($tipoSeleccionado, ['todos', 'ganado']))
        <h2>Ganado</h2>
        @if($ganados->isEmpty())
            <div class="empty">No hay registros de ganado.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Arete</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Sexo</th>
                        <th>Estado de salud</th>
                        <th>Tipo</th>
                        <th>Peso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ganados as $ganado)
                        <tr>
                            <td>{{ $ganado->codigo_arete }}</td>
                            <td>{{ $ganado->nombre ?? '-' }}</td>
                            <td>{{ $ganado->tipoRaza?->raza ?? '-' }}</td>
                            <td>{{ $ganado->tipoSexo?->nombre ?? '-' }}</td>
                            <td>{{ $ganado->estadoSalud?->nombre ?? '-' }}</td>
                            <td>{{ $ganado->tipoGanado?->nombre ?? '-' }}</td>
                            <td>{{ $ganado->peso_actual !== null ? rtrim(rtrim(number_format((float) $ganado->peso_actual, 2, '.', ','), '0'), '.') . ' ' . ($ganado->unidadPeso?->nombre ?? '') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    @if(in_array($tipoSeleccionado, ['todos', 'produccion']))
        <h2>Producción</h2>
        @if($producciones->isEmpty())
            <div class="empty">No hay registros de producción.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Animal</th>
                        <th>Turno</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($producciones as $produccion)
                        <tr>
                            <td>{{ optional($produccion->fecha_producion)->format('d/m/Y') }}</td>
                            <td>{{ $produccion->ganado?->codigo_arete ?? '-' }}{{ $produccion->ganado?->tipoRaza ? ' - '.$produccion->ganado->tipoRaza->raza : '' }}</td>
                            <td>{{ $produccion->tipoTurno?->nombre ?? '-' }}</td>
                            <td>@decimal($produccion->cantidad)</td>
                            <td>{{ $produccion->unidadLeche?->nombre ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    @if(in_array($tipoSeleccionado, ['todos', 'ventas']))
        <h2>Ventas de Leche</h2>
        @if($ventasLeche->isEmpty())
            <div class="empty">No hay ventas de leche.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasLeche as $venta)
                        <tr>
                            <td>{{ $venta->numero_factura }}</td>
                            <td>{{ optional($venta->fecha_venta)->format('d/m/Y') }}</td>
                            <td>{{ $venta->cliente?->nombre_completo ?? '-' }}</td>
                            <td>@decimal($venta->total_litros) {{ $venta->unidadLeche?->nombre ?? '' }}</td>
                            <td>${{ number_format((float) $venta->precio_total, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <h2>Ventas de Ganado</h2>
        @if($ventasGanado->isEmpty())
            <div class="empty">No hay ventas de ganado.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Animal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasGanado as $venta)
                        <tr>
                            <td>{{ $venta->numero_factura }}</td>
                            <td>{{ optional($venta->fecha_venta)->format('d/m/Y') }}</td>
                            <td>{{ $venta->cliente?->nombre_completo ?? '-' }}</td>
                            <td>{{ $venta->ganado?->codigo_arete ?? '-' }}{{ $venta->ganado?->tipoRaza ? ' - '.$venta->ganado->tipoRaza->raza : '' }}</td>
                            <td>${{ number_format((float) $venta->precio_venta, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    @if(in_array($tipoSeleccionado, ['todos', 'clientes']))
        <h2>Clientes</h2>
        @if($clientes->isEmpty())
            <div class="empty">No hay clientes registrados.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre_completo }}</td>
                            <td>{{ ucfirst($cliente->tipo) }}</td>
                            <td>{{ $cliente->correo_electronico }}</td>
                            <td>{{ $cliente->telefono }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    @if(in_array($tipoSeleccionado, ['todos', 'insumos']))
        <h2>Insumos</h2>
        @if($insumos->isEmpty())
            <div class="empty">No hay insumos registrados.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                        <th>Precio unitario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insumos as $insumo)
                        <tr>
                            <td>{{ $insumo->nombre }}</td>
                            <td>{{ $insumo->categoria?->nombre ?? '-' }}</td>
                            <td>@decimal($insumo->stock_actual) {{ $insumo->medida?->nombre ?? '' }}</td>
                            <td>@decimal($insumo->stock_minimo) {{ $insumo->medida?->nombre ?? '' }}</td>
                            <td>${{ number_format((float) $insumo->precio_unitario, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</body>
</html>
