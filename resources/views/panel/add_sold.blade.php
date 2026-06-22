@extends('panel.layout')
@section('titulo', 'Registrar Ventas')

@section('contenido')
<div class="max-w-6xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Registrar Ventas</h2>
        <p class="mt-1 text-gray-600">Administra por separado las ventas de leche y las ventas de ganado.</p>
    </div>

    @if (session('status'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="rounded-xl border border-orange-200 bg-gradient-to-r from-orange-50 to-amber-50 px-4 py-3 text-sm text-orange-800">
            {{ session('warning') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-gray-200 p-6 md:flex-row md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Lista de Ventas de Leche</h3>
                    <p class="mt-1 text-sm text-gray-600">Consulta tus ventas registradas de leche y agrega nuevas cuando lo necesites.</p>
                </div>
                <div class="flex justify-start md:justify-end md:pl-6">
                    <button type="button" @if ($clientesLeche->isNotEmpty()) onclick="openVentaLecheModal('addVentaLecheModal')" @else onclick="showVentaWarning('Primero debes agregar un cliente para la venta de leche.')" @endif class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 font-medium text-white shadow-sm transition hover:bg-green-700">
                        <span class="material-symbols-sharp">add</span>
                        <span>Agregar Venta</span>
                    </button>
                </div>
            </div>
            <div class="border-b border-gray-200 bg-gray-50 p-6">
                <form method="GET" action="{{ route('panel.ventas') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input id="buscar-venta-leche" name="q_leche" type="text" value="{{ $busquedaLeche ?? '' }}" placeholder="Buscar por factura, cliente, fecha o unidad..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-2">
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                            <span class="material-symbols-sharp">filter_list</span>
                        </button>
                        <a href="{{ route('panel.ventas') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($ventasLeche as $venta)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $venta->numero_factura }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $venta->cliente?->nombre_completo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">@decimal($venta->total_litros) {{ ucfirst($venta->unidadLeche?->nombre ?? '') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format((float) $venta->precio_total, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-3 whitespace-nowrap">
                                        <button type="button" onclick="openVentaLecheModal('view-venta-leche-{{ $venta->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                        <button type="button" onclick="openVentaLecheModal('edit-venta-leche-{{ $venta->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                        <form method="POST" action="{{ route('panel.ventas.leche.destroy', $venta) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta venta de leche?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Aun no hay ventas de leche registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $ventasLeche->count() }}</span> de <span class="font-medium">{{ $ventasLeche->total() }}</span> resultados
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($ventasLeche->onFirstPage())
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                        @else
                            <a href="{{ $ventasLeche->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                        @endif

                        @if ($ventasLeche->hasMorePages())
                            <a href="{{ $ventasLeche->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                        @else
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div id="ventas-ganado-search" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-gray-200 p-6 md:flex-row md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Lista de Ventas de Ganado</h3>
                    <p class="mt-1 text-sm text-gray-600">Consulta tus ventas registradas de ganado y agrega nuevas cuando lo necesites.</p>
                </div>
                <div class="flex justify-start md:justify-end md:pl-6">
                    <button type="button" @if ($clientesGanado->isNotEmpty()) onclick="openVentaGanadoModal('addVentaGanadoModal')" @else onclick="showVentaWarning('Primero debes agregar un cliente para la venta de ganado.')" @endif class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 font-medium text-white shadow-sm transition hover:bg-green-700">
                        <span class="material-symbols-sharp">add</span>
                        <span>Agregar Venta</span>
                    </button>
                </div>
            </div>
            <div class="border-b border-gray-200 bg-gray-50 p-6">
                <form method="GET" action="{{ route('panel.ventas') }}#ventas-ganado-search" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input id="buscar-venta-ganado" name="q_ganado" type="text" value="{{ $busquedaGanado ?? '' }}" placeholder="Buscar por factura, cliente, fecha, arete, nombre o raza..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-2">
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                            <span class="material-symbols-sharp">filter_list</span>
                        </button>
                        <a href="{{ route('panel.ventas') }}#ventas-ganado-search" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($ventasGanado as $venta)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $venta->numero_factura }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $venta->cliente?->nombre_completo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $venta->ganado?->codigo_arete }} - {{ $venta->ganado?->tipoRaza?->raza ?? 'Sin raza' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format((float) $venta->precio_venta, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-3 whitespace-nowrap">
                                        <button type="button" onclick="openVentaGanadoModal('view-venta-ganado-{{ $venta->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                        <button type="button" onclick="openVentaGanadoModal('edit-venta-ganado-{{ $venta->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                        <form method="POST" action="{{ route('panel.ventas.ganado.destroy', $venta) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta venta de ganado?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Aun no hay ventas de ganado registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $ventasGanado->count() }}</span> de <span class="font-medium">{{ $ventasGanado->total() }}</span> resultados
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($ventasGanado->onFirstPage())
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                        @else
                            <a href="{{ $ventasGanado->previousPageUrl() }}#ventas-ganado-search" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                        @endif

                        @if ($ventasGanado->hasMorePages())
                            <a href="{{ $ventasGanado->nextPageUrl() }}#ventas-ganado-search" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                        @else
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<div id="addVentaLecheModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-panel w-full max-w-4xl max-h-[95vh] overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Venta de Leche</h3>
                <p class="mt-1 text-sm text-gray-600">Registra litros vendidos, unidad y valor total de la venta.</p>
            </div>
            <button type="button" onclick="closeVentaLecheModal('addVentaLecheModal')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
        <form class="space-y-6" method="POST" action="{{ route('panel.ventas.leche.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Venta</label>
                    <input name="fecha_venta" type="date" value="{{ old('fecha_venta', date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numero de Factura</label>
                    <input name="numero_factura" type="number" step="1" min="1" value="{{ old('numero_factura') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="1001" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Cliente</label>
                <select name="id_cliente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    <option value="">Seleccionar cliente</option>
                    @foreach ($clientesLeche as $cliente)
                        <option value="{{ $cliente->id }}" @selected(old('id_cliente') == $cliente->id)>{{ $cliente->nombre_completo }} - {{ ucfirst($cliente->tipo) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                    <input name="total_litros" type="text" inputmode="decimal" value="{{ old('total_litros') !== null ? rtrim(rtrim(number_format((float) old('total_litros'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="10.5" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unidad</label>
                    <select name="id_unidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccionar unidad</option>
                        @foreach ($unidadesLeche as $unidad)
                            <option value="{{ $unidad->id }}" @selected(old('id_unidad') == $unidad->id)>{{ ucfirst($unidad->nombre) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio Unitario</label>
                    <input name="precio_unitario" type="text" inputmode="numeric" value="{{ old('precio_unitario') }}" data-format-number data-decimals="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="2.500" autocomplete="off" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Notas adicionales sobre la venta de leche...">{{ old('observaciones') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button type="button" onclick="closeVentaLecheModal('addVentaLecheModal')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                    Guardar Registro
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

@foreach ($ventasLeche as $venta)
<div id="view-venta-leche-{{ $venta->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden modal-panel">
        <div class="flex items-start justify-between border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle de Venta de Leche</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles de la venta de leche.</p>
            </div>
            <button type="button" onclick="closeVentaLecheModal('view-venta-leche-{{ $venta->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 bg-white">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Unidad</p>
                <p class="mt-2 text-sm text-gray-900">{{ ucfirst($venta->unidadLeche?->nombre ?? 'Sin unidad') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Nombre</p>
                <p class="mt-2 text-sm text-gray-900">{{ $venta->cliente?->nombre_completo }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Factura</p>
                <p class="mt-2 text-sm text-gray-900">{{ $venta->numero_factura }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Fecha</p>
                <p class="mt-2 text-sm text-gray-900">{{ optional($venta->fecha_venta)->format('d/m/Y') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</p>
                <p class="mt-2 text-sm text-gray-900">{{ ucfirst($venta->cliente?->tipo ?? 'Sin tipo') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad</p>
                <p class="mt-2 text-sm text-gray-900">@decimal($venta->total_litros) {{ ucfirst($venta->unidadLeche?->nombre ?? '') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Precio Unitario</p>
                <p class="mt-2 text-sm text-gray-900">${{ number_format((float) $venta->precio_unitario, 0) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Total</p>
                <p class="mt-2 text-sm font-medium text-gray-900">${{ number_format((float) $venta->precio_total, 2) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Observaciones</p>
                <p class="mt-2 text-sm leading-6 text-gray-900">{{ $venta->observaciones ?: 'Sin observaciones registradas.' }}</p>
            </div>
        </div>
        </div>
    </div>
</div>

<div id="edit-venta-leche-{{ $venta->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Venta de Leche</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza la información de la venta de leche.</p>
            </div>
            <button type="button" onclick="closeVentaLecheModal('edit-venta-leche-{{ $venta->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
        <form class="space-y-6" method="POST" action="{{ route('panel.ventas.leche.update', $venta) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Venta</label>
                    <input name="fecha_venta" type="date" value="{{ optional($venta->fecha_venta)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numero de Factura</label>
                    <input name="numero_factura" type="number" step="1" min="1" value="{{ $venta->numero_factura }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Cliente</label>
                <select name="id_cliente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    <option value="">Seleccionar cliente</option>
                    @foreach ($clientesLeche as $cliente)
                        <option value="{{ $cliente->id }}" @selected($venta->id_cliente == $cliente->id)>{{ $cliente->nombre_completo }} - {{ ucfirst($cliente->tipo) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                    <input name="total_litros" type="text" inputmode="decimal" value="{{ rtrim(rtrim(number_format((float) $venta->total_litros, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unidad</label>
                    <select name="id_unidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        @foreach ($unidadesLeche as $unidad)
                            <option value="{{ $unidad->id }}" @selected($venta->id_unidad == $unidad->id)>{{ ucfirst($unidad->nombre) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio Unitario</label>
                    <input name="precio_unitario" type="text" inputmode="numeric" value="{{ number_format((float) $venta->precio_unitario, 0, '.', '') }}" data-format-number data-decimals="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" autocomplete="off" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $venta->observaciones }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeVentaLecheModal('edit-venta-leche-{{ $venta->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                    Actualizar Venta de Leche
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
@endforeach

<div id="addVentaGanadoModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="modal-panel w-full max-w-4xl max-h-[95vh] overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Venta de Ganado</h3>
                <p class="mt-1 text-sm text-gray-600">Registra el animal vendido, el cliente comprador y el precio final.</p>
            </div>
            <button type="button" onclick="closeVentaGanadoModal('addVentaGanadoModal')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
        <form class="space-y-6" method="POST" action="{{ route('panel.ventas.ganado.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Venta</label>
                    <input name="fecha_venta" type="date" value="{{ old('fecha_venta', date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numero de Factura</label>
                    <input name="numero_factura" type="number" step="1" min="1" value="{{ old('numero_factura') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="2001" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Cliente</label>
                    <select name="id_cliente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccionar cliente</option>
                        @foreach ($clientesGanado as $cliente)
                            <option value="{{ $cliente->id }}" @selected(old('id_cliente') == $cliente->id)>{{ $cliente->nombre_completo }} - {{ ucfirst($cliente->tipo) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Animal</label>
                    <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccionar ganado</option>
                        @foreach ($ganados as $ganado)
                            <option value="{{ $ganado->id }}" @selected(old('id_ganado') == $ganado->id)>{{ $ganado->codigo_arete }} - {{ $ganado->tipoRaza?->raza ?? 'Sin raza' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Precio por Kilo</label>
                <input name="precio_por_kilo" type="text" inputmode="numeric" value="{{ old('precio_por_kilo') }}" data-format-number data-decimals="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="100.000" autocomplete="off" required>
                <p class="mt-2 text-xs text-gray-500">El total de la venta se calcula automaticamente con el peso actual del ganado.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Notas adicionales sobre la venta de ganado...">{{ old('observaciones') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button type="button" onclick="closeVentaGanadoModal('addVentaGanadoModal')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                    Guardar Registro
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

@foreach ($ventasGanado as $venta)
<div id="view-venta-ganado-{{ $venta->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden modal-panel">
        <div class="flex items-start justify-between border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle de Venta de Ganado</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles de la venta de ganado.</p>
            </div>
            <button type="button" onclick="closeVentaGanadoModal('view-venta-ganado-{{ $venta->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 bg-white">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</p>
                <p class="mt-2 text-sm text-gray-900">Ganado</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Animal</p>
                <p class="mt-2 text-sm text-gray-900">{{ $venta->ganado?->codigo_arete }} - {{ $venta->ganado?->tipoRaza?->raza ?? 'Sin raza' }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Factura</p>
                <p class="mt-2 text-sm text-gray-900">{{ $venta->numero_factura }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Fecha</p>
                <p class="mt-2 text-sm text-gray-900">{{ optional($venta->fecha_venta)->format('d/m/Y') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Cliente</p>
                <p class="mt-2 text-sm text-gray-900">{{ $venta->cliente?->nombre_completo }} - {{ ucfirst($venta->cliente?->tipo ?? '') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Precio por Kilo</p>
                <p class="mt-2 text-sm text-gray-900">${{ number_format((float) $venta->precio_por_kilo, 0) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Total</p>
                <p class="mt-2 text-sm font-medium text-gray-900">${{ number_format((float) $venta->precio_venta, 2) }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Observaciones</p>
                <p class="mt-2 text-sm leading-6 text-gray-900">{{ $venta->observaciones ?: 'Sin observaciones registradas.' }}</p>
            </div>
        </div>
        </div>
    </div>
</div>

<div id="edit-venta-ganado-{{ $venta->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Venta de Ganado</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza la información de la venta de ganado.</p>
            </div>
            <button type="button" onclick="closeVentaGanadoModal('edit-venta-ganado-{{ $venta->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
        <form class="space-y-6" method="POST" action="{{ route('panel.ventas.ganado.update', $venta) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Venta</label>
                    <input name="fecha_venta" type="date" value="{{ optional($venta->fecha_venta)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numero de Factura</label>
                    <input name="numero_factura" type="number" step="1" min="1" value="{{ $venta->numero_factura }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Cliente</label>
                    <select name="id_cliente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccionar cliente</option>
                        @foreach ($clientesGanado as $cliente)
                            <option value="{{ $cliente->id }}" @selected($venta->id_cliente == $cliente->id)>{{ $cliente->nombre_completo }} - {{ ucfirst($cliente->tipo) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Animal</label>
                    <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccionar ganado</option>
                        @foreach ($ganadosOperador as $ganado)
                            @php
                                $ganadoDisponible = $ganados->contains('id', $ganado->id) || $venta->id_ganado === $ganado->id;
                            @endphp
                            @if ($ganadoDisponible)
                                <option value="{{ $ganado->id }}" @selected($venta->id_ganado == $ganado->id)>{{ $ganado->codigo_arete }} - {{ $ganado->tipoRaza?->raza ?? 'Sin raza' }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Precio por Kilo</label>
                <input name="precio_por_kilo" type="text" inputmode="numeric" value="{{ $venta->precio_por_kilo }}" data-format-number data-decimals="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" autocomplete="off" required>
                <p class="mt-2 text-xs text-gray-500">El total de la venta se recalcula automaticamente con el peso actual del ganado.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $venta->observaciones }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeVentaGanadoModal('edit-venta-ganado-{{ $venta->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                    Actualizar Venta de Ganado
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
@endforeach
@endsection

<script>
function openVentaLecheModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closeVentaLecheModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}

function openVentaGanadoModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closeVentaGanadoModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}

function showVentaWarning(message) {
    window.alert(message);
}

function formatPriceInputValue(value, decimals) {
    const sanitized = String(value ?? '').replace(/[^\d.,]/g, '');

    if (!sanitized) {
        return '';
    }

    if (decimals === 0) {
        const digits = sanitized.replace(/\D/g, '');
        return digits ? new Intl.NumberFormat('es-CO', { maximumFractionDigits: 0 }).format(Number(digits)) : '';
    }

    const lastSeparatorIndex = Math.max(sanitized.lastIndexOf(','), sanitized.lastIndexOf('.'));
    const rawDecimalDigits = lastSeparatorIndex !== -1
        ? sanitized.slice(lastSeparatorIndex + 1).replace(/\D/g, '')
        : '';
    const hasDecimalPart = lastSeparatorIndex !== -1 && rawDecimalDigits.length > 0 && rawDecimalDigits.length <= decimals;
    const integerDigits = (hasDecimalPart ? sanitized.slice(0, lastSeparatorIndex) : sanitized).replace(/\D/g, '');
    const decimalDigits = hasDecimalPart ? rawDecimalDigits.slice(0, decimals) : '';

    if (!integerDigits && !decimalDigits) {
        return '';
    }

    const formattedInteger = new Intl.NumberFormat('es-CO', { maximumFractionDigits: 0 }).format(Number(integerDigits || '0'));

    return hasDecimalPart ? `${formattedInteger},${decimalDigits}` : formattedInteger;
}

function normalizePriceInputValue(value, decimals) {
    const sanitized = String(value ?? '').replace(/[^\d.,]/g, '');

    if (!sanitized) {
        return '';
    }

    if (decimals === 0) {
        return sanitized.replace(/\D/g, '');
    }

    const lastSeparatorIndex = Math.max(sanitized.lastIndexOf(','), sanitized.lastIndexOf('.'));
    const rawDecimalDigits = lastSeparatorIndex !== -1
        ? sanitized.slice(lastSeparatorIndex + 1).replace(/\D/g, '')
        : '';
    const hasDecimalPart = lastSeparatorIndex !== -1 && rawDecimalDigits.length > 0 && rawDecimalDigits.length <= decimals;
    const integerDigits = (hasDecimalPart ? sanitized.slice(0, lastSeparatorIndex) : sanitized).replace(/\D/g, '');
    const decimalDigits = hasDecimalPart ? rawDecimalDigits.slice(0, decimals) : '';

    if (!integerDigits && !decimalDigits) {
        return '';
    }

    return hasDecimalPart ? `${integerDigits || '0'}.${decimalDigits}` : integerDigits;
}

function setupFormattedPriceInputs(scope = document) {
    scope.querySelectorAll('input[data-format-number]').forEach((input) => {
        const decimals = Number(input.dataset.decimals || 0);

        input.value = formatPriceInputValue(input.value, decimals);

        input.addEventListener('input', function () {
            this.value = formatPriceInputValue(this.value, decimals);
        });

        input.form?.addEventListener('submit', function () {
            input.value = normalizePriceInputValue(input.value, decimals);
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    setupFormattedPriceInputs();

    const ventaLecheModals = document.querySelectorAll('[id^="view-venta-leche-"], [id^="edit-venta-leche-"], #addVentaLecheModal');
    const ventaGanadoModals = document.querySelectorAll('[id^="view-venta-ganado-"], [id^="edit-venta-ganado-"], #addVentaGanadoModal');

    ventaLecheModals.forEach((modal) => {
        const panel = modal.querySelector('.modal-panel');

        modal.addEventListener('click', function (event) {
            if (panel && !panel.contains(event.target)) {
                closeVentaLecheModal(modal.id);
            }
        });
    });

    ventaGanadoModals.forEach((modal) => {
        const panel = modal.querySelector('.modal-panel');

        modal.addEventListener('click', function (event) {
            if (panel && !panel.contains(event.target)) {
                closeVentaGanadoModal(modal.id);
            }
        });
    });

    @if ($errors->any())
        @if (old('id_ganado') || old('precio_por_kilo'))
            openVentaGanadoModal('addVentaGanadoModal');
        @elseif (old('total_litros') || old('precio_unitario') || old('id_unidad'))
            openVentaLecheModal('addVentaLecheModal');
        @endif
    @endif
});
</script>
