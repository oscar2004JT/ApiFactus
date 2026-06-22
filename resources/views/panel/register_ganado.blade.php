@extends('panel.layout')
@section('titulo', 'Ganado y Engorde')

@section('contenido')
<style>
    .ganado-list-copy p:last-of-type {
        display: none;
    }
</style>
@php
    $formatInputNumber = static function ($value): string {
        if ($value === null || $value === '') {
            return '';
        }

        $normalized = str_replace(',', '.', (string) $value);

        if (! str_contains($normalized, '.')) {
            return $normalized;
        }

        return rtrim(rtrim($normalized, '0'), '.');
    };
@endphp
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Ganado y Engorde</h2>
            <p class="text-gray-600 mt-1">Consulta la informacion de tu ganado, registra nuevos animales y gestiona el seguimiento de engorde cuando lo necesites.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div id="registros-section" class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between gap-4">
            <div class="ganado-list-copy">
                <h3 class="text-lg font-semibold text-gray-900">Lista de Ganado</h3>
                <p class="mt-1 text-sm text-gray-600">Consulta los animales registrados, tanto activos como vendidos, y su informacion principal.</p>
                <p class="mt-1 text-sm text-gray-600">Consulta los animales registrados y su información principal.</p>
            </div>
            <button type="button" onclick="openAddGanadoModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center space-x-2 shrink-0">
                <span class="material-symbols-sharp">add</span>
                <span>Agregar Ganado</span>
            </button>
        </div>
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('panel.ganado') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input name="q" type="text" value="{{ $busqueda }}" placeholder="Buscar por arete, nombre, raza, sexo, estado, estado de salud o tipo..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div class="md:w-64">
                    <select name="tipo_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Todos los tipos</option>
                        @foreach ($tiposGanado as $tipoGanado)
                            <option value="{{ $tipoGanado->id }}" @selected((string) $tipoGanadoSeleccionado === (string) $tipoGanado->id)>{{ $tipoGanado->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                        <span class="material-symbols-sharp">filter_list</span>
                    </button>
                    <a href="{{ route('panel.ganado') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arete</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sexo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ganados as $ganado)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ganado->codigo_arete }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ganado->nombre ?: 'Sin nombre' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ganado->tipoRaza?->raza ?? 'Sin raza' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($ganado->tipoSexo?->nombre ?? 'Sin sexo') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($ganado->peso_actual !== null)
                                    @decimal($ganado->peso_actual) {{ $ganado->unidadPeso?->nombre }}
                                @else
                                    Sin peso
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $ganado->ventaGanados->isNotEmpty() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $ganado->ventaGanados->isNotEmpty() ? 'Vendido' : 'Activo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3 whitespace-nowrap">
                                    <button type="button" onclick="openGanadoModal('view-ganado-{{ $ganado->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                    <button type="button" onclick="openGanadoModal('edit-ganado-{{ $ganado->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                    <form method="POST" action="{{ route('panel.ganado.destroy', $ganado) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar este ganado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                Aun no hay ganado registrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ $ganados->count() }}</span> de <span class="font-medium">{{ $ganados->total() }}</span> resultados
                </div>
                <div class="flex items-center gap-2">
                    @if ($ganados->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                    @else
                        <a href="{{ $ganados->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                    @endif

                    @if ($ganados->hasMorePages())
                        <a href="{{ $ganados->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="ficha-familiar" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden scroll-mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Ficha Familiar</h3>
                    <p class="text-sm text-gray-600 mt-1">Madre, padre e hijos del animal seleccionado.</p>
                </div>

                <form id="familia-ganado-form" method="GET" action="{{ route('panel.ganado') }}#ficha-familiar" class="flex flex-col md:flex-row gap-4 xl:min-w-[420px]">
                    <input type="hidden" name="q" value="{{ $busqueda }}">
                    @if (filled($tipoGanadoSeleccionado))
                        <input type="hidden" name="tipo_ganado" value="{{ $tipoGanadoSeleccionado }}">
                    @endif
                    <div class="flex-1">
                        <input
                            id="ganado_id"
                            name="ganado_id"
                            type="hidden"
                            value="{{ $ganadoId ?? ($ganadoSeleccionado?->id ?? '') }}"
                        >
                        <input
                            id="ganado_selector"
                            name="ganado_busqueda"
                            type="text"
                            list="ganados-list"
                            value="{{ $ganadoSeleccionado ? $ganadoSeleccionado->codigo_arete . ' - ' . $ganadoSeleccionado->nombre_o_default : $busquedaGanado }}"
                            placeholder="Buscar por arete o nombre del animal..."
                            autocomplete="off"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                        <datalist id="ganados-list">
                            @foreach ($ganadosFamilia as $ganadoFamilia)
                                <option
                                    value="{{ $ganadoFamilia->codigo_arete }} - {{ $ganadoFamilia->nombre_o_default }}"
                                    data-id="{{ $ganadoFamilia->id }}"
                                ></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium">
                            <span class="material-symbols-sharp">filter_list</span>
                        </button>
                        <a href="{{ route('panel.ganado') }}#ficha-familiar" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($ganadoSeleccionado)
            <div class="p-6 border-b border-gray-200 bg-gray-50/70">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                    <div class="rounded-xl border border-gray-200 bg-white p-5">
                        <div class="flex items-start gap-4">
                            <div class="min-w-0">
                                <p class="text-xs uppercase tracking-[0.2em] text-green-700">Animal seleccionado</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Nombre</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->nombre_o_default }}</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Arete</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->codigo_arete }}</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Tipo</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->tipoGanado?->nombre ?? 'Sin tipo' }}</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Raza</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->tipoRaza?->raza ?? 'Sin raza' }}</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Estado</p>
                                <p class="mt-1 text-sm text-gray-800">{{ ucfirst($ganadoSeleccionado->estadoSalud?->nombre ?? 'Sin dato') }}</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Hijos</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $hijosDelGanado->count() }} registrados</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-wider text-gray-500">Madre</p>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                                <span class="material-symbols-sharp text-[20px]">female</span>
                            </span>
                        </div>
                        @if ($ganadoSeleccionado->madre)
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Nombre</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->madre->nombre_o_default }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Arete</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->madre->codigo_arete }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Raza</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->madre->tipoRaza?->raza ?? 'Sin raza' }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Tipo</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->madre->tipoGanado?->nombre ?? 'Sin tipo' }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Estado</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ ucfirst($ganadoSeleccionado->madre->estadoSalud?->nombre ?? 'Sin dato') }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Sexo</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ ucfirst($ganadoSeleccionado->madre->tipoSexo?->nombre ?? 'Sin dato') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-5 text-sm text-gray-500">
                                Sin registro de madre.
                            </div>
                        @endif
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-wider text-gray-500">Padre</p>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                                <span class="material-symbols-sharp text-[20px]">male</span>
                            </span>
                        </div>
                        @if ($ganadoSeleccionado->padre)
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Nombre</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->padre->nombre_o_default }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Arete</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->padre->codigo_arete }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Raza</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->padre->tipoRaza?->raza ?? 'Sin raza' }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Tipo</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ $ganadoSeleccionado->padre->tipoGanado?->nombre ?? 'Sin tipo' }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Estado</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ ucfirst($ganadoSeleccionado->padre->estadoSalud?->nombre ?? 'Sin dato') }}</p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 px-3 py-2">
                                        <p class="text-[11px] uppercase tracking-wide text-gray-500">Sexo</p>
                                        <p class="mt-1 text-sm text-gray-800">{{ ucfirst($ganadoSeleccionado->padre->tipoSexo?->nombre ?? 'Sin dato') }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-5 text-sm text-gray-500">
                                Sin registro de padre.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-center sm:text-left">
                    <h4 class="text-base font-semibold text-gray-900">Hijos Registrados</h4>
                    <p class="text-sm text-gray-600">Descendencia encontrada en el sistema.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">{{ $hijosDelGanado->count() }} registros</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arete</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nacimiento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condicion</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($hijosDelGanado as $hijo)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $hijo->codigo_arete }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $hijo->nombre_o_default }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $hijo->tipoGanado?->nombre ?? 'Sin tipo' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ strtolower((string) ($hijo->estadoSalud?->nombre ?? '')) === 'sano' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($hijo->estadoSalud?->nombre ?? 'Sin dato') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($hijo->fecha_nacimiento)->format('d/m/Y') ?? 'Sin fecha' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $hijo->ventaGanados->isNotEmpty() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $hijo->ventaGanados->isNotEmpty() ? 'Vendido' : 'Activo' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Este animal no tiene hijos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $hijosDelGanado->count() }}</span> registros
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                    </div>
                </div>
            </div>
        @else
            <div class="px-6 py-8 text-center text-sm text-gray-500">
                Aun no hay ganado registrado para mostrar este reporte.
            </div>
        @endif
    </div>

    <div id="engordes-section" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Control de Engordes</h3>
                <p class="mt-1 text-sm text-gray-600">Visualiza y agrega los animales registrados en la tabla de engordes.</p>
            </div>
            <button type="button" onclick="@if ($ganadosFamilia->isNotEmpty()) openAddEngordeModal() @else showEngordeWarning('Primero debes registrar al menos un ganado para poder agregar un engorde.') @endif" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center space-x-2 shrink-0">
                <span class="material-symbols-sharp">add</span>
                <span>Agregar Engorde</span>
            </button>
        </div>

        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('panel.ganado') }}#engordes-section" class="flex flex-col md:flex-row gap-4">
                <input type="hidden" name="q" value="{{ $busqueda }}">
                @if (filled($tipoGanadoSeleccionado))
                    <input type="hidden" name="tipo_ganado" value="{{ $tipoGanadoSeleccionado }}">
                @endif
                @if (filled($ganadoId))
                    <input type="hidden" name="ganado_id" value="{{ $ganadoId }}">
                @endif
                @if (filled($busquedaGanado))
                    <input type="hidden" name="ganado_busqueda" value="{{ $busquedaGanado }}">
                @endif
                <div class="flex-1">
                    <input name="q_engorde" type="text" value="{{ $busquedaEngorde }}" placeholder="Buscar por nombre, codigo arete o fecha..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium">
                        <span class="material-symbols-sharp">filter_list</span>
                    </button>
                    <a href="{{ route('panel.ganado') }}#engordes-section" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        @if ($engordes->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arete</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso Inicial</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso Final</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($engordes as $engorde)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $engorde->ganado?->codigo_arete ?? 'Sin arete' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($engorde->fecha_inicio)->format('d/m/Y') ?? 'Sin fecha' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">@decimal($engorde->peso_inicial) {{ $engorde->unidadInicial?->nombre ?? '' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($engorde->fecha_fin)->format('d/m/Y') ?? 'En proceso' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($engorde->peso_final !== null)
                                        @decimal($engorde->peso_final) {{ $engorde->unidadFinal?->nombre ?? '' }}
                                    @else
                                        Sin registro
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $engorde->ganado?->ventaGanados?->isNotEmpty() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $engorde->ganado?->ventaGanados?->isNotEmpty() ? 'Vendido' : 'Activo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3 whitespace-nowrap">
                                        <button type="button" onclick="openGanadoModal('view-engorde-{{ $engorde->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                        <button type="button" onclick="openGanadoModal('edit-engorde-{{ $engorde->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                        <form method="POST" action="{{ route('panel.ganado.engordes.destroy', $engorde) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar este engorde?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="q_engorde" value="{{ $busquedaEngorde }}">
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $engordes->count() }}</span> de <span class="font-medium">{{ $engordes->total() }}</span> resultados
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($engordes->onFirstPage())
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                        @else
                            <a href="{{ $engordes->previousPageUrl() }}#engordes-section" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                        @endif

                        @if ($engordes->hasMorePages())
                            <a href="{{ $engordes->nextPageUrl() }}#engordes-section" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                        @else
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="px-6 py-8 text-center text-sm text-gray-500">
                Aun no hay animales registrados en la tabla de engordes.
            </div>
        @endif
    </div>
