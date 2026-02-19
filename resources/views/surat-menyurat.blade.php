<!DOCTYPE html>
<html lang="id" x-data="suratApp()" x-init="init()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Surat Menyurat — KAP Budiandru & Rekan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }

        .sidebar-link {
            @apply flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors;
        }
        .sidebar-link.active {
            @apply bg-slate-900 text-white hover:bg-slate-800 hover:text-white;
        }

        /* Badge jenis surat */
        .badge-masuk    { background: #dbeafe; color: #1d4ed8; }
        .badge-keluar   { background: #dcfce7; color: #15803d; }
        .badge-internal { background: #fef9c3; color: #a16207; }
        .badge-sk       { background: #ede9fe; color: #7c3aed; }

        /* Badge status */
        .status-draft      { background: #f1f5f9; color: #64748b; }
        .status-terkirim   { background: #dbeafe; color: #1d4ed8; }
        .status-diterima   { background: #dcfce7; color: #15803d; }
        .status-dibalas    { background: #fef9c3; color: #a16207; }
        .status-diarsipkan { background: #e2e8f0; color: #475569; }

        /* Table row hover */
        .table-row:hover { background-color: #f8fafc; }

        /* Modal backdrop */
        .modal-backdrop {
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
        }

        /* Drag & drop zone */
        .drop-zone { border: 2px dashed #cbd5e1; transition: all 0.2s; }
        .drop-zone.active { border-color: #3b82f6; background: #eff6ff; }

        /* Toast */
        .toast-enter { animation: toastIn 0.3s ease-out; }
        @keyframes toastIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        /* Print */
        @media print {
            .no-print { display: none !important; }
            .print-full { width: 100% !important; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

{{-- ===================== TOAST ===================== --}}
<div class="fixed bottom-5 right-5 z-[100] flex flex-col gap-2 no-print" x-cloak>
    <template x-for="toast in toasts" :key="toast.id">
        <div class="toast-enter flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-sm font-medium max-w-xs"
             :class="toast.type === 'success' ? 'bg-white border border-green-200 text-green-800' : 'bg-white border border-red-200 text-red-800'">
            <span x-show="toast.type === 'success'" class="text-green-500 flex-shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </span>
            <span x-show="toast.type === 'error'" class="text-red-500 flex-shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            </span>
            <span x-text="toast.message"></span>
        </div>
    </template>
</div>

{{-- ===================== LAYOUT ===================== --}}
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="no-print flex flex-col w-64 flex-shrink-0 bg-white border-r border-slate-200 h-full">
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100">
            <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-900 leading-tight">KAP Budiandru</p>
                <p class="text-[10px] text-slate-400 leading-tight">& Rekan</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
            <p class="px-3 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Menu Utama</p>
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                Dashboard
            </a>
            <a href="{{ route('legal-documents.index') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Dokumen Legal
            </a>
            <a href="{{ route('inventory.index') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Inventaris
            </a>
            <a href="{{ route('partner-documents.index') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Dokumen Partner
            </a>
            <a href="{{ route('employee-legal.index') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Kontrak Karyawan
            </a>
            <a href="{{ route('employee-documents.index') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Legal Karyawan
            </a>
            <a href="{{ route('management-documents.index') }}" class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Legal Management
            </a>
            <a href="{{ route('surat-menyurat.index') }}" class="sidebar-link active">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Surat Menyurat
            </a>
        </nav>

        {{-- User --}}
        <div class="border-t border-slate-100 px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 bg-slate-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-slate-700 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 flex flex-col overflow-hidden">

        {{-- ---- HEADER ---- --}}
        <header class="no-print bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-lg font-semibold text-slate-900">Surat Menyurat</h1>
                <p class="text-xs text-slate-400 mt-0.5">Kelola surat masuk, keluar, internal, dan surat keputusan</p>
            </div>
            <button @click="openModal('add')"
                    class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Surat
            </button>
        </header>

        {{-- ---- BODY ---- --}}
        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-slate-200 p-4 cursor-pointer transition-shadow hover:shadow-sm"
                     @click="filterJenis = filterJenis === 'masuk' ? '' : 'masuk'">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-slate-500">Surat Masuk</span>
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalMasuk }}</p>
                    <p class="text-xs text-slate-400 mt-1">surat diterima</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 cursor-pointer transition-shadow hover:shadow-sm"
                     @click="filterJenis = filterJenis === 'keluar' ? '' : 'keluar'">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-slate-500">Surat Keluar</span>
                        <div class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalKeluar }}</p>
                    <p class="text-xs text-slate-400 mt-1">surat dikirim</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 cursor-pointer transition-shadow hover:shadow-sm"
                     @click="filterJenis = filterJenis === 'internal' ? '' : 'internal'">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-slate-500">Internal</span>
                        <div class="w-7 h-7 rounded-lg bg-yellow-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalInternal }}</p>
                    <p class="text-xs text-slate-400 mt-1">memo internal</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 cursor-pointer transition-shadow hover:shadow-sm"
                     @click="filterJenis = filterJenis === 'sk' ? '' : 'sk'">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-slate-500">Surat Keputusan</span>
                        <div class="w-7 h-7 rounded-lg bg-purple-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalSK }}</p>
                    <p class="text-xs text-slate-400 mt-1">SK diterbitkan</p>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-xl border border-slate-200">
                {{-- Table Toolbar --}}
                <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1 max-w-sm">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" x-model="search" placeholder="Cari nomor, perihal, instansi..."
                               class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 bg-slate-50">
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Filter Jenis --}}
                        <select x-model="filterJenis"
                                class="text-sm border border-slate-200 rounded-lg px-3 py-2 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 text-slate-700">
                            <option value="">Semua Jenis</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                            <option value="internal">Internal</option>
                            <option value="sk">Surat Keputusan</option>
                        </select>

                        {{-- Filter Status --}}
                        <select x-model="filterStatus"
                                class="text-sm border border-slate-200 rounded-lg px-3 py-2 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 text-slate-700">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="terkirim">Terkirim</option>
                            <option value="diterima">Diterima</option>
                            <option value="dibalas">Dibalas</option>
                            <option value="diarsipkan">Diarsipkan</option>
                        </select>

                        {{-- Clear Filter --}}
                        <button x-show="search || filterJenis || filterStatus" x-cloak
                                @click="search = ''; filterJenis = ''; filterStatus = ''"
                                class="text-xs text-slate-500 hover:text-slate-700 px-2 py-2 rounded-lg hover:bg-slate-100 transition-colors whitespace-nowrap">
                            Reset
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-5 py-3 w-36">Nomor Surat</th>
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-3 py-3 w-24">Jenis</th>
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-3 py-3">Perihal</th>
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-3 py-3 w-36">Pengirim / Penerima</th>
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-3 py-3 w-28">Tanggal</th>
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-3 py-3 w-24">Status</th>
                                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wide px-3 py-3 w-8">File</th>
                                <th class="px-3 py-3 w-20"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="filteredSurat.length === 0">
                                <tr>
                                    <td colspan="8" class="text-center py-16">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            </div>
                                            <p class="text-sm font-medium text-slate-500">Tidak ada surat ditemukan</p>
                                            <p class="text-xs text-slate-400" x-show="search || filterJenis || filterStatus">Coba ubah filter pencarian</p>
                                            <button x-show="!search && !filterJenis && !filterStatus" @click="openModal('add')"
                                                    class="text-xs text-slate-900 font-medium hover:underline">+ Tambah surat pertama</button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-for="surat in filteredSurat" :key="surat.id">
                                <tr class="table-row border-b border-slate-50 last:border-0">
                                    <td class="px-5 py-3.5">
                                        <span class="font-mono text-xs text-slate-700 font-medium" x-text="surat.nomor_surat"></span>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium"
                                              :class="badgeJenis(surat.jenis_surat)"
                                              x-text="labelJenis(surat.jenis_surat)"></span>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <p class="text-slate-800 font-medium text-sm leading-snug" x-text="surat.perihal"></p>
                                        <p class="text-xs text-slate-400 mt-0.5" x-show="surat.instansi" x-text="surat.instansi"></p>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <p class="text-xs text-slate-600"
                                           x-text="surat.jenis_surat === 'keluar' ? (surat.penerima || '—') : (surat.pengirim || '—')"></p>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <p class="text-xs text-slate-600" x-text="formatTanggal(surat.tanggal_surat)"></p>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium capitalize"
                                              :class="badgeStatus(surat.status)"
                                              x-text="surat.status"></span>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <template x-if="surat.file_path">
                                            <a :href="'/surat-menyurat/' + surat.id + '/preview'" target="_blank"
                                               class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors text-slate-500 hover:text-slate-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        </template>
                                        <template x-if="!surat.file_path">
                                            <span class="text-slate-300">—</span>
                                        </template>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        <div class="flex items-center gap-1 justify-end">
                                            <button @click="openModal('edit', surat)"
                                                    class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center transition-colors text-slate-400 hover:text-slate-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button @click="confirmDelete(surat)"
                                                    class="w-7 h-7 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors text-slate-400 hover:text-red-500">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer --}}
                <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs text-slate-400">
                        <span x-text="filteredSurat.length"></span> dari <span x-text="suratList.length"></span> surat
                    </p>
                </div>
            </div>

        </div>{{-- end body --}}
    </main>
</div>

{{-- ===================== MODAL ADD / EDIT ===================== --}}
<div x-show="showModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-backdrop no-print"
     @keydown.escape.window="closeModal()">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col"
         @click.outside="closeModal()">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 flex-shrink-0">
            <div>
                <h2 class="text-base font-semibold text-slate-900"
                    x-text="modalMode === 'add' ? 'Tambah Surat Baru' : 'Edit Surat'"></h2>
                <p class="text-xs text-slate-400 mt-0.5"
                   x-text="modalMode === 'add' ? 'Nomor surat akan digenerate otomatis' : 'Perbarui data surat'"></p>
            </div>
            <button @click="closeModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="overflow-y-auto flex-1 px-6 py-5">
            <form @submit.prevent="submitForm()" enctype="multipart/form-data" id="suratForm">
                <div class="grid grid-cols-2 gap-4">

                    {{-- Jenis Surat --}}
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Jenis Surat <span class="text-red-500">*</span></label>
                        <select x-model="form.jenis_surat" required
                                class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 bg-white text-slate-700">
                            <option value="">— Pilih Jenis —</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                            <option value="internal">Internal / Memo</option>
                            <option value="sk">Surat Keputusan (SK)</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Status</label>
                        <select x-model="form.status"
                                class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 bg-white text-slate-700">
                            <option value="draft">Draft</option>
                            <option value="terkirim">Terkirim</option>
                            <option value="diterima">Diterima</option>
                            <option value="dibalas">Dibalas</option>
                            <option value="diarsipkan">Diarsipkan</option>
                        </select>
                    </div>

                    {{-- Perihal --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Perihal <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.perihal" required maxlength="500"
                               placeholder="Perihal surat..."
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300">
                    </div>

                    {{-- Tanggal Surat --}}
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Surat <span class="text-red-500">*</span></label>
                        <input type="date" x-model="form.tanggal_surat" required
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300">
                    </div>

                    {{-- Tanggal Diterima (hanya surat masuk) --}}
                    <div class="col-span-2 sm:col-span-1" x-show="form.jenis_surat === 'masuk'">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Diterima</label>
                        <input type="date" x-model="form.tanggal_diterima"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300">
                    </div>

                    {{-- Pengirim (masuk & internal) --}}
                    <div class="col-span-2 sm:col-span-1"
                         x-show="form.jenis_surat === 'masuk' || form.jenis_surat === 'internal' || form.jenis_surat === 'sk'">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5"
                               x-text="form.jenis_surat === 'internal' ? 'Dari (Divisi/Orang)' : 'Pengirim'"></label>
                        <input type="text" x-model="form.pengirim" maxlength="255"
                               :placeholder="form.jenis_surat === 'internal' ? 'Nama divisi atau orang...' : 'Nama pengirim...'"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300">
                    </div>

                    {{-- Penerima (keluar & internal) --}}
                    <div class="col-span-2 sm:col-span-1"
                         x-show="form.jenis_surat === 'keluar' || form.jenis_surat === 'internal'">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5"
                               x-text="form.jenis_surat === 'internal' ? 'Kepada (Divisi/Orang)' : 'Penerima'"></label>
                        <input type="text" x-model="form.penerima" maxlength="255"
                               :placeholder="form.jenis_surat === 'internal' ? 'Nama divisi atau orang...' : 'Nama penerima...'"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300">
                    </div>

                    {{-- Instansi --}}
                    <div class="col-span-2" x-show="form.jenis_surat === 'masuk' || form.jenis_surat === 'keluar'">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5"
                               x-text="form.jenis_surat === 'keluar' ? 'Instansi / Tujuan' : 'Asal Instansi'"></label>
                        <input type="text" x-model="form.instansi" maxlength="255"
                               placeholder="Nama instansi / perusahaan..."
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300">
                    </div>

                    {{-- Keterangan --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Keterangan</label>
                        <textarea x-model="form.keterangan" rows="2" maxlength="1000"
                                  placeholder="Catatan tambahan (opsional)..."
                                  class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 resize-none"></textarea>
                    </div>

                    {{-- Upload File --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Lampiran Surat</label>
                        <div class="drop-zone rounded-lg p-4 text-center cursor-pointer relative"
                             :class="dragOver ? 'active' : ''"
                             @dragover.prevent="dragOver = true"
                             @dragleave.prevent="dragOver = false"
                             @drop.prevent="handleDrop($event)"
                             @click="$refs.fileInput.click()">
                            <input type="file" x-ref="fileInput" class="hidden"
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                   @change="handleFileSelect($event)">
                            <template x-if="!selectedFile">
                                <div>
                                    <svg class="w-7 h-7 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs text-slate-500">Drag & drop atau <span class="text-slate-700 font-medium">klik untuk pilih file</span></p>
                                    <p class="text-[10px] text-slate-400 mt-1">PDF, JPG, PNG, DOC, DOCX — maks 10MB</p>
                                    <template x-if="editingItem && editingItem.file_path">
                                        <p class="text-[10px] text-blue-500 mt-1">File saat ini: <span x-text="editingItem.file_name"></span></p>
                                    </template>
                                </div>
                            </template>
                            <template x-if="selectedFile">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-xs font-medium text-slate-700" x-text="selectedFile.name"></p>
                                        <p class="text-[10px] text-slate-400" x-text="formatFileSize(selectedFile.size)"></p>
                                    </div>
                                    <button type="button" @click.stop="selectedFile = null; $refs.fileInput.value = ''"
                                            class="ml-2 text-slate-400 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>{{-- end grid --}}
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-end gap-3 flex-shrink-0">
            <button type="button" @click="closeModal()"
                    class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                Batal
            </button>
            <button type="button" @click="submitForm()" :disabled="submitting"
                    class="flex items-center gap-2 px-5 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="submitting" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span x-text="submitting ? 'Menyimpan...' : (modalMode === 'add' ? 'Simpan Surat' : 'Perbarui')"></span>
            </button>
        </div>
    </div>
</div>

{{-- ===================== MODAL KONFIRMASI HAPUS ===================== --}}
<div x-show="showDeleteModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-backdrop no-print"
     @keydown.escape.window="showDeleteModal = false">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6" @click.outside="showDeleteModal = false">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-slate-900">Hapus Surat?</h3>
                <p class="text-xs text-slate-500 mt-1">Surat <strong x-text="deletingItem?.nomor_surat"></strong> akan dihapus permanen beserta filenya.</p>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-5">
            <button @click="showDeleteModal = false"
                    class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                Batal
            </button>
            <button @click="deleteSurat()" :disabled="submitting"
                    class="px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors disabled:opacity-50">
                <span x-text="submitting ? 'Menghapus...' : 'Hapus'"></span>
            </button>
        </div>
    </div>
</div>

{{-- ===================== ALPINE JS ===================== --}}
<script>
function suratApp() {
    return {
        // Data
        suratList: @json($suratList),

        // UI state
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

        // Form state
        form: {
            jenis_surat: '',
            perihal: '',
            tanggal_surat: '',
            tanggal_diterima: '',
            pengirim: '',
            penerima: '',
            instansi: '',
            status: 'draft',
            keterangan: '',
        },

        init() {
            // sort by tanggal_surat desc on load
            this.suratList.sort((a, b) => new Date(b.tanggal_surat) - new Date(a.tanggal_surat));
        },

        // ---- Computed ----
        get filteredSurat() {
            return this.suratList.filter(s => {
                const q = this.search.toLowerCase();
                const matchSearch = !q
                    || (s.nomor_surat || '').toLowerCase().includes(q)
                    || (s.perihal || '').toLowerCase().includes(q)
                    || (s.instansi || '').toLowerCase().includes(q)
                    || (s.pengirim || '').toLowerCase().includes(q)
                    || (s.penerima || '').toLowerCase().includes(q);
                const matchJenis  = !this.filterJenis  || s.jenis_surat === this.filterJenis;
                const matchStatus = !this.filterStatus || s.status === this.filterStatus;
                return matchSearch && matchJenis && matchStatus;
            });
        },

        // ---- Helpers ----
        labelJenis(jenis) {
            return { masuk: 'Masuk', keluar: 'Keluar', internal: 'Internal', sk: 'SK' }[jenis] || jenis;
        },
        badgeJenis(jenis) {
            return {
                masuk:    'badge-masuk',
                keluar:   'badge-keluar',
                internal: 'badge-internal',
                sk:       'badge-sk',
            }[jenis] || '';
        },
        badgeStatus(status) {
            return {
                draft:      'status-draft',
                terkirim:   'status-terkirim',
                diterima:   'status-diterima',
                dibalas:    'status-dibalas',
                diarsipkan: 'status-diarsipkan',
            }[status] || 'status-draft';
        },
        formatTanggal(str) {
            if (!str) return '—';
            const d = new Date(str + 'T00:00:00');
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        },
        formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(1) + ' MB';
        },

        // ---- Modal ----
        openModal(mode, item = null) {
            this.modalMode = mode;
            this.selectedFile = null;
            if (this.$refs.fileInput) this.$refs.fileInput.value = '';
            if (mode === 'add') {
                this.editingItem = null;
                this.form = {
                    jenis_surat: '',
                    perihal: '',
                    tanggal_surat: new Date().toISOString().slice(0, 10),
                    tanggal_diterima: '',
                    pengirim: '',
                    penerima: '',
                    instansi: '',
                    status: 'draft',
                    keterangan: '',
                };
            } else {
                this.editingItem = item;
                this.form = {
                    jenis_surat:      item.jenis_surat || '',
                    perihal:          item.perihal || '',
                    tanggal_surat:    item.tanggal_surat ? item.tanggal_surat.substring(0, 10) : '',
                    tanggal_diterima: item.tanggal_diterima ? item.tanggal_diterima.substring(0, 10) : '',
                    pengirim:         item.pengirim || '',
                    penerima:         item.penerima || '',
                    instansi:         item.instansi || '',
                    status:           item.status || 'draft',
                    keterangan:       item.keterangan || '',
                };
            }
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.editingItem = null;
            this.selectedFile = null;
        },

        // ---- File handling ----
        handleDrop(event) {
            this.dragOver = false;
            const file = event.dataTransfer.files[0];
            if (file) this.selectedFile = file;
        },
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.selectedFile = file;
        },

        // ---- Submit ----
        async submitForm() {
            if (!this.form.jenis_surat || !this.form.perihal || !this.form.tanggal_surat) {
                this.showToast('Harap lengkapi field yang wajib diisi.', 'error');
                return;
            }

            this.submitting = true;
            const fd = new FormData();
            Object.entries(this.form).forEach(([k, v]) => {
                if (v !== null && v !== undefined && v !== '') fd.append(k, v);
            });
            if (this.selectedFile) fd.append('file', this.selectedFile);

            const isEdit = this.modalMode === 'edit';
            if (isEdit) fd.append('_method', 'PUT');

            const url = isEdit
                ? `/surat-menyurat/${this.editingItem.id}`
                : '/surat-menyurat';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: fd,
                });
                const data = await res.json();

                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.closeModal();
                    // Reload page to reflect changes
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    this.showToast(data.message || 'Terjadi kesalahan.', 'error');
                }
            } catch (e) {
                this.showToast('Gagal terhubung ke server.', 'error');
            } finally {
                this.submitting = false;
            }
        },

        // ---- Delete ----
        confirmDelete(item) {
            this.deletingItem = item;
            this.showDeleteModal = true;
        },
        async deleteSurat() {
            if (!this.deletingItem) return;
            this.submitting = true;
            try {
                const res = await fetch(`/surat-menyurat/${this.deletingItem.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.showDeleteModal = false;
                    this.suratList = this.suratList.filter(s => s.id !== this.deletingItem.id);
                    this.deletingItem = null;
                } else {
                    this.showToast(data.message || 'Gagal menghapus surat.', 'error');
                }
            } catch (e) {
                this.showToast('Gagal terhubung ke server.', 'error');
            } finally {
                this.submitting = false;
            }
        },

        // ---- Toast ----
        showToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 3500);
        },
    };
}
</script>
</body>
</html>
