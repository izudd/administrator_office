<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div x-data="suratApp()" x-init="init()" class="min-h-screen flex bg-slate-100 dark:bg-slate-950 transition-colors duration-300">

        <!-- ===== SIDEBAR ===== -->
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
                <a href="{{ route('employee-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-sky-500 flex items-center justify-center transition-all"><i class="fa-solid fa-user-shield text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Karyawan</span>
                </a>
                <a href="{{ route('management-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-amber-500 flex items-center justify-center transition-all"><i class="fa-solid fa-user-tie text-sm"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Management</span>
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
                <a href="{{ route('surat-menyurat.index') }}" class="group flex items-center px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 text-white font-medium transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center shadow-lg shadow-rose-500/30"><i class="fa-solid fa-envelope-open-text text-sm text-white"></i></div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Surat Menyurat</span>
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

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Bar -->
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Surat Menyurat</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                            <i class="fa-solid fa-envelope-open-text"></i>
                            Kelola surat masuk, keluar, internal, dan surat keputusan
                        </p>
                    </div>
                    <button @click="openModal('add')"
                            class="px-5 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl font-semibold text-sm shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Surat
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                    <!-- Surat Masuk -->
                    <div @click="filterJenis = filterJenis === 'masuk' ? '' : 'masuk'"
                         class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-500/50 transition-all hover:shadow-xl overflow-hidden cursor-pointer"
                         :class="filterJenis === 'masuk' ? 'border-blue-400 dark:border-blue-500 shadow-xl' : ''">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-envelope text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalMasuk }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Surat Masuk</div>
                        </div>
                    </div>
                    <!-- Surat Keluar -->
                    <div @click="filterJenis = filterJenis === 'keluar' ? '' : 'keluar'"
                         class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-emerald-300 dark:hover:border-emerald-500/50 transition-all hover:shadow-xl overflow-hidden cursor-pointer"
                         :class="filterJenis === 'keluar' ? 'border-emerald-400 dark:border-emerald-500 shadow-xl' : ''">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-paper-plane text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalKeluar }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Surat Keluar</div>
                        </div>
                    </div>
                    <!-- Internal -->
                    <div @click="filterJenis = filterJenis === 'internal' ? '' : 'internal'"
                         class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-amber-300 dark:hover:border-amber-500/50 transition-all hover:shadow-xl overflow-hidden cursor-pointer"
                         :class="filterJenis === 'internal' ? 'border-amber-400 dark:border-amber-500 shadow-xl' : ''">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-comments text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalInternal }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Internal / Memo</div>
                        </div>
                    </div>
                    <!-- SK -->
                    <div @click="filterJenis = filterJenis === 'sk' ? '' : 'sk'"
                         class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 hover:border-purple-300 dark:hover:border-purple-500/50 transition-all hover:shadow-xl overflow-hidden cursor-pointer"
                         :class="filterJenis === 'sk' ? 'border-purple-400 dark:border-purple-500 shadow-xl' : ''">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform mb-3">
                                <i class="fa-solid fa-certificate text-white text-lg"></i>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalSK }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Surat Keputusan</div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Bar -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" x-model="search"
                                   placeholder="Cari nomor surat, perihal, instansi, pengirim..."
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all">
                        </div>
                        <select x-model="filterJenis"
                                class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500">
                            <option value="">Semua Jenis</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                            <option value="internal">Internal / Memo</option>
                            <option value="sk">Surat Keputusan</option>
                        </select>
                        <select x-model="filterStatus"
                                class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-rose-500">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="terkirim">Terkirim</option>
                            <option value="diterima">Diterima</option>
                            <option value="dibalas">Dibalas</option>
                            <option value="diarsipkan">Diarsipkan</option>
                        </select>
                        <button x-show="search || filterJenis || filterStatus"
                                @click="search = ''; filterJenis = ''; filterStatus = ''"
                                class="px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-sm hover:bg-slate-100 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Surat List -->
                <div class="space-y-3 mb-8">
                    <!-- Empty State -->
                    <template x-if="filteredSurat.length === 0">
                        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800">
                            <div class="text-center py-16">
                                <div class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-envelope-open text-3xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-2">Tidak ada surat ditemukan</h3>
                                <p class="text-sm text-slate-400 mb-4" x-show="search || filterJenis || filterStatus">Coba ubah filter pencarian</p>
                                <button x-show="!search && !filterJenis && !filterStatus"
                                        @click="openModal('add')"
                                        class="px-6 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                                    <i class="fa-solid fa-plus mr-2"></i>Tambah Surat Pertama
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Surat Cards -->
                    <template x-for="surat in filteredSurat" :key="surat.id">
                        <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 hover:shadow-xl transition-all overflow-hidden"
                             :class="{
                                 'hover:border-blue-300 dark:hover:border-blue-500/50':   surat.jenis_surat === 'masuk',
                                 'hover:border-emerald-300 dark:hover:border-emerald-500/50': surat.jenis_surat === 'keluar',
                                 'hover:border-amber-300 dark:hover:border-amber-500/50':  surat.jenis_surat === 'internal',
                                 'hover:border-purple-300 dark:hover:border-purple-500/50': surat.jenis_surat === 'sk',
                             }">
                            <div class="p-5 flex items-start gap-4">
                                <!-- Icon -->
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0 group-hover:scale-110 transition-transform"
                                     :class="iconBg(surat.jenis_surat)">
                                    <i class="text-white text-lg" :class="iconClass(surat.jenis_surat)"></i>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3 flex-wrap">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                                <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded-lg"
                                                      :class="badgeBg(surat.jenis_surat)"
                                                      x-text="surat.nomor_surat"></span>
                                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full"
                                                      :class="statusBadge(surat.status)"
                                                      x-text="surat.status"></span>
                                            </div>
                                            <h3 class="text-base font-bold text-slate-900 dark:text-white truncate" x-text="surat.perihal"></h3>
                                            <div class="flex items-center gap-3 mt-1 flex-wrap text-xs text-slate-500 dark:text-slate-400">
                                                <span x-show="surat.instansi" class="flex items-center gap-1">
                                                    <i class="fa-solid fa-building"></i>
                                                    <span x-text="surat.instansi"></span>
                                                </span>
                                                <span x-show="surat.jenis_surat !== 'keluar' && surat.pengirim" class="flex items-center gap-1">
                                                    <i class="fa-solid fa-user"></i>
                                                    <span x-text="surat.pengirim"></span>
                                                </span>
                                                <span x-show="surat.jenis_surat === 'keluar' && surat.penerima" class="flex items-center gap-1">
                                                    <i class="fa-solid fa-user"></i>
                                                    <span x-text="surat.penerima"></span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa-solid fa-calendar-day"></i>
                                                    <span x-text="formatTanggal(surat.tanggal_surat)"></span>
                                                </span>
                                            </div>
                                            <p x-show="surat.keterangan" class="text-xs text-slate-400 dark:text-slate-500 mt-1.5 line-clamp-1" x-text="surat.keterangan"></p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-1.5 flex-shrink-0">
                                            <template x-if="surat.file_path">
                                                <a :href="'/surat-menyurat/' + surat.id + '/preview'" target="_blank"
                                                   class="w-9 h-9 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-500/10 text-slate-400 hover:text-blue-500 flex items-center justify-center transition-all hover:scale-110"
                                                   title="Preview Lampiran">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </a>
                                            </template>
                                            <button @click="openModal('edit', surat)"
                                                    class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center transition-all hover:scale-110"
                                                    title="Edit">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </button>
                                            <button @click="confirmDelete(surat)"
                                                    class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-500 dark:text-red-400 flex items-center justify-center transition-all hover:scale-110"
                                                    title="Hapus">
                                                <i class="fa-solid fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File indicator bar -->
                            <template x-if="surat.file_path">
                                <div class="px-5 pb-3 -mt-2">
                                    <div class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500">
                                        <i class="fa-solid fa-paperclip"></i>
                                        <span x-text="surat.file_name"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Footer count -->
                <p class="text-sm text-slate-400 dark:text-slate-500 text-center pb-4">
                    Menampilkan <span class="font-semibold text-slate-600 dark:text-slate-300" x-text="filteredSurat.length"></span>
                    dari <span class="font-semibold" x-text="suratList.length"></span> surat
                </p>

            </div>
        </main>
    </div>

    <!-- ===== MODAL ADD / EDIT ===== -->
    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @click.self="closeModal()"
         style="display:none;">
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col relative overflow-hidden">

            <!-- Top accent bar -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-rose-500 via-pink-500 to-purple-500"></div>

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-7 pt-7 pb-5 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white"
                        x-text="modalMode === 'add' ? 'Tambah Surat Baru' : 'Edit Surat'"></h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5"
                       x-text="modalMode === 'add' ? 'Nomor surat digenerate otomatis' : 'Perbarui informasi surat'"></p>
                </div>
                <button @click="closeModal()"
                        class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-red-100 dark:hover:bg-red-500/20 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-slate-400 hover:text-red-500 text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="overflow-y-auto flex-1 px-7 pb-5">
                <div class="grid grid-cols-2 gap-4">

                    <!-- Jenis Surat -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Jenis Surat <span class="text-red-500">*</span></label>
                        <select x-model="form.jenis_surat" required
                                class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                            <option value="">— Pilih Jenis —</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                            <option value="internal">Internal / Memo</option>
                            <option value="sk">Surat Keputusan (SK)</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Status</label>
                        <select x-model="form.status"
                                class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                            <option value="draft">Draft</option>
                            <option value="terkirim">Terkirim</option>
                            <option value="diterima">Diterima</option>
                            <option value="dibalas">Dibalas</option>
                            <option value="diarsipkan">Diarsipkan</option>
                        </select>
                    </div>

                    <!-- Perihal -->
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Perihal <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.perihal" required maxlength="500"
                               placeholder="Perihal surat..."
                               class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                    </div>

                    <!-- Tanggal Surat -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Tanggal Surat <span class="text-red-500">*</span></label>
                        <input type="date" x-model="form.tanggal_surat" required
                               class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                    </div>

                    <!-- Tanggal Diterima (surat masuk) -->
                    <div class="col-span-2 sm:col-span-1" x-show="form.jenis_surat === 'masuk'" x-cloak>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Tanggal Diterima</label>
                        <input type="date" x-model="form.tanggal_diterima"
                               class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                    </div>

                    <!-- Pengirim -->
                    <div class="col-span-2 sm:col-span-1"
                         x-show="form.jenis_surat === 'masuk' || form.jenis_surat === 'internal' || form.jenis_surat === 'sk'" x-cloak>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider"
                               x-text="form.jenis_surat === 'internal' ? 'Dari (Divisi/Orang)' : 'Pengirim'"></label>
                        <input type="text" x-model="form.pengirim" maxlength="255"
                               placeholder="Nama pengirim..."
                               class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                    </div>

                    <!-- Penerima -->
                    <div class="col-span-2 sm:col-span-1"
                         x-show="form.jenis_surat === 'keluar' || form.jenis_surat === 'internal'" x-cloak>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider"
                               x-text="form.jenis_surat === 'internal' ? 'Kepada (Divisi/Orang)' : 'Penerima'"></label>
                        <input type="text" x-model="form.penerima" maxlength="255"
                               placeholder="Nama penerima..."
                               class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                    </div>

                    <!-- Instansi -->
                    <div class="col-span-2"
                         x-show="form.jenis_surat === 'masuk' || form.jenis_surat === 'keluar'" x-cloak>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider"
                               x-text="form.jenis_surat === 'keluar' ? 'Instansi / Tujuan' : 'Asal Instansi'"></label>
                        <input type="text" x-model="form.instansi" maxlength="255"
                               placeholder="Nama instansi / perusahaan..."
                               class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all">
                    </div>

                    <!-- Keterangan -->
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Keterangan</label>
                        <textarea x-model="form.keterangan" rows="2" maxlength="1000"
                                  placeholder="Catatan tambahan (opsional)..."
                                  class="w-full text-sm border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white transition-all resize-none"></textarea>
                    </div>

                    <!-- Upload File -->
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Lampiran Surat</label>
                        <div class="border-2 border-dashed rounded-xl p-5 text-center cursor-pointer transition-all"
                             :class="dragOver ? 'border-rose-400 bg-rose-50 dark:bg-rose-500/10' : 'border-slate-200 dark:border-slate-700 hover:border-rose-300 dark:hover:border-rose-500/50'"
                             @dragover.prevent="dragOver = true"
                             @dragleave.prevent="dragOver = false"
                             @drop.prevent="handleDrop($event)"
                             @click="$refs.fileInput.click()">
                            <input type="file" x-ref="fileInput" class="hidden"
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                   @change="handleFileSelect($event)">
                            <template x-if="!selectedFile">
                                <div>
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400"></i>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Drag & drop atau <span class="text-rose-500 font-semibold">klik untuk pilih file</span></p>
                                    <p class="text-xs text-slate-400 mt-1">PDF, JPG, PNG, DOC, DOCX — maks 10MB</p>
                                    <template x-if="editingItem && editingItem.file_path">
                                        <p class="text-xs text-blue-500 mt-2">
                                            <i class="fa-solid fa-paperclip mr-1"></i>
                                            File saat ini: <span x-text="editingItem.file_name" class="font-medium"></span>
                                        </p>
                                    </template>
                                </div>
                            </template>
                            <template x-if="selectedFile">
                                <div class="flex items-center justify-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-500/20 flex items-center justify-center">
                                        <i class="fa-solid fa-file text-rose-500"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300" x-text="selectedFile.name"></p>
                                        <p class="text-xs text-slate-400" x-text="formatFileSize(selectedFile.size)"></p>
                                    </div>
                                    <button type="button" @click.stop="selectedFile = null; $refs.fileInput.value = ''"
                                            class="w-7 h-7 rounded-full bg-red-100 dark:bg-red-500/20 text-red-500 flex items-center justify-center hover:bg-red-200 transition-all">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-7 py-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3 flex-shrink-0">
                <button type="button" @click="closeModal()"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                    Batal
                </button>
                <button type="button" @click="submitForm()" :disabled="submitting"
                        class="px-6 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center gap-2">
                    <span x-show="submitting" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span x-text="submitting ? 'Menyimpan...' : (modalMode === 'add' ? 'Simpan Surat' : 'Perbarui')"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== MODAL KONFIRMASI HAPUS ===== -->
    <div x-show="showDeleteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         @click.self="showDeleteModal = false"
         style="display:none;">
        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-sm p-7 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Hapus Surat?</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Surat <strong class="text-slate-700 dark:text-slate-300" x-text="deletingItem?.nomor_surat"></strong> beserta lampiran filenya akan dihapus permanen.
                    </p>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button @click="showDeleteModal = false"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                    Batal
                </button>
                <button @click="deleteSurat()" :disabled="submitting"
                        class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-orange-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl transition-all disabled:opacity-50 flex items-center gap-2">
                    <span x-show="submitting" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span x-text="submitting ? 'Menghapus...' : 'Ya, Hapus'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== TOAST ===== -->
    <div class="fixed bottom-5 right-5 z-[100] flex flex-col gap-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium max-w-xs border"
                 :class="toast.type === 'success'
                     ? 'bg-white dark:bg-slate-900 border-emerald-200 dark:border-emerald-500/30 text-emerald-800 dark:text-emerald-300'
                     : 'bg-white dark:bg-slate-900 border-red-200 dark:border-red-500/30 text-red-800 dark:text-red-300'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <i :class="toast.type === 'success' ? 'fa-solid fa-circle-check text-emerald-500' : 'fa-solid fa-circle-xmark text-red-500'"></i>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <script>
    function suratApp() {
        return {
            sidebarCollapsed: false,
            suratList: @json($suratList),
            search: '',
            filterJenis: '',
            filterStatus: '',
            showModal: false,
            showDeleteModal: false,
            modalMode: 'add',
            submitting: false,
            dragOver: false,
            selectedFile: null,
            editingItem: null,
            deletingItem: null,
            toasts: [],
            form: {
                jenis_surat: '', perihal: '', tanggal_surat: '',
                tanggal_diterima: '', pengirim: '', penerima: '',
                instansi: '', status: 'draft', keterangan: '',
            },

            init() {
                this.suratList.sort((a, b) => new Date(b.tanggal_surat) - new Date(a.tanggal_surat));
            },

            get filteredSurat() {
                return this.suratList.filter(s => {
                    const q = this.search.toLowerCase();
                    const matchSearch = !q
                        || (s.nomor_surat||'').toLowerCase().includes(q)
                        || (s.perihal||'').toLowerCase().includes(q)
                        || (s.instansi||'').toLowerCase().includes(q)
                        || (s.pengirim||'').toLowerCase().includes(q)
                        || (s.penerima||'').toLowerCase().includes(q);
                    const matchJenis  = !this.filterJenis  || s.jenis_surat === this.filterJenis;
                    const matchStatus = !this.filterStatus || s.status === this.filterStatus;
                    return matchSearch && matchJenis && matchStatus;
                });
            },

            iconBg(jenis) {
                return {
                    masuk:    'bg-gradient-to-br from-blue-500 to-cyan-500 shadow-blue-500/30',
                    keluar:   'bg-gradient-to-br from-emerald-500 to-green-500 shadow-emerald-500/30',
                    internal: 'bg-gradient-to-br from-amber-500 to-orange-500 shadow-amber-500/30',
                    sk:       'bg-gradient-to-br from-purple-500 to-pink-500 shadow-purple-500/30',
                }[jenis] || 'bg-gradient-to-br from-slate-500 to-slate-600';
            },
            iconClass(jenis) {
                return {
                    masuk:    'fa-solid fa-envelope',
                    keluar:   'fa-solid fa-paper-plane',
                    internal: 'fa-solid fa-comments',
                    sk:       'fa-solid fa-certificate',
                }[jenis] || 'fa-solid fa-file';
            },
            badgeBg(jenis) {
                return {
                    masuk:    'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300',
                    keluar:   'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300',
                    internal: 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300',
                    sk:       'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300',
                }[jenis] || 'bg-slate-100 text-slate-600';
            },
            statusBadge(status) {
                return {
                    draft:      'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300',
                    terkirim:   'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300',
                    diterima:   'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300',
                    dibalas:    'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300',
                    diarsipkan: 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300',
                }[status] || 'bg-slate-100 text-slate-600';
            },
            formatTanggal(str) {
                if (!str) return '—';
                return new Date(str + 'T00:00:00').toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            },
            formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(1) + ' MB';
            },

            openModal(mode, item = null) {
                this.modalMode = mode;
                this.selectedFile = null;
                if (this.$refs.fileInput) this.$refs.fileInput.value = '';
                if (mode === 'add') {
                    this.editingItem = null;
                    this.form = { jenis_surat: '', perihal: '', tanggal_surat: new Date().toISOString().slice(0,10), tanggal_diterima: '', pengirim: '', penerima: '', instansi: '', status: 'draft', keterangan: '' };
                } else {
                    this.editingItem = item;
                    this.form = {
                        jenis_surat: item.jenis_surat||'', perihal: item.perihal||'',
                        tanggal_surat: item.tanggal_surat ? item.tanggal_surat.substring(0,10) : '',
                        tanggal_diterima: item.tanggal_diterima ? item.tanggal_diterima.substring(0,10) : '',
                        pengirim: item.pengirim||'', penerima: item.penerima||'',
                        instansi: item.instansi||'', status: item.status||'draft', keterangan: item.keterangan||'',
                    };
                }
                this.showModal = true;
            },
            closeModal() { this.showModal = false; this.editingItem = null; this.selectedFile = null; },

            handleDrop(e) { this.dragOver = false; const f = e.dataTransfer.files[0]; if (f) this.selectedFile = f; },
            handleFileSelect(e) { const f = e.target.files[0]; if (f) this.selectedFile = f; },

            async submitForm() {
                if (!this.form.jenis_surat || !this.form.perihal || !this.form.tanggal_surat) {
                    this.showToast('Harap lengkapi field yang wajib diisi.', 'error'); return;
                }
                this.submitting = true;
                const fd = new FormData();
                Object.entries(this.form).forEach(([k, v]) => { if (v !== null && v !== undefined && v !== '') fd.append(k, v); });
                if (this.selectedFile) fd.append('file', this.selectedFile);
                const isEdit = this.modalMode === 'edit';
                if (isEdit) fd.append('_method', 'PUT');
                try {
                    const res = await fetch(isEdit ? `/surat-menyurat/${this.editingItem.id}` : '/surat-menyurat', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: fd,
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message, 'success');
                        this.closeModal();
                        setTimeout(() => window.location.reload(), 700);
                    } else {
                        this.showToast(data.message || 'Terjadi kesalahan.', 'error');
                    }
                } catch (e) { this.showToast('Gagal terhubung ke server.', 'error'); }
                this.submitting = false;
            },

            confirmDelete(item) { this.deletingItem = item; this.showDeleteModal = true; },
            async deleteSurat() {
                if (!this.deletingItem) return;
                this.submitting = true;
                try {
                    const res = await fetch(`/surat-menyurat/${this.deletingItem.id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showToast(data.message, 'success');
                        this.showDeleteModal = false;
                        this.suratList = this.suratList.filter(s => s.id !== this.deletingItem.id);
                        this.deletingItem = null;
                    } else { this.showToast(data.message || 'Gagal menghapus.', 'error'); }
                } catch (e) { this.showToast('Gagal terhubung ke server.', 'error'); }
                this.submitting = false;
            },

            showToast(message, type = 'success') {
                const id = Date.now();
                this.toasts.push({ id, message, type });
                setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 3500);
            },
        };
    }
    </script>
</x-app-layout>