</div>

<div id="addEngordeModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div id="addEngordeModalContent" class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <div class="flex items-start justify-between border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Agregar Engorde</h3>
                <p class="mt-1 text-sm text-gray-600">Registra un nuevo seguimiento de engorde para un animal.</p>
            </div>
            <button type="button" onclick="closeAddEngordeModal()" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600">
                <span class="material-symbols-sharp">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            @if ($ganadosFamilia->isNotEmpty())
                @if ($errors->any() && old('form_context') === 'engorde')
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="engorde-form" class="space-y-6" method="POST" action="{{ route('panel.ganado.engordes.store') }}">
                    @csrf
                    <input type="hidden" name="form_context" value="engorde">
                    <input type="hidden" name="q_engorde" value="{{ $busquedaEngorde }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Animal</label>
                        <input type="hidden" name="id_ganado" id="engorde_ganado_id" value="{{ old('id_ganado') }}">
                        <input
                            type="text"
                            id="engorde_ganado_selector"
                            list="engordes-ganados-list"
                            value="{{ $ganadosFamilia->firstWhere('id', (int) old('id_ganado'))?->codigo_arete ? $ganadosFamilia->firstWhere('id', (int) old('id_ganado'))->codigo_arete . ' - ' . $ganadosFamilia->firstWhere('id', (int) old('id_ganado'))->nombre_o_default : '' }}"
                            placeholder="Buscar por arete o nombre del animal..."
                            autocomplete="off"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            required
                        >
                        <datalist id="engordes-ganados-list">
                            @foreach ($ganadosFamilia as $ganadoFamilia)
                                <option
                                    value="{{ $ganadoFamilia->codigo_arete }} - {{ $ganadoFamilia->nombre_o_default }}"
                                    data-id="{{ $ganadoFamilia->id }}"
                                ></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio</label>
                            <input name="fecha_inicio" type="date" value="{{ old('fecha_inicio', date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Fin (O)</label>
                            <input name="fecha_fin" type="date" value="{{ old('fecha_fin') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_180px] gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Peso Inicial</label>
                        <input name="peso_inicial" type="text" inputmode="decimal" value="{{ $formatInputNumber(old('peso_inicial')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="450" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unidad Inicial</label>
                                <select name="id_unidad_i" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($unidadesPeso as $unidadPeso)
                                        <option value="{{ $unidadPeso->id }}" @selected(old('id_unidad_i') == $unidadPeso->id)>{{ ucfirst($unidadPeso->nombre) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_180px] gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Peso Final (O)</label>
                                <input name="peso_final" type="text" inputmode="decimal" value="{{ $formatInputNumber(old('peso_final')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unidad Final (O)</label>
                                <select name="id_unidad_f" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    <option value="">Seleccionar</option>
                                    @foreach ($unidadesPeso as $unidadPeso)
                                        <option value="{{ $unidadPeso->id }}" @selected(old('id_unidad_f') == $unidadPeso->id)>{{ ucfirst($unidadPeso->nombre) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                        <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Notas sobre la evolucion del engorde...">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeAddEngordeModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">Guardar Registro</button>
                    </div>
                </form>
            @else
                <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">
                    Primero debes registrar animales en ganado para poder agregar engordes.
                </div>
            @endif
        </div>
    </div>
</div>

@foreach ($engordes as $engorde)
<div id="view-engorde-{{ $engorde->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Detalle de Engorde</h3>
                <p class="mt-1 text-sm text-gray-600">Consulta la información registrada para este proceso.</p>
            </div>
            <button onclick="closeGanadoModal('view-engorde-{{ $engorde->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Animal</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $engorde->ganado?->codigo_arete ?? 'Sin arete' }} - {{ $engorde->ganado?->nombre_o_default ?? 'Sin nombre' }}</p>
                </div>
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Fecha de Inicio</p>
                    <p class="mt-1 text-sm text-gray-900">{{ optional($engorde->fecha_inicio)->format('d/m/Y') ?? 'Sin fecha' }}</p>
                </div>
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Peso Inicial</p>
                    <p class="mt-1 text-sm text-gray-900">@decimal($engorde->peso_inicial) {{ $engorde->unidadInicial?->nombre ?? '' }}</p>
                </div>
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Fecha de Fin</p>
                    <p class="mt-1 text-sm text-gray-900">{{ optional($engorde->fecha_fin)->format('d/m/Y') ?? 'En proceso' }}</p>
                </div>
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Peso Final</p>
                    <p class="mt-1 text-sm text-gray-900">
                        @if ($engorde->peso_final !== null)
                            @decimal($engorde->peso_final) {{ $engorde->unidadFinal?->nombre ?? '' }}
                        @else
                            Sin registro
                        @endif
                    </p>
                </div>
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Observaciones</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $engorde->observaciones ?: 'Sin observaciones' }}</p>
                </div>
            </div>
            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeGanadoModal('view-engorde-{{ $engorde->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-all duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="edit-engorde-{{ $engorde->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Engorde</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza la información del proceso de engorde.</p>
            </div>
            <button onclick="closeGanadoModal('edit-engorde-{{ $engorde->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <form class="space-y-6" method="POST" action="{{ route('panel.ganado.engordes.update', $engorde) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_context" value="engorde_edit">
                <input type="hidden" name="q_engorde" value="{{ $busquedaEngorde }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Animal</label>
                    <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        @foreach ($ganadosFamilia as $ganadoFamilia)
                            <option value="{{ $ganadoFamilia->id }}" @selected($engorde->id_ganado == $ganadoFamilia->id)>{{ $ganadoFamilia->codigo_arete }} - {{ $ganadoFamilia->nombre_o_default }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio</label>
                        <input name="fecha_inicio" type="date" value="{{ optional($engorde->fecha_inicio)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Fin (O)</label>
                        <input name="fecha_fin" type="date" value="{{ optional($engorde->fecha_fin)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-1 sm:grid-cols-[1fr_180px] gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peso Inicial</label>
                            <input name="peso_inicial" type="text" inputmode="decimal" value="{{ $formatInputNumber($engorde->peso_inicial) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unidad Inicial</label>
                            <select name="id_unidad_i" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                                @foreach ($unidadesPeso as $unidadPeso)
                                    <option value="{{ $unidadPeso->id }}" @selected($engorde->id_unidad_i == $unidadPeso->id)>{{ ucfirst($unidadPeso->nombre) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-[1fr_180px] gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peso Final (O)</label>
                            <input name="peso_final" type="text" inputmode="decimal" value="{{ $formatInputNumber($engorde->peso_final) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unidad Final (O)</label>
                            <select name="id_unidad_f" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Seleccionar</option>
                                @foreach ($unidadesPeso as $unidadPeso)
                                    <option value="{{ $unidadPeso->id }}" @selected($engorde->id_unidad_f == $unidadPeso->id)>{{ ucfirst($unidadPeso->nombre) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                    <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $engorde->observaciones }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeGanadoModal('edit-engorde-{{ $engorde->id }}')" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Cancelar</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">Actualizar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('familia-ganado-form');
        const hiddenInput = document.getElementById('ganado_id');
        const selectorInput = document.getElementById('ganado_selector');
        const datalist = document.getElementById('ganados-list');

        if (!form || !hiddenInput || !selectorInput || !datalist) {
            return;
        }

        const options = Array.from(datalist.options);

        const resolverSeleccion = () => {
            const termino = selectorInput.value.trim().toLowerCase();

            if (termino === '') {
                hiddenInput.value = '';
                return;
            }

            const exacta = options.find((option) => option.value.toLowerCase() === termino);
            hiddenInput.value = exacta?.dataset.id ?? '';
        };

        selectorInput.addEventListener('input', resolverSeleccion);
        selectorInput.addEventListener('change', resolverSeleccion);
        form.addEventListener('submit', resolverSeleccion);
    });
</script>
@endsection

@section('modals')
<div id="addGanadoModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out" id="addGanadoModalContent">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Informacion del Animal</h3>
                <p class="mt-1 text-sm text-gray-600">Completa los datos principales para registrar un nuevo ganado.</p>
            </div>
            <button onclick="closeAddGanadoModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('panel.ganado.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_codigo_arete" class="block text-sm font-medium text-gray-700 mb-2">Numero de arete</label>
                        <input id="modal_codigo_arete" name="codigo_arete" type="number" min="1" value="{{ old('codigo_arete') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ej: 1001" required>
                    </div>
                    <div>
                        <label for="modal_nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre (O)</label>
                        <input id="modal_nombre" name="nombre" type="text" value="{{ old('nombre') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Nombre del animal">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_codigo_madre" class="block text-sm font-medium text-gray-700 mb-2">Arete madre (O)</label>
                        <input list="madres-list" id="modal_codigo_madre" name="codigo_madre" value="{{ old('codigo_madre') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Seleccionar o escribir arete">
                        <datalist id="madres-list">
                            @foreach ($madresDisponibles as $madre)
                                <option value="{{ $madre->codigo_arete }}">{{ $madre->codigo_arete }} - {{ $madre->tipoRaza?->raza ?? 'Sin raza' }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label for="modal_codigo_padre" class="block text-sm font-medium text-gray-700 mb-2">Arete padre (O)</label>
                        <input list="padres-list" id="modal_codigo_padre" name="codigo_padre" value="{{ old('codigo_padre') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Seleccionar o escribir arete">
                        <datalist id="padres-list">
                            @foreach ($padresDisponibles as $padre)
                                <option value="{{ $padre->codigo_arete }}">{{ $padre->codigo_arete }} - {{ $padre->tipoRaza?->raza ?? 'Sin raza' }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_id_raza" class="block text-sm font-medium text-gray-700 mb-2">Raza</label>
                        <select id="modal_id_raza" name="id_raza" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar raza</option>
                            @foreach ($tiposRaza as $tipoRaza)
                                <option value="{{ $tipoRaza->id }}" @selected(old('id_raza') == $tipoRaza->id)>{{ $tipoRaza->raza }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modal_id_sexo" class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                        <select id="modal_id_sexo" name="id_sexo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required data-ganado-sexo>
                            <option value="">Seleccionar sexo</option>
                            @foreach ($tiposSexo as $tipoSexo)
                                <option value="{{ $tipoSexo->id }}" @selected(old('id_sexo') == $tipoSexo->id)>{{ ucfirst($tipoSexo->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento (O)</label>
                        <input id="modal_fecha_nacimiento" name="fecha_nacimiento" type="date" value="{{ old('fecha_nacimiento') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="modal_fecha_aquisicion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Adquisicion (O)</label>
                        <input id="modal_fecha_aquisicion" name="fecha_aquisicion" type="date" value="{{ old('fecha_aquisicion') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_edad" class="block text-sm font-medium text-gray-700 mb-2">Edad</label>
                        <input id="modal_edad" name="edad" type="number" min="0" value="{{ old('edad') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="24" required>
                    </div>
                    <div>
                        <label for="modal_id_edad" class="block text-sm font-medium text-gray-700 mb-2">Unidad de Edad</label>
                        <select id="modal_id_edad" name="id_edad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar unidad</option>
                            @foreach ($tiposEdad as $tipoEdad)
                                <option value="{{ $tipoEdad->id }}" @selected(old('id_edad') == $tipoEdad->id)>{{ ucfirst($tipoEdad->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_peso_actual" class="block text-sm font-medium text-gray-700 mb-2">Peso Actual (O)</label>
                        <input id="modal_peso_actual" name="peso_actual" type="text" inputmode="decimal" value="{{ $formatInputNumber(old('peso_actual')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="450">
                    </div>
                    <div>
                        <label for="modal_id_peso" class="block text-sm font-medium text-gray-700 mb-2">Unidad de Peso</label>
                        <select id="modal_id_peso" name="id_peso" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar unidad</option>
                            @foreach ($unidadesPeso as $unidadPeso)
                                <option value="{{ $unidadPeso->id }}" @selected(old('id_peso') == $unidadPeso->id)>{{ ucfirst($unidadPeso->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="modal_id_estado_salud" class="block text-sm font-medium text-gray-700 mb-2">Estado de Salud</label>
                        <select id="modal_id_estado_salud" name="id_estado_salud" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar estado</option>
                            @foreach ($estadosSalud as $estadoSalud)
                                <option value="{{ $estadoSalud->id }}" @selected(old('id_estado_salud') == $estadoSalud->id)>{{ ucfirst($estadoSalud->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modal_id_tipo_ganado" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Ganado</label>
                        <select id="modal_id_tipo_ganado" name="id_tipo_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" data-ganado-tipo required>
                            <option value="">Seleccionar tipo</option>
                            @foreach ($tiposGanado as $tipoGanado)
                                <option value="{{ $tipoGanado->id }}" data-nombre="{{ $tipoGanado->nombre }}" @selected(old('id_tipo_ganado') == $tipoGanado->id)>{{ $tipoGanado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="modal_observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                    <textarea id="modal_observaciones" name="observaciones" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Informacion adicional sobre el animal...">{{ old('observaciones') }}</textarea>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeAddGanadoModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
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

@foreach ($ganados as $ganado)
<div id="view-ganado-{{ $ganado->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-start justify-between border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle del Ganado</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles del animal registrado.</p>
            </div>
            <button onclick="closeGanadoModal('view-ganado-{{ $ganado->id }}')" class="rounded-full p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 bg-white">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Sexo</p>
                    <p class="mt-2 text-sm text-gray-900">{{ ucfirst($ganado->tipoSexo?->nombre ?? 'Sin sexo') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Nombre</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $ganado->nombre ?: 'Sin nombre' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Arete</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $ganado->codigo_arete }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Arete madre</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $ganado->madre?->codigo_arete ?? 'Sin registro' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Arete padre</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $ganado->padre?->codigo_arete ?? 'Sin registro' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Raza</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $ganado->tipoRaza?->raza ?? 'Sin raza' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Peso</p>
                    <p class="mt-2 text-sm text-gray-900">
                        @if ($ganado->peso_actual !== null)
                            @decimal($ganado->peso_actual) {{ $ganado->unidadPeso?->nombre }}
                        @else
                            Sin peso
                        @endif
                    </p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Edad</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $ganado->edad }} {{ $ganado->tipoEdad?->nombre }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Observaciones</p>
                    <p class="mt-2 text-sm leading-6 text-gray-900">{{ $ganado->observaciones ?: 'Sin observaciones registradas' }}</p>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeGanadoModal('view-ganado-{{ $ganado->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-all duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="edit-ganado-{{ $ganado->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Ganado</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza la información del animal registrado.</p>
            </div>
            <button onclick="closeGanadoModal('edit-ganado-{{ $ganado->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <form class="space-y-6" method="POST" action="{{ route('panel.ganado.update', $ganado) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numero de arete</label>
                        <input name="codigo_arete" type="number" min="1" value="{{ $ganado->codigo_arete }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre (O)</label>
                        <input name="nombre" type="text" value="{{ $ganado->nombre }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Arete madre (O)</label>
                        <input list="madres-list-edit-{{ $ganado->id }}" name="codigo_madre" value="{{ $ganado->madre?->codigo_arete }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Seleccionar o escribir arete">
                        <datalist id="madres-list-edit-{{ $ganado->id }}">
                            @foreach ($madresDisponibles as $madre)
                                <option value="{{ $madre->codigo_arete }}">{{ $madre->codigo_arete }} - {{ $madre->tipoRaza?->raza ?? 'Sin raza' }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Arete padre (O)</label>
                        <input list="padres-list-edit-{{ $ganado->id }}" name="codigo_padre" value="{{ $ganado->padre?->codigo_arete }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Seleccionar o escribir arete">
                        <datalist id="padres-list-edit-{{ $ganado->id }}">
                            @foreach ($padresDisponibles as $padre)
                                <option value="{{ $padre->codigo_arete }}">{{ $padre->codigo_arete }} - {{ $padre->tipoRaza?->raza ?? 'Sin raza' }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Raza</label>
                        <select name="id_raza" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($tiposRaza as $tipoRaza)
                                <option value="{{ $tipoRaza->id }}" @selected($ganado->id_raza == $tipoRaza->id)>{{ $tipoRaza->raza }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                        <select name="id_sexo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required data-ganado-sexo>
                            @foreach ($tiposSexo as $tipoSexo)
                                <option value="{{ $tipoSexo->id }}" @selected($ganado->id_sexo == $tipoSexo->id)>{{ ucfirst($tipoSexo->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento (O)</label>
                        <input name="fecha_nacimiento" type="date" value="{{ optional($ganado->fecha_nacimiento)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Adquisicion (O)</label>
                        <input name="fecha_aquisicion" type="date" value="{{ optional($ganado->fecha_aquisicion)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Edad</label>
                        <input name="edad" type="number" min="0" value="{{ $ganado->edad }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidad de Edad</label>
                        <select name="id_edad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($tiposEdad as $tipoEdad)
                                <option value="{{ $tipoEdad->id }}" @selected($ganado->id_edad == $tipoEdad->id)>{{ ucfirst($tipoEdad->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Peso Actual (O)</label>
                        <input name="peso_actual" type="text" inputmode="decimal" value="{{ $formatInputNumber($ganado->peso_actual) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidad de Peso</label>
                        <select name="id_peso" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($unidadesPeso as $unidadPeso)
                                <option value="{{ $unidadPeso->id }}" @selected($ganado->id_peso == $unidadPeso->id)>{{ ucfirst($unidadPeso->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Salud</label>
                        <select name="id_estado_salud" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar estado</option>
                            @foreach ($estadosSalud as $estadoSalud)
                                <option value="{{ $estadoSalud->id }}" @selected($ganado->id_estado_salud == $estadoSalud->id)>{{ ucfirst($estadoSalud->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Ganado</label>
                        <select name="id_tipo_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" data-ganado-tipo required>
                            <option value="">Seleccionar tipo</option>
                            @foreach ($tiposGanado as $tipoGanado)
                                <option value="{{ $tipoGanado->id }}" data-nombre="{{ $tipoGanado->nombre }}" @selected($ganado->id_tipo_ganado == $tipoGanado->id)>{{ $tipoGanado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                    <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $ganado->observaciones }}</textarea>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeGanadoModal('edit-ganado-{{ $ganado->id }}')" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium">
                        Actualizar Ganado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
const tiposGanadoPorSexo = @json($tiposGanadoPorSexo);

function normalizarTexto(valor) {
    return (valor || '').toString().trim().toLowerCase();
}

function sincronizarTiposGanadoPorSexo(sexoSelect, tipoSelect) {
    if (!sexoSelect || !tipoSelect) {
        return;
    }

    const sexoSeleccionado = normalizarTexto(sexoSelect.options[sexoSelect.selectedIndex]?.text || sexoSelect.value);
    const tiposPermitidos = tiposGanadoPorSexo[sexoSeleccionado] || [];

    Array.from(tipoSelect.options).forEach((option) => {
        if (!option.value) {
            option.hidden = false;
            option.disabled = false;
            return;
        }

        const nombreTipo = option.dataset.nombre || option.textContent.trim();
        const permitido = tiposPermitidos.includes(nombreTipo);

        option.hidden = tiposPermitidos.length > 0 && !permitido;
        option.disabled = tiposPermitidos.length > 0 && !permitido;
    });

    const opcionSeleccionada = tipoSelect.options[tipoSelect.selectedIndex];

    if (opcionSeleccionada && opcionSeleccionada.value && opcionSeleccionada.disabled) {
        tipoSelect.value = '';
    }
}

function inicializarFiltroTipoGanado(scope = document) {
    const formularios = scope.querySelectorAll('form');

    formularios.forEach((form) => {
        const sexoSelect = form.querySelector('[data-ganado-sexo]');
        const tipoSelect = form.querySelector('[data-ganado-tipo]');

        if (!sexoSelect || !tipoSelect || sexoSelect.dataset.tipoGanadoInicializado === 'true') {
            return;
        }

        const actualizar = () => sincronizarTiposGanadoPorSexo(sexoSelect, tipoSelect);

        sexoSelect.addEventListener('change', actualizar);
        sexoSelect.dataset.tipoGanadoInicializado = 'true';
        actualizar();
    });
}

function inicializarBuscadorConDatalist({ formId, hiddenId, inputId, datalistId }) {
    const form = document.getElementById(formId);
    const hiddenInput = document.getElementById(hiddenId);
    const selectorInput = document.getElementById(inputId);
    const datalist = document.getElementById(datalistId);

    if (!form || !hiddenInput || !selectorInput || !datalist) {
        return;
    }

    const options = Array.from(datalist.options);

    const resolverSeleccion = () => {
        const termino = selectorInput.value.trim().toLowerCase();

        if (termino === '') {
            hiddenInput.value = '';
            return;
        }

        const exacta = options.find((option) => option.value.toLowerCase() === termino);
        hiddenInput.value = exacta?.dataset.id ?? '';
    };

    selectorInput.addEventListener('input', function () {
        selectorInput.setCustomValidity('');
        resolverSeleccion();
    });

    selectorInput.addEventListener('change', resolverSeleccion);

    form.addEventListener('submit', function (event) {
        resolverSeleccion();

        if (!hiddenInput.value && selectorInput.value.trim() !== '') {
            event.preventDefault();
            selectorInput.setCustomValidity('Selecciona un animal valido de la lista.');
            selectorInput.reportValidity();
            return;
        }

        selectorInput.setCustomValidity('');
    });
}

function openAddGanadoModal() {
    const modal = document.getElementById('addGanadoModal');
    const modalContent = document.getElementById('addGanadoModalContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
}

function closeAddGanadoModal() {
    const modal = document.getElementById('addGanadoModal');
    const modalContent = document.getElementById('addGanadoModalContent');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function openAddEngordeModal() {
    const modal = document.getElementById('addEngordeModal');
    const modalContent = document.getElementById('addEngordeModalContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
}

function closeAddEngordeModal() {
    const modal = document.getElementById('addEngordeModal');
    const modalContent = document.getElementById('addEngordeModalContent');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function showEngordeWarning(message) {
    window.alert(message);
}

function openGanadoModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
}

function closeGanadoModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const addGanadoModal = document.getElementById('addGanadoModal');
    const addGanadoModalContent = document.getElementById('addGanadoModalContent');
    const addEngordeModal = document.getElementById('addEngordeModal');
    const addEngordeModalContent = document.getElementById('addEngordeModalContent');
    const ganadoModals = document.querySelectorAll('[id^="view-ganado-"], [id^="edit-ganado-"], [id^="view-engorde-"], [id^="edit-engorde-"]');

    inicializarBuscadorConDatalist({
        formId: 'familia-ganado-form',
        hiddenId: 'ganado_id',
        inputId: 'ganado_selector',
        datalistId: 'ganados-list',
    });

    inicializarBuscadorConDatalist({
        formId: 'engorde-form',
        hiddenId: 'engorde_ganado_id',
        inputId: 'engorde_ganado_selector',
        datalistId: 'engordes-ganados-list',
    });

    inicializarFiltroTipoGanado();

    @if ($errors->any())
        @if (old('form_context') === 'engorde')
            openAddEngordeModal();
        @else
            openAddGanadoModal();
        @endif
    @endif

    addGanadoModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddGanadoModal();
        }
    });

    addGanadoModalContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    if (addEngordeModal && addEngordeModalContent) {
        addEngordeModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddEngordeModal();
            }
        });

        addEngordeModalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !addGanadoModal.classList.contains('hidden')) {
            closeAddGanadoModal();
        }

        if (e.key === 'Escape' && addEngordeModal && !addEngordeModal.classList.contains('hidden')) {
            closeAddEngordeModal();
        }
    });

    ganadoModals.forEach((ganadoModal) => {
        const panel = ganadoModal.querySelector('.modal-panel');

        ganadoModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeGanadoModal(ganadoModal.id);
            }
        });

        panel.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
@endsection
