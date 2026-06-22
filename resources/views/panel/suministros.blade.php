@extends('panel.layout')
@section('titulo', 'Gestion de Insumos')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-6">
    <div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Gestion de Insumos</h2>
            <p class="text-gray-600 mt-1">Administra dos apartados desde este modulo: registra tus insumos en inventario y controla el consumo de productos usados en la operación o en animales específicos.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-700">
            {{ session('warning') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between gap-4 p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Lista de Insumos</h3>
                <p class="mt-1 text-sm text-gray-600">Consulta la información de tus productos registrados, revisa existencias y agrega nuevos insumos al inventario cuando lo necesites.</p>
            </div>
            <button type="button" onclick="openAddSuministroModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center space-x-2 shrink-0">
                <span class="material-symbols-sharp">add</span>
                <span>Agregar Insumo</span>
            </button>
        </div>
        <div class="border-b border-gray-200 bg-gray-50 p-6">
            <form method="GET" action="{{ route('panel.insumos') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input name="q" type="text" value="{{ $busqueda }}" placeholder="Buscar por nombre, categoria, proveedor, descripcion o medida..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div class="md:w-64">
                    <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Todas las categorias</option>
                        @foreach ($categoriasSuministro as $categoria)
                            <option value="{{ $categoria->id }}" @selected((string) $categoriaSeleccionada === (string) $categoria->id)>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                        <span class="material-symbols-sharp">filter_list</span>
                    </button>
                    <a href="{{ route('panel.insumos') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad medida</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad disponible</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($suministros as $suministro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $suministro->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $suministro->categoria?->nombre ?? 'Sin categoria' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ rtrim(rtrim(number_format((float) $suministro->cantidad_medida, 2, '.', ''), '0'), '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ rtrim(rtrim(number_format((float) $suministro->cantidad_disponible, 2, '.', ''), '0'), '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $suministro->medida?->nombre ?? 'Sin medida' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($suministro->fecha_vencimiento)->format('d/m/Y') ?: 'Sin fecha' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3 whitespace-nowrap">
                                    <button type="button" onclick="openSuministroModal('view-suministro-{{ $suministro->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                    <button type="button" onclick="openSuministroModal('edit-suministro-{{ $suministro->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                    <form method="POST" action="{{ route('panel.insumos.destroy', $suministro) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar este insumo?')">
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
                                Aun no hay insumos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ $suministros->count() }}</span> de <span class="font-medium">{{ $suministros->total() }}</span> resultados
                </div>
                <div class="flex items-center gap-2">
                    @if ($suministros->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                    @else
                        <a href="{{ $suministros->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                    @endif

                    @if ($suministros->hasMorePages())
                        <a href="{{ $suministros->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="consumir-insumos" class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between gap-4 p-6 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Consumir Insumos</h3>
                <p class="mt-1 text-sm text-gray-600">Registra salidas de inventario, consulta los movimientos realizados.</p>
            </div>
            <button type="button" onclick="openAddConsumoModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center space-x-2 shrink-0">
                <span class="material-symbols-sharp">add</span>
                <span>Agregar Consumo</span>
            </button>
        </div>
        <div class="border-b border-gray-200 bg-gray-50 p-6">
            <form method="GET" action="{{ route('panel.insumos') }}#consumir-insumos" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input name="q_consumo" type="text" value="{{ $busquedaConsumo ?? '' }}" placeholder="Buscar por ganado, fecha o insumo..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <input type="hidden" name="q" value="{{ $busqueda }}">
                <input type="hidden" name="pagina_consumo" value="{{ request('pagina_consumo') }}">
                @if (filled($categoriaSeleccionada))
                    <input type="hidden" name="categoria" value="{{ $categoriaSeleccionada }}">
                @endif
                <div class="flex gap-2">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                        <span class="material-symbols-sharp">filter_list</span>
                    </button>
                    <a href="{{ route('panel.insumos', array_filter(['q' => $busqueda, 'categoria' => $categoriaSeleccionada])) }}#consumir-insumos" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insumo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ganado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($consumos as $consumo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $consumo->suministro?->nombre ?? 'Insumo no disponible' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ rtrim(rtrim(number_format((float) $consumo->cantidad, 2, '.', ''), '0'), '.') }}
                                {{ $consumo->suministro?->medida?->nombre ? ' ' . $consumo->suministro->medida->nombre : '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($consumo->fecha)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $consumo->ganado?->nombre_o_default ?? 'General' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $consumo->motivo ?: 'Sin motivo' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3 whitespace-nowrap">
                                    <button type="button" onclick="openConsumoModal('view-consumo-{{ $consumo->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                    <button type="button" onclick="openConsumoModal('edit-consumo-{{ $consumo->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                    <form method="POST" action="{{ route('panel.insumos.consumos.destroy', $consumo) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar este consumo? La cantidad volvera al inventario.')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="q" value="{{ $busqueda }}">
                                        <input type="hidden" name="categoria" value="{{ $categoriaSeleccionada }}">
                                        <input type="hidden" name="q_consumo" value="{{ $busquedaConsumo }}">
                                        <input type="hidden" name="pagina_consumo" value="{{ request('pagina_consumo', $consumos->currentPage()) }}">
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                Aun no hay consumos de insumos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ $consumos->count() }}</span> de <span class="font-medium">{{ $consumos->total() }}</span> consumos
                </div>
                <div class="flex items-center gap-2">
                    @if ($consumos->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                    @else
                        <a href="{{ $consumos->previousPageUrl() }}#consumir-insumos" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                    @endif

                    @if ($consumos->hasMorePages())
                        <a href="{{ $consumos->nextPageUrl() }}#consumir-insumos" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&gt;</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<div id="addSuministroModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out" id="addSuministroModalContent">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Informacion del Insumo</h3>
                <p class="mt-1 text-sm text-gray-600">Completa los datos principales para registrar un nuevo insumo.</p>
            </div>
            <button type="button" onclick="closeAddSuministroModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            @if ($errors->any() && ! str_starts_with((string) old('form_context'), 'consumo_'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('panel.insumos.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input name="nombre" type="text" value="{{ old('nombre') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Nombre del insumo" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                        <select name="id_categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar categoria</option>
                            @foreach ($categoriasSuministro as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('id_categoria') == $categoria->id)>{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad por Medida</label>
                        <input name="cantidad_medida" type="text" inputmode="decimal" value="{{ old('cantidad_medida') !== null ? rtrim(rtrim(number_format((float) old('cantidad_medida'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ej: 10" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Medida</label>
                        <select name="id_medida" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar medida</option>
                            @foreach ($medidas as $medida)
                                <option value="{{ $medida->id }}" @selected(old('id_medida') == $medida->id)>{{ $medida->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Actual</label>
                        <input name="stock_actual" type="text" inputmode="decimal" value="{{ old('stock_actual') !== null ? rtrim(rtrim(number_format((float) old('stock_actual'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ej: 30" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Minimo</label>
                        <input name="stock_minimo" type="text" inputmode="decimal" value="{{ old('stock_minimo') !== null ? rtrim(rtrim(number_format((float) old('stock_minimo'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ej: 5" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Precio Unitario</label>
                        <input name="precio_unitario" type="text" inputmode="numeric" value="{{ old('precio_unitario') }}" data-format-number data-decimals="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ej: 25.000" autocomplete="off" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento (O)</label>
                        <input name="fecha_vencimiento" type="date" value="{{ old('fecha_vencimiento') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor (O)</label>
                        <input name="proveedor" type="text" value="{{ old('proveedor') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Nombre del proveedor">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripcion (O)</label>
                        <textarea name="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Descripcion del insumo">{{ old('descripcion') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeAddSuministroModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Cancelar</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addConsumoModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out" id="addConsumoModalContent">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Consumir Insumos</h3>
                <p class="mt-1 text-sm text-gray-600">Registra una salida de inventario asociada a un insumo y, si aplica, a un animal.</p>
            </div>
            <button type="button" onclick="closeAddConsumoModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            @if ($errors->any() && str_starts_with((string) old('form_context'), 'consumo_'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('panel.insumos.consumos.store') }}">
                @csrf
                <input type="hidden" name="form_context" value="consumo_create">
                <input type="hidden" name="q" value="{{ $busqueda }}">
                <input type="hidden" name="categoria" value="{{ $categoriaSeleccionada }}">
                <input type="hidden" name="q_consumo" value="{{ $busquedaConsumo }}">
                <input type="hidden" name="pagina_consumo" value="{{ request('pagina_consumo', $consumos->currentPage()) }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Insumo</label>
                        <select name="id_suministro" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Seleccionar insumo</option>
                            @foreach ($suministrosDisponibles as $insumoDisponible)
                                <option value="{{ $insumoDisponible->id }}" @selected(old('id_suministro') == $insumoDisponible->id)>
                                    {{ $insumoDisponible->nombre }}{{ $insumoDisponible->medida?->nombre ? ' - ' . $insumoDisponible->medida->nombre : '' }} - disponible {{ rtrim(rtrim(number_format((float) $insumoDisponible->cantidad_disponible, 2, '.', ''), '0'), '.') }}{{ $insumoDisponible->fecha_vencimiento ? ' - vence ' . $insumoDisponible->fecha_vencimiento->format('d/m/Y') : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad de medida a consumir</label>
                        <input name="cantidad" type="text" inputmode="decimal" value="{{ old('cantidad') !== null ? rtrim(rtrim(number_format((float) old('cantidad'), 2, '.', ''), '0'), '.') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ej: 1 medida" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input name="fecha" type="date" value="{{ old('fecha', date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ganado (O)</label>
                        <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Consumo general</option>
                            @foreach ($ganadosDisponibles as $ganadoDisponible)
                                <option value="{{ $ganadoDisponible->id }}" @selected(old('id_ganado') == $ganadoDisponible->id)>
                                    {{ $ganadoDisponible->nombre_o_default }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Motivo (O)</label>
                        <input name="motivo" type="text" value="{{ old('motivo') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Vacunacion, alimentacion, tratamiento...">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeAddConsumoModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Cancelar</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">Guardar Consumo</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($consumos as $consumo)
<div id="view-consumo-{{ $consumo->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle del Consumo</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles del consumo registrado.</p>
            </div>
            <button type="button" onclick="closeConsumoModal('view-consumo-{{ $consumo->id }}')" class="rounded-full p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 bg-white">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Insumo</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $consumo->suministro?->nombre ?? 'Insumo no disponible' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad</p>
                    <p class="mt-2 text-sm text-gray-900">
                        {{ rtrim(rtrim(number_format((float) $consumo->cantidad, 2, '.', ''), '0'), '.') }}
                        {{ $consumo->suministro?->medida?->nombre ?? '' }}
                    </p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Fecha</p>
                    <p class="mt-2 text-sm text-gray-900">{{ optional($consumo->fecha)->format('d/m/Y') ?: 'Sin fecha' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Ganado</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $consumo->ganado?->nombre_o_default ?? 'Consumo general' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Motivo</p>
                    <p class="mt-2 text-sm leading-6 text-gray-900">{{ $consumo->motivo ?: 'Sin motivo registrado' }}</p>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeConsumoModal('view-consumo-{{ $consumo->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-all duration-200">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-consumo-{{ $consumo->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Consumo</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza el movimiento y el inventario se ajustara automaticamente.</p>
            </div>
            <button type="button" onclick="closeConsumoModal('edit-consumo-{{ $consumo->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            @if ($errors->any() && old('form_context') === 'consumo_edit' && (string) old('consumo_id') === (string) $consumo->id)
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('panel.insumos.consumos.update', $consumo) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_context" value="consumo_edit">
                <input type="hidden" name="consumo_id" value="{{ $consumo->id }}">
                <input type="hidden" name="q" value="{{ $busqueda }}">
                <input type="hidden" name="categoria" value="{{ $categoriaSeleccionada }}">
                <input type="hidden" name="q_consumo" value="{{ $busquedaConsumo }}">
                <input type="hidden" name="pagina_consumo" value="{{ request('pagina_consumo', $consumos->currentPage()) }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Insumo</label>
                        <select name="id_suministro" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($suministrosDisponibles as $insumoDisponible)
                                <option value="{{ $insumoDisponible->id }}" @selected((old('form_context') === 'consumo_edit' && (string) old('consumo_id') === (string) $consumo->id ? old('id_suministro') : $consumo->id_suministro) == $insumoDisponible->id)>
                                    {{ $insumoDisponible->nombre }}{{ $insumoDisponible->medida?->nombre ? ' - ' . $insumoDisponible->medida->nombre : '' }} - disponible {{ rtrim(rtrim(number_format((float) $insumoDisponible->cantidad_disponible, 2, '.', ''), '0'), '.') }}{{ $insumoDisponible->fecha_vencimiento ? ' - vence ' . $insumoDisponible->fecha_vencimiento->format('d/m/Y') : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad de medida a consumir</label>
                        <input name="cantidad" type="text" inputmode="decimal" value="{{ old('form_context') === 'consumo_edit' && (string) old('consumo_id') === (string) $consumo->id ? (old('cantidad') !== null ? rtrim(rtrim(number_format((float) old('cantidad'), 2, '.', ''), '0'), '.') : '') : rtrim(rtrim(number_format((float) $consumo->cantidad, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input name="fecha" type="date" value="{{ old('form_context') === 'consumo_edit' && (string) old('consumo_id') === (string) $consumo->id ? old('fecha') : optional($consumo->fecha)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ganado (O)</label>
                        <select name="id_ganado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Consumo general</option>
                            @foreach ($ganadosDisponibles as $ganadoDisponible)
                                <option value="{{ $ganadoDisponible->id }}" @selected((old('form_context') === 'consumo_edit' && (string) old('consumo_id') === (string) $consumo->id ? old('id_ganado') : $consumo->id_ganado) == $ganadoDisponible->id)>
                                    {{ $ganadoDisponible->nombre_o_default }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Motivo (O)</label>
                        <input name="motivo" type="text" value="{{ old('form_context') === 'consumo_edit' && (string) old('consumo_id') === (string) $consumo->id ? old('motivo') : $consumo->motivo }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Vacunacion, alimentacion, tratamiento...">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeConsumoModal('edit-consumo-{{ $consumo->id }}')" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Cancelar</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">Actualizar Consumo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ($suministros as $suministro)
<div id="view-suministro-{{ $suministro->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle del Insumo</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles del insumo registrado.</p>
            </div>
            <button type="button" onclick="closeSuministroModal('view-suministro-{{ $suministro->id }}')" class="rounded-full p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Nombre</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $suministro->nombre }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Categoria</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $suministro->categoria?->nombre ?? 'Sin categoria' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad por Medida</p>
                    <p class="mt-2 text-sm text-gray-900">{{ rtrim(rtrim(number_format((float) $suministro->cantidad_medida, 2, '.', ''), '0'), '.') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Cantidad Disponible</p>
                    <p class="mt-2 text-sm text-gray-900">{{ rtrim(rtrim(number_format((float) $suministro->cantidad_disponible, 2, '.', ''), '0'), '.') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Medida</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $suministro->medida?->nombre ?? 'Sin medida' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Stock Actual</p>
                    <p class="mt-2 text-sm text-gray-900">{{ rtrim(rtrim(number_format((float) $suministro->stock_actual, 2, '.', ''), '0'), '.') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Stock Minimo</p>
                    <p class="mt-2 text-sm text-gray-900">{{ rtrim(rtrim(number_format((float) $suministro->stock_minimo, 2, '.', ''), '0'), '.') }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Precio Unitario</p>
                    <p class="mt-2 text-sm text-gray-900">${{ number_format((float) $suministro->precio_unitario, 0) }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Fecha de Vencimiento</p>
                    <p class="mt-2 text-sm text-gray-900">{{ optional($suministro->fecha_vencimiento)->format('d/m/Y') ?: 'Sin fecha registrada' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Proveedor</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $suministro->proveedor ?: 'Sin proveedor registrado' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Descripcion</p>
                    <p class="mt-2 text-sm leading-6 text-gray-900">{{ $suministro->descripcion ?: 'Sin descripcion registrada' }}</p>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeSuministroModal('view-suministro-{{ $suministro->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-all duration-200">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-suministro-{{ $suministro->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Insumo</h3>
                <p class="mt-1 text-sm text-gray-600">Actualiza la información del insumo registrado.</p>
            </div>
            <button type="button" onclick="closeSuministroModal('edit-suministro-{{ $suministro->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <form class="space-y-6" method="POST" action="{{ route('panel.insumos.update', $suministro) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input name="nombre" type="text" value="{{ $suministro->nombre }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                        <select name="id_categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($categoriasSuministro as $categoria)
                                <option value="{{ $categoria->id }}" @selected($suministro->id_categoria == $categoria->id)>{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad por Medida</label>
                        <input name="cantidad_medida" type="text" inputmode="decimal" value="{{ rtrim(rtrim(number_format((float) $suministro->cantidad_medida, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad Disponible</label>
                        <input name="cantidad_disponible" type="text" inputmode="decimal" value="{{ rtrim(rtrim(number_format((float) $suministro->cantidad_disponible, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Medida</label>
                        <select name="id_medida" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            @foreach ($medidas as $medida)
                                <option value="{{ $medida->id }}" @selected($suministro->id_medida == $medida->id)>{{ $medida->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Actual</label>
                        <input name="stock_actual" type="text" inputmode="decimal" value="{{ rtrim(rtrim(number_format((float) $suministro->stock_actual, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Minimo</label>
                        <input name="stock_minimo" type="text" inputmode="decimal" value="{{ rtrim(rtrim(number_format((float) $suministro->stock_minimo, 2, '.', ''), '0'), '.') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Precio Unitario</label>
                        <input name="precio_unitario" type="text" inputmode="numeric" value="{{ number_format((float) $suministro->precio_unitario, 0, '.', '') }}" data-format-number data-decimals="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" autocomplete="off" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento (O)</label>
                        <input name="fecha_vencimiento" type="date" value="{{ optional($suministro->fecha_vencimiento)->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor (O)</label>
                        <input name="proveedor" type="text" value="{{ $suministro->proveedor }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripcion (O)</label>
                        <textarea name="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $suministro->descripcion }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeSuministroModal('edit-suministro-{{ $suministro->id }}')" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium">Cancelar</button>
                    <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium">Actualizar Insumo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
function openAddSuministroModal() {
    const modal = document.getElementById('addSuministroModal');
    const modalContent = document.getElementById('addSuministroModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeAddSuministroModal() {
    const modal = document.getElementById('addSuministroModal');
    const modalContent = document.getElementById('addSuministroModalContent');
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function openAddConsumoModal() {
    const modal = document.getElementById('addConsumoModal');
    const modalContent = document.getElementById('addConsumoModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeAddConsumoModal() {
    const modal = document.getElementById('addConsumoModal');
    const modalContent = document.getElementById('addConsumoModalContent');
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function openConsumoModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeConsumoModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function openSuministroModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeSuministroModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
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

document.addEventListener('DOMContentLoaded', function() {
    setupFormattedPriceInputs();

    const addSuministroModal = document.getElementById('addSuministroModal');
    const addSuministroModalContent = document.getElementById('addSuministroModalContent');
    const addConsumoModal = document.getElementById('addConsumoModal');
    const addConsumoModalContent = document.getElementById('addConsumoModalContent');
    const suministroModals = document.querySelectorAll('[id^="view-suministro-"], [id^="edit-suministro-"]');
    const consumoModals = document.querySelectorAll('[id^="view-consumo-"], [id^="edit-consumo-"]');

    @if ($errors->any())
        @if (old('form_context') === 'consumo_create')
            openAddConsumoModal();
        @elseif (old('form_context') === 'consumo_edit' && old('consumo_id'))
            openConsumoModal('edit-consumo-{{ old('consumo_id') }}');
        @else
            openAddSuministroModal();
        @endif
    @endif

    addSuministroModal?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddSuministroModal();
        }
    });

    addSuministroModalContent?.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    addConsumoModal?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddConsumoModal();
        }
    });

    addConsumoModalContent?.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    suministroModals.forEach((suministroModal) => {
        const panel = suministroModal.querySelector('.modal-panel');
        suministroModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuministroModal(suministroModal.id);
            }
        });
        panel?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    consumoModals.forEach((consumoModal) => {
        const panel = consumoModal.querySelector('.modal-panel');
        consumoModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeConsumoModal(consumoModal.id);
            }
        });
        panel?.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
@endsection
