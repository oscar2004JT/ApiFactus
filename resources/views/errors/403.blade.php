<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso no permitido | AgroGestor</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,_#ecfccb,_#f8fafc_45%,_#e5e7eb)] text-gray-900">
    <main class="mx-auto flex min-h-screen max-w-4xl items-center px-6 py-16">
        <section class="w-full overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-2xl shadow-green-900/10 backdrop-blur">
            <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="p-8 sm:p-10 lg:p-12">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-green-700">Error 403</p>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-gray-900 sm:text-4xl">
                        Esta accion no esta disponible para tu cuenta.
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-gray-600">
                        Intentaste entrar a una accion o registro que no te pertenece, o para la que no tienes permiso.
                    </p>
                    <p class="mt-3 max-w-2xl text-base leading-7 text-gray-600">
                        Si crees que esto es un error, vuelve al panel e intenta desde tu propia informacion registrada.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ auth()->check() ? route('panel.index') : route('login') }}" class="inline-flex items-center rounded-2xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                            {{ auth()->check() ? 'Volver al panel' : 'Ir a iniciar sesion' }}
                        </a>
                        <a href="{{ url()->previous() }}" class="inline-flex items-center rounded-2xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Regresar
                        </a>
                    </div>
                </div>

                <div class="relative hidden min-h-full overflow-hidden bg-gradient-to-br from-green-700 via-emerald-700 to-lime-600 lg:block">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,_rgba(255,255,255,0.22),_transparent_35%),radial-gradient(circle_at_80%_30%,_rgba(255,255,255,0.16),_transparent_28%),radial-gradient(circle_at_50%_80%,_rgba(255,255,255,0.14),_transparent_30%)]"></div>
                    <div class="relative flex h-full flex-col justify-between p-10 text-white">
                        <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-white/15 text-2xl font-black shadow-lg shadow-black/10">
                            403
                        </div>
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-lime-100/90">AgroGestor</p>
                            <p class="mt-3 text-2xl font-bold leading-tight">
                                Protegemos tus registros y solo permitimos acciones sobre la informacion autorizada.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
