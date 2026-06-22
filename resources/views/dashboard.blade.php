<x-layouts.app>
    @php
        $user = auth()->user();
        $navigation = [
            ['endpoint' => 'token', 'label' => 'Token', 'icon' => 'vpn_key'],
            ['endpoint' => 'ranges', 'label' => 'Rangos', 'icon' => 'receipt_long'],
            ['endpoint' => 'bills', 'label' => 'Facturas', 'icon' => 'request_quote'],
            ['endpoint' => 'billNumber', 'label' => 'Por numero', 'icon' => 'tag'],
            ['endpoint' => 'billCustomer', 'label' => 'Por cliente', 'icon' => 'badge'],
            ['endpoint' => 'validate', 'label' => 'Crear factura', 'icon' => 'fact_check'],
            ['endpoint' => 'billShow', 'label' => 'Ver factura', 'icon' => 'visibility'],
            ['endpoint' => 'billPdf', 'label' => 'PDF factura', 'icon' => 'picture_as_pdf'],
            ['endpoint' => 'billXml', 'label' => 'XML factura', 'icon' => 'code'],
            ['endpoint' => 'billAttached', 'label' => 'XML adjunto', 'icon' => 'attach_file'],
            ['endpoint' => 'billEvents', 'label' => 'Eventos', 'icon' => 'event'],
            ['endpoint' => 'billEmail', 'label' => 'Enviar correo', 'icon' => 'mail'],
            ['endpoint' => 'creditNotes', 'label' => 'Notas credito', 'icon' => 'note_alt'],
            ['endpoint' => 'supportDocuments', 'label' => 'Soportes', 'icon' => 'description'],
            ['endpoint' => 'company', 'label' => 'Empresa', 'icon' => 'domain'],
        ];
    @endphp

    <div class="min-h-screen lg:grid lg:grid-cols-[280px_minmax(0,1fr)] xl:grid-cols-[280px_minmax(0,1fr)_320px]">
        <aside class="border-r border-gray-200 bg-white">
            <div class="flex items-center gap-3 border-b border-gray-200 px-6 py-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-600 shadow-sm">
                    <span class="text-lg font-bold text-white">A</span>
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-900">ApiFactus</p>
                    <p class="text-sm text-gray-500">Panel principal</p>
                </div>
            </div>

            <nav class="space-y-2 px-4 py-5" aria-label="Endpoints Factus">
                @foreach ($navigation as $item)
                    <button type="button" data-endpoint="{{ $item['endpoint'] }}" class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-semibold text-gray-700 transition hover:bg-gray-100 hover:text-gray-900 first:bg-green-50 first:text-green-700 first:ring-1 first:ring-green-100">
                        <span class="material-symbols-sharp text-gray-400">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </nav>
        </aside>

        <main class="min-w-0">
            <div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6 sm:px-6 xl:px-8">
                <header class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Centro de Gestion</h1>
                        <p class="mt-1 text-gray-600">Consume los endpoints de Factus API V2 desde un panel central.</p>
                    </div>
                    <div id="requestStatus" class="inline-flex w-fit items-center rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">Listo</div>
                </header>

                <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Autenticacion</p>
                                <p class="mt-1 text-3xl font-bold text-gray-900">OAuth</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                                <span class="material-symbols-sharp text-green-600">vpn_key</span>
                            </div>
                        </div>
                    </article>
                    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Facturas</p>
                                <p class="mt-1 text-3xl font-bold text-gray-900">API</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                                <span class="material-symbols-sharp text-red-600">request_quote</span>
                            </div>
                        </div>
                    </article>
                    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Version</p>
                                <p class="mt-1 text-3xl font-bold text-gray-900">V2</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100">
                                <span class="material-symbols-sharp text-yellow-600">fact_check</span>
                            </div>
                        </div>
                    </article>
                </section>

                <section class="grid grid-cols-1 gap-6 lg:grid-cols-[380px_minmax(0,1fr)]">
                    <form id="requestForm" class="rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-200 p-6">
                            <h2 id="endpointTitle" class="text-lg font-semibold text-gray-900">Obtener token</h2>
                            <span id="methodBadge" class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">POST</span>
                        </div>

                        <div class="space-y-5 p-6">
                            <div id="dynamicFields" class="space-y-4"></div>

                            <label id="payloadWrap" class="hidden">
                                Payload JSON
                                <textarea id="payloadInput" spellcheck="false"></textarea>
                            </label>

                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                                <span class="material-symbols-sharp">play_arrow</span>
                                Ejecutar consulta
                            </button>
                        </div>
                    </form>

                    <section class="rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900">Actividad Reciente</h2>
                            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50" id="clearResponse">Limpiar</button>
                        </div>
                        <pre id="responseBox" class="min-h-[360px] overflow-auto whitespace-pre-wrap break-words bg-white p-6 text-sm leading-6 text-gray-600">{}</pre>
                    </section>
                </section>
            </div>
        </main>

        <aside class="hidden border-l border-gray-200 bg-white xl:flex xl:flex-col">
            <div class="border-b border-gray-200 px-6 py-6">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-600 text-base font-bold text-white">
                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                        </div>
                        <p class="break-words text-base font-semibold leading-5 text-gray-900">{{ $user?->name }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="whitespace-nowrap rounded-xl bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">Cerrar sesion</button>
                    </form>
                </div>
            </div>

            <div class="space-y-4 px-6 py-6">
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
</x-layouts.app>
