<x-app-layout>
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark', sidebarCollapsed: false, mobileMenuOpen: false }"
         x-init="$watch('darkMode', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', val);
         });
         document.documentElement.classList.toggle('dark', darkMode);"
         class="min-h-screen flex bg-slate-100 dark:bg-slate-950 transition-colors duration-300">

        <!-- Sidebar -->
        <aside :class="sidebarCollapsed ? 'w-20' : 'w-72'"
               class="hidden lg:flex flex-col bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white border-r border-slate-800 transition-all duration-300 ease-in-out">

            <!-- Logo Section -->
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

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700">
                <p x-show="!sidebarCollapsed" class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Overview</p>

                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 text-white font-medium transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-gauge-high text-white text-sm"></i>
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

                <a href="{{ route('partner-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-purple-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-purple-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-handshake text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Partner Docs</span>
                </a>

                <a href="#" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-amber-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-amber-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-box-archive text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Archive Records</span>
                </a>

                <a href="#" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-indigo-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-indigo-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-graduation-cap text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Training Material</span>
                </a>

                <p x-show="!sidebarCollapsed" class="px-4 py-2 mt-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Management</p>

                <a href="{{ route('inventory.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-teal-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-teal-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-boxes-stacked text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Inventory</span>
                </a>

                <a href="#" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-emerald-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-emerald-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-chart-pie text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Financial Reports</span>
                </a>

                <a href="#" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-rose-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-rose-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-receipt text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Finance & Tax</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-slate-800">
                <div class="bg-slate-800/50 rounded-xl p-4" :class="sidebarCollapsed ? 'p-2' : 'p-4'">
                    <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'space-x-3'">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg">
                                <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-slate-900 rounded-full"></div>
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

                <!-- Collapse Button -->
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
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <i class="fa-solid fa-bars text-slate-600 dark:text-slate-300"></i>
                    </button>

                    <!-- Title & Date -->
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Dashboard Overview</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                            <i class="fa-solid fa-calendar-day"></i>
                            {{ now()->format('l, F j, Y') }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Notifications -->
                        <button class="relative p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                            <i class="fa-solid fa-bell text-slate-600 dark:text-slate-300"></i>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white dark:border-slate-800"></span>
                        </button>

                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode"
                                class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                            <i class="fa-solid text-slate-600 dark:text-yellow-400" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                <!-- Stats Overview -->
                @php
                    try {
                        $totalFolders = \App\Models\LegalDocument::count();
                        $totalDocuments = \App\Models\Document::count();
                        $recentUploads = \App\Models\Document::where('created_at', '>=', now()->subDays(7))->count();

                        // Calculate storage
                        $totalStorageBytes = 0;
                        $documents = \App\Models\Document::all();
                        foreach ($documents as $doc) {
                            $fullPath = storage_path('app/public/' . $doc->file_path);
                            if (file_exists($fullPath)) {
                                $totalStorageBytes += filesize($fullPath);
                            }
                        }
                        $storageUsed = $totalStorageBytes / 1048576; // Convert to MB

                        // Inventory count
                        $inventoryCount = \App\Models\InventoryAsset::where('is_deleted', false)->count();
                    } catch (\Exception $e) {
                        $totalFolders = 0;
                        $totalDocuments = 0;
                        $recentUploads = 0;
                        $storageUsed = 0;
                        $inventoryCount = 0;
                    }
                @endphp

                <!-- Summary Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                    <!-- Total Documents -->
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-500/50 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-lines text-white text-lg"></i>
                                </div>
                                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-full">
                                    <i class="fa-solid fa-arrow-up mr-1"></i>8%
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalDocuments }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Total Documents</div>
                        </div>
                    </div>

                    <!-- Total Folders -->
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-purple-300 dark:hover:border-purple-500/50 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-folder text-white text-lg"></i>
                                </div>
                                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-full">
                                    <i class="fa-solid fa-arrow-up mr-1"></i>12%
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalFolders }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Total Folders</div>
                        </div>
                    </div>

                    <!-- Inventory Items -->
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-teal-300 dark:hover:border-teal-500/50 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-teal-500/30 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-boxes-stacked text-white text-lg"></i>
                                </div>
                                <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-full">
                                    Assets
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ $inventoryCount }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Inventory Items</div>
                        </div>
                    </div>

                    <!-- Storage Used -->
                    <div class="group relative bg-white dark:bg-slate-900 rounded-2xl p-5 lg:p-6 border border-slate-200 dark:border-slate-800 hover:border-orange-300 dark:hover:border-orange-500/50 transition-all hover:shadow-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-amber-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-database text-white text-lg"></i>
                                </div>
                                <span class="text-xs font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 px-2 py-1 rounded-full">
                                    25% Used
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ number_format($storageUsed, 1) }} <span class="text-lg font-normal text-slate-400">MB</span></div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Storage Used</div>
                        </div>
                    </div>
                </div>

                <!-- Modules Grid -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Quick Access</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                        <!-- Legal Documents -->
                        <a href="{{ route('legal-documents.index') }}" class="group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-blue-400 dark:hover:border-blue-500 transition-all hover:shadow-2xl hover:shadow-blue-500/10 overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-xl shadow-blue-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-scale-balanced text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalDocuments }}</span>
                                        <p class="text-xs text-slate-500">files</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Legal Documents</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Contracts, agreements, and legal files</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-folder"></i>
                                        {{ $totalFolders }} folders
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Partner Docs -->
                        <a href="{{ route('partner-documents.index') }}" class="group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-purple-400 dark:hover:border-purple-500 transition-all hover:shadow-2xl hover:shadow-purple-500/10 overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-xl shadow-purple-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-handshake text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">12</span>
                                        <p class="text-xs text-slate-500">partners</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Partner Docs</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Partnership agreements and contracts</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-file"></i>
                                        48 documents
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Archive Records -->
                        <a href="#" class="group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-amber-400 dark:hover:border-amber-500 transition-all hover:shadow-2xl hover:shadow-amber-500/10 overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-orange-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-xl shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-box-archive text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">256</span>
                                        <p class="text-xs text-slate-500">records</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Archive Records</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Historical documents and archives</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        Since 2016
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Training Material -->
                        <a href="#" class="group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-indigo-400 dark:hover:border-indigo-500 transition-all hover:shadow-2xl hover:shadow-indigo-500/10 overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-violet-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shadow-xl shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">45</span>
                                        <p class="text-xs text-slate-500">materials</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Training Material</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Learning resources and guides</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-video"></i>
                                        12 videos
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Inventory -->
                        <a href="{{ route('inventory.index') }}" class="group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-teal-400 dark:hover:border-teal-500 transition-all hover:shadow-2xl hover:shadow-teal-500/10 overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-teal-500/10 to-emerald-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center shadow-xl shadow-teal-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-boxes-stacked text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $inventoryCount }}</span>
                                        <p class="text-xs text-slate-500">items</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">Inventory</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Asset management and tracking</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-chart-line"></i>
                                        Real-time tracking
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Financial Reports -->
                        <a href="#" class="group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-emerald-400 dark:hover:border-emerald-500 transition-all hover:shadow-2xl hover:shadow-emerald-500/10 overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-green-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-xl shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-chart-pie text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">34</span>
                                        <p class="text-xs text-slate-500">reports</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Financial Reports</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Financial statements and analysis</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-calendar"></i>
                                        Q4 2025
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Bottom Row: Finance & Tax + Recent Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Finance & Tax Card -->
                    <a href="#" class="group relative bg-gradient-to-br from-rose-500 via-pink-500 to-rose-600 rounded-2xl p-6 text-white hover:shadow-2xl hover:shadow-rose-500/30 transition-all overflow-hidden">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMtOS45NDEgMC0xOCA4LjA1OS0xOCAxOHM4LjA1OSAxOCAxOCAxOGMxLjI1NCAwIDIuNDgtLjEyOCAzLjY2Mi0uMzcxIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9nPjwvc3ZnPg==')] opacity-30"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-receipt text-2xl"></i>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl font-bold">67</span>
                                    <p class="text-xs text-rose-200">reports</p>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Finance & Tax</h3>
                            <p class="text-sm text-rose-100 mb-4">Tax documents, invoices, and financial records</p>
                            <div class="flex items-center gap-2 text-sm">
                                <span class="px-3 py-1 bg-white/20 rounded-full">2025 Filings</span>
                                <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </a>

                    <!-- Recent Activity -->
                    <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-emerald-500"></i>
                                Recent Activity
                            </h3>
                            <a href="{{ route('legal-documents.index') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline font-medium">View All</a>
                        </div>

                        @php
                            try {
                                $recentDocs = \App\Models\Document::with('folder')->latest()->take(4)->get();
                            } catch (\Exception $e) {
                                $recentDocs = collect();
                            }
                        @endphp

                        <div class="space-y-3">
                            @forelse($recentDocs as $doc)
                            <div class="group flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-500/20 dark:to-cyan-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-file-{{ strtolower($doc->file_type ?? '') == 'pdf' ? 'pdf text-red-500' : 'lines text-blue-500' }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate max-w-[200px]">{{ $doc->file_name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $doc->folder->name ?? 'Unknown' }} • {{ $doc->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-lg uppercase">
                                    {{ strtoupper($doc->file_type ?? 'FILE') }}
                                </span>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-3">
                                    <i class="fa-solid fa-inbox text-2xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">No recent activity</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-12 text-center text-slate-400 dark:text-slate-500 text-sm pb-4">
                    © {{ date('Y') }} <span class="font-medium text-slate-600 dark:text-slate-400">KAP Budiandru & Rekan</span> — Administrator Office
                </footer>
            </div>
        </main>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"></div>

        <!-- Mobile Sidebar -->
        <aside x-show="mobileMenuOpen"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 text-white lg:hidden overflow-y-auto">
            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-cyan-600 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-6 h-6 rounded-lg object-cover">
                    </div>
                    <div>
                        <h2 class="font-bold text-white text-sm">KAP Budiandru</h2>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                </div>
                <button @click="mobileMenuOpen = false" class="p-2 rounded-lg hover:bg-slate-800 transition">
                    <i class="fa-solid fa-xmark text-slate-400"></i>
                </button>
            </div>

            <nav class="px-3 py-6 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500/20 to-cyan-500/20 border border-emerald-500/30 text-white font-medium">
                    <i class="fa-solid fa-gauge-high w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('legal-documents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-scale-balanced w-5"></i>
                    <span>Legal Documents</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-boxes-stacked w-5"></i>
                    <span>Inventory</span>
                </a>
                <a href="{{ route('partner-documents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-handshake w-5"></i>
                    <span>Partner Docs</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-box-archive w-5"></i>
                    <span>Archive Records</span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-3 text-sm bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-xl transition-all font-medium flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</x-app-layout>
