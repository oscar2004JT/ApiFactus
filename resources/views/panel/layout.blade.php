<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('titulo', 'Panel - AgroGestor')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="min-h-full bg-gray-50 font-sans text-gray-900 lg:h-screen lg:overflow-hidden">
  @php
    $navigation = [
        ['route' => 'panel.index', 'label' => 'Inicio', 'icon' => 'grid_view', 'match' => 'panel.index'],
        ['route' => 'panel.ganado', 'label' => 'Ganado', 'icon' => 'pets', 'match' => 'panel.ganado*'],
        ['route' => 'panel.insumos', 'label' => 'Insumos', 'icon' => 'inventory_2', 'match' => 'panel.insumos*'],
        ['route' => 'panel.produccion', 'label' => 'Produccion', 'icon' => 'water_drop', 'match' => 'panel.produccion*'],
        ['route' => 'panel.ventas', 'label' => 'Ventas', 'icon' => 'point_of_sale', 'match' => 'panel.ventas*'],
        ['route' => 'panel.clientes', 'label' => 'Clientes', 'icon' => 'person_outline', 'match' => 'panel.clientes*'],
        ['route' => 'panel.registros', 'label' => 'Registros', 'icon' => 'receipt_long', 'match' => 'panel.registros*'],
        ['route' => 'panel.reportes', 'label' => 'Reportes', 'icon' => 'report_gmailerrorred', 'match' => 'panel.reportes*'],
        ['route' => 'panel.analytics', 'label' => 'Analisis', 'icon' => 'insights', 'match' => 'panel.analytics*'],
        ['route' => 'panel.configuracion', 'label' => 'Configuracion', 'icon' => 'settings', 'match' => 'panel.configuracion*'],
    ];
    $user = auth()->user();
  @endphp

  <div class="min-h-screen lg:grid lg:h-screen lg:grid-cols-[280px_minmax(0,1fr)] lg:overflow-hidden xl:grid-cols-[280px_minmax(0,1fr)_320px]">
    <div id="mobileOverlay" class="fixed inset-0 z-30 hidden bg-slate-950/45 backdrop-blur-sm lg:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-[86vw] max-w-[300px] -translate-x-full flex-col border-r border-gray-200 bg-white shadow-2xl transition-transform duration-300 lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:w-auto lg:max-w-none lg:translate-x-0 lg:overflow-hidden lg:shadow-none">
      <div class="flex items-center justify-between border-b border-gray-200 px-5 py-5 sm:px-6">
        <div class="flex min-w-0 items-center gap-3">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-green-600 shadow-sm">
            <span class="text-lg font-bold text-white">A</span>
          </div>
          <div class="min-w-0">
            <p class="truncate text-lg font-bold text-gray-900">AgroGestor</p>
            <p class="text-sm text-gray-500">Panel principal</p>
          </div>
        </div>
        <button id="closeSidebarButton" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 lg:hidden" aria-label="Cerrar menu">
          <span class="material-symbols-sharp">close</span>
        </button>
      </div>

      <nav class="flex-1 overflow-y-auto px-4 py-5">
        <div class="space-y-1.5">
          @foreach ($navigation as $item)
            @php($active = request()->routeIs($item['match']))
            @php($routeExists = Route::has($item['route']))
            <a
              href="{{ $routeExists ? route($item['route']) : '#' }}"
              class="{{ $active ? 'bg-green-50 text-green-700 shadow-sm ring-1 ring-green-100' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition"
            >
              <span class="material-symbols-sharp {{ $active ? 'text-green-600' : 'text-gray-400' }}">{{ $item['icon'] }}</span>
              <span class="min-w-0 truncate">{{ $item['label'] }}</span>
            </a>
          @endforeach
        </div>
      </nav>

    </aside>

    <aside id="mobileUserPanel" class="fixed inset-y-0 right-0 z-40 flex w-[86vw] max-w-[300px] flex-col border-l border-gray-200 bg-white shadow-2xl lg:hidden" data-open="false" style="transform: translateX(100%); pointer-events: none; transition: transform 300ms ease;">
      <div class="flex items-center justify-between border-b border-gray-200 px-5 py-5 sm:px-6">
        <div class="flex min-w-0 items-center gap-3">
          <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-green-600 shadow-sm">
            <span class="text-lg font-bold text-white">{{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}</span>
          </div>
          <div class="min-w-0">
            <p class="truncate text-lg font-bold text-gray-900">{{ $user?->name }}</p>
            <p class="text-sm text-gray-500">Accesos rapidos</p>
          </div>
        </div>
        <button id="closeMobileUserPanelButton" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-700" aria-label="Cerrar opciones de usuario">
          <span class="material-symbols-sharp">close</span>
        </button>
      </div>

      <div class="flex-1 space-y-4 overflow-y-auto px-4 py-5">
        <div class="rounded-2xl border border-green-100 bg-green-50 p-4">
          <h3 class="font-medium text-green-800">Notificaciones</h3>
          <p class="mt-1 text-sm text-green-700">No hay nuevas notificaciones.</p>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
          <h3 class="font-medium text-blue-800">Actividad Reciente</h3>
          <p class="mt-1 text-sm text-blue-700">Ultima actividad visible desde tu panel.</p>
        </div>
      </div>

      <div class="border-t border-gray-200 px-4 py-4">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-red-700">
            Cerrar sesion
          </button>
        </form>
      </div>
    </aside>

    <main class="min-w-0 lg:h-screen lg:overflow-y-auto">
      <header class="sticky top-0 z-20 border-b border-gray-200 bg-white/95 backdrop-blur lg:hidden">
        <div class="flex items-center justify-between gap-3 px-4 py-3 sm:px-6">
          <div class="flex items-center">
            <button id="openSidebarButton" type="button" class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm transition hover:bg-gray-50" aria-label="Abrir menu">
              <span class="material-symbols-sharp">menu</span>
            </button>
          </div>
          <button
            id="mobileUserMenuButton"
            type="button"
            class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-sm font-bold text-green-700 shadow-sm transition hover:bg-gray-50"
            aria-label="Abrir opciones de usuario"
            aria-expanded="false"
          >
            <span class="leading-none">
              {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
            </span>
          </button>
        </div>
      </header>

      <div class="panel-content mx-auto w-full max-w-7xl px-4 py-4 sm:px-6 sm:py-6 xl:px-8">
        @yield('contenido')
      </div>
    </main>

    <aside class="hidden border-l border-gray-200 bg-white xl:flex xl:h-screen xl:flex-col xl:overflow-hidden">
      <div class="border-b border-gray-200 px-6 py-6">
        <div class="flex items-center justify-between gap-3">
          <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-600 text-base font-bold text-white">
              {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
            </div>
            <div class="min-w-0">
              <p class="break-words text-base font-semibold leading-5 text-gray-900">{{ $user?->name }}</p>
            </div>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="shrink-0">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-xl bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
              Cerrar sesion
            </button>
          </form>
        </div>
      </div>

      <div class="flex-1 space-y-4 px-6 py-6">
        <div class="rounded-2xl border border-green-100 bg-green-50 p-4">
          <h3 class="font-medium text-green-800">Notificaciones</h3>
          <p class="mt-1 text-sm text-green-700">No hay nuevas notificaciones.</p>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
          <h3 class="font-medium text-blue-800">Actividad Reciente</h3>
          <p class="mt-1 text-sm text-blue-700">Ultima actividad visible desde tu panel.</p>
        </div>
      </div>
    </aside>
  </div>

  @yield('modals')

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('mobileOverlay');
      const openButton = document.getElementById('openSidebarButton');
      const closeButton = document.getElementById('closeSidebarButton');
      const mobileUserMenuButton = document.getElementById('mobileUserMenuButton');
      const mobileUserPanel = document.getElementById('mobileUserPanel');
      const closeMobileUserPanelButton = document.getElementById('closeMobileUserPanelButton');

      if (!sidebar || !overlay) {
        return;
      }

      function openUserMenu() {
        if (!mobileUserPanel || !mobileUserMenuButton) {
          return;
        }

        closeSidebar();
        mobileUserPanel.style.transform = 'translateX(0)';
        mobileUserPanel.style.pointerEvents = 'auto';
        mobileUserPanel.dataset.open = 'true';
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        mobileUserMenuButton.setAttribute('aria-expanded', 'true');
      }

      function closeUserMenu() {
        if (!mobileUserPanel || !mobileUserMenuButton) {
          return;
        }

        mobileUserPanel.style.transform = 'translateX(100%)';
        mobileUserPanel.style.pointerEvents = 'none';
        mobileUserPanel.dataset.open = 'false';
        if (sidebar.classList.contains('-translate-x-full')) {
          overlay.classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }
        mobileUserMenuButton.setAttribute('aria-expanded', 'false');
      }

      function toggleUserMenu() {
        if (!mobileUserPanel || mobileUserPanel.dataset.open !== 'true') {
          openUserMenu();
          return;
        }

        closeUserMenu();
      }

      function openSidebar() {
        closeUserMenu();
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      }

      function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        if (!mobileUserPanel || mobileUserPanel.dataset.open !== 'true') {
          overlay.classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }
      }

      openButton?.addEventListener('click', openSidebar);
      closeButton?.addEventListener('click', closeSidebar);
      closeMobileUserPanelButton?.addEventListener('click', closeUserMenu);
      overlay.addEventListener('click', function () {
        closeSidebar();
        closeUserMenu();
      });
      mobileUserMenuButton?.addEventListener('click', toggleUserMenu);

      closeUserMenu();

      window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
          closeSidebar();
          closeUserMenu();
        }
      });
    });
  </script>
</body>
</html>
