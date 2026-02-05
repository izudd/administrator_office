<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Audit Trail
        </h2>
    </x-slot>

    <style>
        .log-item {
            transition: all 0.2s ease;
        }
        .log-item:hover {
            background: rgba(37, 99, 235, 0.03);
        }
        .action-badge {
            font-size: 9px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('inventory.index') }}" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <i class="fa-solid fa-arrow-left text-gray-600 dark:text-gray-400"></i>
                    </a>
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Change Ledger</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest mt-1">Compliance & Audit Trail</p>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center gap-3">
                    <div class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center gap-3 shadow-sm">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span class="text-[10px] font-black text-gray-600 dark:text-gray-300 uppercase tracking-widest">Immutable Log Active</span>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Total Entries</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $logs->total() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Creates</p>
                    <p class="text-2xl font-black text-emerald-600">{{ $logs->where('action', 'CREATE')->count() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Updates</p>
                    <p class="text-2xl font-black text-blue-600">{{ $logs->where('action', 'UPDATE')->count() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Deletes</p>
                    <p class="text-2xl font-black text-rose-600">{{ $logs->where('action', 'DELETE')->count() }}</p>
                </div>
            </div>

            <!-- Logs List -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                @forelse($logs as $log)
                    <div class="log-item p-6 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                @if($log->action === 'CREATE') bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600
                                @elseif($log->action === 'UPDATE') bg-blue-100 dark:bg-blue-500/20 text-blue-600
                                @elseif($log->action === 'DELETE') bg-rose-100 dark:bg-rose-500/20 text-rose-600
                                @elseif($log->action === 'LOAN') bg-purple-100 dark:bg-purple-500/20 text-purple-600
                                @elseif($log->action === 'RETURN') bg-cyan-100 dark:bg-cyan-500/20 text-cyan-600
                                @else bg-gray-100 dark:bg-gray-700 text-gray-600
                                @endif
                            ">
                                @if($log->action === 'CREATE')
                                    <i class="fa-solid fa-plus"></i>
                                @elseif($log->action === 'UPDATE')
                                    <i class="fa-solid fa-pen"></i>
                                @elseif($log->action === 'DELETE')
                                    <i class="fa-solid fa-trash"></i>
                                @elseif($log->action === 'LOAN')
                                    <i class="fa-solid fa-hand-holding"></i>
                                @elseif($log->action === 'RETURN')
                                    <i class="fa-solid fa-rotate-left"></i>
                                @else
                                    <i class="fa-solid fa-circle-info"></i>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="action-badge
                                        @if($log->action === 'CREATE') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400
                                        @elseif($log->action === 'UPDATE') bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400
                                        @elseif($log->action === 'DELETE') bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400
                                        @elseif($log->action === 'LOAN') bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400
                                        @elseif($log->action === 'RETURN') bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400
                                        @else bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-400
                                        @endif
                                    ">{{ $log->action }}</span>
                                    <span class="text-xs font-mono text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ $log->operation_code }}</span>
                                </div>
                                <p class="font-bold text-gray-900 dark:text-white">{{ $log->asset_name }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $log->description }}</p>
                                <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-user"></i>
                                        {{ $log->user_name }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-shield"></i>
                                        {{ $log->user_role }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-clock"></i>
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Snapshots -->
                            @if($log->previous_snapshot || $log->new_snapshot)
                                <div class="hidden sm:block">
                                    <button onclick="toggleSnapshot({{ $log->id }})" class="text-xs text-blue-600 hover:text-blue-700 font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-code"></i>
                                        View Changes
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Snapshot Detail -->
                        @if($log->previous_snapshot || $log->new_snapshot)
                            <div id="snapshot-{{ $log->id }}" class="hidden mt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($log->previous_snapshot)
                                        <div>
                                            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Previous State</p>
                                            <pre class="text-xs text-gray-600 dark:text-gray-300 overflow-x-auto">{{ json_encode($log->previous_snapshot, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                    @if($log->new_snapshot)
                                        <div>
                                            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">New State</p>
                                            <pre class="text-xs text-gray-600 dark:text-gray-300 overflow-x-auto">{{ json_encode($log->new_snapshot, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-clock-rotate-left text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No audit logs yet</p>
                        <p class="text-xs text-gray-400 mt-1">Changes will be recorded here</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if($logs->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleSnapshot(id) {
            const el = document.getElementById('snapshot-' + id);
            el.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
