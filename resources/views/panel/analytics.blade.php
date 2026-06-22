@extends('panel.layout')
@section('titulo', 'Analitica')

@section('contenido')
<div class="space-y-6">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Analitica y Reportes</h2>
            <p class="text-gray-600 mt-1">Visualiza el rendimiento de tu finca.</p>
        </div>
        <form method="GET" action="{{ route('panel.analytics.export') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:flex xl:flex-wrap xl:justify-end">
                <select id="analytics-period" onchange="window.location.href='{{ route('panel.analytics') }}?period=' + encodeURIComponent(this.value)" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="7d" @selected(($periodoSeleccionado ?? '7d') === '7d')>Ultimos 7 dias</option>
                    <option value="30d" @selected(($periodoSeleccionado ?? '') === '30d')>Ultimos 30 dias</option>
                    <option value="3m" @selected(($periodoSeleccionado ?? '') === '3m')>Ultimos 3 meses</option>
                    <option value="1y" @selected(($periodoSeleccionado ?? '') === '1y')>Ultimo año</option>
                </select>
                <input type="hidden" name="period" value="{{ $periodoSeleccionado ?? '7d' }}">
                <select id="analytics-format" name="format" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center space-x-2 whitespace-nowrap sm:col-span-2 xl:col-span-1">
                    <span class="material-symbols-sharp">download</span>
                    <span>Exportar</span>
                </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Produccion Total</p>
                    <p class="text-[1.75rem] font-bold text-gray-900 mt-1">{{ number_format((float) ($produccionTotal ?? 0), 0) }} L</p>
                    <p class="text-xs text-{{ $tendenciaProduccion['color'] ?? 'green' }}-600 mt-1 flex items-center">
                        <span class="material-symbols-sharp text-sm">{{ $tendenciaProduccion['icono'] ?? 'trending_up' }}</span>
                        {{ $tendenciaProduccion['texto'] ?? '+0% vs periodo anterior' }}
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ingresos Totales</p>
                    <p class="text-[1.75rem] font-bold text-gray-900 mt-1">${{ number_format((float) ($ingresosTotales ?? 0), 0) }}</p>
                    <p class="text-xs text-{{ $tendenciaIngresos['color'] ?? 'green' }}-600 mt-1 flex items-center">
                        <span class="material-symbols-sharp text-sm">{{ $tendenciaIngresos['icono'] ?? 'trending_up' }}</span>
                        {{ $tendenciaIngresos['texto'] ?? '+0% vs periodo anterior' }}
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="28px" viewBox="0 -960 960 960" width="28px" fill="currentColor" class="text-yellow-600"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Produccion Promedio Día</p>
                    <p class="text-[1.75rem] font-bold text-gray-900 mt-1">{{ rtrim(rtrim(number_format((float) ($produccionPromedio ?? 0), 2, '.', ','), '0'), '.') }} L</p>
                    <p class="text-xs text-{{ $tendenciaProduccionPromedio['color'] ?? 'green' }}-600 mt-1 flex items-center">
                        <span class="material-symbols-sharp text-sm">{{ $tendenciaProduccionPromedio['icono'] ?? 'trending_up' }}</span>
                        {{ $tendenciaProduccionPromedio['texto'] ?? '+0% vs periodo anterior' }}
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                    <span class="material-symbols-sharp text-purple-600">analytics</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Produccion de Leche</h3>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-[radial-gradient(circle_at_top,_rgba(34,197,94,0.10),_transparent_45%),linear-gradient(180deg,_#f8fafc_0%,_#ffffff_100%)] p-5">
                <div class="mb-4 flex flex-col gap-3 px-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600" id="chart-title">{{ $chartPeriodTitle ?? 'Periodo seleccionado' }}</p>
                        <p class="text-xs text-gray-400" id="chart-subtitle">{{ $chartPeriodSubtitle ?? 'Litros producidos por fecha' }}</p>
                    </div>
                    <div class="rounded-lg bg-green-50 px-3 py-2 text-left sm:text-right">
                        <p class="text-[11px] uppercase tracking-wide text-green-700">Total</p>
                        <p class="text-sm font-semibold text-green-800" id="chart-total">0 L</p>
                    </div>
                </div>

                <div id="production-chart-wrapper" class="relative h-64 overflow-hidden rounded-xl border border-gray-200 bg-white px-4 py-4">
                    <div class="pointer-events-none absolute inset-0">
                        <div class="absolute inset-x-0 top-1/4 border-t border-dashed border-gray-200"></div>
                        <div class="absolute inset-x-0 top-2/4 border-t border-dashed border-gray-200"></div>
                        <div class="absolute inset-x-0 top-3/4 border-t border-dashed border-gray-200"></div>
                    </div>
                    <svg id="production-chart" viewBox="0 0 640 220" class="relative z-10 h-full w-full" preserveAspectRatio="none"></svg>
                    <div id="production-chart-tooltip" class="pointer-events-none absolute z-20 hidden max-w-[12rem] rounded-lg px-3 py-2 text-xs text-white" style="background-color: rgba(17, 24, 39, 0.96); border: 1px solid rgba(255, 255, 255, 0.14); box-shadow: 0 18px 40px rgba(15, 23, 42, 0.28);">
                        <p id="production-chart-tooltip-date" class="font-medium leading-4"></p>
                        <p id="production-chart-tooltip-value" class="mt-1 leading-4" style="color: rgba(255, 255, 255, 0.88);"></p>
                    </div>
                </div>

                <div id="chart-labels" class="mt-4 grid gap-2 text-xs text-gray-500" style="grid-template-columns: repeat({{ max(count($serieProduccionPeriodo ?? []), 1) }}, minmax(0, 1fr));"></div>

                <div class="mt-8 rounded-xl bg-emerald-50 px-4 py-3" style="border: 1px solid #a7f3d0;">
                    <p class="text-[11px] uppercase tracking-wide text-emerald-700">Ingresos Totales</p>
                    <p class="mt-1 text-lg font-semibold text-emerald-900" id="chart-income-total">$0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Ingresos por Categoria</h3>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="income-toggle px-3 py-1 text-sm rounded-lg bg-green-100 text-green-700" data-income-view="leche">Leche</button>
                    <button type="button" class="income-toggle px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg" data-income-view="ganado">Ganado</button>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-[radial-gradient(circle_at_top,_rgba(234,179,8,0.14),_transparent_45%),linear-gradient(180deg,_#fffdf7_0%,_#ffffff_100%)] px-3.5 pb-6 pt-10">
                <div class="mb-4 flex flex-col gap-3 px-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="mt-2 text-base font-semibold text-gray-900" id="income-category-title">Leche</p>
                    </div>
                    <div class="shrink-0 rounded-lg bg-yellow-50 px-3 py-1.5 text-left sm:text-right">
                        <p class="text-[11px] uppercase tracking-wide text-yellow-700">Total</p>
                        <p class="mt-1 text-sm font-semibold text-yellow-800" id="income-category-total">$0</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-center">
                        <div class="relative h-48 w-48">
                            <svg id="income-category-chart" viewBox="0 0 220 220" class="h-full w-full">
                                <circle cx="110" cy="110" r="74" fill="none" stroke="#eef2f7" stroke-width="24"></circle>
                                <circle id="income-arc-leche" cx="110" cy="110" r="74" fill="none" stroke="#2563eb" stroke-width="24" stroke-linecap="butt" transform="rotate(-90 110 110)"></circle>
                                <circle id="income-arc-ganado" cx="110" cy="110" r="74" fill="none" stroke="#16a34a" stroke-width="24" stroke-linecap="butt" transform="rotate(-90 110 110)"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-3">
                                <p class="text-[11px] uppercase tracking-wide text-gray-500">Participacion</p>
                                <p class="text-xl font-bold leading-none text-gray-900 mt-1" id="income-category-percent">0%</p>
                                <p class="mt-1 text-[11px] leading-4 text-gray-400">del ingreso total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div id="income-card-leche" class="rounded-2xl bg-blue-50/70 px-3 py-2.5 transition-all duration-200" style="box-shadow: 0 10px 22px rgba(37, 99, 235, 0.12);">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Leche</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">${{ number_format((float) ($ingresosLecheTotales ?? 0), 0) }}</p>
                            <p class="text-xs text-gray-500 mt-1" id="income-card-leche-percent">0% del ingreso total</p>
                        </div>
                        <div class="h-9 w-9 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-blue-600"><path d="m208-80-88-800h720L752-80H208Zm28-480 44 400h400l44-400H236Zm-10-80h508l16-160H210l16 160Zm230 350q-10-10-10-24 0-15 8.5-34.5T480-393q17 25 25.5 44.5T514-314q0 14-10 24t-24 10q-14 0-24-10Zm105 57q33-33 33-81 0-41-26.5-89T480-520q-61 69-87.5 117T366-314q0 48 33 81t81 33q48 0 81-33Zm-281 73h400-400Z"/></svg>
                        </div>
                    </div>
                </div>
                <div id="income-card-ganado" class="rounded-2xl bg-green-50/70 px-3 py-2.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Ganado</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">${{ number_format((float) ($ingresosGanadoTotales ?? 0), 0) }}</p>
                            <p class="text-xs text-gray-500 mt-1" id="income-card-ganado-percent">0% del ingreso total</p>
                        </div>
                        <div class="h-9 w-9 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Reportes Detallados</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('panel.analytics.report.export', ['tipo' => 'produccion', 'period' => ($periodoSeleccionado ?? '7d')]) }}" class="text-center flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                    <span class="material-symbols-sharp text-3xl text-blue-600">description</span>
                    <h4 class="font-medium text-gray-900 mt-2">Reporte de Produccion</h4>
                    <p class="text-sm text-gray-600 mt-1">Analisis de leche</p>
                </a>
                <a href="{{ route('panel.analytics.report.export', ['tipo' => 'ganado', 'period' => ($periodoSeleccionado ?? '7d')]) }}" class="text-center flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#16a34a"><path d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm109-189q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm240 0q-29-29-29-71t29-71q29-29 71-29t71 29q29 29 29 71t-29 71q-29 29-71 29t-71-29Zm251 189q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z"/></svg>
                    <h4 class="font-medium text-gray-900 mt-2">Reporte de Ganado</h4>
                    <p class="text-sm text-gray-600 mt-1">Estado y salud del ganado</p>
                </a>
                <a href="{{ route('panel.analytics.report.export', ['tipo' => 'financiero', 'period' => ($periodoSeleccionado ?? '7d')]) }}" class="text-center flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="text-yellow-600"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                    <h4 class="font-medium text-gray-900 mt-2">Reporte Financiero</h4>
                    <p class="text-sm text-gray-600 mt-1">Ingresos por ventas</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dataset = @json($serieProduccionPeriodo ?? []);
    const ingresosLechePeriodo = {{ json_encode((float) ($ingresosLechePeriodo ?? 0)) }};
    const chartTitleValue = @json($chartPeriodTitle ?? 'Periodo seleccionado');
    const chartSubtitleValue = @json($chartPeriodSubtitle ?? 'Litros producidos por fecha');
    const incomeDataset = {
        leche: Number(@json((float) ($ingresosLecheTotales ?? 0))),
        ganado: Number(@json((float) ($ingresosGanadoTotales ?? 0))),
    };

    const chart = document.getElementById('production-chart');
    const chartWrapper = document.getElementById('production-chart-wrapper');
    const chartTooltip = document.getElementById('production-chart-tooltip');
    const chartTooltipDate = document.getElementById('production-chart-tooltip-date');
    const chartTooltipValue = document.getElementById('production-chart-tooltip-value');
    const labels = document.getElementById('chart-labels');
    const total = document.getElementById('chart-total');
    const incomeSummary = document.getElementById('chart-income-total');
    const title = document.getElementById('chart-title');
    const subtitle = document.getElementById('chart-subtitle');
    const incomeArcLeche = document.getElementById('income-arc-leche');
    const incomeArcGanado = document.getElementById('income-arc-ganado');
    const incomeToggles = document.querySelectorAll('.income-toggle');
    const incomeTitle = document.getElementById('income-category-title');
    const incomeTotal = document.getElementById('income-category-total');
    const incomePercent = document.getElementById('income-category-percent');
    const incomeCardLechePercent = document.getElementById('income-card-leche-percent');
    const incomeCardGanadoPercent = document.getElementById('income-card-ganado-percent');
    const incomeCircumference = 2 * Math.PI * 74;
    let chartCoordinates = [];
    let chartTooltipPinned = false;

    function formatLiters(value) {
        return `${Number(value || 0).toLocaleString('en-US')} L`;
    }

    function setActiveChartPoint(index) {
        if (!chart) {
            return;
        }

        chart.querySelectorAll('[data-point-halo]').forEach((halo) => {
            halo.setAttribute('opacity', halo.dataset.pointHalo === String(index) ? '1' : '0');
        });

        chart.querySelectorAll('[data-point-dot]').forEach((dot) => {
            const isActive = dot.dataset.pointDot === String(index);
            dot.setAttribute('r', isActive ? '6.5' : '5');
            dot.setAttribute('stroke-width', isActive ? '4' : '3');
        });
    }

    function hideChartTooltip(force = false) {
        if (!force && chartTooltipPinned) {
            return;
        }

        if (force) {
            chartTooltipPinned = false;
        }

        chartTooltip?.classList.add('hidden');
        setActiveChartPoint(-1);
    }

    function showChartTooltip(index, pinned = false) {
        const point = chartCoordinates[index];

        if (!point || !chart || !chartWrapper || !chartTooltip || !chartTooltipDate || !chartTooltipValue) {
            return;
        }

        chartTooltipPinned = pinned;
        chartTooltipDate.textContent = point.tooltip;
        chartTooltipValue.textContent = formatLiters(point.value);
        chartTooltip.classList.remove('hidden');
        setActiveChartPoint(index);

        const wrapperRect = chartWrapper.getBoundingClientRect();
        const chartRect = chart.getBoundingClientRect();
        const relativeX = ((point.x / 640) * chartRect.width) + (chartRect.left - wrapperRect.left);
        const relativeY = ((point.y / 220) * chartRect.height) + (chartRect.top - wrapperRect.top);

        requestAnimationFrame(() => {
            const tooltipWidth = chartTooltip.offsetWidth;
            const tooltipHeight = chartTooltip.offsetHeight;
            const maxLeft = Math.max(wrapperRect.width - tooltipWidth - 8, 8);
            const left = Math.min(Math.max(relativeX - (tooltipWidth / 2), 8), maxLeft);
            let top = relativeY - tooltipHeight - 14;

            if (top < 8) {
                top = Math.min(relativeY + 14, Math.max(wrapperRect.height - tooltipHeight - 8, 8));
            }

            chartTooltip.style.left = `${left}px`;
            chartTooltip.style.top = `${top}px`;
        });
    }

    function renderChart() {
        const points = dataset || [];
        const values = points.map(point => Number(point.valor || 0));
        const maxValue = Math.max(...values, 1);
        const width = 640;
        const height = 220;
        const paddingX = 28;
        const paddingTop = 18;
        const paddingBottom = 22;
        const innerWidth = width - paddingX * 2;
        const innerHeight = height - paddingTop - paddingBottom;
        const step = points.length > 1 ? innerWidth / (points.length - 1) : innerWidth;

        const coordinates = points.map((point, index) => {
            const x = paddingX + step * index;
            const y = paddingTop + innerHeight - ((Number(point.valor || 0) / maxValue) * innerHeight);
            return { x, y, value: Number(point.valor || 0), label: point.label, tooltip: point.tooltip };
        });
        chartCoordinates = coordinates;

        if (!coordinates.length) {
            chart.innerHTML = '';
            labels.style.gridTemplateColumns = 'repeat(1, minmax(0, 1fr))';
            labels.innerHTML = '<div class="text-center">Sin datos</div>';
            total.textContent = '0 L';
            incomeSummary.textContent = `$${Math.round(Number(ingresosLechePeriodo || 0)).toLocaleString('en-US')}`;
            title.textContent = chartTitleValue;
            subtitle.textContent = chartSubtitleValue;
            hideChartTooltip(true);
            return;
        }

        const linePath = coordinates.map((point, index) => `${index === 0 ? 'M' : 'L'} ${point.x} ${point.y}`).join(' ');
        const areaPath = `${linePath} L ${coordinates[coordinates.length - 1]?.x ?? paddingX} ${height - paddingBottom} L ${coordinates[0]?.x ?? paddingX} ${height - paddingBottom} Z`;
        const circles = coordinates.map((point, index) => `
            <g>
                <circle data-point-halo="${index}" cx="${point.x}" cy="${point.y}" r="10" fill="rgba(22,163,74,0.18)" opacity="0"></circle>
                <circle data-point-dot="${index}" cx="${point.x}" cy="${point.y}" r="5" fill="#16a34a" stroke="#ffffff" stroke-width="3"></circle>
                <circle
                    data-point-index="${index}"
                    cx="${point.x}"
                    cy="${point.y}"
                    r="16"
                    fill="transparent"
                    style="cursor: pointer;"
                    tabindex="0"
                ></circle>
            </g>
        `).join('');

        chart.innerHTML = `
            <defs>
                <linearGradient id="productionAreaGradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="rgba(34,197,94,0.35)" />
                    <stop offset="100%" stop-color="rgba(34,197,94,0.02)" />
                </linearGradient>
            </defs>
            <path d="${areaPath}" fill="url(#productionAreaGradient)"></path>
            <path d="${linePath}" fill="none" stroke="#16a34a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
            ${circles}
        `;

        labels.style.gridTemplateColumns = `repeat(${Math.max(points.length, 1)}, minmax(0, 1fr))`;
        labels.innerHTML = points.map((point) => `<div class="text-center">${point.label}</div>`).join('');

        const totalValue = values.reduce((sum, value) => sum + value, 0);
        total.textContent = formatLiters(Math.round(totalValue));
        incomeSummary.textContent = `$${Math.round(Number(ingresosLechePeriodo || 0)).toLocaleString('en-US')}`;
        title.textContent = chartTitleValue;
        subtitle.textContent = chartSubtitleValue;
        hideChartTooltip(true);

        chart.querySelectorAll('[data-point-index]').forEach((target) => {
            const pointIndex = Number(target.dataset.pointIndex);

            target.addEventListener('mouseenter', function () {
                showChartTooltip(pointIndex);
            });

            target.addEventListener('focus', function () {
                showChartTooltip(pointIndex, true);
            });

            target.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    showChartTooltip(pointIndex, true);
                }
            });

            target.addEventListener('pointerdown', function (event) {
                if (event.pointerType !== 'mouse') {
                    showChartTooltip(pointIndex, true);
                }
            });

            target.addEventListener('click', function (event) {
                event.stopPropagation();
                showChartTooltip(pointIndex, true);
            });
        });
    }

    function renderIncomeChart(selected) {
        const leche = incomeDataset.leche || 0;
        const ganado = incomeDataset.ganado || 0;
        const totalIngresos = Math.max(leche + ganado, 0);
        const lecheRatio = totalIngresos > 0 ? leche / totalIngresos : 0;
        const ganadoRatio = totalIngresos > 0 ? ganado / totalIngresos : 0;
        const formatIncomePercent = (value) => `${value.toFixed(1)}%`;
        const lecheLength = incomeCircumference * lecheRatio;
        const ganadoLength = incomeCircumference * ganadoRatio;

        if (selected === 'leche') {
            incomeArcLeche.style.strokeDasharray = `${lecheLength} ${incomeCircumference}`;
            incomeArcLeche.style.strokeDashoffset = '0';
            incomeArcLeche.style.opacity = '1';

            incomeArcGanado.style.strokeDasharray = `0 ${incomeCircumference}`;
            incomeArcGanado.style.strokeDashoffset = '0';
            incomeArcGanado.style.opacity = '0';
        } else {
            incomeArcGanado.style.strokeDasharray = `${ganadoLength} ${incomeCircumference}`;
            incomeArcGanado.style.strokeDashoffset = '0';
            incomeArcGanado.style.opacity = '1';

            incomeArcLeche.style.strokeDasharray = `0 ${incomeCircumference}`;
            incomeArcLeche.style.strokeDashoffset = '0';
            incomeArcLeche.style.opacity = '0';
        }
        incomeArcLeche.style.stroke = '#2563eb';
        incomeArcGanado.style.stroke = '#16a34a';

        incomeArcLeche.setAttribute('transform', 'rotate(-90 110 110)');
        incomeArcGanado.setAttribute('transform', 'rotate(-90 110 110)');

        const selectedValue = selected === 'ganado' ? ganado : leche;
        const selectedRatio = totalIngresos > 0 ? (selectedValue / totalIngresos) * 100 : 0;

        incomeTitle.textContent = selected === 'ganado' ? 'Ganado' : 'Leche';
        incomeTotal.textContent = `$${Math.round(selectedValue).toLocaleString('en-US')}`;
        incomePercent.textContent = formatIncomePercent(selectedRatio);
        incomeCardLechePercent.textContent = `${formatIncomePercent(lecheRatio * 100)} del ingreso total`;
        incomeCardGanadoPercent.textContent = `${formatIncomePercent(ganadoRatio * 100)} del ingreso total`;

        incomeToggles.forEach((toggle) => {
            const active = toggle.dataset.incomeView === selected;
            toggle.className = active
                ? 'income-toggle px-3 py-1 text-sm rounded-lg bg-green-100 text-green-700'
                : 'income-toggle px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-lg';
        });
    }

    incomeToggles.forEach((toggle) => {
        toggle.addEventListener('click', function () {
            renderIncomeChart(this.dataset.incomeView);
        });
    });

    chartWrapper?.addEventListener('mouseleave', function () {
        hideChartTooltip();
    });

    document.addEventListener('pointerdown', function (event) {
        if (!chartWrapper?.contains(event.target)) {
            hideChartTooltip(true);
        }
    });

    window.addEventListener('resize', function () {
        hideChartTooltip(true);
    });

    renderChart();
    renderIncomeChart('leche');
});
</script>
