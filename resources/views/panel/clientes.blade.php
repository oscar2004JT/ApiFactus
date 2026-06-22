@extends('panel.layout')
@section('titulo', 'Clientes')

@section('contenido')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Gestion de Clientes</h2>
            <p class="text-gray-600 mt-1">Administra la información de tus clientes.</p>
        </div>
        <button onclick="openAddClientModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center space-x-2">
            <span class="material-symbols-sharp">add</span>
            <span>Agregar Cliente</span>
        </button>
    </div>

    @if (session('status'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
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
        <script>
            window.addEventListener('load', () => openAddClientModal());
        </script>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('panel.clientes') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input name="q" type="text" value="{{ $busqueda }}" placeholder="Buscar por nombre, correo o telefono..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select name="tipo" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="todos" @selected($filtroTipo === 'todos')>Todos los tipos</option>
                    <option value="leche" @selected($filtroTipo === 'leche')>Leche</option>
                    <option value="ganado" @selected($filtroTipo === 'ganado')>Ganado</option>
                </select>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium" type="submit">
                    <span class="material-symbols-sharp">filter_list</span>
                </button>
                <a href="{{ route('panel.clientes') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium border border-gray-300 transition-colors duration-200">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Lista de Clientes</h3>
            <p class="mt-1 text-sm text-gray-600">Consulta los clientes registrados y su información de contacto.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-medium">{{ strtoupper(substr($cliente->nombre_completo, 0, 2)) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cliente->nombre_completo }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $cliente->tipo === 'leche' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($cliente->tipo) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cliente->correo_electronico }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3 whitespace-nowrap">
                                <button type="button" onclick="openClientModal('view-client-{{ $cliente->id }}')" class="text-blue-600 hover:text-blue-900">Ver</button>
                                <button type="button" onclick="openClientModal('edit-client-{{ $cliente->id }}')" class="text-yellow-600 hover:text-yellow-900">Editar</button>
                                <form method="POST" action="{{ route('panel.clientes.destroy', $cliente) }}" class="inline" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')">
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
                                Aun no tienes clientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ $clientes->count() }}</span> de <span class="font-medium">{{ $clientes->total() }}</span> resultados
                </div>
                <div class="flex items-center gap-2">
                    @if ($clientes->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-sm font-medium text-gray-400">&lt;</span>
                    @else
                        <a href="{{ $clientes->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&lt;</a>
                    @endif

                    @if ($clientes->hasMorePages())
                        <a href="{{ $clientes->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">&gt;</a>
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
<div id="addClientModal" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out" id="modalContent">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Agregar Nuevo Cliente</h3>
                <p class="text-sm text-gray-600">Completa la información del cliente</p>
            </div>
            <button onclick="closeAddClientModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all duration-200 hover:rotate-90">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <form class="space-y-6" id="addClientForm" method="POST" action="{{ route('panel.clientes.store') }}">
                @csrf

                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-gray-900">Informacion Basica</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input name="nombre_completo" type="text" value="{{ old('nombre_completo') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="Nombre del cliente" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select name="tipo" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                                <option value="leche" @selected(old('tipo', 'leche') === 'leche')>Leche</option>
                                <option value="ganado" @selected(old('tipo') === 'ganado')>Ganado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-6 border-t border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-900">Informacion de Contacto</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Correo Electronico</label>
                            <input name="correo_electronico" type="email" value="{{ old('correo_electronico') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="cliente@email.com" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Telefono</label>
                            <input name="telefono" type="text" value="{{ old('telefono') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="+57 300 123 4567" required>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Direccion (O)</label>
                        <textarea name="direccion" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Direccion completa del cliente...">{{ old('direccion') }}</textarea>
                    </div>
                </div>

                <div class="space-y-4 pt-6 border-t border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-900">Informacion Adicional</h4>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Observaciones (O)</label>
                        <textarea name="observaciones" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Informacion adicional...">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" onclick="closeAddClientModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-all duration-200 hover:shadow-md">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 font-medium transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5">
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($clientes as $cliente)
<div id="view-client-{{ $cliente->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-start justify-between border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detalle del Cliente</h3>
                <p class="mt-1 text-sm text-gray-600">Ver detalles del cliente.</p>
            </div>
            <button onclick="closeClientModal('view-client-{{ $cliente->id }}')" class="rounded-full p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 bg-white">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Tipo</p>
                    <p class="mt-2 text-sm text-gray-900">{{ ucfirst($cliente->tipo) }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Nombre</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $cliente->nombre_completo }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Correo</p>
                    <p class="mt-2 text-sm text-gray-900 break-all">{{ $cliente->correo_electronico }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Telefono</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $cliente->telefono }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Direccion</p>
                    <p class="mt-2 text-sm leading-6 text-gray-900">{{ $cliente->direccion ?: 'Sin direccion registrada' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Observaciones</p>
                    <p class="mt-2 text-sm leading-6 text-gray-900">{{ $cliente->observaciones ?: 'Sin observaciones registradas' }}</p>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="button" onclick="closeClientModal('view-client-{{ $cliente->id }}')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-all duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="edit-client-{{ $cliente->id }}" class="fixed inset-0 flex items-center justify-center p-4 hidden z-50" style="background-color: rgba(0, 0, 0, 0.7);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-hidden transform scale-95 opacity-0 transition-all duration-300 ease-out modal-panel">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-orange-50">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Editar Cliente</h3>
                <p class="text-sm text-gray-600">Actualiza la información del cliente</p>
            </div>
            <button onclick="closeClientModal('edit-client-{{ $cliente->id }}')" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2">
                <span class="material-symbols-sharp text-2xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]">
            <form class="space-y-6" method="POST" action="{{ route('panel.clientes.update', $cliente) }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-gray-900">Informacion Basica</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input name="nombre_completo" type="text" value="{{ $cliente->nombre_completo }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="Nombre del cliente" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select name="tipo" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                                <option value="leche" @selected($cliente->tipo === 'leche')>Leche</option>
                                <option value="ganado" @selected($cliente->tipo === 'ganado')>Ganado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-6 border-t border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-900">Informacion de Contacto</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Correo Electronico</label>
                            <input name="correo_electronico" type="email" value="{{ $cliente->correo_electronico }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="cliente@email.com" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Telefono</label>
                            <input name="telefono" type="text" value="{{ $cliente->telefono }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="+57 300 123 4567" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Direccion (O)</label>
                        <textarea name="direccion" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Direccion completa del cliente...">{{ $cliente->direccion }}</textarea>
                    </div>
                </div>

                <div class="space-y-4 pt-6 border-t border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-900">Informacion Adicional</h4>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Observaciones (O)</label>
                        <textarea name="observaciones" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Informacion adicional...">{{ $cliente->observaciones }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" onclick="closeClientModal('edit-client-{{ $cliente->id }}')" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-all duration-200 hover:shadow-md">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-medium transition-all duration-200 hover:from-green-700 hover:to-green-800 hover:shadow-lg transform hover:-translate-y-0.5">
                        Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
function openAddClientModal() {
    const modal = document.getElementById('addClientModal');
    const modalContent = document.getElementById('modalContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = '0px';
}

function openClientModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = '0px';
}

function closeAddClientModal() {
    const modal = document.getElementById('addClientModal');
    const modalContent = document.getElementById('modalContent');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '0px';
    }, 300);
}

function closeClientModal(id) {
    const modal = document.getElementById(id);
    const modalContent = modal.querySelector('.modal-panel');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '0px';
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addClientModal');
    const modalContent = document.getElementById('modalContent');
    const clientModals = document.querySelectorAll('[id^="view-client-"], [id^="edit-client-"]');

    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddClientModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeAddClientModal();
        }
    });

    modalContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    clientModals.forEach((clientModal) => {
        const panel = clientModal.querySelector('.modal-panel');

        clientModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeClientModal(clientModal.id);
            }
        });

        panel.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
@endsection
