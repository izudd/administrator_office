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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
        .category-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .category-card:hover {
            transform: translateY(-8px) scale(1.02);
        }
    </style>

    <div style="--header-height:72px">
        <div x-data="partnerDocsApp()" x-init="init()"
            class="relative min-h-screen bg-gradient-to-br from-slate-50 via-white to-pink-50 dark:from-[#0a0f1a] dark:via-[#0e1525] dark:to-[#0d1117] transition-colors duration-500">

            <!-- Animated Background -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-pink-400/20 to-rose-400/20 dark:from-pink-500/10 dark:to-rose-500/10 rounded-full blur-3xl animate-blob"></div>
                <div class="absolute top-1/2 -left-40 w-[500px] h-[500px] bg-gradient-to-br from-fuchsia-400/20 to-purple-400/20 dark:from-fuchsia-500/10 dark:to-purple-500/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-40 right-1/3 w-96 h-96 bg-gradient-to-br from-violet-400/20 to-pink-400/20 dark:from-violet-500/10 dark:to-pink-500/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
            </div>

            <!-- Toast -->
            <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] max-w-sm">
                <div class="rounded-2xl shadow-2xl backdrop-blur-xl border overflow-hidden"
                    :class="{
                        'bg-emerald-500/90 border-emerald-400': toast.type === 'success',
                        'bg-red-500/90 border-red-400': toast.type === 'error',
                        'bg-blue-500/90 border-blue-400': toast.type === 'info'
                    }">
                    <div class="p-4 flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="text-white text-xl"
                                :class="{
                                    'fa-solid fa-check': toast.type === 'success',
                                    'fa-solid fa-exclamation': toast.type === 'error',
                                    'fa-solid fa-info': toast.type === 'info'
                                }"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-white" x-text="toast.title"></h4>
                            <p class="text-sm text-white/90" x-text="toast.message"></p>
                        </div>
                        <button @click="toast.show = false" class="text-white/80 hover:text-white">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <header class="relative z-10 p-6 sm:p-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-start gap-5">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl blur-xl opacity-50"></div>
                                <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-500 via-rose-500 to-fuchsia-500 flex items-center justify-center shadow-2xl animate-float">
                                    <i class="fa-solid fa-handshake text-white text-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h1 class="text-3xl sm:text-4xl font-black bg-gradient-to-r from-gray-900 via-gray-700 to-gray-800 dark:from-white dark:via-gray-200 dark:to-gray-300 bg-clip-text text-transparent">
                                        Partner Documents
                                    </h1>
                                    <span class="px-3 py-1 text-[10px] font-black bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-full uppercase tracking-wider shadow-lg">
                                        Partnership
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                    Manage partnership agreements, contracts & documents
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" x-model="globalSearch" placeholder="Search partners..."
                                    class="pl-11 pr-4 py-3 w-64 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all shadow-sm" />
                            </div>
                            <button @click="showAddCategoryModal = true"
                                class="group relative inline-flex items-center gap-2.5 px-6 py-3 rounded-xl bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 hover:from-pink-600 hover:via-rose-600 hover:to-fuchsia-600 text-white font-bold shadow-xl hover:shadow-2xl hover:shadow-pink-500/30 transform hover:scale-105 transition-all duration-300">
                                <i class="fa-solid fa-folder-plus group-hover:rotate-12 transition-transform"></i>
                                <span>New Category</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Tab Navigation -->
            <nav class="relative z-10 px-6 sm:px-8 pb-4">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center gap-1 p-1.5 glass-card rounded-2xl w-fit">
                        <button @click="activeTab = 'documents'"
                            :class="activeTab === 'documents' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800'"
                            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                            <i class="fa-solid fa-file-contract"></i>
                            <span>Documents</span>
                        </button>
                        <button @click="activeTab = 'partners'; loadPartners()"
                            :class="activeTab === 'partners' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800'"
                            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                            <i class="fa-solid fa-building"></i>
                            <span>Partners</span>
                        </button>
                        <button @click="activeTab = 'revenue'; loadRevenues()"
                            :class="activeTab === 'revenue' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800'"
                            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                            <i class="fa-solid fa-money-bill-trend-up"></i>
                            <span>Revenue</span>
                        </button>
                        <button @click="activeTab = 'analytics'; loadAnalytics()"
                            :class="activeTab === 'analytics' ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800'"
                            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie"></i>
                            <span>Analytics</span>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Stats -->
            <section x-show="activeTab === 'documents'" class="relative z-10 px-6 sm:px-8 pb-6"
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500/10 to-pink-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-contract text-pink-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalDocuments }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Total Documents</p>
                        </div>

                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500/10 to-rose-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-building text-rose-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalPartners }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Partners</p>
                        </div>

                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/10 to-emerald-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-check-circle text-emerald-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $activeDocuments }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Active</p>
                        </div>

                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-clock text-amber-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $expiringSoon }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Expiring Soon</p>
                        </div>

                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/10 to-purple-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-hard-drive text-purple-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalStorage }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Storage</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Categories Grid -->
            <main x-show="activeTab === 'documents'" class="relative z-10 px-6 sm:px-8 pb-8" :class="{ 'blur-sm': showPanel }">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full"></div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Categories</h2>
                            <span class="px-2 py-0.5 text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg">{{ count($categories) }} items</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach ($categories as $index => $category)
                            <div style="animation-delay: {{ $index * 60 }}ms"
                                class="category-card group relative glass-card rounded-2xl overflow-hidden p-6 animate-[fadeIn_0.5s_ease-out_forwards] opacity-0">

                                <div class="absolute inset-0 bg-gradient-to-br from-pink-500/0 to-rose-500/0 group-hover:from-pink-500/5 group-hover:to-rose-500/5 transition-all"></div>

                                <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-all z-20">
                                    <button @click.stop="startRenameCategory('{{ addslashes($category->name) }}')"
                                        class="w-8 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <button @click.stop="deleteCategoryConfirm('{{ addslashes($category->name) }}')"
                                        class="w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>

                                <div @click="openCategory({{ $category->id }}, '{{ addslashes($category->name) }}')" class="relative z-10 cursor-pointer">
                                    <div class="relative mb-5">
                                        <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl blur-lg opacity-0 group-hover:opacity-40 transition-opacity"></div>
                                        <div class="relative w-16 h-16 bg-gradient-to-br from-pink-500 via-rose-500 to-fuchsia-500 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-all">
                                            <i class="fa-solid fa-folder-open text-2xl text-white"></i>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors truncate mb-2">
                                        {{ $category->name }}
                                    </h3>

                                    @if($category->description)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">{{ $category->description }}</p>
                                    @endif

                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fa-solid fa-file"></i>
                                            {{ $category->documents_count }} docs
                                        </span>
                                    </div>
                                </div>

                                <div class="relative z-10 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400 uppercase">
                                        Active
                                    </span>
                                    <div class="flex items-center gap-2 text-pink-500 opacity-0 group-hover:opacity-100 transition-all">
                                        <span class="text-xs font-medium">Open</span>
                                        <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (count($categories) === 0)
                        <div class="text-center py-20">
                            <div class="relative inline-block mb-8">
                                <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                                <div class="relative w-32 h-32 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center">
                                    <i class="fa-solid fa-handshake text-5xl text-gray-400"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-black text-gray-800 dark:text-gray-200 mb-3">No categories yet</h3>
                            <p class="text-gray-500 mb-8">Create your first category to organize partner documents</p>
                            <button @click="showAddCategoryModal = true"
                                class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-2xl hover:shadow-pink-500/30 transform hover:scale-105 transition-all">
                                <i class="fa-solid fa-folder-plus text-xl"></i>
                                <span>Create First Category</span>
                            </button>
                        </div>
                    @endif
                </div>
            </main>

            <!-- Slide Panel -->
            <div x-show="showPanel" x-transition:enter="transition ease-out duration-400"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                @keydown.window.escape="closePanel()"
                class="fixed right-0 top-[var(--header-height)] z-50 w-full sm:w-[600px]"
                style="height: calc(100vh - var(--header-height));">

                <div class="h-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-2xl border-l border-gray-200 dark:border-gray-700 shadow-2xl overflow-y-auto">
                    <div class="p-6">
                        <!-- Panel Header -->
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-xl">
                                    <i class="fa-solid fa-folder-open text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100" x-text="selectedCategoryName"></h2>
                                    <p class="text-sm text-gray-500" x-text="documents.length + ' documents'"></p>
                                </div>
                            </div>
                            <button @click="closePanel" class="w-10 h-10 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center justify-center">
                                <i class="fa-solid fa-xmark text-xl text-gray-500"></i>
                            </button>
                        </div>

                        <!-- Upload Button -->
                        <button @click="showUploadModal = true"
                            class="w-full mb-6 py-4 rounded-xl border-2 border-dashed border-pink-300 dark:border-pink-700 bg-pink-50/50 dark:bg-pink-900/10 hover:bg-pink-100/50 dark:hover:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-bold transition-all flex items-center justify-center gap-3">
                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                            <span>Upload New Document</span>
                        </button>

                        <!-- Search -->
                        <div class="relative mb-6">
                            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input x-model="search" type="text" placeholder="Search documents..."
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-pink-500" />
                        </div>

                        <!-- Loading -->
                        <template x-if="loading">
                            <div class="space-y-3">
                                <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                                <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                            </div>
                        </template>

                        <!-- Documents List -->
                        <template x-if="!loading && filteredDocuments().length">
                            <div class="space-y-3">
                                <template x-for="doc in filteredDocuments()" :key="doc.id">
                                    <div class="group p-4 rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 hover:from-pink-50 hover:to-rose-50 dark:hover:from-pink-900/20 dark:hover:to-rose-900/20 border border-gray-200 dark:border-gray-600 transition-all">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-md">
                                                <i class="fa-solid fa-file-pdf text-white text-xl"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2">
                                                    <div>
                                                        <h4 class="font-bold text-gray-800 dark:text-gray-100 truncate" x-text="doc.file_name"></h4>
                                                        <p class="text-sm text-pink-600 dark:text-pink-400 font-medium" x-text="doc.partner_name"></p>
                                                    </div>
                                                    <span class="flex-shrink-0 px-2 py-1 text-[10px] font-bold rounded-full"
                                                        :class="{
                                                            'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400': doc.status === 'active',
                                                            'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400': doc.is_expiring_soon,
                                                            'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': doc.is_expired,
                                                            'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400': doc.status === 'archived'
                                                        }"
                                                        x-text="doc.is_expired ? 'Expired' : (doc.is_expiring_soon ? 'Expiring' : doc.status)">
                                                    </span>
                                                </div>
                                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-500">
                                                    <span class="flex items-center gap-1">
                                                        <i class="fa-solid fa-tag"></i>
                                                        <span x-text="doc.document_type"></span>
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <i class="fa-solid fa-database"></i>
                                                        <span x-text="doc.file_size"></span>
                                                    </span>
                                                    <template x-if="doc.expiry_date">
                                                        <span class="flex items-center gap-1">
                                                            <i class="fa-solid fa-calendar-xmark"></i>
                                                            <span x-text="'Expires: ' + doc.expiry_date"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                                <!-- Actions -->
                                                <div class="flex items-center gap-2 mt-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <a :href="'/partner-documents/preview/' + doc.id" target="_blank"
                                                        class="px-3 py-1.5 rounded-lg bg-pink-600 hover:bg-pink-700 text-white text-xs font-medium flex items-center gap-1.5">
                                                        <i class="fa-solid fa-eye"></i> Preview
                                                    </a>
                                                    <a :href="'/partner-documents/download/' + doc.id"
                                                        class="px-3 py-1.5 rounded-lg bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium flex items-center gap-1.5">
                                                        <i class="fa-solid fa-download"></i> Download
                                                    </a>
                                                    <button @click="deleteDocument(doc.id, doc.file_name)"
                                                        class="px-3 py-1.5 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-medium flex items-center gap-1.5">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Empty -->
                        <template x-if="!loading && !filteredDocuments().length">
                            <div class="text-center py-16 text-gray-500">
                                <i class="fa-solid fa-folder-open text-5xl mb-4"></i>
                                <p class="font-medium">No documents in this category</p>
                                <p class="text-sm">Upload your first document</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Add Category Modal -->
            <div x-show="showAddCategoryModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showAddCategoryModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-folder-plus text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">New Category</h3>
                            <p class="text-sm text-gray-500">Create a new document category</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                            <input type="text" x-model="newCategoryName" placeholder="e.g., PT ABC Corporation"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description (Optional)</label>
                            <textarea x-model="newCategoryDesc" rows="2" placeholder="Brief description..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button @click="showAddCategoryModal = false" class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">Cancel</button>
                        <button @click="createCategory()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">Create</button>
                    </div>
                </div>
            </div>

            <!-- Upload Modal -->
            <div x-show="showUploadModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showUploadModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-cloud-arrow-up text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Upload Document</h3>
                            <p class="text-sm text-gray-500">Add new partner document</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner Name *</label>
                            <input type="text" x-model="uploadForm.partner_name" placeholder="Company/Partner name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Document Type *</label>
                            <select x-model="uploadForm.document_type"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500">
                                <option value="">Select type...</option>
                                <option value="Agreement">Partnership Agreement</option>
                                <option value="Contract">Contract</option>
                                <option value="NDA">NDA</option>
                                <option value="MOU">MOU</option>
                                <option value="Invoice">Invoice</option>
                                <option value="Proposal">Proposal</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Document Date</label>
                                <input type="date" x-model="uploadForm.document_date"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiry Date</label>
                                <input type="date" x-model="uploadForm.expiry_date"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                            <textarea x-model="uploadForm.notes" rows="2" placeholder="Additional notes..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">File *</label>
                            <input type="file" x-ref="uploadFile" @change="uploadForm.file = $event.target.files[0]"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-500 file:text-white file:font-medium" />
                        </div>

                        <template x-if="uploading">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-pink-500 to-rose-500 transition-all" :style="`width: ${uploadProgress}%`"></div>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button @click="showUploadModal = false" class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">Cancel</button>
                        <button @click="uploadDocument()" :disabled="uploading" class="px-6 py-3 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all disabled:opacity-50">
                            <span x-show="!uploading">Upload</span>
                            <span x-show="uploading">Uploading...</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Rename Modal -->
            <div x-show="showRenameModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showRenameModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-pen text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Rename Category</h3>
                            <p class="text-sm text-gray-500">Enter new name for "<span x-text="renamingCategory"></span>"</p>
                        </div>
                    </div>

                    <input type="text" x-model="newCategoryNameRename" @keydown.enter="renameCategory()"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 mb-6" />

                    <div class="flex justify-end gap-3">
                        <button @click="showRenameModal = false" class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">Cancel</button>
                        <button @click="renameCategory()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg">Rename</button>
                    </div>
                </div>
            </div>

            <!-- Delete Confirm Modal -->
            <div x-show="showDeleteModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showDeleteModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-trash text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Delete Category</h3>
                            <p class="text-sm text-gray-500">This cannot be undone</p>
                        </div>
                    </div>

                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                        <p class="text-sm text-red-700 dark:text-red-300">
                            Delete "<span class="font-bold" x-text="deletingCategory"></span>" and all its documents?
                        </p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button @click="showDeleteModal = false" class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">Cancel</button>
                        <button @click="deleteCategory()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold shadow-lg">Delete</button>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- PARTNERS TAB -->
            <!-- ========================================== -->
            <section x-show="activeTab === 'partners'" class="relative z-10 px-6 sm:px-8 pb-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Partner Stats -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500/10 to-pink-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-building text-pink-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalPartnersManaged }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Total Partners</p>
                        </div>
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/10 to-emerald-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-check-circle text-emerald-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $activePartnersCount }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Active</p>
                        </div>
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-hourglass-half text-amber-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $pendingPartnersCount }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Pending</p>
                        </div>
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500/10 to-red-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-calendar-xmark text-red-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-gray-900 dark:text-white">{{ $expiredContracts }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Expired Contracts</p>
                        </div>
                    </div>

                    <!-- Partner Actions Bar -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full"></div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Partner Management</h2>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" x-model="partnerSearch" @input.debounce.300ms="loadPartners()" placeholder="Search partners..."
                                    class="pl-10 pr-4 py-2.5 w-56 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent" />
                            </div>
                            <select x-model="partnerStatusFilter" @change="loadPartners()"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-pink-500">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                                <option value="terminated">Terminated</option>
                            </select>
                            <button @click="showAddPartnerModal = true"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all text-sm">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Partner</span>
                            </button>
                        </div>
                    </div>

                    <!-- Partners List -->
                    <div class="space-y-3">
                        <template x-if="partnersLoading">
                            <div class="space-y-3">
                                <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                                <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                                <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                            </div>
                        </template>

                        <template x-if="!partnersLoading && partnersList.length">
                            <div class="space-y-3">
                                <template x-for="p in partnersList" :key="p.id">
                                    <div class="group glass-card rounded-2xl p-5 hover:shadow-lg transition-all">
                                        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                                            <!-- Partner Info -->
                                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-lg">
                                                    <i class="fa-solid fa-building text-white text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <h3 class="font-bold text-gray-800 dark:text-white truncate" x-text="p.company_name"></h3>
                                                        <span class="flex-shrink-0 px-2 py-0.5 text-[10px] font-bold rounded-full"
                                                            :class="{
                                                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400': p.status === 'active',
                                                                'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400': p.status === 'pending',
                                                                'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400': p.status === 'inactive',
                                                                'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': p.status === 'suspended' || p.status === 'terminated'
                                                            }" x-text="p.status"></span>
                                                        <template x-if="p.is_contract_expired">
                                                            <span class="flex-shrink-0 px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Contract Expired</span>
                                                        </template>
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                                        <span class="flex items-center gap-1"><i class="fa-solid fa-envelope"></i> <span x-text="p.email"></span></span>
                                                        <template x-if="p.city"><span class="flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> <span x-text="p.city"></span></span></template>
                                                        <span class="px-2 py-0.5 rounded-md bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 font-medium" x-text="p.partnership_model.replace('_', ' ')"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Partner Stats -->
                                            <div class="flex items-center gap-6 text-sm">
                                                <div class="text-center">
                                                    <p class="font-bold text-gray-800 dark:text-white" x-text="p.documents_count"></p>
                                                    <p class="text-[10px] text-gray-500 uppercase">Docs</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="font-bold text-gray-800 dark:text-white" x-text="p.revenue_transactions_count"></p>
                                                    <p class="text-[10px] text-gray-500 uppercase">Transactions</p>
                                                </div>
                                                <template x-if="p.contract_end_date">
                                                    <div class="text-center">
                                                        <p class="font-bold text-gray-800 dark:text-white text-xs" x-text="p.contract_end_date"></p>
                                                        <p class="text-[10px] text-gray-500 uppercase">Contract End</p>
                                                    </div>
                                                </template>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center gap-2">
                                                <button @click="viewPartner(p.id)" class="px-3 py-2 rounded-lg bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 hover:bg-pink-200 dark:hover:bg-pink-900/50 text-xs font-medium transition-colors">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button @click="editPartner(p)" class="px-3 py-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-xs font-medium transition-colors">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <template x-if="p.status !== 'active'">
                                                    <button @click="activatePartner(p.id)" class="px-3 py-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200 text-xs font-medium transition-colors">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </template>
                                                <template x-if="p.status === 'active'">
                                                    <button @click="suspendPartner(p.id)" class="px-3 py-2 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 text-xs font-medium transition-colors">
                                                        <i class="fa-solid fa-pause"></i>
                                                    </button>
                                                </template>
                                                <button @click="confirmDeletePartner(p.id, p.company_name)" class="px-3 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 text-xs font-medium transition-colors">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="!partnersLoading && !partnersList.length">
                            <div class="text-center py-16">
                                <div class="relative inline-block mb-6">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center">
                                        <i class="fa-solid fa-building text-4xl text-gray-400"></i>
                                    </div>
                                </div>
                                <h3 class="text-2xl font-black text-gray-800 dark:text-gray-200 mb-2">No partners found</h3>
                                <p class="text-gray-500 mb-6">Add your first partner to get started</p>
                                <button @click="showAddPartnerModal = true"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                                    <i class="fa-solid fa-plus"></i> Add Partner
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- REVENUE TAB -->
            <!-- ========================================== -->
            <section x-show="activeTab === 'revenue'" class="relative z-10 px-6 sm:px-8 pb-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Revenue Stats -->
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/10 to-emerald-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-money-bill-wave text-emerald-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Total Revenue</p>
                        </div>
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/10 to-amber-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-clock text-amber-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Pending</p>
                        </div>
                        <div class="glass-card rounded-2xl p-5 hover:shadow-lg transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/10 to-blue-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-calendar-check text-blue-500 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">This Month</p>
                        </div>
                    </div>

                    <!-- Revenue Actions -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full"></div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Revenue Transactions</h2>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <select x-model="revenueStatusFilter" @change="loadRevenues()"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-pink-500">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                            <button @click="showAddRevenueModal = true"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all text-sm">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Transaction</span>
                            </button>
                        </div>
                    </div>

                    <!-- Revenue List -->
                    <div class="space-y-3">
                        <template x-if="revenueLoading">
                            <div class="space-y-3">
                                <div class="h-20 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                                <div class="h-20 bg-gray-200 dark:bg-gray-700 rounded-xl animate-pulse"></div>
                            </div>
                        </template>

                        <template x-if="!revenueLoading && revenueList.length">
                            <div class="space-y-3">
                                <template x-for="rev in revenueList" :key="rev.id">
                                    <div class="group glass-card rounded-2xl p-5 hover:shadow-lg transition-all">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center shadow-md"
                                                    :class="{
                                                        'bg-gradient-to-br from-emerald-500 to-green-500': rev.type === 'one_time_payment' || rev.type === 'subscription_fee',
                                                        'bg-gradient-to-br from-blue-500 to-indigo-500': rev.type === 'revenue_share',
                                                        'bg-gradient-to-br from-red-500 to-rose-500': rev.type === 'refund' || rev.type === 'credit',
                                                        'bg-gradient-to-br from-amber-500 to-orange-500': rev.type === 'adjustment'
                                                    }">
                                                    <i class="text-white text-lg"
                                                        :class="{
                                                            'fa-solid fa-money-bill': rev.type === 'one_time_payment',
                                                            'fa-solid fa-repeat': rev.type === 'subscription_fee',
                                                            'fa-solid fa-handshake': rev.type === 'revenue_share',
                                                            'fa-solid fa-rotate-left': rev.type === 'refund' || rev.type === 'credit',
                                                            'fa-solid fa-sliders': rev.type === 'adjustment'
                                                        }"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <h4 class="font-bold text-gray-800 dark:text-white" x-text="rev.partner_name"></h4>
                                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full"
                                                            :class="{
                                                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400': rev.payment_status === 'paid',
                                                                'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400': rev.payment_status === 'pending',
                                                                'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': rev.payment_status === 'failed' || rev.payment_status === 'cancelled',
                                                                'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400': rev.payment_status === 'refunded'
                                                            }" x-text="rev.payment_status"></span>
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                                        <span class="px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 font-medium" x-text="rev.type.replace(/_/g, ' ')"></span>
                                                        <template x-if="rev.invoice_number"><span class="flex items-center gap-1"><i class="fa-solid fa-receipt"></i> <span x-text="rev.invoice_number"></span></span></template>
                                                        <template x-if="rev.payment_date"><span class="flex items-center gap-1"><i class="fa-solid fa-calendar"></i> <span x-text="rev.payment_date"></span></span></template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-black" :class="rev.net_amount < 0 ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400'" x-text="rev.formatted_amount"></p>
                                                <template x-if="rev.tax_amount > 0">
                                                    <p class="text-[10px] text-gray-500">Tax: Rp <span x-text="Number(rev.tax_amount).toLocaleString('id-ID')"></span></p>
                                                </template>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <template x-if="rev.payment_status === 'pending'">
                                                    <button @click="markRevenuePaid(rev.id)" class="px-3 py-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200 text-xs font-medium transition-colors" title="Mark as Paid">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </template>
                                                <button @click="confirmDeleteRevenue(rev.id)" class="px-3 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 text-xs font-medium transition-colors">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="!revenueLoading && !revenueList.length">
                            <div class="text-center py-16">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center mx-auto mb-6">
                                    <i class="fa-solid fa-money-bill-trend-up text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-2xl font-black text-gray-800 dark:text-gray-200 mb-2">No transactions yet</h3>
                                <p class="text-gray-500 mb-6">Record your first revenue transaction</p>
                                <button @click="showAddRevenueModal = true"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-lg">
                                    <i class="fa-solid fa-plus"></i> Add Transaction
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- ANALYTICS TAB -->
            <!-- ========================================== -->
            <section x-show="activeTab === 'analytics'" class="relative z-10 px-6 sm:px-8 pb-6">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Analytics Overview</h2>
                    </div>

                    <template x-if="analyticsLoading">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="h-72 bg-gray-200 dark:bg-gray-700 rounded-2xl animate-pulse"></div>
                            <div class="h-72 bg-gray-200 dark:bg-gray-700 rounded-2xl animate-pulse"></div>
                        </div>
                    </template>

                    <template x-if="!analyticsLoading">
                        <div class="space-y-6">
                            <!-- Top Row: Revenue Chart + Partnership Distribution -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Revenue Trend -->
                                <div class="glass-card rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-chart-line text-pink-500"></i> Revenue Trend (6 Months)
                                    </h3>
                                    <div class="space-y-3">
                                        <template x-for="item in analyticsData.revenue_by_month" :key="item.month + '-' + item.year">
                                            <div>
                                                <div class="flex items-center justify-between text-sm mb-1">
                                                    <span class="text-gray-600 dark:text-gray-400 font-medium" x-text="getMonthName(item.month) + ' ' + item.year"></span>
                                                    <span class="font-bold text-gray-800 dark:text-white" x-text="'Rp ' + Number(item.total).toLocaleString('id-ID')"></span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-700 h-3 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-pink-500 to-rose-500 rounded-full transition-all duration-500"
                                                        :style="'width: ' + getRevenueBarWidth(item.total) + '%'"></div>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="!analyticsData.revenue_by_month || !analyticsData.revenue_by_month.length">
                                            <p class="text-center text-gray-400 py-8">No revenue data yet</p>
                                        </template>
                                    </div>
                                </div>

                                <!-- Partnership Distribution -->
                                <div class="glass-card rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-chart-pie text-pink-500"></i> Partnership Models
                                    </h3>
                                    <div class="space-y-4">
                                        <template x-for="(count, model) in analyticsData.partnership_distribution" :key="model">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                                    :class="{
                                                        'bg-blue-100 dark:bg-blue-900/30': model === 'equity',
                                                        'bg-emerald-100 dark:bg-emerald-900/30': model === 'revenue_share',
                                                        'bg-purple-100 dark:bg-purple-900/30': model === 'subscription',
                                                        'bg-amber-100 dark:bg-amber-900/30': model === 'project_based'
                                                    }">
                                                    <i class="text-sm"
                                                        :class="{
                                                            'fa-solid fa-chart-pie text-blue-500': model === 'equity',
                                                            'fa-solid fa-handshake text-emerald-500': model === 'revenue_share',
                                                            'fa-solid fa-repeat text-purple-500': model === 'subscription',
                                                            'fa-solid fa-briefcase text-amber-500': model === 'project_based'
                                                        }"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize" x-text="model.replace('_', ' ')"></span>
                                                        <span class="text-sm font-bold text-gray-800 dark:text-white" x-text="count + ' partners'"></span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                                        <div class="h-full rounded-full transition-all duration-500"
                                                            :class="{
                                                                'bg-blue-500': model === 'equity',
                                                                'bg-emerald-500': model === 'revenue_share',
                                                                'bg-purple-500': model === 'subscription',
                                                                'bg-amber-500': model === 'project_based'
                                                            }"
                                                            :style="'width: ' + getDistributionWidth(count) + '%'"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="!analyticsData.partnership_distribution || !Object.keys(analyticsData.partnership_distribution).length">
                                            <p class="text-center text-gray-400 py-8">No partnership data yet</p>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Row: Status + Top Partners -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Status Distribution -->
                                <div class="glass-card rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-signal text-pink-500"></i> Partner Status
                                    </h3>
                                    <div class="grid grid-cols-2 gap-3">
                                        <template x-for="(count, status) in analyticsData.status_distribution" :key="status">
                                            <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 text-center">
                                                <p class="text-2xl font-black text-gray-800 dark:text-white" x-text="count"></p>
                                                <p class="text-xs font-medium uppercase tracking-wider capitalize"
                                                    :class="{
                                                        'text-emerald-500': status === 'active',
                                                        'text-amber-500': status === 'pending',
                                                        'text-gray-500': status === 'inactive',
                                                        'text-red-500': status === 'suspended' || status === 'terminated'
                                                    }" x-text="status"></p>
                                            </div>
                                        </template>
                                    </div>
                                    <template x-if="!analyticsData.status_distribution || !Object.keys(analyticsData.status_distribution).length">
                                        <p class="text-center text-gray-400 py-8">No data yet</p>
                                    </template>
                                </div>

                                <!-- Top Partners -->
                                <div class="glass-card rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-trophy text-pink-500"></i> Top Partners by Revenue
                                    </h3>
                                    <div class="space-y-3">
                                        <template x-for="(tp, idx) in analyticsData.top_partners" :key="idx">
                                            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                                                <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center font-black text-sm"
                                                    :class="{
                                                        'bg-yellow-100 text-yellow-700': idx === 0,
                                                        'bg-gray-200 text-gray-600': idx === 1,
                                                        'bg-orange-100 text-orange-700': idx === 2,
                                                        'bg-gray-100 text-gray-500': idx > 2
                                                    }" x-text="'#' + (idx + 1)"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-bold text-sm text-gray-800 dark:text-white truncate" x-text="tp.company_name"></p>
                                                </div>
                                                <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400" x-text="'Rp ' + Number(tp.total_revenue || 0).toLocaleString('id-ID')"></p>
                                            </div>
                                        </template>
                                        <template x-if="!analyticsData.top_partners || !analyticsData.top_partners.length">
                                            <p class="text-center text-gray-400 py-8">No revenue data yet</p>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- ADD PARTNER MODAL -->
            <!-- ========================================== -->
            <div x-show="showAddPartnerModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showAddPartnerModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-building text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100" x-text="editingPartnerId ? 'Edit Partner' : 'Add New Partner'"></h3>
                            <p class="text-sm text-gray-500">Fill in the partner details</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <!-- Company Info -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Name *</label>
                                <input type="text" x-model="partnerForm.company_name" placeholder="PT Example Corp"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Type *</label>
                                <select x-model="partnerForm.company_type"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm">
                                    <option value="PT">PT</option>
                                    <option value="CV">CV</option>
                                    <option value="Perorangan">Perorangan</option>
                                    <option value="Yayasan">Yayasan</option>
                                    <option value="Koperasi">Koperasi</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                                <input type="email" x-model="partnerForm.email" placeholder="contact@example.com"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                                <input type="text" x-model="partnerForm.phone" placeholder="+62 812 xxxx xxxx"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                            <textarea x-model="partnerForm.address" rows="2" placeholder="Full address..."
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                                <input type="text" x-model="partnerForm.city" placeholder="Jakarta"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NPWP</label>
                                <input type="text" x-model="partnerForm.npwp" placeholder="XX.XXX.XXX.X-XXX.XXX"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Partnership Model *</label>
                                <select x-model="partnerForm.partnership_model"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm">
                                    <option value="project_based">Project Based</option>
                                    <option value="equity">Equity</option>
                                    <option value="revenue_share">Revenue Share</option>
                                    <option value="subscription">Subscription</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract Start</label>
                                <input type="date" x-model="partnerForm.contract_start_date"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract End</label>
                                <input type="date" x-model="partnerForm.contract_end_date"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                        </div>
                        <!-- Contact Person -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Contact Person</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                                    <input type="text" x-model="partnerForm.contact_person_name" placeholder="John Doe"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position</label>
                                    <input type="text" x-model="partnerForm.contact_person_position" placeholder="Director"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                            <textarea x-model="partnerForm.notes" rows="2" placeholder="Additional notes..."
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button @click="showAddPartnerModal = false; resetPartnerForm()" class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">Cancel</button>
                        <button @click="savePartner()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            <span x-text="editingPartnerId ? 'Update' : 'Create'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- ADD REVENUE MODAL -->
            <!-- ========================================== -->
            <div x-show="showAddRevenueModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showAddRevenueModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-money-bill-trend-up text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Add Revenue Transaction</h3>
                            <p class="text-sm text-gray-500">Record a new transaction</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Partner *</label>
                            <select x-model="revenueForm.partner_id"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm">
                                <option value="">Select partner...</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type *</label>
                                <select x-model="revenueForm.type"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm">
                                    <option value="one_time_payment">One Time Payment</option>
                                    <option value="subscription_fee">Subscription Fee</option>
                                    <option value="revenue_share">Revenue Share</option>
                                    <option value="refund">Refund</option>
                                    <option value="credit">Credit</option>
                                    <option value="adjustment">Adjustment</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (Rp) *</label>
                                <input type="number" x-model="revenueForm.amount" placeholder="0"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Status</label>
                                <select x-model="revenueForm.payment_status"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Date</label>
                                <input type="date" x-model="revenueForm.payment_date"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                            <input type="text" x-model="revenueForm.payment_method" placeholder="Bank Transfer / Cash / etc."
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea x-model="revenueForm.description" rows="2" placeholder="Transaction description..."
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 text-sm"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button @click="showAddRevenueModal = false" class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium">Cancel</button>
                        <button @click="saveRevenue()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">Create</button>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- VIEW PARTNER DETAIL MODAL -->
            <!-- ========================================== -->
            <div x-show="showPartnerDetailModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                <div @click.away="showPartnerDetailModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-xl">
                                <i class="fa-solid fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100" x-text="partnerDetail?.partner?.company_name"></h3>
                                <p class="text-sm text-gray-500" x-text="partnerDetail?.partner?.email"></p>
                            </div>
                        </div>
                        <button @click="showPartnerDetailModal = false" class="w-10 h-10 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center justify-center">
                            <i class="fa-solid fa-xmark text-xl text-gray-500"></i>
                        </button>
                    </div>

                    <template x-if="partnerDetail && partnerDetail.partner">
                        <div class="space-y-6">
                            <!-- Quick Stats -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="text-center p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
                                    <p class="text-xl font-black text-emerald-600 dark:text-emerald-400" x-text="'Rp ' + Number(partnerDetail.total_revenue || 0).toLocaleString('id-ID')"></p>
                                    <p class="text-xs text-gray-500 uppercase">Total Revenue</p>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20">
                                    <p class="text-xl font-black text-amber-600 dark:text-amber-400" x-text="'Rp ' + Number(partnerDetail.pending_revenue || 0).toLocaleString('id-ID')"></p>
                                    <p class="text-xs text-gray-500 uppercase">Pending</p>
                                </div>
                                <div class="text-center p-4 rounded-xl bg-pink-50 dark:bg-pink-900/20">
                                    <p class="text-xl font-black text-pink-600 dark:text-pink-400" x-text="partnerDetail.partner.documents_count"></p>
                                    <p class="text-xs text-gray-500 uppercase">Documents</p>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><span class="text-gray-500">Type:</span> <span class="font-medium text-gray-800 dark:text-white" x-text="partnerDetail.partner.company_type"></span></div>
                                <div><span class="text-gray-500">Status:</span> <span class="font-medium capitalize text-gray-800 dark:text-white" x-text="partnerDetail.partner.status"></span></div>
                                <div><span class="text-gray-500">Model:</span> <span class="font-medium capitalize text-gray-800 dark:text-white" x-text="(partnerDetail.partner.partnership_model || '').replace('_', ' ')"></span></div>
                                <div><span class="text-gray-500">Phone:</span> <span class="font-medium text-gray-800 dark:text-white" x-text="partnerDetail.partner.phone || '-'"></span></div>
                                <div><span class="text-gray-500">City:</span> <span class="font-medium text-gray-800 dark:text-white" x-text="partnerDetail.partner.city || '-'"></span></div>
                                <div><span class="text-gray-500">NPWP:</span> <span class="font-medium text-gray-800 dark:text-white" x-text="partnerDetail.partner.npwp || '-'"></span></div>
                                <div><span class="text-gray-500">Contact:</span> <span class="font-medium text-gray-800 dark:text-white" x-text="partnerDetail.partner.contact_person_name || '-'"></span></div>
                                <div><span class="text-gray-500">Position:</span> <span class="font-medium text-gray-800 dark:text-white" x-text="partnerDetail.partner.contact_person_position || '-'"></span></div>
                            </div>

                            <!-- Recent Transactions -->
                            <template x-if="partnerDetail.partner.revenue_transactions && partnerDetail.partner.revenue_transactions.length">
                                <div>
                                    <h4 class="font-bold text-gray-800 dark:text-white mb-3">Recent Transactions</h4>
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
                                        <template x-for="tx in partnerDetail.partner.revenue_transactions.slice(0, 5)" :key="tx.id">
                                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 text-sm">
                                                <div>
                                                    <span class="font-medium text-gray-800 dark:text-white capitalize" x-text="tx.type.replace(/_/g, ' ')"></span>
                                                    <span class="ml-2 px-2 py-0.5 text-[10px] font-bold rounded-full"
                                                        :class="tx.payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'"
                                                        x-text="tx.payment_status"></span>
                                                </div>
                                                <span class="font-bold" :class="tx.net_amount < 0 ? 'text-red-500' : 'text-emerald-600'" x-text="'Rp ' + Number(tx.net_amount).toLocaleString('id-ID')"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Footer -->
            <footer class="relative z-10 py-8 border-t border-gray-200/50 dark:border-gray-700/50 mt-12 bg-white/30 dark:bg-gray-900/30 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 p-[2px] shadow-lg">
                                <div class="w-full h-full rounded-[10px] bg-white dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/logo.PNG') }}" alt="KAP Logo" class="w-7 h-7 object-contain">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-sm bg-gradient-to-r from-pink-600 to-rose-500 bg-clip-text text-transparent">KAP Budiandru & Rekan</span>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider">Public Accountant Firm</span>
                            </div>
                        </div>
                        <span class="text-gray-300 dark:text-gray-600 hidden sm:inline">|</span>
                        <span class="text-xs text-gray-400">© {{ date('Y') }} All rights reserved</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        function partnerDocsApp() {
            return {
                activeTab: 'documents',
                documents: [],
                loading: false,
                showPanel: false,
                selectedCategoryId: null,
                selectedCategoryName: '',
                search: '',
                globalSearch: '',
                toast: { show: false, type: 'success', title: '', message: '' },

                // Modals
                showAddCategoryModal: false,
                showUploadModal: false,
                showRenameModal: false,
                showDeleteModal: false,

                // Form data
                newCategoryName: '',
                newCategoryDesc: '',
                newCategoryNameRename: '',
                renamingCategory: '',
                deletingCategory: '',

                // Upload
                uploading: false,
                uploadProgress: 0,
                uploadForm: {
                    partner_name: '',
                    document_type: '',
                    document_date: '',
                    expiry_date: '',
                    notes: '',
                    file: null
                },

                // === Partner Management ===
                partnersList: [],
                partnersLoading: false,
                partnerSearch: '',
                partnerStatusFilter: '',
                showAddPartnerModal: false,
                showPartnerDetailModal: false,
                editingPartnerId: null,
                partnerDetail: null,
                partnerForm: {
                    company_name: '', company_type: 'PT', email: '', phone: '', address: '', city: '',
                    postal_code: '', npwp: '', partnership_model: 'project_based', status: 'pending',
                    contract_start_date: '', contract_end_date: '',
                    contact_person_name: '', contact_person_position: '', notes: ''
                },

                // === Revenue ===
                revenueList: [],
                revenueLoading: false,
                revenueStatusFilter: '',
                showAddRevenueModal: false,
                revenueForm: {
                    partner_id: '', type: 'one_time_payment', amount: '', payment_status: 'pending',
                    payment_date: '', payment_method: '', description: ''
                },

                // === Analytics ===
                analyticsData: { revenue_by_month: [], partnership_distribution: {}, status_distribution: {}, revenue_by_type: {}, top_partners: [] },
                analyticsLoading: false,

                init() {
                    console.log('Partner Documents initialized');
                },

                showToast(type, title, message) {
                    this.toast = { show: true, type, title, message };
                    setTimeout(() => this.toast.show = false, 3000);
                },

                async openCategory(id, name) {
                    this.selectedCategoryId = id;
                    this.selectedCategoryName = name;
                    this.showPanel = true;
                    await this.loadDocuments();
                },

                closePanel() {
                    this.showPanel = false;
                    this.selectedCategoryId = null;
                    this.documents = [];
                    this.search = '';
                },

                async loadDocuments() {
                    if (!this.selectedCategoryId) return;
                    this.loading = true;
                    try {
                        const res = await fetch(`/partner-documents/${this.selectedCategoryId}/documents`);
                        this.documents = await res.json();
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to load documents');
                    } finally {
                        this.loading = false;
                    }
                },

                filteredDocuments() {
                    if (!this.search) return this.documents;
                    const s = this.search.toLowerCase();
                    return this.documents.filter(d =>
                        d.file_name.toLowerCase().includes(s) ||
                        d.partner_name.toLowerCase().includes(s) ||
                        d.document_type.toLowerCase().includes(s)
                    );
                },

                async createCategory() {
                    if (!this.newCategoryName.trim()) {
                        this.showToast('error', 'Error', 'Please enter category name');
                        return;
                    }
                    try {
                        const res = await fetch('/partner-documents/category/create', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name: this.newCategoryName, description: this.newCategoryDesc })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.showToast('success', 'Success', 'Category created');
                            this.showAddCategoryModal = false;
                            this.newCategoryName = '';
                            this.newCategoryDesc = '';
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            this.showToast('error', 'Error', data.message);
                        }
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to create category');
                    }
                },

                startRenameCategory(name) {
                    this.renamingCategory = name;
                    this.newCategoryNameRename = name;
                    this.showRenameModal = true;
                },

                async renameCategory() {
                    if (!this.newCategoryNameRename.trim()) return;
                    try {
                        const res = await fetch('/partner-documents/category/rename', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ old_name: this.renamingCategory, new_name: this.newCategoryNameRename })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.showToast('success', 'Success', 'Category renamed');
                            this.showRenameModal = false;
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            this.showToast('error', 'Error', data.message);
                        }
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to rename');
                    }
                },

                deleteCategoryConfirm(name) {
                    this.deletingCategory = name;
                    this.showDeleteModal = true;
                },

                async deleteCategory() {
                    try {
                        const res = await fetch('/partner-documents/category/delete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name: this.deletingCategory })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.showToast('success', 'Deleted', 'Category deleted');
                            this.showDeleteModal = false;
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            this.showToast('error', 'Error', data.message);
                        }
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to delete');
                    }
                },

                async uploadDocument() {
                    if (!this.uploadForm.partner_name || !this.uploadForm.document_type || !this.uploadForm.file) {
                        this.showToast('error', 'Error', 'Please fill required fields');
                        return;
                    }

                    this.uploading = true;
                    this.uploadProgress = 0;

                    const formData = new FormData();
                    formData.append('file', this.uploadForm.file);
                    formData.append('partner_name', this.uploadForm.partner_name);
                    formData.append('document_type', this.uploadForm.document_type);
                    if (this.uploadForm.document_date) formData.append('document_date', this.uploadForm.document_date);
                    if (this.uploadForm.expiry_date) formData.append('expiry_date', this.uploadForm.expiry_date);
                    if (this.uploadForm.notes) formData.append('notes', this.uploadForm.notes);

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', `/partner-documents/${this.selectedCategoryId}/upload`);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

                    xhr.upload.onprogress = (e) => {
                        if (e.lengthComputable) {
                            this.uploadProgress = Math.round((e.loaded / e.total) * 100);
                        }
                    };

                    xhr.onload = async () => {
                        this.uploading = false;
                        if (xhr.status === 200) {
                            this.showToast('success', 'Success', 'Document uploaded');
                            this.showUploadModal = false;
                            this.resetUploadForm();
                            await this.loadDocuments();
                        } else {
                            this.showToast('error', 'Error', 'Upload failed');
                        }
                    };

                    xhr.onerror = () => {
                        this.uploading = false;
                        this.showToast('error', 'Error', 'Upload failed');
                    };

                    xhr.send(formData);
                },

                resetUploadForm() {
                    this.uploadForm = { partner_name: '', document_type: '', document_date: '', expiry_date: '', notes: '', file: null };
                    if (this.$refs.uploadFile) this.$refs.uploadFile.value = '';
                },

                async deleteDocument(id, name) {
                    if (!confirm(`Delete "${name}"?`)) return;
                    try {
                        const res = await fetch(`/partner-documents/document/${id}/delete`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.documents = this.documents.filter(d => d.id !== id);
                            this.showToast('success', 'Deleted', 'Document deleted');
                        } else {
                            this.showToast('error', 'Error', data.message);
                        }
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to delete');
                    }
                },

                // ==========================================
                // PARTNER MANAGEMENT METHODS
                // ==========================================
                async loadPartners() {
                    this.partnersLoading = true;
                    try {
                        const params = new URLSearchParams();
                        if (this.partnerSearch) params.append('search', this.partnerSearch);
                        if (this.partnerStatusFilter) params.append('status', this.partnerStatusFilter);
                        const res = await fetch(`/partner-documents/partners?${params}`);
                        this.partnersList = await res.json();
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to load partners');
                    } finally {
                        this.partnersLoading = false;
                    }
                },

                resetPartnerForm() {
                    this.editingPartnerId = null;
                    this.partnerForm = {
                        company_name: '', company_type: 'PT', email: '', phone: '', address: '', city: '',
                        postal_code: '', npwp: '', partnership_model: 'project_based', status: 'pending',
                        contract_start_date: '', contract_end_date: '',
                        contact_person_name: '', contact_person_position: '', notes: ''
                    };
                },

                editPartner(p) {
                    this.editingPartnerId = p.id;
                    this.partnerForm = {
                        company_name: p.company_name || '', company_type: p.company_type || 'PT',
                        email: p.email || '', phone: p.phone || '', address: '', city: p.city || '',
                        postal_code: '', npwp: '', partnership_model: p.partnership_model || 'project_based',
                        status: p.status || 'pending', contract_start_date: '', contract_end_date: '',
                        contact_person_name: p.contact_person_name || '',
                        contact_person_position: p.contact_person_position || '', notes: ''
                    };
                    this.showAddPartnerModal = true;
                },

                async savePartner() {
                    if (!this.partnerForm.company_name || !this.partnerForm.email) {
                        this.showToast('error', 'Error', 'Company name and email are required');
                        return;
                    }
                    try {
                        const url = this.editingPartnerId
                            ? `/partner-documents/partners/${this.editingPartnerId}`
                            : '/partner-documents/partners';
                        const method = this.editingPartnerId ? 'PUT' : 'POST';
                        const res = await fetch(url, {
                            method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.partnerForm)
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.showToast('success', 'Success', data.message);
                            this.showAddPartnerModal = false;
                            this.resetPartnerForm();
                            await this.loadPartners();
                        } else {
                            this.showToast('error', 'Error', data.message);
                        }
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to save partner');
                    }
                },

                async viewPartner(id) {
                    try {
                        const res = await fetch(`/partner-documents/partners/${id}`);
                        this.partnerDetail = await res.json();
                        this.showPartnerDetailModal = true;
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to load partner detail');
                    }
                },

                async activatePartner(id) {
                    if (!confirm('Activate this partner?')) return;
                    try {
                        const res = await fetch(`/partner-documents/partners/${id}/activate`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        });
                        const data = await res.json();
                        if (data.success) { this.showToast('success', 'Success', 'Partner activated'); await this.loadPartners(); }
                        else { this.showToast('error', 'Error', data.message); }
                    } catch (e) { this.showToast('error', 'Error', 'Failed'); }
                },

                async suspendPartner(id) {
                    if (!confirm('Suspend this partner?')) return;
                    try {
                        const res = await fetch(`/partner-documents/partners/${id}/suspend`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        });
                        const data = await res.json();
                        if (data.success) { this.showToast('success', 'Success', 'Partner suspended'); await this.loadPartners(); }
                        else { this.showToast('error', 'Error', data.message); }
                    } catch (e) { this.showToast('error', 'Error', 'Failed'); }
                },

                async confirmDeletePartner(id, name) {
                    if (!confirm(`Delete partner "${name}"? This will also delete all related transactions.`)) return;
                    try {
                        const res = await fetch(`/partner-documents/partners/${id}`, {
                            method: 'DELETE',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        });
                        const data = await res.json();
                        if (data.success) { this.showToast('success', 'Deleted', 'Partner deleted'); await this.loadPartners(); }
                        else { this.showToast('error', 'Error', data.message); }
                    } catch (e) { this.showToast('error', 'Error', 'Failed to delete partner'); }
                },

                // ==========================================
                // REVENUE METHODS
                // ==========================================
                async loadRevenues() {
                    this.revenueLoading = true;
                    try {
                        const params = new URLSearchParams();
                        if (this.revenueStatusFilter) params.append('status', this.revenueStatusFilter);
                        const res = await fetch(`/partner-documents/revenues?${params}`);
                        this.revenueList = await res.json();
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to load revenues');
                    } finally {
                        this.revenueLoading = false;
                    }
                },

                async saveRevenue() {
                    if (!this.revenueForm.partner_id || !this.revenueForm.amount) {
                        this.showToast('error', 'Error', 'Partner and amount are required');
                        return;
                    }
                    try {
                        const res = await fetch('/partner-documents/revenues', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.revenueForm)
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.showToast('success', 'Success', data.message);
                            this.showAddRevenueModal = false;
                            this.revenueForm = { partner_id: '', type: 'one_time_payment', amount: '', payment_status: 'pending', payment_date: '', payment_method: '', description: '' };
                            await this.loadRevenues();
                        } else {
                            this.showToast('error', 'Error', data.message);
                        }
                    } catch (e) { this.showToast('error', 'Error', 'Failed to create transaction'); }
                },

                async markRevenuePaid(id) {
                    if (!confirm('Mark this transaction as paid?')) return;
                    try {
                        const res = await fetch(`/partner-documents/revenues/${id}`, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                            body: JSON.stringify({ payment_status: 'paid', payment_date: new Date().toISOString().split('T')[0] })
                        });
                        const data = await res.json();
                        if (data.success) { this.showToast('success', 'Success', 'Marked as paid'); await this.loadRevenues(); }
                        else { this.showToast('error', 'Error', data.message); }
                    } catch (e) { this.showToast('error', 'Error', 'Failed'); }
                },

                async confirmDeleteRevenue(id) {
                    if (!confirm('Delete this transaction?')) return;
                    try {
                        const res = await fetch(`/partner-documents/revenues/${id}`, {
                            method: 'DELETE',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        });
                        const data = await res.json();
                        if (data.success) { this.showToast('success', 'Deleted', 'Transaction deleted'); await this.loadRevenues(); }
                        else { this.showToast('error', 'Error', data.message); }
                    } catch (e) { this.showToast('error', 'Error', 'Failed'); }
                },

                // ==========================================
                // ANALYTICS METHODS
                // ==========================================
                async loadAnalytics() {
                    this.analyticsLoading = true;
                    try {
                        const res = await fetch('/partner-documents/analytics');
                        this.analyticsData = await res.json();
                    } catch (e) {
                        this.showToast('error', 'Error', 'Failed to load analytics');
                    } finally {
                        this.analyticsLoading = false;
                    }
                },

                getMonthName(month) {
                    const months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    return months[month] || '';
                },

                getRevenueBarWidth(total) {
                    if (!this.analyticsData.revenue_by_month || !this.analyticsData.revenue_by_month.length) return 0;
                    const max = Math.max(...this.analyticsData.revenue_by_month.map(i => Number(i.total)));
                    return max > 0 ? (Number(total) / max * 100) : 0;
                },

                getDistributionWidth(count) {
                    if (!this.analyticsData.partnership_distribution) return 0;
                    const max = Math.max(...Object.values(this.analyticsData.partnership_distribution));
                    return max > 0 ? (count / max * 100) : 0;
                }
            }
        }
    </script>
</x-app-layout>
