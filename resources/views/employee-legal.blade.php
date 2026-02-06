<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div x-data="employeeLegalApp()" x-init="init()" class="min-h-screen flex bg-slate-100 dark:bg-slate-950 transition-colors duration-300">

        <!-- Sidebar -->
        <aside :class="sidebarCollapsed ? 'w-20' : 'w-72'"
               class="hidden lg:flex flex-col bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white border-r border-slate-800 transition-all duration-300 ease-in-out">
            <div class="p-5 border-b border-slate-800">
                <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-xl blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        <div class="relative w-11 h-11 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                            <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-7 h-7 rounded-lg object-cover">
                        </div>
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition class="overflow-hidden">
                        <h2 class="font-bold text-white text-sm">KAP Budiandru</h2>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <p x-show="!sidebarCollapsed" class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Overview</p>
                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-emerald-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-emerald-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-gauge-high text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Dashboard</span>
                </a>

                <p x-show="!sidebarCollapsed" class="px-4 py-2 mt-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Documents</p>
                <a href="{{ route('legal-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-blue-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-blue-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-scale-balanced text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Documents</span>
                </a>
                <a href="{{ route('employee-legal.index') }}" class="group flex items-center px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 text-white font-medium transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-signature text-sm text-white"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Kontrak Karyawan</span>
                </a>
                <a href="{{ route('employee-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-sky-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-sky-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Karyawan</span>
                </a>
                <a href="{{ route('partner-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-purple-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-purple-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-handshake text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Partner Docs</span>
                </a>

                <p x-show="!sidebarCollapsed" class="px-4 py-2 mt-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Management</p>
                <a href="{{ route('inventory.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-teal-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-teal-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-boxes-stacked text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Inventory</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div class="bg-slate-800/50 rounded-xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg">
                                <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div x-show="!sidebarCollapsed" class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" x-show="!sidebarCollapsed" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 text-sm bg-slate-700/50 hover:bg-red-500/20 hover:text-red-400 text-slate-300 rounded-lg transition-all font-medium flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                        class="hidden lg:flex w-full mt-3 items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
                    <i class="fa-solid" :class="sidebarCollapsed ? 'fa-angles-right' : 'fa-angles-left'"></i>
                    <span x-show="!sidebarCollapsed">Collapse</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Kontrak Karyawan</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                            <i class="fa-solid fa-file-contract"></i>
                            Sistem Manajemen Kontrak Karyawan
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Sub-Navigation Tabs -->
                        <div class="hidden md:flex bg-slate-100 dark:bg-slate-800 rounded-xl p-1">
                            <button @click="currentView = 'dashboard'" :class="currentView === 'dashboard' ? 'bg-white dark:bg-slate-700 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-700'"
                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                <i class="fa-solid fa-chart-line mr-1.5"></i>Dashboard
                            </button>
                            <button @click="currentView = 'create'" :class="currentView === 'create' ? 'bg-white dark:bg-slate-700 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-700'"
                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                <i class="fa-solid fa-plus mr-1.5"></i>Buat Kontrak
                            </button>
                            <button @click="currentView = 'list'" :class="currentView === 'list' ? 'bg-white dark:bg-slate-700 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-700'"
                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                <i class="fa-solid fa-list mr-1.5"></i>Daftar Kontrak
                            </button>
                            <button @click="currentView = 'templates'" :class="currentView === 'templates' ? 'bg-white dark:bg-slate-700 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-700'"
                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                <i class="fa-solid fa-copy mr-1.5"></i>Template
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Mobile Navigation -->
                <div class="md:hidden flex gap-1 px-4 pb-3 overflow-x-auto">
                    <button @click="currentView = 'dashboard'" :class="currentView === 'dashboard' ? 'bg-emerald-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600'"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all">Dashboard</button>
                    <button @click="currentView = 'create'" :class="currentView === 'create' ? 'bg-emerald-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600'"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all">Buat Kontrak</button>
                    <button @click="currentView = 'list'" :class="currentView === 'list' ? 'bg-emerald-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600'"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all">Daftar</button>
                    <button @click="currentView = 'templates'" :class="currentView === 'templates' ? 'bg-emerald-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600'"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all">Template</button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">

                <!-- ========== DASHBOARD VIEW ========== -->
                <div x-show="currentView === 'dashboard'" x-transition>
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                        <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-500/50 transition-all hover:shadow-xl overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-file-contract text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalContracts }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Total Kontrak</div>
                            </div>
                        </div>
                        <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-emerald-300 dark:hover:border-emerald-500/50 transition-all hover:shadow-xl overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-circle-check text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $activeContracts }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Kontrak Aktif</div>
                            </div>
                        </div>
                        <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-amber-300 dark:hover:border-amber-500/50 transition-all hover:shadow-xl overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-yellow-500 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-hourglass-half text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $probationContracts }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Masa Percobaan</div>
                            </div>
                        </div>
                        <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-red-300 dark:hover:border-red-500/50 transition-all hover:shadow-xl overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-rose-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-triangle-exclamation text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $expiringContracts }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Akan Berakhir</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Contracts Table -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-emerald-500"></i>
                                Kontrak Terbaru
                            </h2>
                            <button @click="currentView = 'list'" class="text-sm text-emerald-600 hover:underline font-medium">Lihat Semua</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-slate-50 dark:bg-slate-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Karyawan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jabatan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @forelse($contracts->take(5) as $contract)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $contract->employee_name }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $contract->position }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $contract->contract_type === 'PKWTT' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' }}">
                                                {{ $contract->contract_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $contract->start_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                                    'probation' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
                                                    'expired' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
                                                    'terminated' => 'bg-slate-100 text-slate-700 dark:bg-slate-500/20 dark:text-slate-400',
                                                ];
                                                $statusLabels = ['active' => 'Aktif', 'probation' => 'Percobaan', 'expired' => 'Berakhir', 'terminated' => 'Diberhentikan'];
                                            @endphp
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusColors[$contract->status] ?? $statusColors['active'] }}">
                                                {{ $statusLabels[$contract->status] ?? 'Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button @click="viewContract({{ $contract->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fa-solid fa-eye mr-1"></i>Lihat
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                                                <i class="fa-solid fa-file-contract text-2xl text-slate-300 dark:text-slate-600"></i>
                                            </div>
                                            <p class="text-slate-500 dark:text-slate-400 mb-2">Belum ada kontrak</p>
                                            <button @click="currentView = 'create'" class="text-emerald-600 hover:underline text-sm font-medium">
                                                Buat kontrak baru
                                            </button>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== CREATE CONTRACT VIEW ========== -->
                <div x-show="currentView === 'create'" x-transition>
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-plus-circle text-emerald-500"></i>
                                Buat Kontrak Kerja Baru
                            </h2>
                        </div>
                        <form @submit.prevent="submitContract()" class="p-6 space-y-8">

                            <!-- Section 1: Identitas Para Pihak -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">1</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Identitas Para Pihak</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Perusahaan *</label>
                                        <input type="text" x-model="form.company_name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Alamat Perusahaan</label>
                                        <input type="text" x-model="form.company_address" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Karyawan *</label>
                                        <input type="text" x-model="form.employee_name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">NIK / No KTP</label>
                                        <input type="text" x-model="form.employee_nik" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Alamat Karyawan</label>
                                        <input type="text" x-model="form.employee_address" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Jenis Perjanjian -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">2</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Dasar & Jenis Perjanjian Kerja</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jenis Kontrak *</label>
                                        <select x-model="form.contract_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                            <option value="">Pilih Jenis Kontrak</option>
                                            <option value="PKWT">PKWT (Kontrak)</option>
                                            <option value="PKWTT">PKWTT (Tetap)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Dasar Hukum</label>
                                        <input type="text" x-model="form.legal_basis" readonly class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Jabatan -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">3</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Jabatan & Ruang Lingkup Pekerjaan</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jabatan *</label>
                                        <input type="text" x-model="form.position" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Atasan Langsung</label>
                                        <input type="text" x-model="form.direct_superior" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Job Description *</label>
                                        <textarea x-model="form.job_description" required rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm resize-y"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Lokasi & Waktu -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">4</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Lokasi & Waktu Kerja</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Lokasi Kerja *</label>
                                        <select x-model="form.work_location" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                            <option value="">Pilih Lokasi</option>
                                            <option value="Kantor">Kantor</option>
                                            <option value="Remote">Remote</option>
                                            <option value="Hybrid">Hybrid</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jam Kerja / Hari</label>
                                        <input type="number" x-model="form.working_hours" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Hari Kerja / Minggu</label>
                                        <input type="number" x-model="form.working_days" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Aturan Lembur</label>
                                        <textarea x-model="form.overtime_rules" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm resize-y"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5: Masa Kerja -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">5</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Masa Kerja & Masa Percobaan</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Mulai Kerja *</label>
                                        <input type="date" x-model="form.start_date" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Durasi Kontrak (Bulan)</label>
                                        <input type="number" x-model="form.contract_duration" placeholder="Untuk PKWT" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Masa Probation (Bulan)</label>
                                        <input type="number" x-model="form.probation_period" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 6: Gaji & Kompensasi -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">6</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Gaji & Kompensasi</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Gaji Pokok (Rp) *</label>
                                        <input type="number" x-model="form.base_salary" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tunjangan Transport (Rp)</label>
                                        <input type="number" x-model="form.transport_allowance" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tunjangan Makan (Rp)</label>
                                        <input type="number" x-model="form.meal_allowance" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tunjangan Lainnya (Rp)</label>
                                        <input type="number" x-model="form.other_allowance" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Metode Pembayaran</label>
                                        <select x-model="form.payment_method" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                            <option value="Transfer Bank">Transfer Bank</option>
                                            <option value="Cash">Cash</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Pembayaran</label>
                                        <input type="number" x-model="form.payment_date" min="1" max="31" placeholder="Tanggal setiap bulan" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 7: Hak Karyawan -->
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">7</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Hak Karyawan</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                                        <input type="checkbox" x-model="form.right_annual_leave" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Cuti Tahunan (12 hari)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                                        <input type="checkbox" x-model="form.right_sick_leave" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Cuti Sakit</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                                        <input type="checkbox" x-model="form.right_special_leave" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Cuti Khusus (Nikah, Duka, dll)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                                        <input type="checkbox" x-model="form.right_bpjs_health" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">BPJS Kesehatan</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                                        <input type="checkbox" x-model="form.right_bpjs_employment" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">BPJS Ketenagakerjaan</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-all">
                                        <input type="checkbox" x-model="form.right_thr" class="w-4 h-4 rounded text-emerald-500 focus:ring-emerald-500 border-slate-300">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">THR (Tunjangan Hari Raya)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Section 8: Kewajiban & Kerahasiaan -->
                            <div class="pb-4">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold shadow-lg">8</div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Kewajiban, Kerahasiaan & Ketentuan Lainnya</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kewajiban Karyawan</label>
                                        <textarea x-model="form.employee_obligations" rows="2" placeholder="Mematuhi SOP, menjaga rahasia perusahaan, dll" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm resize-y"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kebijakan NDA & IP Rights</label>
                                        <textarea x-model="form.nda_ip_policy" rows="2" placeholder="Data perusahaan, source code, hak cipta" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm resize-y"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Larangan & Sanksi</label>
                                        <textarea x-model="form.prohibitions" rows="2" placeholder="Konflik kepentingan, kerja sampingan tanpa izin" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm resize-y"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Ketentuan PHK</label>
                                        <textarea x-model="form.termination_terms" rows="2" placeholder="Pengunduran diri, PHK oleh perusahaan, pemberitahuan" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm resize-y"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                                <button type="submit" :disabled="saving" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-semibold text-sm shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all disabled:opacity-50 flex items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Kontrak'"></span>
                                </button>
                                <button type="button" @click="previewContract()" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-eye"></i>
                                    Preview Kontrak
                                </button>
                                <button type="button" @click="resetForm()" class="px-6 py-3 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold text-sm transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-rotate"></i>
                                    Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ========== CONTRACT LIST VIEW ========== -->
                <div x-show="currentView === 'list'" x-transition>
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-list text-emerald-500"></i>
                                Daftar Kontrak Karyawan
                            </h2>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                    <input type="text" x-model="searchQuery" placeholder="Cari karyawan..."
                                           class="pl-9 pr-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm w-64 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-slate-50 dark:bg-slate-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Karyawan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jabatan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jenis</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @forelse($contracts as $contract)
                                    <tr x-show="!searchQuery || '{{ strtolower($contract->employee_name) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($contract->position) }}'.includes(searchQuery.toLowerCase())"
                                        class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-slate-500">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $contract->employee_name }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $contract->position }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $contract->contract_type === 'PKWTT' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' }}">
                                                {{ $contract->contract_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $contract->start_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                                    'probation' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
                                                    'expired' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
                                                    'terminated' => 'bg-slate-100 text-slate-700 dark:bg-slate-500/20 dark:text-slate-400',
                                                ];
                                                $statusLabels = ['active' => 'Aktif', 'probation' => 'Percobaan', 'expired' => 'Berakhir', 'terminated' => 'Diberhentikan'];
                                            @endphp
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusColors[$contract->status] ?? $statusColors['active'] }}">
                                                {{ $statusLabels[$contract->status] ?? 'Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex items-center gap-2">
                                            <button @click="viewContract({{ $contract->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button @click="confirmDelete({{ $contract->id }}, '{{ addslashes($contract->employee_name) }}')" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                                                <i class="fa-solid fa-file-contract text-2xl text-slate-300 dark:text-slate-600"></i>
                                            </div>
                                            <p class="text-slate-500 dark:text-slate-400">Belum ada kontrak</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TEMPLATES VIEW ========== -->
                <div x-show="currentView === 'templates'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                        <div @click="loadTemplate('developer')" class="group cursor-pointer bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-blue-400 dark:hover:border-blue-500 transition-all hover:shadow-xl">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform mb-4">
                                <i class="fa-solid fa-laptop-code text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">IT Developer</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Template untuk Software Developer, Web Developer, Mobile Developer</p>
                        </div>
                        <div @click="loadTemplate('designer')" class="group cursor-pointer bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-purple-400 dark:hover:border-purple-500 transition-all hover:shadow-xl">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform mb-4">
                                <i class="fa-solid fa-palette text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-purple-600 transition-colors">Designer</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Template untuk UI/UX Designer, Graphic Designer</p>
                        </div>
                        <div @click="loadTemplate('marketing')" class="group cursor-pointer bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-amber-400 dark:hover:border-amber-500 transition-all hover:shadow-xl">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform mb-4">
                                <i class="fa-solid fa-bullhorn text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-amber-600 transition-colors">Marketing</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Template untuk Digital Marketing, Social Media Specialist</p>
                        </div>
                        <div @click="loadTemplate('admin')" class="group cursor-pointer bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-red-400 dark:hover:border-red-500 transition-all hover:shadow-xl">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-110 transition-transform mb-4">
                                <i class="fa-solid fa-clipboard-list text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-red-600 transition-colors">Admin</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Template untuk Staff Admin, Office Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-12 text-center text-slate-400 dark:text-slate-500 text-sm pb-4">
                    &copy; {{ date('Y') }} <span class="font-medium text-slate-600 dark:text-slate-400">KAP Budiandru & Rekan</span> — Kontrak Karyawan
                </footer>
            </div>
        </main>

        <!-- ========== PREVIEW MODAL ========== -->
        <div x-show="showPreview" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" @click.self="showPreview = false">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden" @click.stop>
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between flex-shrink-0">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-file-contract text-emerald-500"></i>
                        Preview Kontrak Kerja
                    </h2>
                    <div class="flex items-center gap-2">
                        <button @click="printContract()" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                        <button @click="showPreview = false" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <i class="fa-solid fa-xmark text-slate-500"></i>
                        </button>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto p-6">
                    <div id="contract-preview" class="bg-white p-8 border border-slate-200 rounded-xl" style="font-family: 'Times New Roman', serif; line-height: 1.8;">
                        <h1 class="text-center text-2xl font-bold mb-6 text-slate-900" style="font-family: 'Times New Roman', serif;">PERJANJIAN KERJA</h1>
                        <p class="text-center mb-8 text-slate-600" x-text="'No: ' + (previewData.id || Date.now())"></p>

                        <p class="mb-4 text-slate-800 text-justify">Pada hari ini, <span x-text="new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })"></span>, telah dibuat dan ditandatangani Perjanjian Kerja antara:</p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">I. IDENTITAS PARA PIHAK</h2>
                        <p class="mb-2 text-slate-800"><strong>PIHAK PERTAMA:</strong></p>
                        <p class="mb-1 text-slate-800">Nama Perusahaan: <span x-text="previewData.company_name || '-'"></span></p>
                        <p class="mb-4 text-slate-800">Alamat: <span x-text="previewData.company_address || '-'"></span></p>
                        <p class="mb-2 text-slate-800"><strong>PIHAK KEDUA:</strong></p>
                        <p class="mb-1 text-slate-800">Nama: <span x-text="previewData.employee_name || '-'"></span></p>
                        <p class="mb-1 text-slate-800">NIK: <span x-text="previewData.employee_nik || '-'"></span></p>
                        <p class="mb-4 text-slate-800">Alamat: <span x-text="previewData.employee_address || '-'"></span></p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">II. JENIS PERJANJIAN</h2>
                        <p class="mb-4 text-slate-800 text-justify">Perjanjian ini dibuat berdasarkan <span x-text="previewData.legal_basis || 'UU Ketenagakerjaan & UU Cipta Kerja'"></span> dengan jenis kontrak <strong x-text="previewData.contract_type || '-'"></strong>.</p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">III. JABATAN DAN PEKERJAAN</h2>
                        <p class="mb-2 text-slate-800 text-justify">Pihak Kedua dipekerjakan sebagai <strong x-text="previewData.position || '-'"></strong> dengan atasan langsung <span x-text="previewData.direct_superior || '-'"></span>.</p>
                        <p class="mb-4 text-slate-800 text-justify">Job Description: <span x-text="previewData.job_description || '-'"></span></p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">IV. LOKASI DAN WAKTU KERJA</h2>
                        <p class="mb-1 text-slate-800">Lokasi Kerja: <span x-text="previewData.work_location || '-'"></span></p>
                        <p class="mb-4 text-slate-800">Jam Kerja: <span x-text="(previewData.working_hours || 8) + ' jam per hari, ' + (previewData.working_days || 5) + ' hari kerja per minggu'"></span></p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">V. MASA KERJA</h2>
                        <p class="mb-1 text-slate-800">Tanggal Mulai: <span x-text="previewData.start_date || '-'"></span></p>
                        <p class="mb-4 text-slate-800">Masa Percobaan: <span x-text="(previewData.probation_period || 3) + ' bulan'"></span></p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">VI. GAJI DAN KOMPENSASI</h2>
                        <p class="mb-1 text-slate-800">Gaji Pokok: Rp <span x-text="parseInt(previewData.base_salary || 0).toLocaleString('id-ID')"></span></p>
                        <p class="mb-1 text-slate-800">Tunjangan Transport: Rp <span x-text="parseInt(previewData.transport_allowance || 0).toLocaleString('id-ID')"></span></p>
                        <p class="mb-1 text-slate-800">Tunjangan Makan: Rp <span x-text="parseInt(previewData.meal_allowance || 0).toLocaleString('id-ID')"></span></p>
                        <p class="mb-4 text-slate-800">Metode Pembayaran: <span x-text="previewData.payment_method || 'Transfer Bank'"></span></p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">VII. HAK DAN KEWAJIBAN</h2>
                        <p class="mb-4 text-slate-800 text-justify">Pihak Kedua berhak atas: Cuti Tahunan, Cuti Sakit, BPJS Kesehatan & Ketenagakerjaan, THR sesuai ketentuan yang berlaku.</p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">VIII. KERAHASIAAN</h2>
                        <p class="mb-4 text-slate-800 text-justify">Pihak Kedua wajib menjaga kerahasiaan informasi perusahaan, termasuk namun tidak terbatas pada data perusahaan, source code, strategi bisnis, dan data klien.</p>

                        <h2 class="text-lg font-bold mt-6 mb-3 text-slate-900">IX. PENUTUP</h2>
                        <p class="mb-8 text-slate-800 text-justify">Demikian Perjanjian Kerja ini dibuat dalam rangkap 2 (dua), masing-masing bermaterai cukup dan mempunyai kekuatan hukum yang sama.</p>

                        <div class="grid grid-cols-2 gap-8 mt-12">
                            <div class="text-center">
                                <p class="font-semibold text-slate-800">PIHAK PERTAMA</p>
                                <div class="border-t-2 border-slate-900 mt-20 pt-2">
                                    <span x-text="previewData.company_name || '_______________'" class="text-slate-800"></span>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="font-semibold text-slate-800">PIHAK KEDUA</p>
                                <div class="border-t-2 border-slate-900 mt-20 pt-2">
                                    <span x-text="previewData.employee_name || '_______________'" class="text-slate-800"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== DELETE CONFIRM MODAL ========== -->
        <div x-show="showDeleteModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" @click.self="showDeleteModal = false">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md p-6" @click.stop>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-triangle-exclamation text-2xl text-red-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Hapus Kontrak?</h3>
                    <p class="text-sm text-slate-500">Kontrak <strong x-text="deleteTargetName"></strong> akan dihapus permanen.</p>
                </div>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false" class="flex-1 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium transition-colors">Batal</button>
                    <button @click="deleteContract()" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-medium transition-colors">Hapus</button>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-4 opacity-0"
             class="fixed bottom-6 right-6 z-[60] max-w-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-4 flex items-start gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                     :class="toast.type === 'success' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600'">
                    <i class="fa-solid" :class="toast.type === 'success' ? 'fa-check' : 'fa-xmark'"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-slate-900 dark:text-white" x-text="toast.message"></p>
                </div>
                <button @click="toast.show = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
    function employeeLegalApp() {
        return {
            sidebarCollapsed: false,
            currentView: 'dashboard',
            searchQuery: '',
            saving: false,
            showPreview: false,
            showDeleteModal: false,
            deleteTargetId: null,
            deleteTargetName: '',
            previewData: {},
            toast: { show: false, message: '', type: 'success' },
            form: {
                company_name: '',
                company_address: '',
                employee_name: '',
                employee_nik: '',
                employee_address: '',
                contract_type: '',
                legal_basis: 'UU Ketenagakerjaan & UU Cipta Kerja',
                position: '',
                direct_superior: '',
                job_description: '',
                work_location: '',
                working_hours: 8,
                working_days: 5,
                overtime_rules: '',
                start_date: '',
                contract_duration: '',
                probation_period: 3,
                base_salary: '',
                transport_allowance: '',
                meal_allowance: '',
                other_allowance: '',
                payment_method: 'Transfer Bank',
                payment_date: '',
                right_annual_leave: true,
                right_sick_leave: true,
                right_special_leave: true,
                right_bpjs_health: true,
                right_bpjs_employment: true,
                right_thr: true,
                employee_obligations: '',
                nda_ip_policy: '',
                prohibitions: '',
                termination_terms: '',
            },

            init() {},

            showToast(message, type = 'success') {
                this.toast = { show: true, message, type };
                setTimeout(() => this.toast.show = false, 4000);
            },

            async submitContract() {
                this.saving = true;
                try {
                    const formData = new FormData();
                    Object.entries(this.form).forEach(([key, value]) => {
                        if (typeof value === 'boolean') {
                            if (value) formData.append(key, '1');
                        } else {
                            formData.append(key, value ?? '');
                        }
                    });

                    const res = await fetch('/employee-legal', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message);
                        this.resetForm();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        this.showToast(data.message || 'Gagal menyimpan kontrak', 'error');
                    }
                } catch (err) {
                    this.showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
                this.saving = false;
            },

            resetForm() {
                this.form = {
                    company_name: '', company_address: '',
                    employee_name: '', employee_nik: '', employee_address: '',
                    contract_type: '', legal_basis: 'UU Ketenagakerjaan & UU Cipta Kerja',
                    position: '', direct_superior: '', job_description: '',
                    work_location: '', working_hours: 8, working_days: 5, overtime_rules: '',
                    start_date: '', contract_duration: '', probation_period: 3,
                    base_salary: '', transport_allowance: '', meal_allowance: '', other_allowance: '',
                    payment_method: 'Transfer Bank', payment_date: '',
                    right_annual_leave: true, right_sick_leave: true, right_special_leave: true,
                    right_bpjs_health: true, right_bpjs_employment: true, right_thr: true,
                    employee_obligations: '', nda_ip_policy: '', prohibitions: '', termination_terms: '',
                };
            },

            previewContract() {
                this.previewData = { ...this.form };
                this.showPreview = true;
            },

            async viewContract(id) {
                try {
                    const res = await fetch(`/employee-legal/${id}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    this.previewData = data;
                    this.showPreview = true;
                } catch (err) {
                    this.showToast('Gagal memuat kontrak', 'error');
                }
            },

            confirmDelete(id, name) {
                this.deleteTargetId = id;
                this.deleteTargetName = name;
                this.showDeleteModal = true;
            },

            async deleteContract() {
                try {
                    const res = await fetch(`/employee-legal/${this.deleteTargetId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message);
                        this.showDeleteModal = false;
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        this.showToast(data.message || 'Gagal menghapus', 'error');
                    }
                } catch (err) {
                    this.showToast('Terjadi kesalahan', 'error');
                }
            },

            printContract() {
                const content = document.getElementById('contract-preview').innerHTML;
                const win = window.open('', '_blank');
                win.document.write(`
                    <html><head><title>Kontrak Kerja</title>
                    <style>
                        body { font-family: 'Times New Roman', serif; line-height: 1.8; padding: 2rem; color: #1e293b; }
                        h1 { text-align: center; font-size: 1.8rem; margin-bottom: 1.5rem; }
                        h2 { font-size: 1.2rem; margin-top: 1.5rem; margin-bottom: 0.5rem; }
                        p { margin-bottom: 0.5rem; text-align: justify; }
                        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 3rem; }
                        .text-center { text-align: center; }
                        .font-semibold { font-weight: 600; }
                        .border-t-2 { border-top: 2px solid #1e293b; margin-top: 5rem; padding-top: 0.5rem; }
                    </style></head>
                    <body>${content}</body></html>
                `);
                win.document.close();
                win.print();
            },

            loadTemplate(type) {
                const templates = {
                    developer: {
                        position: 'Software Developer',
                        job_description: 'Mengembangkan dan memelihara aplikasi web/mobile, menulis code yang clean dan terdokumentasi, melakukan testing dan debugging, berkolaborasi dengan tim development',
                        nda_ip_policy: 'Seluruh source code, dokumentasi teknis, dan hasil karya yang dibuat selama masa kerja adalah milik perusahaan.',
                        prohibitions: 'Dilarang melakukan freelance development tanpa izin perusahaan, menggunakan aset perusahaan untuk proyek pribadi.'
                    },
                    designer: {
                        position: 'UI/UX Designer',
                        job_description: 'Merancang interface dan user experience aplikasi, membuat wireframe dan prototype, melakukan user research dan testing, berkolaborasi dengan tim development',
                        nda_ip_policy: 'Seluruh desain, mockup, prototype, dan asset visual adalah milik perusahaan.',
                        prohibitions: 'Dilarang menerima proyek desain freelance yang sejenis dengan project perusahaan tanpa izin.'
                    },
                    marketing: {
                        position: 'Digital Marketing Specialist',
                        job_description: 'Mengelola campaign digital marketing, membuat konten social media, analisis performa marketing, SEO/SEM optimization',
                        nda_ip_policy: 'Data marketing, strategi campaign, database customer adalah aset rahasia perusahaan.',
                        prohibitions: 'Dilarang membawa database customer atau strategi marketing ke perusahaan lain.'
                    },
                    admin: {
                        position: 'Staff Admin',
                        job_description: 'Mengelola administrasi kantor, filing dokumen, koordinasi meeting, support operasional',
                        nda_ip_policy: 'Dokumen perusahaan, data keuangan, dan informasi internal bersifat rahasia.',
                        prohibitions: 'Dilarang membocorkan informasi internal perusahaan kepada pihak luar.'
                    }
                };

                const tpl = templates[type];
                if (tpl) {
                    this.form.position = tpl.position;
                    this.form.job_description = tpl.job_description;
                    this.form.nda_ip_policy = tpl.nda_ip_policy;
                    this.form.prohibitions = tpl.prohibitions;
                    this.currentView = 'create';
                    this.showToast('Template ' + tpl.position + ' berhasil dimuat!');
                }
            },
        };
    }
    </script>
</x-app-layout>
