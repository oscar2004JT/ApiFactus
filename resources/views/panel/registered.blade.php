@extends('panel.layout')
@section('titulo', 'Registros')

@section('contenido')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Registros del Sistema</h2>
            <p class="text-gray-600 mt-1">Vista general de todos los registros.</p>
        </div>
        <form method="GET" action="{{ route('panel.registros.exportar') }}" class="flex space-x-3">
            <select name="tipo" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="todos" {{ ($tipoSeleccionado ?? 'todos') === 'todos' ? 'selected' : '' }}>Todos los tipos</option>
                <option value="ganado" {{ ($tipoSeleccionado ?? '') === 'ganado' ? 'selected' : '' }}>Ganado</option>
                <option value="produccion" {{ ($tipoSeleccionado ?? '') === 'produccion' ? 'selected' : '' }}>Producción</option>
                <option value="ventas" {{ ($tipoSeleccionado ?? '') === 'ventas' ? 'selected' : '' }}>Ventas</option>
                <option value="clientes" {{ ($tipoSeleccionado ?? '') === 'clientes' ? 'selected' : '' }}>Clientes</option>
                <option value="insumos" {{ ($tipoSeleccionado ?? '') === 'insumos' ? 'selected' : '' }}>Insumos</option>
            </select>
            <select name="formato" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="pdf" @selected(request('formato', 'pdf') === 'pdf')>PDF</option>
                <option value="excel" @selected(request('formato') === 'excel')>Excel</option>
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
                <span class="material-symbols-sharp">download</span>
                <span>Exportar</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Ganado</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalGanadoActivo ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">Activos</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Registros de Produccion</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($registrosProduccionMes ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">Este mes</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ventas Registradas</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($ventasRegistradasMes ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">Este mes</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-yellow-600"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Clientes Activos</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($clientesActivos ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">Registrados</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                    <span class="material-symbols-sharp text-purple-600">person</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Actividad Reciente</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse (($actividadesRecientes ?? collect()) as $actividad)
                <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:gap-4">
                    <div class="flex items-center justify-center w-10 h-10 {{ $actividad['icono_bg'] }} rounded-lg">
                        @if (($actividad['icono'] ?? '') === 'pets')
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                        @elseif (($actividad['icono'] ?? '') === 'local_drink')
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                        @else
                            <span class="material-symbols-sharp {{ $actividad['icono_color'] }}">{{ $actividad['icono'] }}</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $actividad['titulo'] }}</p>
                        <p class="text-sm text-gray-600">{{ $actividad['descripcion'] }}</p>
                    </div>
                    <div class="flex flex-col gap-2 sm:items-end">
                        <span class="text-xs text-gray-500">{{ $actividad['tiempo'] }}</span>
                        @if (!empty($actividad['puede_revertir']))
                            <form method="POST" action="{{ route('panel.actividad.revertir', $actividad['id']) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center rounded-md border border-green-200 bg-green-50 px-3 py-1 text-xs font-medium text-green-700 hover:bg-green-100">
                                    Revertir
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-sm text-gray-500">
                    Aun no hay actividad reciente registrada.
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Acciones Rapidas</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('panel.ganado') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                    <span class="text-sm font-medium text-gray-900">Registrar Ganado</span>
                </a>
                <a href="{{ route('panel.produccion') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                    <span class="text-sm font-medium text-gray-900">Registrar Produccion</span>
                </a>
                <a href="{{ route('panel.ventas') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-yellow-600 mb-2"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                    <span class="text-sm font-medium text-gray-900">Registrar Venta</span>
                </a>
                <a href="{{ route('panel.clientes') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition-colors">
                    <span class="material-symbols-sharp text-2xl text-purple-600 mb-2">person</span>
                    <span class="text-sm font-medium text-gray-900">Gestionar Clientes</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
