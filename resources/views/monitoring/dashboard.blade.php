<x-layouts.dashboard title="Monitoring AIoT">
    <section class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">
            <div class="flex flex-col justify-between gap-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:flex-row lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-green-700">
                        Monitoring AIoT
                    </p>
                    <h1 class="mt-2 text-2xl font-bold text-slate-950 sm:text-3xl">
                        Dashboard Kualitas Tanah dan Air
                    </h1>
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">
                        Pantau kondisi media tumbuh melon secara ringkas, cepat, dan mudah dibaca. Data diperbarui otomatis dari perangkat IoT yang terhubung.
                    </p>
                </div>

                <div class="rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-800 ring-1 ring-green-100">
                    <div class="font-semibold">Update terakhir</div>
                    <div id="lastUpdate" class="mt-1 text-green-700">Memuat data...</div>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">Total Device</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p id="totalDevices" class="text-3xl font-bold text-slate-950">0</p>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Device</span>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">Device Online</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p id="onlineDevices" class="text-3xl font-bold text-slate-950">0</p>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">Status Tanah</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p id="soilStatusText" class="text-2xl font-bold text-slate-950">Offline</p>
                        <span id="soilStatusBadge" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">OFFLINE</span>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm font-medium text-slate-500">Status Air</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p id="waterStatusText" class="text-2xl font-bold text-slate-950">Offline</p>
                        <span id="waterStatusBadge" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">OFFLINE</span>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-2">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">Monitoring Tanah</h2>
                            <p class="mt-1 text-sm text-slate-500">Data terbaru kualitas tanah lahan melon.</p>
                        </div>
                        <span id="soilDevice" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">-</span>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <x-monitoring.metric label="Nitrogen" value-id="soilNitrogen" unit="mg/kg" />
                        <x-monitoring.metric label="Fosfor" value-id="soilPhosphorus" unit="mg/kg" />
                        <x-monitoring.metric label="Kalium" value-id="soilPotassium" unit="mg/kg" />
                        <x-monitoring.metric label="Suhu" value-id="soilTemperature" unit="°C" />
                        <x-monitoring.metric label="Moisture" value-id="soilMoisture" unit="%" />
                        <x-monitoring.metric label="pH" value-id="soilPh" unit="" />
                        <x-monitoring.metric label="EC" value-id="soilEc" unit="µS/cm" />
                        <x-monitoring.metric label="Latitude" value-id="soilLat" unit="" />
                        <x-monitoring.metric label="Longitude" value-id="soilLng" unit="" />
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">Monitoring Air</h2>
                            <p class="mt-1 text-sm text-slate-500">Data terbaru kualitas air dan nutrisi.</p>
                        </div>
                        <span id="waterDevice" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">-</span>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <x-monitoring.metric label="pH" value-id="waterPh" unit="" />
                        <x-monitoring.metric label="TDS" value-id="waterTds" unit="ppm" />
                        <x-monitoring.metric label="EC" value-id="waterEc" unit="µS/cm" />
                        <x-monitoring.metric label="Battery" value-id="waterBattery" unit="%" />
                        <x-monitoring.metric label="Latitude" value-id="waterLat" unit="" />
                        <x-monitoring.metric label="Longitude" value-id="waterLng" unit="" />
                    </div>
                </div>
            </div>
            <div class="grid gap-6 xl:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">
                                Grafik Tren Tanah
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Pantau perubahan pH, kelembapan, suhu, EC, dan unsur hara tanah secara berkala.
                            </p>
                        </div>

                        <span class="rounded-lg bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            Realtime
                        </span>
                    </div>

                    <div class="mt-6 h-80">
                        <canvas id="soilTrendChart"></canvas>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">
                                Grafik Tren Air
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Pantau perubahan pH, TDS, EC, dan baterai perangkat monitoring air.
                            </p>
                        </div>

                        <span class="rounded-lg bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            Realtime
                        </span>
                    </div>

                    <div class="mt-6 h-80">
                        <canvas id="waterTrendChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="grid gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-950">Riwayat Tanah Terbaru</h2>
                        <p class="mt-1 text-sm text-slate-500">10 data terakhir dari sensor tanah.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="px-5 py-3">Waktu</th>
                                    <th class="px-5 py-3">Device</th>
                                    <th class="px-5 py-3">pH</th>
                                    <th class="px-5 py-3">Moisture</th>
                                    <th class="px-5 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody id="soilHistoryBody" class="divide-y divide-slate-100 bg-white">
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-slate-500">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-950">Riwayat Air Terbaru</h2>
                        <p class="mt-1 text-sm text-slate-500">10 data terakhir dari sensor air.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <th class="px-5 py-3">Waktu</th>
                                    <th class="px-5 py-3">Device</th>
                                    <th class="px-5 py-3">pH</th>
                                    <th class="px-5 py-3">TDS</th>
                                    <th class="px-5 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody id="waterHistoryBody" class="divide-y divide-slate-100 bg-white">
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-slate-500">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const chartDataUrl = "{{ route('monitoring.chart-data') }}";
        const latestUrl = "{{ route('monitoring.latest') }}";

        const statusClasses = {
            normal: 'bg-emerald-100 text-emerald-700',
            warning: 'bg-amber-100 text-amber-700',
            danger: 'bg-red-100 text-red-700',
            offline: 'bg-slate-100 text-slate-600',
        };

        function valueOrDash(value) {
            return value === null || value === undefined || value === '' ? '-' : value;
        }

        function setText(id, value) {
            const element = document.getElementById(id);
            if (element) element.textContent = valueOrDash(value);
        }

        function setStatus(textId, badgeId, status) {
            const cleanStatus = status || 'offline';
            const text = document.getElementById(textId);
            const badge = document.getElementById(badgeId);

            if (text) {
                text.textContent = cleanStatus.charAt(0).toUpperCase() + cleanStatus.slice(1);
            }

            if (badge) {
                badge.textContent = cleanStatus.toUpperCase();
                badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${statusClasses[cleanStatus] ?? statusClasses.offline}`;
            }
        }

        function renderStatusBadge(status) {
            const cleanStatus = status || 'offline';
            const className = statusClasses[cleanStatus] ?? statusClasses.offline;

            return `<span class="rounded-full px-3 py-1 text-xs font-semibold ${className}">${cleanStatus.toUpperCase()}</span>`;
        }

        function renderSoilHistory(items) {
            const body = document.getElementById('soilHistoryBody');

            if (!items || items.length === 0) {
                body.innerHTML = `<tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">Belum ada data tanah.</td></tr>`;
                return;
            }

            body.innerHTML = items.map(item => `
                <tr class="hover:bg-slate-50">
                    <td class="whitespace-nowrap px-5 py-4 text-slate-600">${valueOrDash(item.recorded_at)}</td>
                    <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900">${valueOrDash(item.device?.device_code)}</td>
                    <td class="px-5 py-4 text-slate-600">${valueOrDash(item.ph)}</td>
                    <td class="px-5 py-4 text-slate-600">${valueOrDash(item.moisture)}%</td>
                    <td class="px-5 py-4">${renderStatusBadge(item.status)}</td>
                </tr>
            `).join('');
        }

        function renderWaterHistory(items) {
            const body = document.getElementById('waterHistoryBody');

            if (!items || items.length === 0) {
                body.innerHTML = `<tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">Belum ada data air.</td></tr>`;
                return;
            }

            body.innerHTML = items.map(item => `
                <tr class="hover:bg-slate-50">
                    <td class="whitespace-nowrap px-5 py-4 text-slate-600">${valueOrDash(item.recorded_at)}</td>
                    <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900">${valueOrDash(item.device?.device_code)}</td>
                    <td class="px-5 py-4 text-slate-600">${valueOrDash(item.ph)}</td>
                    <td class="px-5 py-4 text-slate-600">${valueOrDash(item.tds)} ppm</td>
                    <td class="px-5 py-4">${renderStatusBadge(item.status)}</td>
                </tr>
            `).join('');
        }

        async function loadMonitoringData() {
            try {
                const response = await fetch(latestUrl, {
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                setText('totalDevices', data.summary.total_devices);
                setText('onlineDevices', data.summary.online_devices);
                setText('lastUpdate', data.summary.last_update);

                setStatus('soilStatusText', 'soilStatusBadge', data.summary.soil_status);
                setStatus('waterStatusText', 'waterStatusBadge', data.summary.water_status);

                const soil = data.latest_soil;
                setText('soilDevice', soil?.device?.device_code ?? '-');
                setText('soilNitrogen', soil?.nitrogen);
                setText('soilPhosphorus', soil?.phosphorus);
                setText('soilPotassium', soil?.potassium);
                setText('soilTemperature', soil?.temperature);
                setText('soilMoisture', soil?.moisture);
                setText('soilPh', soil?.ph);
                setText('soilEc', soil?.ec);
                setText('soilLat', soil?.latitude);
                setText('soilLng', soil?.longitude);

                const water = data.latest_water;
                setText('waterDevice', water?.device?.device_code ?? '-');
                setText('waterPh', water?.ph);
                setText('waterTds', water?.tds);
                setText('waterEc', water?.ec);
                setText('waterBattery', water?.battery);
                setText('waterLat', water?.latitude);
                setText('waterLng', water?.longitude);

                renderSoilHistory(data.soil_history);
                renderWaterHistory(data.water_history);
            } catch (error) {
                console.error(error);
                setText('lastUpdate', 'Gagal memuat data');
            }
        }

        function prependSoilHistory(item) {
            const body = document.getElementById('soilHistoryBody');

            if (!body) return;

            const emptyText = body.querySelector('td[colspan="5"]');
            if (emptyText) {
                body.innerHTML = '';
            }

            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50';
            row.innerHTML = `
        <td class="whitespace-nowrap px-5 py-4 text-slate-600">${valueOrDash(item.recorded_at)}</td>
        <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900">${valueOrDash(item.device?.device_code)}</td>
        <td class="px-5 py-4 text-slate-600">${valueOrDash(item.ph)}</td>
        <td class="px-5 py-4 text-slate-600">${valueOrDash(item.moisture)}%</td>
        <td class="px-5 py-4">${renderStatusBadge(item.status)}</td>
    `;

            body.prepend(row);

            while (body.children.length > 10) {
                body.removeChild(body.lastElementChild);
            }
        }

        function prependWaterHistory(item) {
            const body = document.getElementById('waterHistoryBody');

            if (!body) return;

            const emptyText = body.querySelector('td[colspan="5"]');
            if (emptyText) {
                body.innerHTML = '';
            }

            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50';
            row.innerHTML = `
        <td class="whitespace-nowrap px-5 py-4 text-slate-600">${valueOrDash(item.recorded_at)}</td>
        <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900">${valueOrDash(item.device?.device_code)}</td>
        <td class="px-5 py-4 text-slate-600">${valueOrDash(item.ph)}</td>
        <td class="px-5 py-4 text-slate-600">${valueOrDash(item.tds)} ppm</td>
        <td class="px-5 py-4">${renderStatusBadge(item.status)}</td>
    `;

            body.prepend(row);

            while (body.children.length > 10) {
                body.removeChild(body.lastElementChild);
            }
        }
        let soilTrendChart = null;
        let waterTrendChart = null;

        function createLineChart(canvasId, labels, datasets) {
            const canvas = document.getElementById(canvasId);

            if (!canvas || !window.Chart) {
                return null;
            }

            return new window.Chart(canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                usePointStyle: true,
                            },
                        },
                        tooltip: {
                            enabled: true,
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                maxRotation: 0,
                                autoSkip: true,
                            },
                            grid: {
                                display: false,
                            },
                        },
                        y: {
                            beginAtZero: false,
                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                    elements: {
                        line: {
                            tension: 0.35,
                            borderWidth: 2,
                        },
                        point: {
                            radius: 2,
                            hoverRadius: 5,
                        },
                    },
                },
            });
        }

        function buildDataset(label, data, borderDash = []) {
            return {
                label,
                data,
                borderDash,
                fill: false,
            };
        }

        async function loadMonitoringCharts() {
            try {
                const response = await fetch(`${chartDataUrl}?limit=30`, {
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (soilTrendChart) {
                    soilTrendChart.destroy();
                }

                if (waterTrendChart) {
                    waterTrendChart.destroy();
                }

                soilTrendChart = createLineChart('soilTrendChart', data.soil.labels, [
                    buildDataset('pH Tanah', data.soil.datasets.ph),
                    buildDataset('Moisture (%)', data.soil.datasets.moisture),
                    buildDataset('Temperature (°C)', data.soil.datasets.temperature),
                    buildDataset('EC', data.soil.datasets.ec),
                    buildDataset('Nitrogen', data.soil.datasets.nitrogen, [6, 4]),
                    buildDataset('Fosfor', data.soil.datasets.phosphorus, [6, 4]),
                    buildDataset('Kalium', data.soil.datasets.potassium, [6, 4]),
                ]);

                waterTrendChart = createLineChart('waterTrendChart', data.water.labels, [
                    buildDataset('pH Air', data.water.datasets.ph),
                    buildDataset('TDS', data.water.datasets.tds),
                    buildDataset('EC', data.water.datasets.ec),
                    buildDataset('Battery (%)', data.water.datasets.battery, [6, 4]),
                ]);
            } catch (error) {
                console.error('Gagal memuat grafik monitoring:', error);
            }
        }

        function appendChartPoint(chart, label, values, maxPoints = 30) {
            if (!chart) {
                return;
            }

            chart.data.labels.push(label);

            chart.data.datasets.forEach((dataset, index) => {
                dataset.data.push(values[index] ?? null);
            });

            while (chart.data.labels.length > maxPoints) {
                chart.data.labels.shift();

                chart.data.datasets.forEach((dataset) => {
                    dataset.data.shift();
                });
            }

            chart.update('none');
        }
        document.addEventListener('DOMContentLoaded', () => {
            loadMonitoringData();
            loadMonitoringCharts();
            if (!window.Echo) {
                console.warn('Laravel Echo belum tersedia. Pastikan resources/js/app.js sudah dikompilasi oleh Vite.');
                return;
            }

            window.Echo.private('monitoring')
                .listen('.soil.reading.created', (event) => {
                    const soil = event.reading;

                    setText('soilDevice', soil?.device?.device_code ?? '-');
                    setText('soilNitrogen', soil?.nitrogen);
                    setText('soilPhosphorus', soil?.phosphorus);
                    setText('soilPotassium', soil?.potassium);
                    setText('soilTemperature', soil?.temperature);
                    setText('soilMoisture', soil?.moisture);
                    setText('soilPh', soil?.ph);
                    setText('soilEc', soil?.ec);
                    setText('soilLat', soil?.latitude);
                    setText('soilLng', soil?.longitude);

                    setStatus('soilStatusText', 'soilStatusBadge', soil?.status);
                    setText('lastUpdate', soil?.recorded_at);

                    prependSoilHistory(soil);

                    appendChartPoint(
                        soilTrendChart,
                        soil?.recorded_at?.substring(11, 19) ?? '-',
                        [
                            Number(soil?.ph ?? 0),
                            Number(soil?.moisture ?? 0),
                            Number(soil?.temperature ?? 0),
                            Number(soil?.ec ?? 0),
                            Number(soil?.nitrogen ?? 0),
                            Number(soil?.phosphorus ?? 0),
                            Number(soil?.potassium ?? 0),
                        ]
                    );
                })
                .listen('.water.reading.created', (event) => {
                    const water = event.reading;

                    setText('waterDevice', water?.device?.device_code ?? '-');
                    setText('waterPh', water?.ph);
                    setText('waterTds', water?.tds);
                    setText('waterEc', water?.ec);
                    setText('waterBattery', water?.battery);
                    setText('waterLat', water?.latitude);
                    setText('waterLng', water?.longitude);

                    setStatus('waterStatusText', 'waterStatusBadge', water?.status);
                    setText('lastUpdate', water?.recorded_at);

                    prependWaterHistory(water);

                    appendChartPoint(
                        waterTrendChart,
                        water?.recorded_at?.substring(11, 19) ?? '-',
                        [
                            Number(water?.ph ?? 0),
                            Number(water?.tds ?? 0),
                            Number(water?.ec ?? 0),
                            Number(water?.battery ?? 0),
                        ]
                    );
                });
        });
    </script>
</x-layouts.dashboard>