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

            <!-- Stats -->
            <section class="relative z-10 px-6 sm:px-8 pb-6">
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
            <main class="relative z-10 px-6 sm:px-8 pb-8" :class="{ 'blur-sm': showPanel }">
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
                }
            }
        }
    </script>
</x-app-layout>
