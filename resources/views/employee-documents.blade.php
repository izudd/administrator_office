<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div x-data="employeeDocsApp()" x-init="init()" class="min-h-screen flex bg-slate-100 dark:bg-slate-950 transition-colors duration-300">

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
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-emerald-500 flex items-center justify-center transition-all"><i class="fa-solid fa-gauge-high text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Dashboard</span>
                </a>
                <p x-show="!sidebarCollapsed" class="px-4 py-2 mt-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Documents</p>
                <a href="{{ route('legal-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-blue-500 flex items-center justify-center transition-all"><i class="fa-solid fa-scale-balanced text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Documents</span>
                </a>
                <a href="{{ route('employee-legal.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-cyan-500 flex items-center justify-center transition-all"><i class="fa-solid fa-file-signature text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Kontrak Karyawan</span>
                </a>
                <a href="{{ route('employee-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 text-white font-medium transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center shadow-lg shadow-sky-500/30"><i class="fa-solid fa-user-shield text-sm text-white"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Karyawan</span>
                </a>
                <a href="{{ route('partner-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-purple-500 flex items-center justify-center transition-all"><i class="fa-solid fa-handshake text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Partner Docs</span>
                </a>
                <p x-show="!sidebarCollapsed" class="px-4 py-2 mt-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Management</p>
                <a href="{{ route('inventory.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-teal-500 flex items-center justify-center transition-all"><i class="fa-solid fa-boxes-stacked text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Inventory</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <div class="bg-slate-800/50 rounded-xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg">
                            <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div x-show="!sidebarCollapsed" class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" x-show="!sidebarCollapsed" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 text-sm bg-slate-700/50 hover:bg-red-500/20 hover:text-red-400 text-slate-300 rounded-lg transition-all font-medium flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
                        </button>
                    </form>
                </div>
                <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex w-full mt-3 items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
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
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Legal Karyawan</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                            <i class="fa-solid fa-user-shield"></i>
                            Kelola berkas & dokumen legal karyawan
                        </p>
                    </div>
                    <button @click="showAddEmployee = true" class="px-5 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl font-semibold text-sm shadow-lg shadow-sky-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i>
                        Tambah Karyawan
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-sky-300 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center shadow-lg shadow-sky-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-users text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalEmployees }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Total Karyawan</div>
                        </div>
                    </div>
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-emerald-300 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-file-circle-check text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalFiles }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Total Dokumen</div>
                        </div>
                    </div>
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-blue-300 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-user-check text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $activeEmployees }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Karyawan Aktif</div>
                        </div>
                    </div>
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-amber-300 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-clock text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $expiringDocs }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Segera Expired</div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Bar -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" x-model="searchQuery" placeholder="Cari nama karyawan, NIK, jabatan..."
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all">
                        </div>
                        <select x-model="filterPartner" class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-sky-500">
                            <option value="">Semua Partner</option>
                            @foreach($partners as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>
                        <select x-model="filterStatus" class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-sky-500">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Non-Aktif</option>
                            <option value="resigned">Resign</option>
                        </select>
                    </div>
                </div>

                <!-- Employee Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6 mb-8">
                    @forelse($employees as $emp)
                    <div x-show="matchesFilter({{ json_encode(strtolower($emp->employee_name), JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }}, {{ json_encode(strtolower($emp->employee_id_number ?? ''), JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }}, {{ json_encode(strtolower($emp->position ?? ''), JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }}, {{ json_encode($emp->status, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }}, {{ json_encode($emp->partner ?? '', JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }})"
                         class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-sky-300 dark:hover:border-sky-500/50 transition-all hover:shadow-xl overflow-hidden">
                        <!-- Card Header -->
                        <div class="relative p-5 pb-4">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-sky-500/10 to-blue-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="relative flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center shadow-lg shadow-sky-500/20 flex-shrink-0">
                                    <span class="text-lg font-bold text-white">{{ strtoupper(substr($emp->employee_name, 0, 2)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white truncate group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">{{ $emp->employee_name }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $emp->position ?? 'Belum diisi' }}</p>
                                    @if($emp->department)
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $emp->department }}</p>
                                    @endif
                                    @if($emp->partner)
                                    <p class="text-xs mt-1 flex items-center gap-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-md font-medium">
                                            <i class="fa-solid fa-user-tie text-[10px]"></i>{{ $emp->partner }}
                                        </span>
                                    </p>
                                    @endif
                                </div>
                                @php
                                    $sColors = ['active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400', 'inactive' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400', 'resigned' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400'];
                                    $sLabels = ['active' => 'Aktif', 'inactive' => 'Non-Aktif', 'resigned' => 'Resign'];
                                @endphp
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $sColors[$emp->status] ?? $sColors['active'] }} flex-shrink-0">
                                    {{ $sLabels[$emp->status] ?? 'Aktif' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Meta -->
                        <div class="px-5 pb-3">
                            <div class="flex flex-wrap gap-2 text-xs text-slate-500 dark:text-slate-400">
                                @if($emp->employee_id_number)
                                <span class="flex items-center gap-1 px-2 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg"><i class="fa-solid fa-id-card"></i> {{ $emp->employee_id_number }}</span>
                                @endif
                                @if($emp->join_date)
                                <span class="flex items-center gap-1 px-2 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg"><i class="fa-solid fa-calendar"></i> {{ $emp->join_date->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm">
                                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-sky-50 dark:bg-sky-500/10 rounded-lg text-sky-700 dark:text-sky-400 font-medium">
                                    <i class="fa-solid fa-file-lines text-xs"></i>
                                    <span>{{ $emp->files_count }} dokumen</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button @click="openEmployeeFiles({{ $emp->id }}, {{ json_encode($emp->employee_name, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }})" class="w-9 h-9 rounded-lg bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 dark:hover:bg-sky-500/20 text-sky-600 dark:text-sky-400 flex items-center justify-center transition-all hover:scale-110" title="Lihat Dokumen">
                                    <i class="fa-solid fa-folder-open text-sm"></i>
                                </button>
                                <button @click="editEmployee(@json($emp))" class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center transition-all hover:scale-110" title="Edit">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>
                                <button @click="confirmDeleteEmployee({{ $emp->id }}, {{ json_encode($emp->employee_name, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) }})" class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-500 dark:text-red-400 flex items-center justify-center transition-all hover:scale-110" title="Hapus">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="sm:col-span-2 xl:col-span-3">
                        <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800">
                            <div class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-users text-3xl text-slate-300 dark:text-slate-600"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-2">Belum ada data karyawan</h3>
                            <p class="text-sm text-slate-400 mb-4">Tambahkan karyawan untuk mulai mengelola berkas legal</p>
                            <button @click="showAddEmployee = true" class="px-6 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                                <i class="fa-solid fa-user-plus mr-2"></i>Tambah Karyawan
                            </button>
                        </div>
                    </div>
                    @endforelse
                </div>

                <footer class="mt-8 text-center text-slate-400 dark:text-slate-500 text-sm pb-4">
                    &copy; {{ date('Y') }} <span class="font-medium text-slate-600 dark:text-slate-400">KAP Budiandru & Rekan</span> — Legal Karyawan
                </footer>
            </div>
        </main>

        <!-- ========== ADD/EDIT EMPLOYEE MODAL ========== -->
        <div x-show="showAddEmployee" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" @click.self="showAddEmployee = false">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
                <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-sky-500"></i>
                        <span x-text="editingEmployee ? 'Edit Karyawan' : 'Tambah Karyawan Baru'"></span>
                    </h2>
                    <button @click="showAddEmployee = false; resetEmployeeForm()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors"><i class="fa-solid fa-xmark text-slate-500"></i></button>
                </div>
                <form @submit.prevent="submitEmployee()" class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Karyawan *</label>
                            <input type="text" x-model="empForm.employee_name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">NIK / NIP</label>
                            <input type="text" x-model="empForm.employee_id_number" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Jabatan</label>
                            <input type="text" x-model="empForm.position" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Departemen</label>
                            <input type="text" x-model="empForm.department" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Partner</label>
                            <select x-model="empForm.partner" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                                <option value="">Pilih Partner</option>
                                @foreach($partners as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                            <input type="email" x-model="empForm.email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">No. Telepon</label>
                            <input type="text" x-model="empForm.phone" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Bergabung</label>
                            <input type="date" x-model="empForm.join_date" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                        </div>
                        <template x-if="editingEmployee">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                                <select x-model="empForm.status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Non-Aktif</option>
                                    <option value="resigned">Resign</option>
                                </select>
                            </div>
                        </template>
                    </div>
                    <div class="flex gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <button type="submit" :disabled="savingEmployee" class="px-6 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all disabled:opacity-50 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span x-text="savingEmployee ? 'Menyimpan...' : (editingEmployee ? 'Update' : 'Simpan')"></span>
                        </button>
                        <button type="button" @click="showAddEmployee = false; resetEmployeeForm()" class="px-6 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-semibold text-sm transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========== EMPLOYEE FILES MODAL ========== -->
        <div x-show="showFilesModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" @click.self="showFilesModal = false">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden" @click.stop>
                <!-- Header -->
                <div class="flex-shrink-0 px-6 pt-5 pb-4 border-b border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center shadow-lg">
                                <i class="fa-solid fa-folder-open text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900 dark:text-white" x-text="selectedEmployeeName"></h2>
                                <p class="text-sm text-slate-500" x-text="empFiles.length + ' dokumen tersimpan'"></p>
                            </div>
                        </div>
                        <button @click="showFilesModal = false" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center text-slate-500 transition-all">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Files List -->
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    <template x-if="loadingFiles">
                        <div class="space-y-3">
                            <template x-for="i in 3" :key="i">
                                <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800 animate-pulse">
                                    <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700"></div>
                                    <div class="flex-1 space-y-2"><div class="h-4 bg-slate-200 dark:bg-slate-700 rounded w-3/4"></div><div class="h-3 bg-slate-200 dark:bg-slate-700 rounded w-1/3"></div></div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="!loadingFiles && empFiles.length">
                        <div class="space-y-2">
                            <template x-for="f in empFiles" :key="f.id">
                                <div class="group flex items-center gap-4 p-4 rounded-xl border border-slate-100 dark:border-slate-800 hover:border-sky-200 dark:hover:border-sky-800 bg-white dark:bg-slate-800/50 hover:bg-sky-50/50 dark:hover:bg-sky-900/10 transition-all hover:shadow-md">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center shadow-sm" :class="getDocColor(f.document_type)">
                                        <i class="text-white text-lg" :class="getDocIcon(f.document_type)"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-md bg-sky-100 dark:bg-sky-500/20 text-sky-700 dark:text-sky-400" x-text="f.document_type"></span>
                                            <template x-if="f.expiry_date && isExpiringSoon(f.expiry_date)">
                                                <span class="px-2 py-0.5 text-xs font-semibold rounded-md bg-amber-100 text-amber-700"><i class="fa-solid fa-clock mr-1"></i>Segera Expired</span>
                                            </template>
                                        </div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate mt-1" x-text="f.file_name"></div>
                                        <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-3">
                                            <span x-text="f.created_at"></span>
                                            <template x-if="f.expiry_date"><span class="text-amber-500">Exp: <span x-text="f.expiry_date"></span></span></template>
                                        </div>
                                        <template x-if="f.notes"><div class="text-xs text-slate-400 mt-1 italic" x-text="f.notes"></div></template>
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <a :href="f.url" target="_blank" class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition-all hover:scale-110" title="Preview"><i class="fa-solid fa-eye text-sm"></i></a>
                                        <a :href="f.url" download class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all hover:scale-110" title="Download"><i class="fa-solid fa-download text-sm"></i></a>
                                        <button @click="deleteFile(f.id)" class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 text-red-500 flex items-center justify-center transition-all hover:scale-110" title="Hapus"><i class="fa-solid fa-trash text-sm"></i></button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="!loadingFiles && !empFiles.length">
                        <div class="text-center py-12">
                            <div class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-file-circle-plus text-3xl text-slate-300 dark:text-slate-600"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">Belum ada dokumen</h3>
                            <p class="text-sm text-slate-400">Upload dokumen legal karyawan di bawah</p>
                        </div>
                    </template>
                </div>

                <!-- Upload Footer -->
                <div class="flex-shrink-0 px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/30">
                    <form @submit.prevent="uploadFile()" class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <select x-model="uploadForm.document_type" required class="px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-sky-500">
                                <option value="">Jenis Dokumen *</option>
                                @foreach($documentTypes as $dt)
                                <option value="{{ $dt }}">{{ $dt }}</option>
                                @endforeach
                            </select>
                            <input type="date" x-model="uploadForm.expiry_date" placeholder="Tanggal Expired" class="px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-sky-500">
                            <input type="text" x-model="uploadForm.notes" placeholder="Catatan (opsional)" class="px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-3 text-center hover:border-sky-400 bg-white dark:bg-slate-800/50 transition-all cursor-pointer"
                                 @click="$refs.empFileInput.click()"
                                 @dragover.prevent="$el.classList.add('border-sky-400','bg-sky-50/50')"
                                 @dragleave.prevent="$el.classList.remove('border-sky-400','bg-sky-50/50')"
                                 @drop.prevent="$el.classList.remove('border-sky-400','bg-sky-50/50'); uploadForm.file = $event.dataTransfer.files[0]">
                                <input type="file" x-ref="empFileInput" class="hidden" @change="uploadForm.file = $event.target.files[0]">
                                <p class="text-sm text-slate-500" x-text="uploadForm.file ? uploadForm.file.name : 'Klik atau drop file di sini (max 10MB)'"></p>
                            </div>
                            <button type="submit" :disabled="uploading || !uploadForm.file || !uploadForm.document_type"
                                    class="px-5 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all disabled:opacity-40 flex items-center gap-2">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <span x-text="uploading ? 'Uploading...' : 'Upload'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ========== DELETE CONFIRM MODAL ========== -->
        <div x-show="showDeleteModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4" @click.self="showDeleteModal = false">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md p-6" @click.stop>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-triangle-exclamation text-2xl text-red-500"></i></div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Hapus Karyawan?</h3>
                    <p class="text-sm text-slate-500">Semua dokumen <strong x-text="deleteTargetName"></strong> akan ikut terhapus.</p>
                </div>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false" class="flex-1 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium transition-colors">Batal</button>
                    <button @click="deleteEmployee()" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-medium transition-colors">Hapus</button>
                </div>
            </div>
        </div>

        <!-- Toast -->
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-4 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-4 opacity-0"
             class="fixed bottom-6 right-6 z-[60] max-w-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-4 flex items-start gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" :class="toast.type === 'success' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600'">
                    <i class="fa-solid" :class="toast.type === 'success' ? 'fa-check' : 'fa-xmark'"></i>
                </div>
                <p class="text-sm font-medium text-slate-900 dark:text-white flex-1" x-text="toast.message"></p>
                <button @click="toast.show = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xs"></i></button>
            </div>
        </div>
    </div>

    <script>
    function employeeDocsApp() {
        return {
            sidebarCollapsed: false,
            searchQuery: '',
            filterStatus: '',
            filterPartner: '',
            showAddEmployee: false,
            showFilesModal: false,
            showDeleteModal: false,
            editingEmployee: null,
            savingEmployee: false,
            selectedEmployeeId: null,
            selectedEmployeeName: '',
            empFiles: [],
            loadingFiles: false,
            uploading: false,
            deleteTargetId: null,
            deleteTargetName: '',
            toast: { show: false, message: '', type: 'success' },
            empForm: { employee_name: '', employee_id_number: '', position: '', department: '', partner: '', email: '', phone: '', join_date: '', status: 'active' },
            uploadForm: { document_type: '', notes: '', expiry_date: '', file: null },

            init() {},

            showToast(msg, type = 'success') {
                this.toast = { show: true, message: msg, type };
                setTimeout(() => this.toast.show = false, 4000);
            },

            matchesFilter(name, nik, pos, status, partner) {
                const q = this.searchQuery.toLowerCase();
                const matchSearch = !q || name.includes(q) || nik.includes(q) || pos.includes(q);
                const matchStatus = !this.filterStatus || status === this.filterStatus;
                const matchPartner = !this.filterPartner || partner === this.filterPartner;
                return matchSearch && matchStatus && matchPartner;
            },

            resetEmployeeForm() {
                this.empForm = { employee_name: '', employee_id_number: '', position: '', department: '', partner: '', email: '', phone: '', join_date: '', status: 'active' };
                this.editingEmployee = null;
            },

            editEmployee(emp) {
                this.editingEmployee = emp.id;
                this.empForm = {
                    employee_name: emp.employee_name || '',
                    employee_id_number: emp.employee_id_number || '',
                    position: emp.position || '',
                    department: emp.department || '',
                    partner: emp.partner || '',
                    email: emp.email || '',
                    phone: emp.phone || '',
                    join_date: emp.join_date ? emp.join_date.split('T')[0] : '',
                    status: emp.status || 'active',
                };
                this.showAddEmployee = true;
            },

            async submitEmployee() {
                this.savingEmployee = true;
                try {
                    const url = this.editingEmployee ? `/employee-documents/employees/${this.editingEmployee}` : '/employee-documents/employees';
                    const method = this.editingEmployee ? 'PUT' : 'POST';
                    const res = await fetch(url, {
                        method,
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.empForm),
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message);
                        this.showAddEmployee = false;
                        this.resetEmployeeForm();
                        setTimeout(() => location.reload(), 800);
                    } else {
                        this.showToast(data.message || 'Gagal menyimpan', 'error');
                    }
                } catch (e) { this.showToast('Terjadi kesalahan', 'error'); }
                this.savingEmployee = false;
            },

            confirmDeleteEmployee(id, name) {
                this.deleteTargetId = id;
                this.deleteTargetName = name;
                this.showDeleteModal = true;
            },

            async deleteEmployee() {
                try {
                    const res = await fetch(`/employee-documents/employees/${this.deleteTargetId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message);
                        this.showDeleteModal = false;
                        setTimeout(() => location.reload(), 800);
                    } else { this.showToast(data.message || 'Gagal menghapus', 'error'); }
                } catch (e) { this.showToast('Terjadi kesalahan', 'error'); }
            },

            async openEmployeeFiles(id, name) {
                this.selectedEmployeeId = id;
                this.selectedEmployeeName = name;
                this.empFiles = [];
                this.loadingFiles = true;
                this.showFilesModal = true;
                this.uploadForm = { document_type: '', notes: '', expiry_date: '', file: null };
                try {
                    const res = await fetch(`/employee-documents/${id}/files`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    this.empFiles = await res.json();
                } catch (e) { this.showToast('Gagal memuat dokumen', 'error'); }
                this.loadingFiles = false;
            },

            async uploadFile() {
                if (!this.uploadForm.file || !this.uploadForm.document_type) return;
                this.uploading = true;
                try {
                    const fd = new FormData();
                    fd.append('file', this.uploadForm.file);
                    fd.append('document_type', this.uploadForm.document_type);
                    fd.append('notes', this.uploadForm.notes || '');
                    if (this.uploadForm.expiry_date) fd.append('expiry_date', this.uploadForm.expiry_date);
                    const res = await fetch(`/employee-documents/${this.selectedEmployeeId}/upload`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                        body: fd,
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message);
                        this.uploadForm = { document_type: '', notes: '', expiry_date: '', file: null };
                        if (this.$refs.empFileInput) this.$refs.empFileInput.value = '';
                        await this.openEmployeeFiles(this.selectedEmployeeId, this.selectedEmployeeName);
                    } else { this.showToast(data.message || 'Gagal upload', 'error'); }
                } catch (e) { this.showToast('Terjadi kesalahan', 'error'); }
                this.uploading = false;
            },

            async deleteFile(fileId) {
                if (!confirm('Hapus dokumen ini?')) return;
                try {
                    const res = await fetch(`/employee-documents/files/${fileId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message);
                        this.openEmployeeFiles(this.selectedEmployeeId, this.selectedEmployeeName);
                    } else { this.showToast(data.message || 'Gagal menghapus', 'error'); }
                } catch (e) { this.showToast('Terjadi kesalahan', 'error'); }
            },

            isExpiringSoon(date) {
                if (!date) return false;
                const d = new Date(date);
                const now = new Date();
                const diff = (d - now) / (1000 * 60 * 60 * 24);
                return diff >= 0 && diff <= 30;
            },

            getDocIcon(type) {
                const map = {
                    'KTP': 'fa-solid fa-id-card', 'NPWP': 'fa-solid fa-file-invoice',
                    'BPJS Kesehatan': 'fa-solid fa-heart-pulse', 'BPJS Ketenagakerjaan': 'fa-solid fa-hard-hat',
                    'Kartu Keluarga': 'fa-solid fa-people-roof', 'Ijazah': 'fa-solid fa-graduation-cap',
                    'Sertifikat': 'fa-solid fa-certificate', 'Surat Lamaran': 'fa-solid fa-envelope-open-text',
                    'CV / Resume': 'fa-solid fa-file-lines', 'Pas Foto': 'fa-solid fa-camera',
                    'Surat Keterangan Sehat': 'fa-solid fa-stethoscope', 'SKCK': 'fa-solid fa-shield-halved',
                    'Surat Referensi': 'fa-solid fa-quote-right', 'Slip Gaji': 'fa-solid fa-money-bill-wave',
                    'SPT Pajak': 'fa-solid fa-receipt',
                };
                return map[type] || 'fa-solid fa-file';
            },

            getDocColor(type) {
                const map = {
                    'KTP': 'bg-gradient-to-br from-blue-500 to-indigo-600', 'NPWP': 'bg-gradient-to-br from-emerald-500 to-green-600',
                    'BPJS Kesehatan': 'bg-gradient-to-br from-red-500 to-rose-600', 'BPJS Ketenagakerjaan': 'bg-gradient-to-br from-amber-500 to-orange-600',
                    'Kartu Keluarga': 'bg-gradient-to-br from-purple-500 to-violet-600', 'Ijazah': 'bg-gradient-to-br from-indigo-500 to-blue-600',
                    'Sertifikat': 'bg-gradient-to-br from-yellow-500 to-amber-600', 'Surat Lamaran': 'bg-gradient-to-br from-sky-500 to-cyan-600',
                    'CV / Resume': 'bg-gradient-to-br from-teal-500 to-emerald-600', 'Pas Foto': 'bg-gradient-to-br from-pink-500 to-rose-600',
                    'Surat Keterangan Sehat': 'bg-gradient-to-br from-green-500 to-emerald-600', 'SKCK': 'bg-gradient-to-br from-slate-500 to-gray-600',
                    'Surat Referensi': 'bg-gradient-to-br from-cyan-500 to-blue-600', 'Slip Gaji': 'bg-gradient-to-br from-emerald-500 to-teal-600',
                    'SPT Pajak': 'bg-gradient-to-br from-orange-500 to-red-600',
                };
                return map[type] || 'bg-gradient-to-br from-slate-500 to-gray-600';
            },
        };
    }
    </script>
</x-app-layout>
