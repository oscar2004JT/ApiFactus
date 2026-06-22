<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0" />
  <title>Iniciar Sesión - AgroGestor</title>

</head>
<body class="h-full bg-gray-50 font-sans">
  <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Logo y título -->
      <div class="text-center">
        <div class="mx-auto w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-2xl">A</span>
        </div>
        <h2 class="mt-6 text-3xl font-bold text-gray-900">AgroGestor</h2>
        <p class="mt-2 text-sm text-gray-600">Sistema de gestión ganadera</p>
      </div>

      <!-- Formulario de login/registro -->
      @php
        $uiMode = $mode
          ?? request()->query('mode')
          ?? ((old('name') || old('apellido') || old('password_confirmation')) ? 'register' : 'login');
      @endphp
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        @if (session('status'))
          <div class="p-4 text-green-700 bg-green-100 border border-green-200">
            {{ session('status') }}
          </div>
        @endif
        @if ($errors->any() && $uiMode === 'login')
          <div class="p-4 text-red-700 bg-red-100 border border-red-200">
            <ul class="list-disc pl-5 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        @if ($uiMode === 'verify')
          <div class="p-4 text-gray-700 bg-blue-50 border border-blue-200 mb-4 rounded-lg">
            <p class="text-sm">
              Para continuar con el acceso es necesario verificar tu correo. Revisa la bandeja de entrada y haz clic en el enlace enviado.
            </p>
            <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
              @csrf
              <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Reenviar enlace de verificación</button>
            </form>
          </div>
        @endif
        <!-- Pestañas -->
        <div class="flex border-b border-gray-200">
          <button id="loginTab" class="flex-1 py-4 px-6 text-center font-medium transition-all duration-200 {{ $uiMode === 'login' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500' }}">
            Iniciar Sesión
          </button>
          <button id="registerTab" class="flex-1 py-4 px-6 text-center font-medium transition-all duration-200 {{ $uiMode === 'register' ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500' }}">
            Registrarse
          </button>
        </div>

        <!-- Formulario de Login -->
        <div id="loginForm" class="p-6 sm:p-8 {{ $uiMode === 'login' ? '' : 'hidden' }}">
          <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Correo Electrónico
              </label>
              <div class="relative">
                <input
                  id="email"
                  name="email"
                  type="email"
                  value="{{ old('email') }}"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="tu@email.com"
                >
                @error('email')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">email</span>
		              </div>
		            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Contraseña
              </label>
              <div class="relative">
                <input
                  id="password"
                  name="password"
                  type="password"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="••••••••"
                >
                @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">lock</span>
		              </div>
		            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
              <div class="flex items-center">
                <input
                  id="remember_me"
                  name="remember"
                  type="checkbox"
                  class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                  Recordarme
                </label>
              </div>

              <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                  ¿Olvidaste tu contraseña?
                </a>
		              </div>
		            </div>

            <button
              type="submit"
              class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5"
            >
              <span class="material-symbols-sharp mr-2">login</span>
              Iniciar Sesión
            </button>
          </form>
        </div>

        <!-- Formulario de Recuperación de Contraseña -->
        <div id="forgotForm" class="p-6 sm:p-8 {{ $uiMode === 'forgot' ? '' : 'hidden' }}">
          <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
              <label for="forgot_email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
              <div class="relative">
                <input
                  id="forgot_email"
                  name="email"
                  type="email"
                  value="{{ old('email') }}"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="tu@email.com"
                >
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">email</span>
              </div>
              @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
              Enviar enlace de restablecimiento
            </button>
          </form>
        </div>
        <!-- Formulario de Restablecer Contraseña -->
        <div id="resetForm" class="p-6 sm:p-8 {{ $uiMode === 'reset' ? '' : 'hidden' }}">
          <form class="space-y-6" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <div>
              <label for="reset_email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
              <div class="relative">
                <input
                  id="reset_email"
                  name="email"
                  type="email"
                  value="{{ old('email') }}"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="tu@email.com"
                >
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">email</span>
              </div>
              @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="reset_password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
              <div class="relative">
                <input
                  id="reset_password"
                  name="password"
                  type="password"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="••••••••"
                >
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">lock</span>
              </div>
              @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="reset_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
              <div class="relative">
                <input
                  id="reset_password_confirmation"
                  name="password_confirmation"
                  type="password"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="••••••••"
                >
		              </div>
		            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
              Restablecer Contraseña
            </button>
          </form>
        </div>

        <!-- Formulario de Registro -->
        <div id="registerForm" class="p-6 sm:p-8 {{ $uiMode === 'register' ? '' : 'hidden' }}">
          @if ($errors->any() && $uiMode === 'register')
            <div class="mb-6 text-red-700 bg-red-100 border border-red-200 p-4 rounded-lg">
              <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form class="space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                  Nombre
                </label>
                <div class="relative">
                  <input
                    id="first_name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                    placeholder="Juan"
                  >
                  @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
	                  <span class="material-symbols-sharp absolute left-3 top-3.5 text-gray-400 text-sm">person</span>
		              </div>
		            </div>

              <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                  Apellido
                </label>
                <div class="relative">
                  <input
                    id="last_name"
                    name="apellido"
                    type="text"
                    required
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                    placeholder="Pérez"
                  >
                  <span class="material-symbols-sharp absolute left-3 top-3.5 text-gray-400 text-sm">person</span>
                </div>
              </div>
            </div>

            <div>
              <label for="register_email" class="block text-sm font-medium text-gray-700 mb-2">
                Correo Electrónico
              </label>
              <div class="relative">
                <input
                  id="register_email"
                  name="email"
                  type="email"
                  value="{{ old('email') }}"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="tu@email.com"
                >
                @error('email')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">email</span>
              </div>
            </div>

            <div>
              <label for="register_password" class="block text-sm font-medium text-gray-700 mb-2">
                Contraseña
              </label>
              <div class="relative">
                <input
                  id="register_password"
                  name="password"
                  type="password"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="••••••••"
                >
                @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
	                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">lock</span>
	              </div>
	              <p class="mt-2 text-xs text-gray-500">Debe tener minimo 8 caracteres, una mayuscula, una minuscula, un numero y un simbolo.</p>
	            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Confirmar Contraseña
              </label>
              <div class="relative">
                <input
                  id="password_confirmation"
                  name="password_confirmation"
                  type="password"
                  required
                  class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                  placeholder="••••••••"
                >
                @error('password_confirmation')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <span class="material-symbols-sharp absolute left-4 top-3.5 text-gray-400">lock</span>
              </div>
            </div>

            <button
              type="submit"
              class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5"
            >
              <span class="material-symbols-sharp mr-2">person_add</span>
              Crear Cuenta
            </button>
          </form>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center">
        <p class="text-sm text-gray-600">
          Sistema de gestión para ganaderos
        </p>
      </div>
    </div>
  </div>

  <script>
    // Funcionalidad de cambio entre pestañas
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    loginTab.addEventListener('click', () => {
      loginTab.classList.add('text-green-600', 'border-b-2', 'border-green-600');
      loginTab.classList.remove('text-gray-500');
      registerTab.classList.remove('text-green-600', 'border-b-2', 'border-green-600');
      registerTab.classList.add('text-gray-500');

      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
    });

    registerTab.addEventListener('click', () => {
      registerTab.classList.add('text-green-600', 'border-b-2', 'border-green-600');
      registerTab.classList.remove('text-gray-500');
      loginTab.classList.remove('text-green-600', 'border-b-2', 'border-green-600');
      loginTab.classList.add('text-gray-500');

      registerForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
    });
  </script>
</body>
</html>

