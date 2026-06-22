@extends('panel.layout')
@section('titulo', 'Reportes')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Reportes</h2>
        <p class="text-gray-600 mt-1">Consulta indicadores clave del ganado y el resumen general de tu operación.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-5">
            <form method="GET" action="{{ route('panel.registros.exportar') }}" class="w-full xl:w-auto">
                <div class="flex flex-row flex-wrap items-center gap-3 xl:justify-end">
                    <select name="tipo" class="flex-1 min-w-[180px] px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="todos" @selected(request('tipo', 'todos') === 'todos')>Todos los tipos</option>
                        <option value="ganado" @selected(request('tipo') === 'ganado')>Ganado</option>
                        <option value="produccion" @selected(request('tipo') === 'produccion')>Producción</option>
                        <option value="ventas" @selected(request('tipo') === 'ventas')>Ventas</option>
                        <option value="clientes" @selected(request('tipo') === 'clientes')>Clientes</option>
                        <option value="insumos" @selected(request('tipo') === 'insumos')>Insumos</option>
                    </select>
                    <select name="periodo" class="flex-1 min-w-[180px] px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="7" @selected(request('periodo', '7') === '7')>Ultimos 7 dias</option>
                        <option value="15" @selected(request('periodo') === '15')>Ultimos 15 dias</option>
                        <option value="30" @selected(request('periodo') === '30')>Ultimos 30 dias</option>
                        <option value="90" @selected(request('periodo') === '90')>Ultimos 90 dias</option>
                        <option value="todos" @selected(request('periodo') === 'todos')>Todo el historial</option>
                    </select>
                    <select name="formato" class="min-w-[140px] px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="pdf" @selected(request('formato', 'pdf') === 'pdf')>PDF</option>
                        <option value="excel" @selected(request('formato') === 'excel')>Excel</option>
                    </select>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg font-medium inline-flex items-center justify-center space-x-2 whitespace-nowrap">
                        <span class="material-symbols-sharp">download</span>
                        <span>Exportar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ganado Activo</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($resumen['ganado_activo']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Animales disponibles</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Hembras y Machos</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($resumen['hembras_activas']) }} / {{ number_format($resumen['machos_activos']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Distribucion actual</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-lg">
                    <span class="material-symbols-sharp text-gray-600">group</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Crias Activas</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($resumen['crias_activas']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Terneros y terneras</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                    <span class="material-symbols-sharp text-blue-600">pets</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Animales sin filiacion</p>
                    <p class="text-2xl font-bold mt-1 text-gray-900">{{ number_format($resumen['sin_filiacion']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Sin madre ni padre registrados</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-amber-100 rounded-lg">
                    <span class="material-symbols-sharp text-amber-600">account_tree</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
