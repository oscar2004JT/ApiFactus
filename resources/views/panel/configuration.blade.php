@extends('panel.layout')
@section('titulo', 'Configuracion')

@section('contenido')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Configuracion del Sistema</h2>
    </div>

    @if (session('warning'))
        <div class="rounded-xl border border-orange-200 bg-gradient-to-r from-orange-50 to-amber-50 px-4 py-3 text-sm text-orange-800">
            {{ session('warning') }}
        </div>
    @endif

    @if (session('status'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Configuracion General</h3>
        </div>
        <form class="p-6 space-y-6" method="POST" action="{{ route('panel.configuracion.general') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Finca</label>
                    <input
                        name="nombre_finca"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        value="{{ old('nombre_finca', $configuracionGeneral?->nombre_finca) }}"
                        placeholder="Ingresa el nombre de la finca"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ubicacion</label>
                    <input
                        name="ubicacion"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        value="{{ old('ubicacion', $configuracionGeneral?->ubicacion) }}"
                        placeholder="Ingresa la ubicacion de la finca"
                    >
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Moneda Predeterminada</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-transparent" disabled>
                        <option>COP - Peso Colombiano</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Idioma</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-transparent" disabled>
                        <option>Español</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end pt-2">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium" type="submit">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Datos Personales</h3>
        </div>
        <form class="p-6 space-y-6" method="POST" action="{{ route('panel.configuracion.datos-personales') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento</label>
                    <input
                        name="fecha_nacimiento"
                        type="date"
                        value="{{ old('fecha_nacimiento', optional($persona?->fecha_nacimiento)->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numero de Documento</label>
                    <input
                        name="numero_documento"
                        type="text"
                        value="{{ old('numero_documento', $persona?->numero_documento) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ingresa tu numero de documento"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                    <select name="id_documento" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option>Seleccionar tipo de documento</option>
                        @foreach ($tiposDocumento as $tipoDocumento)
                            <option value="{{ $tipoDocumento->id }}" @selected(old('id_documento', $persona?->id_documento) == $tipoDocumento->id)>
                                {{ $tipoDocumento->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                    <select name="id_sexo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option>Seleccionar sexo</option>
                        @foreach ($sexosPersona as $sexoPersona)
                            <option value="{{ $sexoPersona->id }}" @selected(old('id_sexo', $persona?->id_sexo) == $sexoPersona->id)>
                                {{ $sexoPersona->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex justify-end pt-2">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium" type="submit">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Configuracion de Produccion(proximo en implemtar)</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produccion Diaria Objetivo (L)</label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" value="150">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Temperatura Optima (C)</label>
                    <input type="number" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" value="4.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Calidad Minima (%)</label>
                    <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" value="90">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Unidades de Medida</label>
                <div class="flex space-x-6">
                    <label class="flex items-center">
                        <input type="radio" name="units" value="metric" class="text-green-600 focus:ring-green-500" checked>
                        <span class="ml-2 text-sm text-gray-700">Metrico (Litros, Kg)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="units" value="imperial" class="text-green-600 focus:ring-green-500">
                        <span class="ml-2 text-sm text-gray-700">Imperial (Galones, Lb)</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Notificaciones(proximo en implemtar)</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Alertas de Produccion Baja</h4>
                    <p class="text-sm text-gray-600">Notificar cuando la producción esté por debajo del 80%</p>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500" checked>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Recordatorios de Salud Animal</h4>
                    <p class="text-sm text-gray-600">Alertas para vacunaciones y chequeos veterinarios</p>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500" checked>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Reportes Semanales</h4>
                    <p class="text-sm text-gray-600">Enviar resumen semanal por email</p>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Alertas de Inventario</h4>
                    <p class="text-sm text-gray-600">Notificar cuando los suministros esten bajos</p>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500" checked>
                </label>
            </div>
        </div>
    </div>

</div>

@endsection
