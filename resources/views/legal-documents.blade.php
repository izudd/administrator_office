<x-app-layout>
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(30px, 10px) scale(1.05); }
        }
        .animate-blob { animation: blob 15s ease-in-out infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>

    <div style="--header-height:72px">
        <div x-data="legalDocsApp()" x-init="init()"
            class="relative min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:from-[#0a0f1a] dark:via-[#0e1525] dark:to-[#111827] transition-colors duration-500">

            <!-- Animated Background Blobs -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-300/30 dark:bg-emerald-500/10 rounded-full blur-3xl animate-blob"></div>
                <div class="absolute top-1/2 -left-40 w-96 h-96 bg-cyan-300/30 dark:bg-cyan-500/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-40 right-1/3 w-80 h-80 bg-teal-300/30 dark:bg-teal-500/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
            </div>

            <!-- Toast Notification -->
            <div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-6 right-6 z-[100] max-w-sm">
                <div class="rounded-xl shadow-2xl backdrop-blur-xl border overflow-hidden"
                    :class="{
                        'bg-emerald-500/90 border-emerald-400': toast.type === 'success',
                        'bg-red-500/90 border-red-400': toast.type === 'error',
                        'bg-blue-500/90 border-blue-400': toast.type === 'info'
                    }">
                    <div class="p-4 flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <i class="text-white text-xl"
                                :class="{
                                    'fa-solid fa-check-circle': toast.type === 'success',
                                    'fa-solid fa-exclamation-circle': toast.type === 'error',
                                    'fa-solid fa-info-circle': toast.type === 'info'
                                }"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-white" x-text="toast.title"></h4>
                            <p class="text-sm text-white/90 mt-0.5" x-text="toast.message"></p>
                        </div>
                        <button @click="toast.show = false" class="flex-shrink-0 text-white/80 hover:text-white">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="h-1 bg-white/20">
                        <div class="h-full bg-white/60 transition-all duration-[3000ms] ease-linear"
                            :style="toast.show ? 'width: 0%' : 'width: 100%'"></div>
                    </div>
                </div>
            </div>

            <!-- Header area -->
            <header class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 sm:p-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-folder-tree text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 dark:from-emerald-400 dark:via-teal-400 dark:to-cyan-400 bg-clip-text text-transparent">
                                Legal Documents
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Manage and organize your legal folders securely
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-0 flex items-center gap-3">
                    <!-- Search Bar -->
                    <div class="relative hidden sm:block">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" placeholder="Search folders..."
                            class="pl-9 pr-4 py-2.5 w-48 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" />
                    </div>

                    <!-- New Folder Button -->
                    <button @click="showAddModal = true"
                        class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white font-semibold shadow-lg hover:shadow-xl hover:shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                        <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                        <span>New Folder</span>
                        <div class="absolute inset-0 rounded-xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                </div>
            </header>

            <!-- Grid -->
            <main class="relative z-10 p-6 sm:p-8 transition-all duration-400" :class="{ 'blur-sm scale-[0.995]': showFolderPanel }">
                <!-- Stats Bar -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20 flex items-center justify-center">
                                <i class="fa-solid fa-folder text-emerald-500"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ count($folders) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Total Folders</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg hover:shadow-cyan-500/10 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-cyan-500/10 dark:bg-cyan-500/20 flex items-center justify-center">
                                <i class="fa-solid fa-file-lines text-cyan-500"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalFiles ?? 0 }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Total Files</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg hover:shadow-purple-500/10 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-500/10 dark:bg-purple-500/20 flex items-center justify-center">
                                <i class="fa-solid fa-clock text-purple-500"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $recentFiles ?? 0 }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Recent (7 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg hover:shadow-amber-500/10 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 flex items-center justify-center">
                                <i class="fa-solid fa-hard-drive text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalStorage ?? '0 B' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Storage Used</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Folders Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($folders as $index => $folder)
                        <div
                            style="animation-delay: {{ $index * 50 }}ms"
                            class="group relative p-6 bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-md hover:shadow-2xl hover:shadow-emerald-500/10 dark:hover:shadow-emerald-500/5 transition-all duration-300 transform hover:-translate-y-2 backdrop-blur-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden animate-[fadeIn_0.5s_ease-out_forwards] opacity-0"
                            >

                            <!-- Gradient overlay on hover -->
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 via-teal-500/0 to-cyan-500/0 group-hover:from-emerald-500/5 group-hover:via-teal-500/10 group-hover:to-cyan-500/5 transition-all duration-500 rounded-2xl"></div>

                            <!-- Shine effect -->
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </div>

                            <!-- ripple placeholder -->
                            <span class="absolute inset-0 overflow-hidden rounded-2xl">
                                <span class="ripple absolute w-0 h-0 bg-emerald-400/30 rounded-full transform scale-0 opacity-0 pointer-events-none"></span>
                            </span>

                            <div class="relative z-10">
                                <!-- Action Buttons (Top Right) -->
                                <div class="absolute top-0 right-0 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-200 translate-y-2 group-hover:translate-y-0">
                                    <button @click.stop="startRenameFolder('{{ addslashes($folder->name) }}')"
                                        class="p-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-xs shadow-lg transform hover:scale-110 transition-all"
                                        title="Rename">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button @click.stop="deleteFolder('{{ addslashes($folder->name) }}')"
                                        class="p-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs shadow-lg transform hover:scale-110 transition-all"
                                        title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>

                                <div @click="openFolder('{{ addslashes($folder->name) }}', $event)" class="cursor-pointer">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-xl blur-lg opacity-50 group-hover:opacity-80 transition-opacity"></div>
                                            <div class="relative p-4 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-xl shadow-lg transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                                <i class="fa-solid fa-folder text-2xl text-white"></i>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
                                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Open</span>
                                            <i class="fa-solid fa-arrow-right text-emerald-600 dark:text-emerald-400"></i>
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors truncate">
                                            {{ $folder->name }}
                                        </h3>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                                <i class="fa-solid fa-clock"></i>
                                                <span>{{ $folder->updated_at->diffForHumans() }}</span>
                                            </div>
                                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                                Active
                                            </span>
                                        </div>
                                    </div>
                                </div>
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
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full blur-xl opacity-30 animate-pulse"></div>
                            <div class="relative w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center">
                                <i class="fa-solid fa-folder-open text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">No folders yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Create your first folder to start organizing your legal documents securely</p>
                        <button @click="showAddModal = true"
                            class="group inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white font-semibold shadow-lg hover:shadow-xl hover:shadow-emerald-500/30 transform hover:scale-105 transition-all duration-300">
                            <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                            <span>Create Your First Folder</span>
                        </button>
                    </div>
                @endif
            </main>

            <!-- Slide-in Panel (responsive) -->
            <div x-show="showFolderPanel" x-transition:enter="transition ease-out duration-400"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-400"
                x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
                @keydown.window.escape="closePanel()" class="fixed right-0 top-[var(--header-height)] z-50"
                :class="{ 'w-full sm:w-[52%] md:w-[520px]': true }" style="height: calc(100vh - var(--header-height));">

                <div
                    class="h-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-2xl border-l border-gray-200 dark:border-gray-700 shadow-2xl overflow-y-auto">
                    <div class="p-6">
                        <!-- Header -->
                        <div
                            class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                    <i class="fa-solid fa-folder-open text-emerald-600"></i>
                                    <span x-text="selectedFolder || 'Folder'"></span>
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-2">
                                    <i class="fa-solid fa-file"></i>
                                    <span x-text="files.length ? (files.length + ' files') : 'No files'"></span>
                                </p>
                            </div>
                            <button @click="closePanel"
                                class="p-3 rounded-xl text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>

                        <!-- search -->
                        <div class="mb-6">
                            <div class="relative">
                                <i
                                    class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input x-model="search" type="text" placeholder="Search files..."
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" />
                            </div>
                        </div>

                        <!-- skeleton -->
                        <template x-if="loading">
                            <div class="space-y-3">
                                <div
                                    class="h-20 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-xl animate-pulse">
                                </div>
                                <div
                                    class="h-20 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-xl animate-pulse">
                                </div>
                                <div
                                    class="h-20 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-xl animate-pulse">
                                </div>
                            </div>
                        </template>

                        <!-- file list -->
                        <template x-if="!loading && filteredFiles().length">
                            <div class="space-y-3">
                                <template x-for="f in filteredFiles()" :key="f.file_name">
                                    <div
                                        class="group p-4 rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 hover:from-emerald-50 hover:to-teal-50 dark:hover:from-emerald-900/20 dark:hover:to-teal-900/20 border border-gray-200 dark:border-gray-600 transition-all duration-200 hover:shadow-lg">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4 min-w-0 flex-1">
                                                <div
                                                    class="flex-shrink-0 w-12 h-12 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                                    <i class="fa-solid fa-file-pdf text-white text-xl"></i>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors"
                                                        x-text="f.file_name"></div>
                                                    <div
                                                        class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-2">
                                                        <i class="fa-solid fa-database"></i>
                                                        <span x-text="f.size || ''"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button @click="previewFile(f.file_name)"
                                                    class="p-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm transition-colors shadow-md hover:shadow-lg"
                                                    title="Preview">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button @click="deleteFile(f.file_name)"
                                                    class="p-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm transition-colors shadow-md hover:shadow-lg"
                                                    title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- empty -->
                        <template x-if="!loading && !filteredFiles().length">
                            <div class="text-center text-gray-500 dark:text-gray-400 py-16">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                    <i class="fa-solid fa-box-open text-4xl"></i>
                                </div>
                                <p class="text-lg font-medium">No files found</p>
                                <p class="text-sm mt-1">Upload your first document below</p>
                            </div>
                        </template>

                        <!-- upload area -->
                        <div class="mt-8 relative">
                            <div class="border-2 border-dashed border-emerald-300 dark:border-emerald-700 rounded-2xl p-8 text-center bg-gradient-to-br from-emerald-50/50 to-teal-50/50 dark:from-emerald-900/10 dark:to-teal-900/10 hover:border-emerald-400 dark:hover:border-emerald-600 transition-all cursor-pointer group"
                                @dragover.prevent @drop.prevent="onDrop($event)" @click="$refs.fileInput.click()">

                                <input type="file" x-ref="fileInput" class="hidden"
                                    @change="onFileChange($event)" />

                                <div class="flex flex-col items-center gap-4">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-white"></i>
                                    </div>

                                    <div>
                                        <div class="text-base font-semibold text-gray-700 dark:text-gray-200">
                                            Drop files here or click to browse
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Maximum file size: 10MB
                                        </div>
                                    </div>

                                    <template x-if="uploading">
                                        <div class="w-full mt-4">
                                            <div
                                                class="w-full bg-gray-200 dark:bg-gray-700 h-3 rounded-full overflow-hidden shadow-inner">
                                                <div class="h-3 bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-300 rounded-full relative overflow-hidden"
                                                    :style="`width: ${progress}%`">
                                                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                                </div>
                                            </div>
                                            <div class="flex justify-between items-center mt-2">
                                                <span
                                                    class="text-xs font-medium text-emerald-600 dark:text-emerald-400"
                                                    x-text="progress + '%'"></span>
                                                <span class="text-xs text-gray-500">Uploading...</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showPreview" x-transition
                class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
                @click.self="showPreview = false">

                <!-- Modal Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl h-[85vh] flex flex-col overflow-hidden">

                    <!-- Header -->
                    <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100" x-text="previewTitle"></h2>
                        <button @click="showPreview = false"
                            class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <div class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-800 flex items-center justify-center">
                        <!-- PDF -->
                        <template x-if="previewType === 'pdf'">
                            <iframe :src="previewUrl" class="w-full h-full" frameborder="0"></iframe>
                        </template>

                        <!-- Image -->
                        <template x-if="previewType === 'image'">
                            <img :src="previewUrl" class="max-h-[80vh] object-contain" />
                        </template>

                        <!-- Office -->
                        <template x-if="previewType === 'office'">
                            <iframe :src="previewUrl" class="w-full h-full" frameborder="0"></iframe>
                        </template>

                        <!-- Text -->
                        <template x-if="previewType === 'text'">
                            <iframe :src="previewUrl" class="w-full h-full bg-white"></iframe>
                        </template>

                        <!-- Unknown -->
                        <template x-if="previewType === 'unknown'">
                            <div class="text-gray-600 dark:text-gray-300 text-center p-8">
                                <p>File type not supported for preview.</p>
                                <a :href="previewUrl" download
                                    class="mt-2 inline-block bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
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

                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-folder-plus text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Create New Folder</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Enter a name for your folder</p>
                        </div>
                    </div>

                    <input type="text" x-model="newFolderName" placeholder="e.g., Tax Documents 2024"
                        @keydown.enter="createFolder()"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-100 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all mb-6" />

                    <div class="flex justify-end gap-3">
                        <button @click="showAddModal = false"
                            class="px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition-colors">
                            Cancel
                        </button>
                        <button @click="createFolder()"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            Create Folder
                        </button>
                    </div>
                </div>
            </div>

            <!-- footer -->
            <footer class="relative z-10 text-center py-8 border-t border-gray-200/50 dark:border-gray-700/50 mt-12 bg-white/30 dark:bg-gray-900/30 backdrop-blur-sm">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                    <span class="text-gray-500 dark:text-gray-400">© {{ date('Y') }}</span>
                    <span class="font-semibold bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 bg-clip-text text-transparent">
                        KAP Budiandru & Rekan
                    </span>
                    <span class="text-gray-400 dark:text-gray-500 hidden sm:inline">•</span>
                    <span class="text-sm text-gray-400 dark:text-gray-500">All rights reserved</span>
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
                selectedFolder: null,
                search: '',
                uploading: false,
                progress: 0,
                newFolderName: '',
                showPreview: false,
                previewUrl: '',
                previewTitle: '',
                previewType: 'unknown',
                toast: {
                    show: false,
                    type: 'success',
                    title: '',
                    message: ''
                },

                init() {
                    console.log('legalDocsApp ready');
                },

                showToast(type, title, message) {
                    this.toast = {
                        show: true,
                        type,
                        title,
                        message
                    };
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3000);
                },

                async openFolder(folderName, evt = null) {
                    if (evt) this.createRipple(evt.currentTarget);
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

                        console.log('Loading files from:', url);

                        const res = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });

                        console.log('Response status:', res.status);
                        console.log('Response headers:', Object.fromEntries(res.headers.entries()));

                        if (!res.ok) {
                            const text = await res.text();
                            console.error('Response body:', text);

                            // Cek apakah redirect ke login
                            if (res.status === 401 || res.url.includes('/login')) {
                                this.showToast('error', 'Session Expired', 'Please login again');
                                window.location.href = '/login';
                                return;
                            }

                            this.showToast('error', 'Error', `Failed to load files: ${res.status}`);
                            this.files = [];
                            return;
                        }

                        const data = await res.json();
                        console.log('Files loaded:', data);

                        this.files = data.map(f => ({
                            ...f,
                            url: f.url ? f.url : (f.file_path ? `/storage/${f.file_path}` : undefined)
                        }));

                        await new Promise(r => setTimeout(r, 250));
                    } catch (err) {
                        console.error('loadFiles error:', err);
                        this.showToast('error', 'Error', 'Failed to load files: ' + err.message);
                        this.files = [];
                    } finally {
                        this.loading = false;
                    }
                },

                previewFile(fileName) {
                    this.previewTitle = fileName;
                    const ext = fileName.split('.').pop().toLowerCase();
                    this.previewUrl =
                        `/legal-documents/${encodeURIComponent(this.selectedFolder)}/preview/${encodeURIComponent(fileName)}`;

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

                    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
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
                            this.showToast('success', 'Success!', `${file.name} uploaded successfully`);
                            await this.loadFiles(this.selectedFolder);
                        } else {
                            let msg = 'Upload failed';
                            try {
                                msg = JSON.parse(xhr.responseText).message || msg
                            } catch (e) {}
                            this.showToast('error', 'Upload Failed', msg);
                            console.error('Upload error details:', xhr.responseText);
                        }
                        setTimeout(() => this.progress = 0, 400);
                    };

                    xhr.onerror = () => {
                        this.uploading = false;
                        this.showToast('error', 'Network Error', 'Failed to connect to server');
                        console.error('XHR error occurred');
                    };

                    // ✅ Handle timeout
                    xhr.ontimeout = () => {
                        this.uploading = false;
                        this.showToast('error', 'Timeout', 'Upload took too long. Try a smaller file.');
                        console.error('XHR timeout');
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
                            body: JSON.stringify({
                                filename: fileName
                            })
                        });

                        if (res.ok) {
                            this.files = this.files.filter(f => f.file_name !== fileName);
                            this.showToast('success', 'Deleted!', `${fileName} has been deleted`);
                        } else {
                            const j = await res.json().catch(() => null);
                            this.showToast('error', 'Delete Failed', (j && j.message) ? j.message :
                                'Failed to delete file');
                            console.error('Delete error details:', j);
                            console.error('Delete error status:', res.status);
                        }
                    } catch (err) {
                        console.error('Delete error:', err);
                        this.showToast('error', 'Error', 'An error occurred while deleting');
                        console.error('Delete error details:', err);
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
                            body: JSON.stringify({
                                name
                            })
                        });

                        if (!res.ok) {
                            const j = await res.json().catch(() => null);
                            this.showToast('error', 'Error', j && j.message ? j.message : 'Create folder failed');
                            return;
                        }

                        this.showToast('success', 'Success!', `Folder "${name}" created successfully`);
                        setTimeout(() => window.location.reload(), 1000);
                    } catch (err) {
                        console.error(err);
                        this.showToast('error', 'Error', 'Failed to create folder');
                    }
                },

                createRipple(target) {
                    try {
                        const el = target;
                        const ripple = el.querySelector('.ripple');
                        if (!ripple) return;
                        ripple.style.transition = 'none';
                        ripple.style.width = ripple.style.height = '0px';
                        ripple.style.left = ripple.style.top = '0px';
                        ripple.style.opacity = '0';
                        const rect = el.getBoundingClientRect();
                        const d = Math.max(rect.width, rect.height) * 2;
                        ripple.style.width = ripple.style.height = d + 'px';
                        ripple.style.left = (event.clientX - rect.left - d / 2) + 'px';
                        ripple.style.top = (event.clientY - rect.top - d / 2) + 'px';
                        ripple.style.opacity = '1';
                        ripple.style.transform = 'scale(1)';
                        ripple.style.transition = 'opacity 600ms ease, transform 600ms ease';
                        setTimeout(() => {
                            ripple.style.opacity = '0';
                            ripple.style.transform = 'scale(1.8)';
                        }, 40);
                    } catch (e) {
                        /* ignore */
                    }
                },

                openPreview(file) {
                    this.previewTitle = file.file_name;
                    this.previewUrl = file.url;

                    const ext = file.file_name.split('.').pop().toLowerCase();
                    console.log('📄 Detected extension:', ext);

                    if (['pdf'].includes(ext)) {
                        this.previewType = 'pdf';
                    } else if (['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(ext)) {
                        this.previewType = 'image';
                    } else if (['txt', 'csv', 'json', 'md'].includes(ext)) {
                        this.previewType = 'text';
                    } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
                        // ✅ pakai Google Docs Viewer untuk Office files
                        this.previewType = 'office';
                        this.previewUrl =
                            `https://docs.google.com/gview?url=${window.location.origin}${file.url}&embedded=true`;
                    } else {
                        this.previewType = 'unknown';
                    }

                    console.log('🧠 Preview type:', this.previewType);
                    console.log('🔗 Preview URL:', this.previewUrl);

                    this.showPreview = true;
                },

                closePreview() {
                    this.showPreview = false;
                    this.previewUrl = '';
                    this.previewTitle = '';
                }
            }
        }
    </script>
</x-app-layout>
