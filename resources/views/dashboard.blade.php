<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard</title>
    @include('layout.head')
</head>

<body class="bg-gray-50">

    @include('layout.sidebar')

    <main class="md:ml-64 xl:ml-72 2xl:ml-72">
        @include('layout.navbar')

        <div class="p-6 space-y-6">

            <!-- HEADER -->
            <div
                class="md:flex justify-between items-center bg-white p-5 rounded-xl shadow-sm border border-gray-100 space-y-2 md:space-y-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-sky-600"></i>
                        Dashboard
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Ringkasan inventory, penjualan, dan keuangan proyek
                    </p>
                </div>
                <div class="text-sm text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <!-- KPI CARDS -->
            <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Total Unit
                    </p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">
                        210
                    </h2>
                    <p class="text-xs text-emerald-600 mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i>
                        +30 unit · 2 cluster
                    </p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Unit Terjual
                    </p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">
                        82
                    </h2>
                    <p class="text-xs text-emerald-600 mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i>
                        +6 bulan ini
                    </p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Pengajuan KPR Aktif
                    </p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">
                        14
                    </h2>
                    <p class="text-xs text-emerald-600 mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i>
                        +3 bulan ini
                    </p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Penerimaan Bulan Ini
                    </p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-1">
                        Rp 4.825.000.000
                    </h2>
                    <p class="text-xs text-gray-400 mt-2">
                        42 pembayaran masuk
                    </p>
                </div>

            </div>

            <!-- SUMMARY SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Stok Tersedia -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-green-600 uppercase font-semibold tracking-wide">Stok Tersedia</p>
                            <h3 class="text-3xl font-bold text-green-700 mt-2">98</h3>
                            <p class="text-xs text-green-600 mt-2">Jun 2026</p>
                        </div>
                        <div class="text-4xl text-green-300 opacity-50">
                            <i class="fa-solid fa-house"></i>
                        </div>
                    </div>
                </div>

                <!-- Unit Dibooking -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-blue-600 uppercase font-semibold tracking-wide">Unit Dibooking</p>
                            <h3 class="text-3xl font-bold text-blue-700 mt-2">30</h3>
                            <p class="text-xs text-blue-600 mt-2">Jun 2026</p>
                        </div>
                        <div class="text-4xl text-blue-300 opacity-50">
                            <i class="fa-solid fa-bookmark"></i>
                        </div>
                    </div>
                </div>

                <!-- Menunggu SP2K -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-yellow-600 uppercase font-semibold tracking-wide">Menunggu SP2K</p>
                            <h3 class="text-3xl font-bold text-yellow-700 mt-2">14</h3>
                            <p class="text-xs text-yellow-600 mt-2">Jun 2026</p>
                        </div>
                        <div class="text-4xl text-yellow-300 opacity-50">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                    </div>
                </div>

                <!-- Serah Terima -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-purple-600 uppercase font-semibold tracking-wide">Serah Terima</p>
                            <h3 class="text-3xl font-bold text-purple-700 mt-2">5</h3>
                            <p class="text-xs text-purple-600 mt-2">Jun 2026</p>
                        </div>
                        <div class="text-4xl text-purple-300 opacity-50">
                            <i class="fa-solid fa-key"></i>
                        </div>
                    </div>
                </div>

            </div>


            <!-- CHARTS -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- TREN PENJUALAN -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">
                                Tren Penjualan
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">6 periode terakhir</p>
                        </div>
                    </div>
                    <canvas id="chartSales" height="100"></canvas>
                </div>

                <!-- PENJUALAN PER CLUSTER -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">
                                Penjualan per Cluster
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">Realisasi dibanding target</p>
                        </div>
                    </div>
                    <canvas id="chartCluster" height="100"></canvas>
                </div>

            </div>

            <p class="text-xs text-gray-400">
                Semua angka adalah data contoh untuk ilustrasi. Pada sistem sebenarnya, angka diperbarui otomatis dari
                aktivitas penjualan dan pembayaran.
            </p>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const CHART = @json($chart);

        const salesCtx = document.getElementById('chartSales').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: CHART.salesLabels,
                datasets: [
                    {
                        label: 'Unit terjual',
                        data: CHART.terjual,
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.08)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Unit dibooking',
                        data: CHART.dibooking,
                        borderColor: '#16a34a',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const clusterCtx = document.getElementById('chartCluster').getContext('2d');
        new Chart(clusterCtx, {
            type: 'bar',
            data: {
                labels: CHART.clusterLabels,
                datasets: [
                    {
                        label: 'Realisasi',
                        data: CHART.realisasi,
                        backgroundColor: '#0284c7',
                        borderRadius: 6
                    },
                    {
                        label: 'Target',
                        data: CHART.target,
                        backgroundColor: '#bae6fd',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    @include('sweetalert::alert')

</body>

</html>
