@extends('panel.layout')
@section('titulo', 'Pago pendiente')

@section('contenido')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Acceso en espera</h2>
            <p class="mt-1 text-gray-600">Tu cuenta ya fue creada, pero todavia esta pendiente la confirmacion manual del pago.</p>
        </div>
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

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Estado del acceso</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Pendiente</p>
                    <p class="text-xs text-orange-600 mt-1">Esperando aprobacion</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg">
                    <span class="material-symbols-sharp text-orange-600">schedule</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Correo</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Verificado</p>
                    <p class="text-xs text-green-600 mt-1">Registro completado</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                    <span class="material-symbols-sharp text-green-600">mark_email_read</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Siguiente paso</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Pago</p>
                    <p class="text-xs text-blue-600 mt-1">Luego llenas tus datos</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                    <span class="material-symbols-sharp text-blue-600">payments</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Estado de tu cuenta</h3>
        </div>
        <div class="p-6 space-y-4">
            <p class="text-sm text-gray-600 leading-6">
                Tu registro ya fue creado y tu correo puede quedar verificado, pero mientras tu pago
                no haya sido confirmado aun no podras entrar al sistema. Cuando el pago se confirme,
                el sistema te enviara a completar los datos personales para activar el panel.
            </p>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm font-semibold text-gray-900">Paso 1</p>
                    <p class="mt-2 text-sm text-gray-600">Tu cuenta ya existe y quedo lista para continuar con el proceso.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm font-semibold text-gray-900">Paso 2</p>
                    <p class="mt-2 text-sm text-gray-600">Cuando el pago quede confirmado, el acceso al sistema se habilitara.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm font-semibold text-gray-900">Paso 3</p>
                    <p class="mt-2 text-sm text-gray-600">Apenas el pago este aprobado, podras completar la informacion personal.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Accion disponible</h3>
        </div>
        <div class="p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <p class="text-sm text-gray-600">
                Si ya confirmaste el pago, usa este boton para revisar el estado actual de la cuenta.
            </p>

            <a
                href="{{ route('panel.pago-pendiente') }}"
                class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700"
            >
                Revisar estado del pago
            </a>
        </div>
    </div>
</div>
@endsection
