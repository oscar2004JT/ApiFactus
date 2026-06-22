<x-layouts.app>
    <main class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <section class="text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-green-600 shadow-lg">
                    <span class="text-2xl font-bold text-white">A</span>
                </div>
                <h1 class="mt-6 text-3xl font-bold text-gray-900">ApiFactus</h1>
                <p class="mt-2 text-sm text-gray-600">Sistema de consumo Factus API V2</p>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-xl">
                <div class="flex border-b border-gray-200">
                    <a href="{{ route('login') }}" class="flex-1 border-b-2 border-green-600 px-6 py-4 text-center font-medium text-green-600">Iniciar Sesion</a>
                    <a href="{{ route('register') }}" class="flex-1 px-6 py-4 text-center font-medium text-gray-500">Registrarse</a>
                </div>

                <form class="space-y-6 p-6 sm:p-8" method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-gray-700">Correo Electronico</span>
                        <span class="relative block">
                            <input name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 transition focus:border-transparent focus:ring-2 focus:ring-green-500" placeholder="tu@email.com">
                            <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">email</span>
                        </span>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-gray-700">Contrasena</span>
                        <span class="relative block">
                            <input name="password" type="password" required autocomplete="current-password" class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 transition focus:border-transparent focus:ring-2 focus:ring-green-500" placeholder="********">
                            <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">lock</span>
                        </span>
                    </label>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <label class="flex items-center text-sm text-gray-700">
                            <input name="remember" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2">Recordarme</span>
                        </label>
                        <a href="#" class="text-sm font-medium text-green-600 hover:text-green-500">Olvidaste tu contrasena?</a>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-lg border border-red-200 bg-red-100 p-4 text-sm text-red-700">{{ $errors->first() }}</div>
                    @endif

                    <button type="submit" class="flex w-full justify-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-medium text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-green-700">
                        <span class="material-symbols-sharp">login</span>
                        Iniciar Sesion
                    </button>
                </form>
            </section>
        </div>
    </main>
</x-layouts.app>
