<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div x-data="{
            darkMode: localStorage.getItem('theme') === 'dark',
            sidebarCollapsed: false,
            mobileMenuOpen: false,
            currentTime: '',
            greeting: '',
            // PIN Modal
            pinModal: false,
            pinTarget: '',
            pinTargetName: '',
            pinTargetUrl: '',
            pinDigits: ['','','','','',''],
            pinError: '',
            pinLoading: false,
            pinSuccess: false,
            // Change PIN Modal
            changePinModal: false,
            changePinModule: '',
            changePinModuleName: '',
            currentPin: ['','','','','',''],
            newPin: ['','','','','',''],
            confirmPin: ['','','','','',''],
            changePinStep: 1,
            changePinError: '',
            changePinLoading: false,
            initClock() {
                const update = () => {
                    const now = new Date();
                    const h = now.getHours();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    if (h >= 5 && h < 11) this.greeting = 'Selamat Pagi';
                    else if (h >= 11 && h < 15) this.greeting = 'Selamat Siang';
                    else if (h >= 15 && h < 18) this.greeting = 'Selamat Sore';
                    else this.greeting = 'Selamat Malam';
                };
                update();
                setInterval(update, 1000);
            },
            openPin(moduleKey, moduleName, url) {
                this.pinTarget = moduleKey;
                this.pinTargetName = moduleName;
                this.pinTargetUrl = url;
                this.pinDigits = ['','','','','',''];
                this.pinError = '';
                this.pinSuccess = false;
                this.pinLoading = false;
                this.pinModal = true;
                this.$nextTick(() => {
                    const first = document.getElementById('pin-0');
                    if (first) first.focus();
                });
            },
            handlePinInput(index, event) {
                const val = event.target.value.replace(/\D/g, '');
                this.pinDigits[index] = val.slice(-1);
                event.target.value = this.pinDigits[index];
                if (val && index < 5) {
                    const next = document.getElementById('pin-' + (index + 1));
                    if (next) next.focus();
                }
                if (this.pinDigits.every(d => d !== '')) {
                    this.verifyPin();
                }
            },
            handlePinKeydown(index, event) {
                if (event.key === 'Backspace' && !this.pinDigits[index] && index > 0) {
                    const prev = document.getElementById('pin-' + (index - 1));
                    if (prev) { this.pinDigits[index - 1] = ''; prev.value = ''; prev.focus(); }
                }
            },
            handlePinPaste(event) {
                event.preventDefault();
                const text = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
                for (let i = 0; i < 6; i++) { this.pinDigits[i] = text[i] || ''; }
                this.$nextTick(() => {
                    for (let i = 0; i < 6; i++) { const el = document.getElementById('pin-' + i); if (el) el.value = this.pinDigits[i]; }
                    if (text.length === 6) this.verifyPin();
                    else { const next = document.getElementById('pin-' + text.length); if (next) next.focus(); }
                });
            },
            async verifyPin() {
                this.pinLoading = true;
                this.pinError = '';
                try {
                    const res = await fetch('/module-pin/verify', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                        body: JSON.stringify({ module_key: this.pinTarget, pin: this.pinDigits.join('') })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.pinSuccess = true;
                        setTimeout(() => { window.location.href = this.pinTargetUrl; }, 600);
                    } else {
                        this.pinError = data.message;
                        this.pinDigits = ['','','','','',''];
                        this.$nextTick(() => {
                            for (let i = 0; i < 6; i++) { const el = document.getElementById('pin-' + i); if (el) el.value = ''; }
                            const first = document.getElementById('pin-0'); if (first) first.focus();
                        });
                    }
                } catch (e) { this.pinError = 'Terjadi kesalahan, coba lagi'; }
                this.pinLoading = false;
            },
            openChangePin(moduleKey, moduleName) {
                this.changePinModule = moduleKey;
                this.changePinModuleName = moduleName;
                this.currentPin = ['','','','','',''];
                this.newPin = ['','','','','',''];
                this.confirmPin = ['','','','','',''];
                this.changePinStep = 1;
                this.changePinError = '';
                this.changePinLoading = false;
                this.changePinModal = true;
                this.$nextTick(() => { const el = document.getElementById('cpin-0'); if (el) el.focus(); });
            },
            handleChangePinInput(prefix, arr, index, event, maxIndex) {
                const val = event.target.value.replace(/\D/g, '');
                this[arr][index] = val.slice(-1);
                event.target.value = this[arr][index];
                if (val && index < maxIndex) {
                    const next = document.getElementById(prefix + (index + 1));
                    if (next) next.focus();
                }
            },
            handleChangePinKeydown(prefix, arr, index, event) {
                if (event.key === 'Backspace' && !this[arr][index] && index > 0) {
                    const prev = document.getElementById(prefix + (index - 1));
                    if (prev) { this[arr][index - 1] = ''; prev.value = ''; prev.focus(); }
                }
            },
            nextChangePinStep() {
                if (this.changePinStep === 1 && this.currentPin.every(d => d !== '')) {
                    this.changePinStep = 2;
                    this.changePinError = '';
                    this.$nextTick(() => { const el = document.getElementById('npin-0'); if (el) el.focus(); });
                } else if (this.changePinStep === 2 && this.newPin.every(d => d !== '')) {
                    this.changePinStep = 3;
                    this.changePinError = '';
                    this.$nextTick(() => { const el = document.getElementById('cfpin-0'); if (el) el.focus(); });
                } else if (this.changePinStep === 3 && this.confirmPin.every(d => d !== '')) {
                    this.submitChangePin();
                }
            },
            async submitChangePin() {
                if (this.newPin.join('') !== this.confirmPin.join('')) {
                    this.changePinError = 'PIN baru tidak cocok!';
                    this.confirmPin = ['','','','','',''];
                    this.$nextTick(() => { for (let i=0;i<6;i++){const el=document.getElementById('cfpin-'+i);if(el)el.value='';} const el=document.getElementById('cfpin-0');if(el)el.focus(); });
                    return;
                }
                this.changePinLoading = true;
                this.changePinError = '';
                try {
                    const res = await fetch('/module-pin/change', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                        body: JSON.stringify({ module_key: this.changePinModule, current_pin: this.currentPin.join(''), new_pin: this.newPin.join(''), confirm_pin: this.confirmPin.join('') })
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.changePinModal = false;
                        alert('PIN ' + this.changePinModuleName + ' berhasil diubah!');
                    } else {
                        this.changePinError = data.message;
                        if (data.message.includes('lama')) { this.changePinStep = 1; this.currentPin = ['','','','','','']; this.$nextTick(() => { for(let i=0;i<6;i++){const el=document.getElementById('cpin-'+i);if(el)el.value='';} const el=document.getElementById('cpin-0');if(el)el.focus(); }); }
                    }
                } catch (e) { this.changePinError = 'Terjadi kesalahan'; }
                this.changePinLoading = false;
            }
         }"
         x-init="$watch('darkMode', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', val);
         });
         document.documentElement.classList.toggle('dark', darkMode);
         initClock();"
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

                <a href="{{ route('employee-legal.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-cyan-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-cyan-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-file-signature text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Kontrak Karyawan</span>
                </a>

                <a href="{{ route('employee-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-sky-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-sky-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Karyawan</span>
                </a>

                <a href="{{ route('management-documents.index') }}" class="group flex items-center px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg bg-slate-800 group-hover:bg-amber-500 flex items-center justify-center transition-all group-hover:shadow-lg group-hover:shadow-amber-500/30 group-hover:scale-110">
                        <i class="fa-solid fa-user-tie text-sm"></i>
                    </div>
                    <span x-show="!sidebarCollapsed" class="ml-3">Legal Management</span>
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
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">
                            <span x-text="greeting"></span>, {{ Auth::user()->name }}! <span class="text-lg">👋</span>
                        </h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-0.5">
                            <i class="fa-solid fa-calendar-day"></i>
                            {{ now()->translatedFormat('l, j F Y') }}
                            <span class="text-slate-300 dark:text-slate-600">|</span>
                            <i class="fa-solid fa-clock"></i>
                            <span x-text="currentTime" class="font-mono tabular-nums"></span>
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

                        // Employee contracts count
                        $employeeContractCount = \App\Models\EmployeeContract::count();

                        // Employee documents count (unique employees)
                        $employeeDocCount = \App\Models\EmployeeProfile::count();

                        // Partner stats
                        $partnerCount = \App\Models\Partner::count();
                        $partnerDocCount = \App\Models\PartnerDocument::count();

                        // Management stats
                        $managementCount = \App\Models\ManagementProfile::count();

                        // Expiring documents (within 30 days) from all modules
                        $expiringEmployeeFiles = \App\Models\EmployeeFile::with('employee')
                            ->whereNotNull('expiry_date')
                            ->where('expiry_date', '>=', now())
                            ->where('expiry_date', '<=', now()->addDays(30))
                            ->get();

                        $expiringManagementFiles = \App\Models\ManagementFile::with('management')
                            ->whereNotNull('expiry_date')
                            ->where('expiry_date', '>=', now())
                            ->where('expiry_date', '<=', now()->addDays(30))
                            ->get();

                        // AP Expiry (within 90 days)
                        $expiringAP = \App\Models\ManagementProfile::whereNotNull('ap_expiry')
                            ->where('ap_expiry', '>=', now())
                            ->where('ap_expiry', '<=', now()->addDays(90))
                            ->get();

                        // Contracts expiring (PKWT with start_date + contract_duration)
                        $expiringContracts = \App\Models\EmployeeContract::where('contract_type', 'PKWT')
                            ->whereNotNull('start_date')
                            ->whereNotNull('contract_duration')
                            ->where('status', 'active')
                            ->get()
                            ->filter(function ($c) {
                                $endDate = $c->start_date->copy()->addMonths((int)$c->contract_duration);
                                return $endDate->greaterThanOrEqualTo(now()) && $endDate->lessThanOrEqualTo(now()->addDays(60));
                            });

                        $totalExpiring = $expiringEmployeeFiles->count() + $expiringManagementFiles->count() + $expiringAP->count() + $expiringContracts->count();

                        // Active employees
                        $activeEmployees = \App\Models\EmployeeProfile::where('status', 'active')->count();
                        $activeManagement = \App\Models\ManagementProfile::where('status', 'active')->count();
                    } catch (\Exception $e) {
                        $totalFolders = 0;
                        $totalDocuments = 0;
                        $recentUploads = 0;
                        $storageUsed = 0;
                        $inventoryCount = 0;
                        $employeeContractCount = 0;
                        $employeeDocCount = 0;
                        $partnerCount = 0;
                        $partnerDocCount = 0;
                        $managementCount = 0;
                        $expiringEmployeeFiles = collect();
                        $expiringManagementFiles = collect();
                        $expiringAP = collect();
                        $expiringContracts = collect();
                        $totalExpiring = 0;
                        $activeEmployees = 0;
                        $activeManagement = 0;
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

                <!-- Quick Summary Bar -->
                <div class="mb-8 bg-gradient-to-r from-emerald-500 via-cyan-500 to-blue-500 rounded-2xl p-[1px]">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 lg:p-5">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/15 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-users text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $activeEmployees + $activeManagement }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Personel Aktif</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/15 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-file-circle-check text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $employeeContractCount }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Kontrak Aktif</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $totalExpiring > 0 ? 'bg-red-100 dark:bg-red-500/15' : 'bg-slate-100 dark:bg-slate-800' }} flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-triangle-exclamation {{ $totalExpiring > 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-400' }}"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-bold {{ $totalExpiring > 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-900 dark:text-white' }}">{{ $totalExpiring }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Akan Expired</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-500/15 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-upload text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $recentUploads }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Upload 7 Hari</p>
                                </div>
                            </div>
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
                        <div @click="openPin('legal-documents', 'Legal Documents', '{{ route('legal-documents.index') }}')" class="cursor-pointer group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-blue-400 dark:hover:border-blue-500 transition-all hover:shadow-2xl hover:shadow-blue-500/10 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10"><i class="fa-solid fa-lock text-slate-300 dark:text-slate-600 text-sm"></i></div>
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
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-folder"></i> {{ $totalFolders }} folders</span>
                                    <button @click.stop="openChangePin('legal-documents', 'Legal Documents')" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium flex items-center gap-1"><i class="fa-solid fa-key text-[10px]"></i> Ubah PIN</button>
                                </div>
                            </div>
                        </div>

                        <!-- Kontrak Karyawan -->
                        <div @click="openPin('employee-legal', 'Kontrak Karyawan', '{{ route('employee-legal.index') }}')" class="cursor-pointer group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-cyan-400 dark:hover:border-cyan-500 transition-all hover:shadow-2xl hover:shadow-cyan-500/10 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10"><i class="fa-solid fa-lock text-slate-300 dark:text-slate-600 text-sm"></i></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-500/10 to-teal-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-500 flex items-center justify-center shadow-xl shadow-cyan-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-file-signature text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $employeeContractCount }}</span>
                                        <p class="text-xs text-slate-500">contracts</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">Kontrak Karyawan</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">PKWT & PKWTT contract management</p>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-file-contract"></i> PKWT & PKWTT</span>
                                    <button @click.stop="openChangePin('employee-legal', 'Kontrak Karyawan')" class="text-cyan-500 hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300 font-medium flex items-center gap-1"><i class="fa-solid fa-key text-[10px]"></i> Ubah PIN</button>
                                </div>
                            </div>
                        </div>

                        <!-- Legal Karyawan -->
                        <div @click="openPin('employee-documents', 'Legal Karyawan', '{{ route('employee-documents.index') }}')" class="cursor-pointer group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-sky-400 dark:hover:border-sky-500 transition-all hover:shadow-2xl hover:shadow-sky-500/10 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10"><i class="fa-solid fa-lock text-slate-300 dark:text-slate-600 text-sm"></i></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-sky-500/10 to-blue-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center shadow-xl shadow-sky-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-user-shield text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $employeeDocCount ?? 0 }}</span>
                                        <p class="text-xs text-slate-500">employees</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">Legal Karyawan</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Berkas legal & dokumen karyawan</p>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-id-card"></i> KTP, NPWP, BPJS</span>
                                    <button @click.stop="openChangePin('employee-documents', 'Legal Karyawan')" class="text-sky-500 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 font-medium flex items-center gap-1"><i class="fa-solid fa-key text-[10px]"></i> Ubah PIN</button>
                                </div>
                            </div>
                        </div>

                        <!-- Partner Docs -->
                        <div @click="openPin('partner-documents', 'Partner Docs', '{{ route('partner-documents.index') }}')" class="cursor-pointer group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-purple-400 dark:hover:border-purple-500 transition-all hover:shadow-2xl hover:shadow-purple-500/10 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10"><i class="fa-solid fa-lock text-slate-300 dark:text-slate-600 text-sm"></i></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-xl shadow-purple-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-handshake text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $partnerCount }}</span>
                                        <p class="text-xs text-slate-500">partners</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Partner Docs</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Partnership agreements and contracts</p>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-file"></i> {{ $partnerDocCount }} documents</span>
                                    <button @click.stop="openChangePin('partner-documents', 'Partner Docs')" class="text-purple-500 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-medium flex items-center gap-1"><i class="fa-solid fa-key text-[10px]"></i> Ubah PIN</button>
                                </div>
                            </div>
                        </div>

                        <!-- Legal Management -->
                        <div @click="openPin('management-documents', 'Legal Management', '{{ route('management-documents.index') }}')" class="cursor-pointer group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-amber-400 dark:hover:border-amber-500 transition-all hover:shadow-2xl hover:shadow-amber-500/10 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10"><i class="fa-solid fa-lock text-slate-300 dark:text-slate-600 text-sm"></i></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-orange-500/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-xl shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-user-tie text-white text-xl"></i>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $managementCount }}</span>
                                        <p class="text-xs text-slate-500">pimpinan</p>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Legal Management</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Data & dokumen legal pimpinan KAP</p>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-certificate"></i> Izin AP, CPA, SKP</span>
                                    <button @click.stop="openChangePin('management-documents', 'Legal Management')" class="text-amber-500 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300 font-medium flex items-center gap-1"><i class="fa-solid fa-key text-[10px]"></i> Ubah PIN</button>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory -->
                        <div @click="openPin('inventory', 'Inventory', '{{ route('inventory.index') }}')" class="cursor-pointer group relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 hover:border-teal-400 dark:hover:border-teal-500 transition-all hover:shadow-2xl hover:shadow-teal-500/10 overflow-hidden">
                            <div class="absolute top-3 right-3 z-10"><i class="fa-solid fa-lock text-slate-300 dark:text-slate-600 text-sm"></i></div>
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
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-chart-line"></i> Real-time tracking</span>
                                    <button @click.stop="openChangePin('inventory', 'Inventory')" class="text-teal-500 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium flex items-center gap-1"><i class="fa-solid fa-key text-[10px]"></i> Ubah PIN</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Expiring Documents Alert -->
                @if($totalExpiring > 0)
                <div class="mb-8">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-red-200 dark:border-red-500/30 overflow-hidden">
                        <div class="bg-gradient-to-r from-red-500 to-orange-500 p-4 lg:p-5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-bell text-white text-lg animate-pulse"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">Peringatan Dokumen Expired</h3>
                                    <p class="text-red-100 text-sm">{{ $totalExpiring }} dokumen/izin akan segera berakhir</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 lg:p-6 overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jenis Dokumen</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Modul</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanggal Expired</th>
                                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach($expiringEmployeeFiles as $ef)
                                    @php
                                        $daysLeft = now()->diffInDays($ef->expiry_date, false);
                                    @endphp
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">{{ $ef->employee->employee_name ?? '-' }}</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $ef->document_type }}</td>
                                        <td class="py-3 px-4"><span class="px-2 py-1 text-xs font-medium bg-sky-100 dark:bg-sky-500/15 text-sky-700 dark:text-sky-300 rounded-lg">Legal Karyawan</span></td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $ef->expiry_date->format('d M Y') }}</td>
                                        <td class="py-3 px-4">
                                            @if($daysLeft <= 7)
                                                <span class="px-2.5 py-1 text-xs font-bold bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 rounded-full animate-pulse">{{ $daysLeft }} hari lagi</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full">{{ $daysLeft }} hari lagi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @foreach($expiringManagementFiles as $mf)
                                    @php
                                        $daysLeft = now()->diffInDays($mf->expiry_date, false);
                                    @endphp
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">{{ $mf->management->full_name ?? '-' }}</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $mf->document_type }}</td>
                                        <td class="py-3 px-4"><span class="px-2 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300 rounded-lg">Legal Management</span></td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $mf->expiry_date->format('d M Y') }}</td>
                                        <td class="py-3 px-4">
                                            @if($daysLeft <= 7)
                                                <span class="px-2.5 py-1 text-xs font-bold bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 rounded-full animate-pulse">{{ $daysLeft }} hari lagi</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full">{{ $daysLeft }} hari lagi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @foreach($expiringAP as $ap)
                                    @php
                                        $daysLeft = now()->diffInDays($ap->ap_expiry, false);
                                    @endphp
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">{{ $ap->full_name }}</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Izin Akuntan Publik (AP)</td>
                                        <td class="py-3 px-4"><span class="px-2 py-1 text-xs font-medium bg-orange-100 dark:bg-orange-500/15 text-orange-700 dark:text-orange-300 rounded-lg">Izin AP</span></td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $ap->ap_expiry->format('d M Y') }}</td>
                                        <td class="py-3 px-4">
                                            @if($daysLeft <= 14)
                                                <span class="px-2.5 py-1 text-xs font-bold bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 rounded-full animate-pulse">{{ $daysLeft }} hari lagi</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full">{{ $daysLeft }} hari lagi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @foreach($expiringContracts as $ec)
                                    @php
                                        $endDate = $ec->start_date->copy()->addMonths((int)$ec->contract_duration);
                                        $daysLeft = now()->diffInDays($endDate, false);
                                    @endphp
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">{{ $ec->employee_name }}</td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">Kontrak PKWT</td>
                                        <td class="py-3 px-4"><span class="px-2 py-1 text-xs font-medium bg-cyan-100 dark:bg-cyan-500/15 text-cyan-700 dark:text-cyan-300 rounded-lg">Kontrak Karyawan</span></td>
                                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $endDate->format('d M Y') }}</td>
                                        <td class="py-3 px-4">
                                            @if($daysLeft <= 14)
                                                <span class="px-2.5 py-1 text-xs font-bold bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 rounded-full animate-pulse">{{ $daysLeft }} hari lagi</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full">{{ $daysLeft }} hari lagi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <!-- All Clear Badge -->
                <div class="mb-8">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-emerald-200 dark:border-emerald-500/30 p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-500/15 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-emerald-700 dark:text-emerald-400">Semua Aman!</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada dokumen atau izin yang akan expired dalam waktu dekat.</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Activity -->
                <div class="mb-8">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
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
                <a href="{{ route('employee-legal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-file-signature w-5"></i>
                    <span>Kontrak Karyawan</span>
                </a>
                <a href="{{ route('employee-documents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-user-shield w-5"></i>
                    <span>Legal Karyawan</span>
                </a>
                <a href="{{ route('management-documents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-user-tie w-5"></i>
                    <span>Legal Management</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-boxes-stacked w-5"></i>
                    <span>Inventory</span>
                </a>
                <a href="{{ route('partner-documents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
                    <i class="fa-solid fa-handshake w-5"></i>
                    <span>Partner Docs</span>
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

        <!-- PIN Verification Modal -->
        <div x-show="pinModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" @click.self="pinModal = false" style="display:none;">
            <div x-show="pinModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden">
                <!-- Decorative -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-500 via-cyan-500 to-blue-500"></div>

                <!-- Close -->
                <button @click="pinModal = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-red-100 dark:hover:bg-red-500/20 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-slate-400 hover:text-red-500 text-sm"></i>
                </button>

                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center" :class="pinSuccess ? 'from-emerald-100 to-emerald-200 dark:from-emerald-500/20 dark:to-emerald-500/10' : ''">
                        <i class="text-3xl" :class="pinSuccess ? 'fa-solid fa-lock-open text-emerald-500' : 'fa-solid fa-lock text-slate-400 dark:text-slate-500'"></i>
                    </div>
                </div>

                <!-- Title -->
                <h3 class="text-xl font-bold text-center text-slate-900 dark:text-white mb-2">Masukkan PIN</h3>
                <p class="text-sm text-center text-slate-500 dark:text-slate-400 mb-8">Masukkan 6 digit PIN untuk akses <span class="font-semibold text-slate-700 dark:text-slate-300" x-text="pinTargetName"></span></p>

                <!-- PIN Input (OTP Style) -->
                <div class="flex justify-center gap-3 mb-6" @paste="handlePinPaste($event)">
                    <template x-for="(digit, index) in pinDigits" :key="index">
                        <input type="text" inputmode="numeric" maxlength="1"
                            :id="'pin-' + index"
                            :value="digit"
                            @input="handlePinInput(index, $event)"
                            @keydown="handlePinKeydown(index, $event)"
                            @focus="$event.target.select()"
                            class="w-12 h-14 text-center text-2xl font-bold rounded-xl border-2 transition-all duration-200 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white outline-none"
                            :class="pinError ? 'border-red-400 dark:border-red-500 animate-shake' : pinSuccess ? 'border-emerald-400 dark:border-emerald-500 bg-emerald-50 dark:bg-emerald-500/10' : 'border-slate-200 dark:border-slate-700 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20'"
                            :disabled="pinLoading || pinSuccess">
                    </template>
                </div>

                <!-- Error Message -->
                <div x-show="pinError" x-transition class="text-center mb-4">
                    <p class="text-sm text-red-500 dark:text-red-400 font-medium flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span x-text="pinError"></span>
                    </p>
                </div>

                <!-- Success -->
                <div x-show="pinSuccess" x-transition class="text-center mb-4">
                    <p class="text-sm text-emerald-500 dark:text-emerald-400 font-medium flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        PIN benar! Mengalihkan...
                    </p>
                </div>

                <!-- Loading -->
                <div x-show="pinLoading && !pinSuccess" class="flex justify-center mb-4">
                    <div class="w-6 h-6 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>

                <!-- Info -->
                <p class="text-xs text-center text-slate-400 dark:text-slate-500 mt-4">
                    <i class="fa-solid fa-info-circle mr-1"></i>
                    PIN default: 000000
                </p>
            </div>
        </div>

        <!-- Change PIN Modal -->
        <div x-show="changePinModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" @click.self="changePinModal = false" style="display:none;">
            <div x-show="changePinModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500"></div>

                <button @click="changePinModal = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-red-100 dark:hover:bg-red-500/20 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-slate-400 hover:text-red-500 text-sm"></i>
                </button>

                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-500/20 dark:to-orange-500/10 flex items-center justify-center">
                        <i class="fa-solid fa-key text-2xl text-amber-500"></i>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-center text-slate-900 dark:text-white mb-1">Ubah PIN</h3>
                <p class="text-sm text-center text-slate-500 dark:text-slate-400 mb-2" x-text="changePinModuleName"></p>

                <!-- Steps Indicator -->
                <div class="flex items-center justify-center gap-2 mb-6">
                    <template x-for="step in [1,2,3]" :key="step">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all" :class="changePinStep >= step ? 'bg-amber-500 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-400'">
                                <span x-text="step"></span>
                            </div>
                            <div x-show="step < 3" class="w-8 h-0.5" :class="changePinStep > step ? 'bg-amber-500' : 'bg-slate-200 dark:bg-slate-700'"></div>
                        </div>
                    </template>
                </div>

                <!-- Step 1: Current PIN -->
                <div x-show="changePinStep === 1" x-transition>
                    <p class="text-sm text-center text-slate-600 dark:text-slate-300 font-medium mb-4">Masukkan PIN Lama</p>
                    <div class="flex justify-center gap-3 mb-4">
                        <template x-for="i in 6" :key="'cp'+i">
                            <input type="text" inputmode="numeric" maxlength="1" :id="'cpin-' + (i-1)" @input="handleChangePinInput('cpin-', 'currentPin', i-1, $event, 5)" @keydown="handleChangePinKeydown('cpin-', 'currentPin', i-1, $event)" @focus="$event.target.select()" class="w-11 h-13 text-center text-xl font-bold rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:border-amber-500 dark:focus:border-amber-400 focus:ring-4 focus:ring-amber-500/20 outline-none transition-all">
                        </template>
                    </div>
                    <div class="flex justify-center">
                        <button @click="nextChangePinStep()" :disabled="!currentPin.every(d => d !== '')" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 disabled:bg-slate-300 dark:disabled:bg-slate-700 text-white rounded-xl font-medium transition-all disabled:cursor-not-allowed">Lanjut</button>
                    </div>
                </div>

                <!-- Step 2: New PIN -->
                <div x-show="changePinStep === 2" x-transition>
                    <p class="text-sm text-center text-slate-600 dark:text-slate-300 font-medium mb-4">Masukkan PIN Baru</p>
                    <div class="flex justify-center gap-3 mb-4">
                        <template x-for="i in 6" :key="'np'+i">
                            <input type="text" inputmode="numeric" maxlength="1" :id="'npin-' + (i-1)" @input="handleChangePinInput('npin-', 'newPin', i-1, $event, 5)" @keydown="handleChangePinKeydown('npin-', 'newPin', i-1, $event)" @focus="$event.target.select()" class="w-11 h-13 text-center text-xl font-bold rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:border-amber-500 dark:focus:border-amber-400 focus:ring-4 focus:ring-amber-500/20 outline-none transition-all">
                        </template>
                    </div>
                    <div class="flex justify-center">
                        <button @click="nextChangePinStep()" :disabled="!newPin.every(d => d !== '')" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 disabled:bg-slate-300 dark:disabled:bg-slate-700 text-white rounded-xl font-medium transition-all disabled:cursor-not-allowed">Lanjut</button>
                    </div>
                </div>

                <!-- Step 3: Confirm PIN -->
                <div x-show="changePinStep === 3" x-transition>
                    <p class="text-sm text-center text-slate-600 dark:text-slate-300 font-medium mb-4">Konfirmasi PIN Baru</p>
                    <div class="flex justify-center gap-3 mb-4">
                        <template x-for="i in 6" :key="'cfp'+i">
                            <input type="text" inputmode="numeric" maxlength="1" :id="'cfpin-' + (i-1)" @input="handleChangePinInput('cfpin-', 'confirmPin', i-1, $event, 5)" @keydown="handleChangePinKeydown('cfpin-', 'confirmPin', i-1, $event)" @focus="$event.target.select()" class="w-11 h-13 text-center text-xl font-bold rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:border-amber-500 dark:focus:border-amber-400 focus:ring-4 focus:ring-amber-500/20 outline-none transition-all">
                        </template>
                    </div>
                    <div class="flex justify-center">
                        <button @click="nextChangePinStep()" :disabled="!confirmPin.every(d => d !== '') || changePinLoading" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 disabled:bg-slate-300 dark:disabled:bg-slate-700 text-white rounded-xl font-medium transition-all disabled:cursor-not-allowed flex items-center gap-2">
                            <span x-show="changePinLoading" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                            <span>Simpan PIN</span>
                        </button>
                    </div>
                </div>

                <!-- Error -->
                <div x-show="changePinError" x-transition class="text-center mt-4">
                    <p class="text-sm text-red-500 font-medium flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span x-text="changePinError"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shake Animation -->
    <style>
        @keyframes shake { 0%, 100% { transform: translateX(0); } 20%, 60% { transform: translateX(-4px); } 40%, 80% { transform: translateX(4px); } }
        .animate-shake { animation: shake 0.4s ease-in-out; }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</x-app-layout>
