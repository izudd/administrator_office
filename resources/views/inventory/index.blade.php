<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inventory Management
        </h2>
    </x-slot>

    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
    </style>

    <div class="py-6" x-data="inventoryDashboard()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Executive Control Panel</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest mt-1">Kapitalisasi & Assurance Summary</p>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center gap-3">
                    <div class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center gap-3 shadow-sm">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-black text-gray-600 dark:text-gray-300 uppercase tracking-widest">Real-time Valuation active</span>
                    </div>
                    <a href="{{ route('inventory.register') }}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Asset</span>
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Fixed Assets -->
                <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 dark:hover:shadow-gray-900/50">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 rounded-2xl bg-blue-50 dark:bg-blue-500/20 text-blue-600 shadow-sm">
                            <i class="fa-solid fa-box text-xl"></i>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] leading-none mb-2">Total Fixed Assets</p>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tabular-nums tracking-tight">Rp {{ number_format($totalCost, 0, ',', '.') }}</h2>
                        <p class="text-[10px] font-bold text-gray-400 italic">{{ $totalAssets }} unit terkapitalisasi</p>
                    </div>
                </div>

                <!-- Net Book Value -->
                <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-emerald-200/50 dark:hover:shadow-emerald-900/50">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 shadow-sm">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] leading-none mb-2">Net Book Value</p>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tabular-nums tracking-tight">Rp {{ number_format($totalBookValue, 0, ',', '.') }}</h2>
                        <p class="text-[10px] font-bold text-gray-400 italic">Valuasi setelah depresiasi</p>
                    </div>
                </div>

                <!-- Risk Exposure -->
                <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-rose-200/50 dark:hover:shadow-rose-900/50">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 rounded-2xl {{ $damagedCount > 0 ? 'bg-rose-50 dark:bg-rose-500/20 text-rose-600' : 'bg-gray-50 dark:bg-gray-700 text-gray-400' }} shadow-sm">
                            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] leading-none mb-2">Risk Exposure</p>
                        <h2 class="text-2xl font-black {{ $damagedCount > 0 ? 'text-rose-600' : 'text-gray-900 dark:text-white' }} tabular-nums tracking-tight">{{ $damagedCount }}</h2>
                        <p class="text-[10px] font-bold text-gray-400 italic">Aset dengan kondisi 'Damaged'</p>
                    </div>
                </div>

                <!-- Loaned Units -->
                <div class="stat-card bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 dark:hover:shadow-gray-900/50">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 rounded-2xl bg-purple-50 dark:bg-purple-500/20 text-purple-600 shadow-sm">
                            <i class="fa-solid fa-database text-xl"></i>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] leading-none mb-2">Loaned Units</p>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tabular-nums tracking-tight">{{ $loanedCount }}</h2>
                        <p class="text-[10px] font-bold text-gray-400 italic">Aset dalam status pinjaman</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Category Chart -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-blue-600"></i>
                            Komposisi Portofolio Aset
                        </h3>
                    </div>
                    <div class="h-[320px]">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- Health Donut -->
                <div class="glass-dark p-8 rounded-3xl shadow-2xl relative overflow-hidden flex flex-col items-center justify-center">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <i class="fa-solid fa-shield-halved text-white text-7xl"></i>
                    </div>
                    <h3 class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] mb-8 text-center">Infrastruktur & Integritas</h3>
                    <div class="h-[200px] w-full flex items-center justify-center relative">
                        <canvas id="healthChart"></canvas>
                        <div class="absolute text-center">
                            <span class="text-3xl font-black text-white block leading-none">{{ $healthPercentage }}%</span>
                            <span class="text-[8px] font-bold text-gray-500 uppercase tracking-widest">In-Good Health</span>
                        </div>
                    </div>
                    <div class="mt-8 grid grid-cols-2 gap-4 w-full">
                        <div class="bg-gray-800/50 p-3 rounded-2xl border border-gray-700/50">
                            <span class="text-[8px] font-black text-gray-500 uppercase block mb-1">Total Unit</span>
                            <span class="text-lg font-black text-white">{{ $totalAssets }}</span>
                        </div>
                        <div class="bg-gray-800/50 p-3 rounded-2xl border border-gray-700/50">
                            <span class="text-[8px] font-black text-gray-500 uppercase block mb-1">Audit Score</span>
                            <span class="text-lg font-black text-emerald-400">9.8</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('inventory.register') }}" class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-table-list text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Asset Register</h3>
                            <p class="text-xs text-gray-500">Kelola daftar aset</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('inventory.audit-trail') }}" class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Audit Trail</h3>
                            <p class="text-xs text-gray-500">Riwayat perubahan</p>
                        </div>
                    </div>
                </a>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-brain text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">AI Risk Insight</h3>
                            <p class="text-xs text-gray-500">Analisis risiko cerdas</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function inventoryDashboard() {
            return {
                init() {
                    this.initCharts();
                },
                initCharts() {
                    // Category Bar Chart
                    const categoryData = @json($categoryData);
                    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                    new Chart(categoryCtx, {
                        type: 'bar',
                        data: {
                            labels: categoryData.map(d => d.name),
                            datasets: [{
                                label: 'Jumlah Asset',
                                data: categoryData.map(d => d.value),
                                backgroundColor: '#2563EB',
                                borderRadius: 6,
                                barThickness: 50,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 10, weight: 'bold' } }
                                },
                                y: {
                                    grid: { color: '#F1F5F9' },
                                    ticks: { font: { size: 10, weight: 'bold' } }
                                }
                            }
                        }
                    });

                    // Health Donut Chart
                    const healthCtx = document.getElementById('healthChart').getContext('2d');
                    new Chart(healthCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Good', 'Damaged'],
                            datasets: [{
                                data: [{{ $goodCount }}, {{ $damagedConditionCount }}],
                                backgroundColor: ['#059669', '#F43F5E'],
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '75%',
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
