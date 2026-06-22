@extends('panel.layout')
@section('titulo', 'Centro de Gestión')

@section('contenido')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Centro de Gestión</h2>
            <p class="text-gray-600 mt-1">Panel de control central del sistema</p>
        </div>
        <div class="flex space-x-3">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
                <span class="material-symbols-sharp">refresh</span>
                <span>Actualizar Datos</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ganado Total</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">247</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center">
                        <span class="material-symbols-sharp text-sm">trending_up</span>
                        +12 este mes
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Producción Hoy</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">127.5 L</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center">
                        <span class="material-symbols-sharp text-sm">trending_up</span>
                        +8% vs ayer
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ventas del Mes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">$45,230</p>
                    <p class="text-xs text-red-600 mt-1 flex items-center">
                        <span class="material-symbols-sharp text-sm">trending_down</span>
                        -3% vs mes anterior
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-yellow-600"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Alertas Activas</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">3</p>
                    <p class="text-xs text-orange-600 mt-1">Requieren atención</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg">
                    <span class="material-symbols-sharp text-red-600">warning</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Acciones Rápidas</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('panel.ganado') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition-colors">
                        <span class="material-symbols-sharp text-2xl text-green-600 mb-2">add</span>
                        <span class="text-sm font-medium text-gray-900 text-center">Registrar Ganado</span>
                    </a>
                    <a href="{{ route('panel.produccion') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                        <span class="text-sm font-medium text-gray-900 text-center">Registrar Producción</span>
                    </a>
                    <a href="{{ route('panel.ventas') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-yellow-600 mb-2"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                        <span class="text-sm font-medium text-gray-900 text-center">Registrar Venta</span>
                    </a>
                    <a href="{{ route('panel.clientes') }}" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition-colors">
                        <span class="material-symbols-sharp text-2xl text-purple-600 mb-2">person</span>
                        <span class="text-sm font-medium text-gray-900 text-center">Gestionar Clientes</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Estado del Sistema</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Base de Datos</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Conectado</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Backup Automático</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Sincronización</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En progreso</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Espacio en Disco</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">85% libre</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Actividad Reciente</h3>
                <a href="{{ route('panel.registros') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">Ver todo</a>
            </div>
        </div>
        <div class="divide-y divide-gray-200">
            <div class="p-6 flex items-center space-x-4">
                <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Nuevo ganado registrado</p>
                    <p class="text-sm text-gray-600">Vaca Holstein (GAN-005) agregada al sistema</p>
                </div>
                <span class="text-xs text-gray-500">Hace 2 horas</span>
            </div>
            <div class="p-6 flex items-center space-x-4">
                <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Producción registrada</p>
                    <p class="text-sm text-gray-600">25.5 litros de leche de GAN-001</p>
                </div>
                <span class="text-xs text-gray-500">Hace 4 horas</span>
            </div>
            <div class="p-6 flex items-center space-x-4">
                <div class="flex items-center justify-center w-10 h-10 bg-yellow-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-yellow-600"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Venta completada</p>
                    <p class="text-sm text-gray-600">Factura FAC-001 por $25,000</p>
                </div>
                <span class="text-xs text-gray-500">Hace 6 horas</span>
            </div>
        </div>
    </div>

    <!-- Alerts and Notifications -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Alertas y Notificaciones</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-start space-x-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                <span class="material-symbols-sharp text-red-600 mt-0.5">warning</span>
                <div class="flex-1">
                    <p class="text-sm font-medium text-red-800">Vacunación pendiente</p>
                    <p class="text-sm text-red-600">5 animales requieren vacunación contra aftosa</p>
                </div>
                <button class="text-red-600 hover:text-red-800 text-sm font-medium">Ver detalles</button>
            </div>
            <div class="flex items-start space-x-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <span class="material-symbols-sharp text-yellow-600 mt-0.5">info</span>
                <div class="flex-1">
                    <p class="text-sm font-medium text-yellow-800">Inventario bajo</p>
                    <p class="text-sm text-yellow-600">Alimentación para ganado por debajo del 20%</p>
                </div>
                <button class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Ver detalles</button>
            </div>
            <div class="flex items-start space-x-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <span class="material-symbols-sharp text-blue-600 mt-0.5">update</span>
                <div class="flex-1">
                    <p class="text-sm font-medium text-blue-800">Mantenimiento programado</p>
                    <p class="text-sm text-blue-600">Chequeo veterinario programado para mañana</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver detalles</button>
            </div>
        </div>
    </div>
</div>
@endsection
