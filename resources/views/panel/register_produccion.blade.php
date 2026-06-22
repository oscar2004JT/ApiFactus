@extends('panel.layout')
@section('titulo', 'Registrar Produccion de Leche')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Registrar Produccion de Leche</h2>
            <p class="text-gray-600 mt-1">Consulta tus registros de producción y agrega nuevos ordeños cuando lo necesites.</p>
        </div>
        <button type="button" @if ($ganados->isNotEmpty()) onclick="openAddProduccionModal()" @else onclick="showProduccionWarning('Primero debes registrar una vaca lactante disponible para agregar una producción.')" @endif class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center space-x-2 shrink-0">
            <span class="material-symbols-sharp">add</span>
            <span>Agregar Produccion</span>
        </button>
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

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('panel.produccion') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input name="q" type="text" value="{{ $busqueda }}" placeholder="Buscar por fecha, arete, nombre, raza o turno..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                    <span class="material-symbols-sharp">filter_list</span>
                </button>
                <a href="{{ route('panel.produccion') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Lista de Produccion</h3>
            <p class="mt-1 text-sm text-gray-600">Consulta los registros de producción almacenados en el sistema.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($producciones as $produccion)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($produccion->fecha_producion)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produccion->ganado?->codigo_arete }} - {{ $produccion->ganado?->tipoRaza?->raza ?? 'Sin raza' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">@decimal($produccion->cantidad) {{ $produccion->unidadLeche?->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    @decimal($produccion->calidad_leche ?? 0)%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3 whitespace-nowrap">
                                    <button type="button" onclick="openProduccionModal('view-produccion-{{ $produccion->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                    <button type="button" onclick="openProduccionModal('edit-produccion-{{ $produccion->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                    <form method="POST" action="{{ route('panel.produccion.destroy', $produccion) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta producción?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                Aún no hay producciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ $producciones->count() }}</span> de <span class="font-medium">{{ $producciones->total() }}</span> resultados
                </div>
                <div class="flex items-center gap-2">
                    @if ($producciones->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                    @else
                        <a href="{{ $producciones->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                    @endif

                    @if ($producciones->hasMorePages())
                        <a href="{{ $producciones->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Top 5 de Produccion por Animal</h3>
            <p class="text-sm text-gray-600 mt-1">Ranking de producción convertido a litros del último mes.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arete</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registros</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Litros</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($topProduccion as $registro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $registro['ganado']->nombre_o_default }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registro['ganado']->codigo_arete }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registro['ganado']->tipoRaza?->raza ?? 'Sin raza' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registro['registros'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">@decimal($registro['litros']) L</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                No hay producción registrada en el último mes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Produccion de Hoy</h3>
                <span class="text-sm text-gray-500">{{ date('d/m/Y') }}</span>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">@decimal($totalProduccionHoy) L</div>
                    <p class="text-sm text-gray-600">Total Produccion</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $animalesOrdenadosHoy }}</div>
                    <p class="text-sm text-gray-600">Animales Ordeñados</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">@decimal($promedioPorAnimalHoy) L</div>
                    <p class="text-sm text-gray-600">Promedio por Animal</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">@decimal($calidadPromedioHoy)%</div>
                    <p class="text-sm text-gray-600">Calidad Promedio</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('modals')
<div id="addProduccionModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out" id="addProduccionModalContent">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Registro de Produccion</h3>
                <p class="mt-1 text-sm text-gray-600">Completa el formulario para guardar una nueva producción de leche.</p>
            </div>
            <button onclick="closeAddProduccionModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
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

            <form class="space-y-6" method="POST" action="{{ route('panel.produccion.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input name="fecha_producion" type="date" value="{{ old('fecha_producion', date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Turno</label>
                        <select name="id_turno" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar turno</option>
                            @foreach ($tiposTurno as $tipoTurno)
                                <option value="{{ $tipoTurno->id }}" @selected(old('id_turno') == $tipoTurno->id)>{{ in_array($tipoTurno->nombre, ['maÃ±ana', 'mañana', 'manana'], true) ? 'Mañana' : ucfirst($tipoTurno->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Animal</label>
                    <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        <option value="">Seleccionar animal</option>
                        @foreach ($ganados as $ganado)
                            <option value="{{ $ganado->id }}" @selected(old('id_ganado') == $ganado->id)>{{ $ganado->codigo_arete }} - {{ $ganado->tipoRaza?->raza ?? 'Sin raza' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                        <input name="cantidad" type="text" inputmode="decimal" value="{{ old('cantidad') !== null ? rtrim(rtrim(number_format((float) old('cantidad'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="25.5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidad</label>
                        <select name="id_unidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar unidad</option>
                            @foreach ($unidadesLeche as $unidadLeche)
                                <option value="{{ $unidadLeche->id }}" @selected(old('id_unidad') == $unidadLeche->id)>{{ ucfirst($unidadLeche->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Calidad (%) (O)</label>
                        <input name="calidad_leche" type="text" inputmode="decimal" value="{{ old('calidad_leche') !== null ? rtrim(rtrim(number_format((float) old('calidad_leche'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="95">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura (C) (O)</label>
                        <input name="temperatura_leche" type="text" inputmode="decimal" value="{{ old('temperatura_leche') !== null ? rtrim(rtrim(number_format((float) old('temperatura_leche'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="4.5">
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Parametros de Calidad(O)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Grasa (%)</label>
                            <input name="grasa" type="text" inputmode="decimal" value="{{ old('grasa') !== null ? rtrim(rtrim(number_format((float) old('grasa'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="3.5">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Proteina (%)</label>
                            <input name="proteina" type="text" inputmode="decimal" value="{{ old('proteina') !== null ? rtrim(rtrim(number_format((float) old('proteina'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="3.2">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Lactosa (%)</label>
                            <input name="lactosa" type="text" inputmode="decimal" value="{{ old('lactosa') !== null ? rtrim(rtrim(number_format((float) old('lactosa'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="4.8">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">CCS (celulas)</label>
                            <input name="ccs" type="number" min="0" value="{{ old('ccs') }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="150000">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                    <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Notas adicionales sobre la producción...">{{ old('observaciones') }}</textarea>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeAddProduccionModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
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

@foreach ($producciones as $produccion)
<div id="view-produccion-{{ $produccion->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-start justify-between border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle de Produccion</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles del registro de producción.</p>
                {{--
                <span class="inline-flex w-fit px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    {{ in_array(($produccion->tipoTurno?->nombre ?? ''), ['maÃ±ana', 'mañana', 'manana'], true) ? 'Mañana' : ucfirst($produccion->tipoTurno?->nombre ?? 'Sin turno') }}
                </span>
                <p class="text-base font-medium text-gray-700">{{ $produccion->ganado?->codigo_arete }} - {{ $produccion->ganado?->tipoRaza?->raza ?? 'Sin raza' }}</p>
                --}}
            </div>
            <button onclick="closeProduccionModal('view-produccion-{{ $produccion->id }}')" class="rounded-full p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 bg-white">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Turno</p>
                    <p class="mt-2 text-sm text-gray-900">{{ in_array(($produccion->tipoTurno?->nombre ?? ''), ['maÃƒÂ±ana', 'maÃ±ana', 'mañana', 'manana'], true) ? 'Mañana' : ucfirst($produccion->tipoTurno?->nombre ?? 'Sin turno') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Animal</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $produccion->ganado?->codigo_arete }} - {{ $produccion->ganado?->tipoRaza?->raza ?? 'Sin raza' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Fecha</p>
                    <p class="mt-2 text-sm text-gray-900">{{ optional($produccion->fecha_producion)->format('d/m/Y') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad</p>
                    <p class="mt-2 text-sm text-gray-900">@decimal($produccion->cantidad) {{ $produccion->unidadLeche?->nombre }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Calidad</p>
                    <p class="mt-2 text-sm text-gray-900">@decimal($produccion->calidad_leche ?? 0)%</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Temperatura</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $produccion->temperatura_leche !== null ? rtrim(rtrim(number_format((float) $produccion->temperatura_leche, 2, '.', ','), '0'), '.') . ' C' : 'Sin dato' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Observaciones</p>
                    <p class="mt-2 text-sm leading-6 text-gray-900">{{ $produccion->observaciones ?: 'Sin observaciones registradas' }}</p>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeProduccionModal('view-produccion-{{ $produccion->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-all duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="edit-produccion-{{ $produccion->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Produccion</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza la información del registro de producción.</p>
            </div>
            <button onclick="closeProduccionModal('edit-produccion-{{ $produccion->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <form class="space-y-6" method="POST" action="{{ route('panel.produccion.update', $produccion) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input name="fecha_producion" type="date" value="{{ optional($produccion->fecha_producion)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Turno</label>
                        <select name="id_turno" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($tiposTurno as $tipoTurno)
                                <option value="{{ $tipoTurno->id }}" @selected($produccion->id_turno == $tipoTurno->id)>{{ in_array($tipoTurno->nombre, ['maÃ±ana', 'mañana', 'manana'], true) ? 'Mañana' : ucfirst($tipoTurno->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Animal</label>
                    <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        @foreach ($ganados as $ganado)
                            <option value="{{ $ganado->id }}" @selected($produccion->id_ganado == $ganado->id)>{{ $ganado->codigo_arete }} - {{ $ganado->tipoRaza?->raza ?? 'Sin raza' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                        <input name="cantidad" type="text" inputmode="decimal" value="{{ rtrim(rtrim(number_format((float) $produccion->cantidad, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidad</label>
                        <select name="id_unidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($unidadesLeche as $unidadLeche)
                                <option value="{{ $unidadLeche->id }}" @selected($produccion->id_unidad == $unidadLeche->id)>{{ ucfirst($unidadLeche->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Calidad (%) (O)</label>
                        <input name="calidad_leche" type="text" inputmode="decimal" value="{{ $produccion->calidad_leche !== null ? rtrim(rtrim(number_format((float) $produccion->calidad_leche, 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura (C) (O)</label>
                        <input name="temperatura_leche" type="text" inputmode="decimal" value="{{ $produccion->temperatura_leche !== null ? rtrim(rtrim(number_format((float) $produccion->temperatura_leche, 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Parametros de Calidad(O)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Grasa (%)</label>
                            <input name="grasa" type="text" inputmode="decimal" value="{{ $produccion->parametroCalidad?->grasa !== null ? rtrim(rtrim(number_format((float) $produccion->parametroCalidad->grasa, 2, '.', ''), '0'), '.') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Proteina (%)</label>
                            <input name="proteina" type="text" inputmode="decimal" value="{{ $produccion->parametroCalidad?->proteina !== null ? rtrim(rtrim(number_format((float) $produccion->parametroCalidad->proteina, 2, '.', ''), '0'), '.') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Lactosa (%)</label>
                            <input name="lactosa" type="text" inputmode="decimal" value="{{ $produccion->parametroCalidad?->lactosa !== null ? rtrim(rtrim(number_format((float) $produccion->parametroCalidad->lactosa, 2, '.', ''), '0'), '.') : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">CCS (celulas)</label>
                            <input name="ccs" type="number" min="0" value="{{ $produccion->parametroCalidad?->ccs }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (O)</label>
                    <textarea name="observaciones" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $produccion->observaciones }}</textarea>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeProduccionModal('edit-produccion-{{ $produccion->id }}')" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                        Actualizar Produccion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
function openAddProduccionModal() {
    const modal = document.getElementById('addProduccionModal');
    const modalContent = document.getElementById('addProduccionModalContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
}

function closeAddProduccionModal() {
    const modal = document.getElementById('addProduccionModal');
    const modalContent = document.getElementById('addProduccionModalContent');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function openProduccionModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
}

function closeProduccionModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function showProduccionWarning(message) {
    window.alert(message);
}

document.addEventListener('DOMContentLoaded', function() {
    const addProduccionModal = document.getElementById('addProduccionModal');
    const addProduccionModalContent = document.getElementById('addProduccionModalContent');
    const produccionModals = document.querySelectorAll('[id^="view-produccion-"], [id^="edit-produccion-"]');

    @if ($errors->any())
        openAddProduccionModal();
    @endif

    addProduccionModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddProduccionModal();
        }
    });

    addProduccionModalContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !addProduccionModal.classList.contains('hidden')) {
            closeAddProduccionModal();
        }
    });

    produccionModals.forEach((produccionModal) => {
        const panel = produccionModal.querySelector('.modal-panel');

        produccionModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeProduccionModal(produccionModal.id);
            }
        });

        panel.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
@endsection
