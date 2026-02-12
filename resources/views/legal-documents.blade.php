<x-app-layout>
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(30px, 10px) scale(1.05); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        .animate-blob { animation: blob 15s ease-in-out infinite; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        .stat-card-glow:hover {
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.2);
        }
        .folder-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .folder-card:hover {
            transform: translateY(-4px) scale(1.01);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9999px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; }
    </style>

    <div style="--header-height:72px">
        <div x-data="legalDocsApp()" x-init="init()"
            class="relative min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-[#0a0f1a] dark:via-[#0e1525] dark:to-[#0d1117] transition-colors duration-500">

            <!-- Animated Background -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-emerald-400/20 to-cyan-400/20 dark:from-emerald-500/10 dark:to-cyan-500/10 rounded-full blur-3xl animate-blob"></div>
                <div class="absolute top-1/2 -left-40 w-[500px] h-[500px] bg-gradient-to-br from-cyan-400/20 to-teal-400/20 dark:from-cyan-500/10 dark:to-teal-500/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-40 right-1/3 w-96 h-96 bg-gradient-to-br from-teal-400/20 to-emerald-400/20 dark:from-teal-500/10 dark:to-emerald-500/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
                <!-- Grid Pattern -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgNDAgMTAgTSAxMCAwIEwgMTAgNDAgTSAwIDIwIEwgNDAgMjAgTSAyMCAwIEwgMjAgNDAgTSAwIDMwIEwgNDAgMzAgTSAzMCAwIEwgMzAgNDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMDA1IiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-40 dark:opacity-20"></div>
            </div>

            <!-- Toast Notification -->
            <div x-show="toast.show" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 -translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-4 scale-95" class="fixed top-6 right-6 z-[100] w-96 max-w-[calc(100vw-2rem)]">
                <div class="rounded-2xl shadow-2xl overflow-hidden border"
                    :class="{
                        'bg-white border-emerald-200': toast.type === 'success',
                        'bg-white border-red-200': toast.type === 'error',
                        'bg-white border-blue-200': toast.type === 'info'
                    }">
                    <!-- Top color bar -->
                    <div class="h-1"
                        :class="{
                            'bg-gradient-to-r from-emerald-400 to-teal-400': toast.type === 'success',
                            'bg-gradient-to-r from-red-400 to-rose-400': toast.type === 'error',
                            'bg-gradient-to-r from-blue-400 to-cyan-400': toast.type === 'info'
                        }"></div>
                    <div class="p-4 flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                            :class="{
                                'bg-emerald-50 text-emerald-500': toast.type === 'success',
                                'bg-red-50 text-red-500': toast.type === 'error',
                                'bg-blue-50 text-blue-500': toast.type === 'info'
                            }">
                            <i class="text-lg"
                                :class="{
                                    'fa-solid fa-circle-check': toast.type === 'success',
                                    'fa-solid fa-circle-exclamation': toast.type === 'error',
                                    'fa-solid fa-circle-info': toast.type === 'info'
                                }"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-800 text-sm" x-text="toast.title"></h4>
                            <p class="text-sm text-gray-500 mt-0.5 break-words" x-text="toast.message"></p>
                        </div>
                        <button @click="toast.show = false" class="flex-shrink-0 w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                    <!-- Progress bar -->
                    <div class="h-0.5 bg-gray-100">
                        <div class="h-full transition-all duration-[4000ms] ease-linear rounded-full"
                            :class="{
                                'bg-emerald-400': toast.type === 'success',
                                'bg-red-400': toast.type === 'error',
                                'bg-blue-400': toast.type === 'info'
                            }"
                            :style="toast.show ? 'width: 0%' : 'width: 100%'"></div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <header class="relative z-10 p-6 sm:p-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Title Section -->
                        <div class="flex items-start gap-5">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-2xl blur-xl opacity-50"></div>
                                <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 flex items-center justify-center shadow-2xl animate-float">
                                    <i class="fa-solid fa-vault text-white text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h1 class="text-3xl sm:text-4xl font-black bg-gradient-to-r from-gray-900 via-gray-700 to-gray-800 dark:from-white dark:via-gray-200 dark:to-gray-300 bg-clip-text text-transparent">
                                        Document Vault
                                    </h1>
                                    <span class="px-3 py-1 text-[10px] font-black bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-full uppercase tracking-wider shadow-lg">
                                        Enterprise
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                    Secure Legal Document Management System
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Search -->
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" x-model="globalSearch" placeholder="Search documents..."
                                    class="pl-11 pr-4 py-3 w-64 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all shadow-sm" />
                            </div>

                            <!-- View Toggle -->
                            <div class="flex items-center bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-1 shadow-sm">
                                <button @click="viewMode = 'grid'"
                                    :class="viewMode === 'grid' ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-500 hover:text-gray-700'"
                                    class="p-2.5 rounded-lg transition-all">
                                    <i class="fa-solid fa-grid-2"></i>
                                </button>
                                <button @click="viewMode = 'list'"
                                    :class="viewMode === 'list' ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-500 hover:text-gray-700'"
                                    class="p-2.5 rounded-lg transition-all">
                                    <i class="fa-solid fa-list"></i>
                                </button>
                            </div>

                            <!-- New Folder Button -->
                            <button @click="showAddModal = true"
                                class="group relative inline-flex items-center gap-2.5 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white font-bold shadow-xl hover:shadow-2xl hover:shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                                <div class="absolute inset-0 rounded-xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <i class="fa-solid fa-folder-plus group-hover:rotate-12 transition-transform duration-300"></i>
                                <span>New Folder</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Stats Section -->
            <section class="relative z-10 px-6 sm:px-8 pb-6">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                        <!-- Total Folders -->
                        <div class="glass-card stat-card-glow rounded-2xl p-5 border border-gray-200/50 dark:border-gray-700/50 hover:border-emerald-500/30 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/10 to-emerald-500/20 dark:from-emerald-500/20 dark:to-emerald-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-folder text-emerald-500 text-xl"></i>
                                </div>
                                <div class="flex items-center gap-1 text-emerald-500 text-xs font-bold">
                                    <i class="fa-solid fa-arrow-up"></i>
                                    <span>Active</span>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mb-1">{{ count($folders) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Total Folders</p>
                        </div>

                        <!-- Total Files -->
                        <div class="glass-card stat-card-glow rounded-2xl p-5 border border-gray-200/50 dark:border-gray-700/50 hover:border-cyan-500/30 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500/10 to-cyan-500/20 dark:from-cyan-500/20 dark:to-cyan-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-lines text-cyan-500 text-xl"></i>
                                </div>
                                <div class="flex items-center gap-1 text-cyan-500 text-xs font-bold">
                                    <i class="fa-solid fa-check"></i>
                                    <span>Secured</span>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mb-1">{{ $totalFiles ?? 0 }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Total Files</p>
                        </div>

                        <!-- Recent Files -->
                        <div class="glass-card stat-card-glow rounded-2xl p-5 border border-gray-200/50 dark:border-gray-700/50 hover:border-purple-500/30 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/10 to-purple-500/20 dark:from-purple-500/20 dark:to-purple-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-clock text-purple-500 text-xl"></i>
                                </div>
                                <div class="flex items-center gap-1 text-purple-500 text-xs font-bold">
                                    <i class="fa-solid fa-bolt"></i>
                                    <span>7 Days</span>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mb-1">{{ $recentFiles ?? 0 }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Recent Files</p>
                        </div>

                        <!-- Storage -->
                        <div class="glass-card stat-card-glow rounded-2xl p-5 border border-gray-200/50 dark:border-gray-700/50 hover:border-amber-500/30 transition-all duration-300 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-500/20 dark:from-amber-500/20 dark:to-amber-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-hard-drive text-amber-500 text-xl"></i>
                                </div>
                                <div class="flex items-center gap-1 text-amber-500 text-xs font-bold">
                                    <i class="fa-solid fa-database"></i>
                                    <span>Used</span>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white mb-1">{{ $totalStorage ?? '0 B' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Storage Used</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <main class="relative z-10 px-6 sm:px-8 pb-8 transition-all duration-400" :class="{ 'blur-sm scale-[0.995]': showFolderPanel }">
                <div class="max-w-7xl mx-auto">
                    <!-- Section Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-emerald-500 to-cyan-500 rounded-full"></div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">All Folders</h2>
                            <span class="px-2 py-0.5 text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg">{{ count($folders) }} items</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fa-solid fa-sort"></i>
                            <span>Sort by name</span>
                        </div>
                    </div>

                    <!-- Folders Grid -->
                    <div class="grid gap-5" :class="viewMode === 'grid' ? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4' : 'grid-cols-1'">
                        @foreach ($folders as $index => $folder)
                            <div
                                style="animation-delay: {{ $index * 60 }}ms"
                                class="folder-card group relative glass-card rounded-2xl overflow-hidden animate-[fadeIn_0.5s_ease-out_forwards] opacity-0"
                                :class="viewMode === 'list' ? 'p-4' : 'p-6'"
                            >
                                <!-- Hover Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 via-teal-500/0 to-cyan-500/0 group-hover:from-emerald-500/5 group-hover:via-teal-500/5 group-hover:to-cyan-500/5 transition-all duration-500"></div>

                                <!-- Top Actions -->
                                <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-1 group-hover:translate-y-0 z-20">
                                    <button @click.stop="startRenameFolder('{{ addslashes($folder->name) }}')"
                                        class="w-9 h-9 rounded-xl bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center shadow-lg transform hover:scale-110 transition-all"
                                        title="Rename">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <button @click.stop="deleteFolderConfirm('{{ addslashes($folder->name) }}')"
                                        class="w-9 h-9 rounded-xl bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg transform hover:scale-110 transition-all"
                                        title="Delete">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>

                                <div class="relative z-10"
                                    :class="viewMode === 'list' ? 'flex items-center gap-4' : ''">

                                    <!-- Folder Icon -->
                                    <div class="relative cursor-pointer" :class="viewMode === 'list' ? '' : 'mb-5'" @click="toggleToc('{{ addslashes($folder->name) }}')">
                                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-2xl blur-lg opacity-0 group-hover:opacity-40 transition-opacity"></div>
                                        <div class="relative w-16 h-16 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                            <i class="text-2xl text-white" :class="tocExpanded['{{ addslashes($folder->name) }}'] ? 'fa-solid fa-folder-open' : 'fa-solid fa-folder'"></i>
                                        </div>
                                    </div>

                                    <!-- Folder Info -->
                                    <div :class="viewMode === 'list' ? 'flex-1' : ''" class="cursor-pointer" @click="toggleToc('{{ addslashes($folder->name) }}')">
                                        <h3 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors truncate"
                                            :class="viewMode === 'list' ? '' : 'mb-3'">
                                            {{ $folder->name }}
                                        </h3>
                                        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400" :class="viewMode === 'list' ? 'mt-1' : ''">
                                            <span class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-calendar"></i>
                                                {{ $folder->updated_at->format('d M Y') }}
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-clock"></i>
                                                {{ $folder->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Toggle & Open Buttons -->
                                    <div class="flex items-center gap-2" :class="viewMode === 'list' ? '' : 'hidden'">
                                        <button @click.stop="toggleToc('{{ addslashes($folder->name) }}')"
                                            class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 flex items-center justify-center transition-all"
                                            title="Daftar Isi">
                                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="tocExpanded['{{ addslashes($folder->name) }}'] ? 'rotate-180' : ''"></i>
                                        </button>
                                        <button @click.stop="openFolder('{{ addslashes($folder->name) }}')"
                                            class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 hover:bg-emerald-200 dark:hover:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center transition-all"
                                            title="Open & Upload">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Footer (Grid View) -->
                                <div x-show="viewMode === 'grid'" class="relative z-10 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 uppercase flex items-center gap-1.5">
                                        <i class="fa-solid fa-list-ul text-[8px]"></i>
                                        <span x-text="tocFiles['{{ addslashes($folder->name) }}'] ? tocFiles['{{ addslashes($folder->name) }}'].length + ' files' : 'Daftar Isi'"></span>
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <button @click.stop="toggleToc('{{ addslashes($folder->name) }}')"
                                            class="flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg transition-all"
                                            :class="tocExpanded['{{ addslashes($folder->name) }}'] ? 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400' : 'text-gray-400 hover:text-emerald-500'">
                                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="tocExpanded['{{ addslashes($folder->name) }}'] ? 'rotate-180' : ''"></i>
                                            <span x-text="tocExpanded['{{ addslashes($folder->name) }}'] ? 'Tutup' : 'Lihat Isi'"></span>
                                        </button>
                                        <button @click.stop="openFolder('{{ addslashes($folder->name) }}')"
                                            class="flex items-center gap-1.5 text-xs font-medium text-emerald-500 hover:text-emerald-600 transition-all opacity-0 group-hover:opacity-100">
                                            <span>Open</span>
                                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- TOC: Daftar Isi (Expand/Collapse) -->
                                <div x-show="tocExpanded['{{ addslashes($folder->name) }}']"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-2 max-h-0"
                                    x-transition:enter-end="opacity-100 translate-y-0 max-h-[500px]"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-2"
                                    class="relative z-10 mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">

                                    <!-- Loading -->
                                    <template x-if="tocLoading['{{ addslashes($folder->name) }}']">
                                        <div class="space-y-2 py-2">
                                            <template x-for="i in 3" :key="i">
                                                <div class="flex items-center gap-3 p-2 rounded-lg animate-pulse">
                                                    <div class="w-8 h-8 rounded-lg bg-gray-200 dark:bg-gray-700"></div>
                                                    <div class="flex-1 space-y-1">
                                                        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                                                        <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- File List -->
                                    <template x-if="!tocLoading['{{ addslashes($folder->name) }}'] && tocFiles['{{ addslashes($folder->name) }}'] && tocFiles['{{ addslashes($folder->name) }}'].length > 0">
                                        <div class="space-y-1 max-h-[300px] overflow-y-auto custom-scrollbar">
                                            <template x-for="(f, idx) in tocFiles['{{ addslashes($folder->name) }}']" :key="idx">
                                                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer group/file"
                                                    @click.stop="tocPreviewFile('{{ addslashes($folder->name) }}', f.file_name)">
                                                    <!-- Mini File Icon -->
                                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs"
                                                        :class="getFileIconClass(f.file_name)">
                                                        <i :class="getFileIcon(f.file_name)"></i>
                                                    </div>
                                                    <!-- File Name + Size -->
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate group-hover/file:text-emerald-600 dark:group-hover/file:text-emerald-400 transition-colors" x-text="f.file_name"></p>
                                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 flex items-center gap-2">
                                                            <span x-text="f.size || 'N/A'"></span>
                                                            <span class="uppercase" x-text="f.file_name.split('.').pop()"></span>
                                                        </p>
                                                    </div>
                                                    <!-- Quick Preview Icon -->
                                                    <div class="flex-shrink-0 opacity-0 group-hover/file:opacity-100 transition-opacity">
                                                        <i class="fa-solid fa-eye text-[10px] text-gray-400"></i>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Empty -->
                                    <template x-if="!tocLoading['{{ addslashes($folder->name) }}'] && tocFiles['{{ addslashes($folder->name) }}'] && tocFiles['{{ addslashes($folder->name) }}'].length === 0">
                                        <div class="py-4 text-center">
                                            <i class="fa-solid fa-folder-open text-2xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">Belum ada file</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <style>
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                    </style>

                    @if (count($folders) === 0)
                        <div class="text-center py-20">
                            <div class="relative inline-block mb-8">
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                                <div class="relative w-32 h-32 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center">
                                    <i class="fa-solid fa-folder-open text-5xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-black text-gray-800 dark:text-gray-200 mb-3">No folders yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Create your first folder to start organizing your legal documents securely</p>
                            <button @click="showAddModal = true"
                                class="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white font-bold shadow-2xl hover:shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                                <i class="fa-solid fa-folder-plus text-xl group-hover:rotate-12 transition-transform duration-300"></i>
                                <span>Create Your First Folder</span>
                            </button>
                        </div>
                    @endif
                </div>
            </main>

            <!-- Folder Files Modal (Full-screen overlay) -->
            <div x-show="showFolderPanel"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @keydown.window.escape="closePanel()"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 sm:p-6">

                <!-- Modal Card -->
                <div x-show="showFolderPanel"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                    @click.away="closePanel()"
                    class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden border border-gray-200 dark:border-gray-700">

                    <!-- Modal Header -->
                    <div class="flex-shrink-0 px-6 pt-6 pb-4 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg">
                                    <i class="fa-solid fa-folder-open text-white text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100" x-text="selectedFolder || 'Folder'"></h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-0.5">
                                        <i class="fa-solid fa-file text-xs"></i>
                                        <span x-text="files.length ? (files.length + ' files') : 'No files yet'"></span>
                                        <span class="text-gray-300 dark:text-gray-600">|</span>
                                        <i class="fa-solid fa-shield-halved text-xs text-emerald-500"></i>
                                        <span class="text-emerald-500 text-xs font-medium">Encrypted</span>
                                    </p>
                                </div>
                            </div>
                            <button @click="closePanel()"
                                class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-all">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>

                        <!-- Search Bar -->
                        <div class="mt-4">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input x-model="search" type="text" placeholder="Search files in this folder..."
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal Body (Scrollable) -->
                    <div class="flex-1 overflow-y-auto px-6 py-4">
                        <!-- Loading Skeleton -->
                        <template x-if="loading">
                            <div class="space-y-3">
                                <template x-for="i in 4" :key="i">
                                    <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 dark:bg-gray-800 animate-pulse">
                                        <div class="w-12 h-12 rounded-xl bg-gray-200 dark:bg-gray-700"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-3/4"></div>
                                            <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-lg w-1/3"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- File List -->
                        <template x-if="!loading && filteredFiles().length">
                            <div class="space-y-2">
                                <template x-for="(f, idx) in filteredFiles()" :key="f.file_name">
                                    <div class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-gray-800 hover:border-emerald-200 dark:hover:border-emerald-800 bg-white dark:bg-gray-800/50 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all duration-200 hover:shadow-md">
                                        <!-- File Icon -->
                                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center shadow-sm"
                                            :class="getFileIconClass(f.file_name)">
                                            <i class="text-white text-lg" :class="getFileIcon(f.file_name)"></i>
                                        </div>

                                        <!-- File Info -->
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors" x-text="f.file_name"></div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-1 flex items-center gap-3">
                                                <span class="flex items-center gap-1">
                                                    <i class="fa-solid fa-hard-drive"></i>
                                                    <span x-text="f.size || 'N/A'"></span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa-solid fa-tag"></i>
                                                    <span x-text="f.file_name.split('.').pop().toUpperCase()"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <button @click="previewFile(f.file_name)"
                                                class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center transition-all hover:scale-110"
                                                title="Preview">
                                                <i class="fa-solid fa-eye text-sm"></i>
                                            </button>
                                            <a :href="f.url" download
                                                class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center transition-all hover:scale-110"
                                                title="Download">
                                                <i class="fa-solid fa-download text-sm"></i>
                                            </a>
                                            <button @click="deleteFile(f.file_name)"
                                                class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-500 dark:text-red-400 flex items-center justify-center transition-all hover:scale-110"
                                                title="Delete">
                                                <i class="fa-solid fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <template x-if="!loading && !filteredFiles().length">
                            <div class="text-center py-16">
                                <div class="relative inline-block mb-6">
                                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                                    <div class="relative w-24 h-24 rounded-full bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                                        <i class="fa-solid fa-file-circle-plus text-4xl text-gray-300 dark:text-gray-600"></i>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-1">No files found</h3>
                                <p class="text-sm text-gray-400 dark:text-gray-500">Upload your first document using the area below</p>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Footer: Upload Area -->
                    <div class="flex-shrink-0 px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                        <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center hover:border-emerald-400 dark:hover:border-emerald-600 bg-white dark:bg-gray-800/50 transition-all cursor-pointer group"
                            @dragover.prevent="$el.classList.add('border-emerald-400','bg-emerald-50/50')"
                            @dragleave.prevent="$el.classList.remove('border-emerald-400','bg-emerald-50/50')"
                            @drop.prevent="$el.classList.remove('border-emerald-400','bg-emerald-50/50'); onDrop($event)"
                            @click="$refs.fileInput.click()">

                            <input type="file" x-ref="fileInput" class="hidden" @change="onFileChange($event)" multiple />

                            <template x-if="!uploading">
                                <div class="flex items-center justify-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center group-hover:scale-110 transition-transform shadow-md">
                                        <i class="fa-solid fa-cloud-arrow-up text-lg text-white"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                            Drop files here or <span class="text-emerald-600 dark:text-emerald-400">click to browse</span>
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                            PDF, DOC, XLS, IMG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="uploading">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-medium text-emerald-600 dark:text-emerald-400">Uploading...</span>
                                        <span class="text-gray-500" x-text="progress + '%'"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-300 rounded-full" :style="`width: ${progress}%`"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <div x-show="showPreview" x-transition
                class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4"
                @click.self="showPreview = false">

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl h-[85vh] flex flex-col overflow-hidden">
                    <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100" x-text="previewTitle"></h2>
                        <button @click="showPreview = false" class="w-10 h-10 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark text-xl text-gray-500"></i>
                        </button>
                    </div>

                    <div class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
                        <template x-if="previewType === 'pdf'">
                            <iframe :src="previewUrl" class="w-full h-full" frameborder="0"></iframe>
                        </template>
                        <template x-if="previewType === 'image'">
                            <img :src="previewUrl" class="max-h-[80vh] object-contain" />
                        </template>
                        <template x-if="previewType === 'office'">
                            <iframe :src="previewUrl" class="w-full h-full" frameborder="0"></iframe>
                        </template>
                        <template x-if="previewType === 'text'">
                            <iframe :src="previewUrl" class="w-full h-full bg-white"></iframe>
                        </template>
                        <template x-if="previewType === 'unknown'">
                            <div class="text-gray-600 dark:text-gray-300 text-center p-8">
                                <p class="mb-4">File type not supported for preview.</p>
                                <a :href="previewUrl" download
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition font-medium">
                                    <i class="fa-solid fa-download"></i>
                                    Download File
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Add Folder Modal -->
            <div x-show="showAddModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                <div x-show="showAddModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    @click.away="showAddModal = false"
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 border border-gray-200 dark:border-gray-700">

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-folder-plus text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Create New Folder</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Enter a name for your folder</p>
                        </div>
                    </div>

                    <input type="text" x-model="newFolderName" placeholder="e.g., Tax Documents 2024"
                        @keydown.enter="createFolder()"
                        class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all mb-6 font-medium" />

                    <div class="flex justify-end gap-3">
                        <button @click="showAddModal = false"
                            class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition-colors">
                            Cancel
                        </button>
                        <button @click="createFolder()"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            Create Folder
                        </button>
                    </div>
                </div>
            </div>

            <!-- Rename Folder Modal -->
            <div x-show="showRenameModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                <div x-show="showRenameModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    @click.away="showRenameModal = false"
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 border border-gray-200 dark:border-gray-700">

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-pen text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Rename Folder</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Enter new name for "<span x-text="renamingFolder"></span>"</p>
                        </div>
                    </div>

                    <input type="text" x-model="newFolderNameRename" placeholder="Enter new folder name"
                        @keydown.enter="renameFolder()"
                        class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all mb-6 font-medium" />

                    <div class="flex justify-end gap-3">
                        <button @click="showRenameModal = false"
                            class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition-colors">
                            Cancel
                        </button>
                        <button @click="renameFolder()"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            Rename
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                    @click.away="showDeleteModal = false"
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 border border-gray-200 dark:border-gray-700">

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-trash text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Delete Folder</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone</p>
                        </div>
                    </div>

                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                        <p class="text-sm text-red-700 dark:text-red-300">
                            Are you sure you want to delete "<span class="font-bold" x-text="deletingFolder"></span>"?
                            All files inside will be permanently removed.
                        </p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button @click="showDeleteModal = false"
                            class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition-colors">
                            Cancel
                        </button>
                        <button @click="deleteFolder()"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            Delete Folder
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="relative z-10 py-8 border-t border-gray-200/50 dark:border-gray-700/50 mt-12 bg-white/30 dark:bg-gray-900/30 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <!-- Logo -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 p-[2px] shadow-lg">
                                <div class="w-full h-full rounded-[10px] bg-white dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/logo.PNG') }}" alt="KAP Logo" class="w-7 h-7 object-contain">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-sm bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 bg-clip-text text-transparent">
                                    KAP Budiandru & Rekan
                                </span>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                    Public Accountant Firm
                                </span>
                            </div>
                        </div>
                        <span class="text-gray-300 dark:text-gray-600 hidden sm:inline">|</span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">
                            © {{ date('Y') }} All rights reserved
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        function legalDocsApp() {
            return {
                files: [],
                loading: false,
                showFolderPanel: false,
                showAddModal: false,
                showRenameModal: false,
                showDeleteModal: false,
                selectedFolder: null,
                search: '',
                globalSearch: '',
                viewMode: 'grid',
                uploading: false,
                progress: 0,
                newFolderName: '',
                newFolderNameRename: '',
                renamingFolder: '',
                deletingFolder: '',
                showPreview: false,
                previewUrl: '',
                previewTitle: '',
                previewType: 'unknown',
                tocExpanded: {},
                tocFiles: {},
                tocLoading: {},
                toast: {
                    show: false,
                    type: 'success',
                    title: '',
                    message: ''
                },

                init() {
                    console.log('Document Vault initialized');
                },

                showToast(type, title, message) {
                    this.toast = { show: true, type, title, message };
                    setTimeout(() => { this.toast.show = false; }, 4000);
                },

                async toggleToc(folderName) {
                    if (this.tocExpanded[folderName]) {
                        this.tocExpanded[folderName] = false;
                        return;
                    }

                    this.tocExpanded[folderName] = true;

                    // Only fetch if not already loaded
                    if (!this.tocFiles[folderName]) {
                        this.tocLoading[folderName] = true;
                        try {
                            const encoded = encodeURIComponent(folderName);
                            const res = await fetch(`/legal-documents/${encoded}/files`, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials: 'same-origin'
                            });

                            if (res.ok) {
                                const data = await res.json();
                                this.tocFiles[folderName] = data.map(f => ({
                                    ...f,
                                    url: f.url || (f.file_path ? `/storage/${f.file_path}` : undefined)
                                }));
                            } else {
                                this.tocFiles[folderName] = [];
                                if (res.status === 403) {
                                    this.showToast('error', 'Akses Ditolak', 'PIN diperlukan untuk mengakses folder ini');
                                    this.tocExpanded[folderName] = false;
                                }
                            }
                        } catch (err) {
                            console.error('TOC fetch error:', err);
                            this.tocFiles[folderName] = [];
                        } finally {
                            this.tocLoading[folderName] = false;
                        }
                    }
                },

                tocPreviewFile(folderName, fileName) {
                    this.previewTitle = fileName;
                    const ext = fileName.split('.').pop().toLowerCase();
                    this.previewUrl = `/legal-documents/${encodeURIComponent(folderName)}/preview/${encodeURIComponent(fileName)}`;

                    if (['pdf'].includes(ext)) this.previewType = 'pdf';
                    else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) this.previewType = 'image';
                    else if (['txt', 'csv'].includes(ext)) this.previewType = 'text';
                    else this.previewType = 'unknown';

                    this.showPreview = true;
                },

                async openFolder(folderName, evt = null) {
                    this.selectedFolder = folderName;
                    this.showFolderPanel = true;
                    await this.loadFiles(folderName);
                },

                closePanel() {
                    this.showFolderPanel = false;
                    this.selectedFolder = null;
                    this.files = [];
                    this.search = '';
                },

                async loadFiles(folderName) {
                    if (!folderName) return;
                    this.loading = true;
                    this.files = [];

                    try {
                        const encoded = encodeURIComponent(folderName);
                        const url = `/legal-documents/${encoded}/files`;
                        const res = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });

                        if (!res.ok) {
                            if (res.status === 401 || res.url.includes('/login')) {
                                this.showToast('error', 'Session Expired', 'Please login again');
                                window.location.href = '/login';
                                return;
                            }
                            this.showToast('error', 'Error', `Failed to load files: ${res.status}`);
                            return;
                        }

                        const data = await res.json();
                        this.files = data.map(f => ({
                            ...f,
                            url: f.url ? f.url : (f.file_path ? `/storage/${f.file_path}` : undefined)
                        }));
                    } catch (err) {
                        console.error('loadFiles error:', err);
                        this.showToast('error', 'Error', 'Failed to load files');
                    } finally {
                        this.loading = false;
                    }
                },

                previewFile(fileName) {
                    this.previewTitle = fileName;
                    const ext = fileName.split('.').pop().toLowerCase();
                    this.previewUrl = `/legal-documents/${encodeURIComponent(this.selectedFolder)}/preview/${encodeURIComponent(fileName)}`;

                    if (['pdf'].includes(ext)) this.previewType = 'pdf';
                    else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) this.previewType = 'image';
                    else if (['txt', 'csv'].includes(ext)) this.previewType = 'text';
                    else this.previewType = 'unknown';

                    this.showPreview = true;
                },

                filteredFiles() {
                    if (!this.search) return this.files;
                    return this.files.filter(f => (f.file_name || '').toLowerCase().includes(this.search.toLowerCase()));
                },

                getFileIcon(fileName) {
                    const ext = (fileName || '').split('.').pop().toLowerCase();
                    const map = {
                        'pdf': 'fa-solid fa-file-pdf',
                        'doc': 'fa-solid fa-file-word',
                        'docx': 'fa-solid fa-file-word',
                        'xls': 'fa-solid fa-file-excel',
                        'xlsx': 'fa-solid fa-file-excel',
                        'ppt': 'fa-solid fa-file-powerpoint',
                        'pptx': 'fa-solid fa-file-powerpoint',
                        'jpg': 'fa-solid fa-file-image',
                        'jpeg': 'fa-solid fa-file-image',
                        'png': 'fa-solid fa-file-image',
                        'gif': 'fa-solid fa-file-image',
                        'webp': 'fa-solid fa-file-image',
                        'zip': 'fa-solid fa-file-zipper',
                        'rar': 'fa-solid fa-file-zipper',
                        'txt': 'fa-solid fa-file-lines',
                        'csv': 'fa-solid fa-file-csv',
                    };
                    return map[ext] || 'fa-solid fa-file';
                },

                getFileIconClass(fileName) {
                    const ext = (fileName || '').split('.').pop().toLowerCase();
                    if (['pdf'].includes(ext)) return 'bg-gradient-to-br from-red-500 to-rose-600';
                    if (['doc', 'docx'].includes(ext)) return 'bg-gradient-to-br from-blue-500 to-indigo-600';
                    if (['xls', 'xlsx', 'csv'].includes(ext)) return 'bg-gradient-to-br from-emerald-500 to-green-600';
                    if (['ppt', 'pptx'].includes(ext)) return 'bg-gradient-to-br from-orange-500 to-amber-600';
                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) return 'bg-gradient-to-br from-purple-500 to-violet-600';
                    if (['zip', 'rar'].includes(ext)) return 'bg-gradient-to-br from-amber-500 to-yellow-600';
                    return 'bg-gradient-to-br from-gray-500 to-gray-600';
                },

                onDrop(e) {
                    const file = e.dataTransfer.files[0];
                    if (file) this.uploadFile(file);
                },

                onFileChange(e) {
                    const file = e.target.files[0];
                    if (file) this.uploadFile(file);
                },

                uploadFile(file) {
                    if (!file || !this.selectedFolder) {
                        this.showToast('error', 'Error', 'Please open a folder first');
                        return;
                    }

                    const maxSize = 5 * 1024 * 1024;
                    if (file.size > maxSize) {
                        this.showToast('error', 'File Too Large', 'Maximum file size is 5MB');
                        return;
                    }

                    this.uploading = true;
                    this.progress = 0;

                    const form = new FormData();
                    form.append('file', file);

                    const xhr = new XMLHttpRequest();
                    const encoded = encodeURIComponent(this.selectedFolder);
                    xhr.open('POST', `/legal-documents/${encoded}/upload`);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                    xhr.timeout = 300000;

                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            this.progress = Math.round((e.loaded / e.total) * 100);
                        }
                    });

                    xhr.onload = async () => {
                        this.uploading = false;
                        if (xhr.status === 200 || xhr.status === 201) {
                            this.showToast('success', 'Success!', `${file.name} uploaded`);
                            // Invalidate TOC cache so it refetches
                            delete this.tocFiles[this.selectedFolder];
                            await this.loadFiles(this.selectedFolder);
                        } else {
                            let msg = 'Upload failed';
                            try { msg = JSON.parse(xhr.responseText).message || msg } catch (e) {}
                            this.showToast('error', 'Upload Failed', msg);
                        }
                        setTimeout(() => this.progress = 0, 400);
                    };

                    xhr.onerror = () => {
                        this.uploading = false;
                        this.showToast('error', 'Network Error', 'Failed to connect');
                    };

                    xhr.ontimeout = () => {
                        this.uploading = false;
                        this.showToast('error', 'Timeout', 'Upload took too long');
                    };

                    xhr.send(form);
                },

                async deleteFile(fileName) {
                    if (!this.selectedFolder) return;
                    if (!confirm(`Delete "${fileName}"?`)) return;

                    try {
                        const url = `/legal-documents/${encodeURIComponent(this.selectedFolder)}/delete`;
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ filename: fileName })
                        });

                        if (res.ok) {
                            this.files = this.files.filter(f => f.file_name !== fileName);
                            // Invalidate TOC cache
                            delete this.tocFiles[this.selectedFolder];
                            this.showToast('success', 'Deleted!', `${fileName} has been deleted`);
                        } else {
                            const j = await res.json().catch(() => null);
                            this.showToast('error', 'Delete Failed', (j && j.message) ? j.message : 'Failed to delete');
                        }
                    } catch (err) {
                        console.error('Delete error:', err);
                        this.showToast('error', 'Error', 'An error occurred');
                    }
                },

                async createFolder() {
                    const name = (this.newFolderName || '').trim();
                    if (!name) {
                        this.showToast('error', 'Error', 'Please enter a folder name');
                        return;
                    }

                    try {
                        const res = await fetch('{{ url('legal-documents/create-folder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name })
                        });

                        if (!res.ok) {
                            const j = await res.json().catch(() => null);
                            this.showToast('error', 'Error', j && j.message ? j.message : 'Create folder failed');
                            return;
                        }

                        this.showToast('success', 'Success!', `Folder "${name}" created`);
                        this.showAddModal = false;
                        this.newFolderName = '';
                        setTimeout(() => window.location.reload(), 1000);
                    } catch (err) {
                        console.error(err);
                        this.showToast('error', 'Error', 'Failed to create folder');
                    }
                },

                // Rename Folder Functions
                startRenameFolder(folderName) {
                    this.renamingFolder = folderName;
                    this.newFolderNameRename = folderName;
                    this.showRenameModal = true;
                },

                async renameFolder() {
                    const newName = (this.newFolderNameRename || '').trim();
                    if (!newName) {
                        this.showToast('error', 'Error', 'Please enter a new folder name');
                        return;
                    }

                    if (newName === this.renamingFolder) {
                        this.showRenameModal = false;
                        return;
                    }

                    try {
                        const res = await fetch('{{ url('legal-documents/rename-folder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                old_name: this.renamingFolder,
                                new_name: newName
                            })
                        });

                        const data = await res.json();

                        if (res.ok && data.success) {
                            this.showToast('success', 'Success!', `Folder renamed to "${newName}"`);
                            this.showRenameModal = false;
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            this.showToast('error', 'Error', data.message || 'Rename failed');
                        }
                    } catch (err) {
                        console.error('Rename error:', err);
                        this.showToast('error', 'Error', 'Failed to rename folder');
                    }
                },

                // Delete Folder Functions
                deleteFolderConfirm(folderName) {
                    this.deletingFolder = folderName;
                    this.showDeleteModal = true;
                },

                async deleteFolder() {
                    if (!this.deletingFolder) return;

                    try {
                        const res = await fetch('{{ url('legal-documents/delete-folder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name: this.deletingFolder })
                        });

                        const data = await res.json();

                        if (res.ok && data.success) {
                            this.showToast('success', 'Deleted!', `Folder "${this.deletingFolder}" deleted`);
                            this.showDeleteModal = false;
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            this.showToast('error', 'Error', data.message || 'Delete failed');
                        }
                    } catch (err) {
                        console.error('Delete folder error:', err);
                        this.showToast('error', 'Error', 'Failed to delete folder');
                    }
                }
            }
        }
    </script>
</x-app-layout>
