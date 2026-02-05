<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Asset Register
        </h2>
    </x-slot>

    <style>
        .table-row {
            transition: all 0.2s ease;
        }
        .table-row:hover {
            background: rgba(37, 99, 235, 0.05);
        }
        .status-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .modal-backdrop {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(4px);
        }
    </style>

    <div class="py-6" x-data="assetRegister()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('inventory.index') }}" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <i class="fa-solid fa-arrow-left text-gray-600 dark:text-gray-400"></i>
                    </a>
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Asset Register</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest mt-1">Daftar Aset Terkapitalisasi</p>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center gap-3">
                    <div class="relative">
                        <input type="text" x-model="searchQuery" placeholder="Search assets..." class="pl-10 pr-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button @click="openModal()" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Asset</span>
                    </button>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Total Assets</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white" x-text="assets.length"></p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Active</p>
                    <p class="text-2xl font-black text-emerald-600" x-text="assets.filter(a => a.status === 'Active').length"></p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Damaged</p>
                    <p class="text-2xl font-black text-rose-600" x-text="assets.filter(a => a.condition === 'Damaged').length"></p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 font-bold uppercase">Loaned</p>
                    <p class="text-2xl font-black text-purple-600" x-text="assets.filter(a => a.status === 'Loaned').length"></p>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Code</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Asset Name</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Category</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Cost</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Book Value</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-500 uppercase tracking-widest">Condition</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-500 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <template x-for="asset in filteredAssets" :key="asset.id">
                                <tr class="table-row">
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-mono font-bold text-blue-600 bg-blue-50 dark:bg-blue-500/20 px-2 py-1 rounded" x-text="asset.code"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white text-sm" x-text="asset.name"></p>
                                            <p class="text-xs text-gray-500" x-text="asset.location || 'No location'"></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-gray-600 dark:text-gray-300" x-text="asset.category"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white tabular-nums" x-text="formatCurrency(asset.cost)"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-emerald-600 tabular-nums" x-text="formatCurrency(asset.book_value)"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-badge" :class="getStatusClass(asset.status)" x-text="asset.status"></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-badge" :class="asset.condition === 'Good' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400'" x-text="asset.condition"></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="editAsset(asset)" class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-500/30 flex items-center justify-center transition-colors">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <template x-if="asset.status !== 'Loaned'">
                                                <button @click="openLoanModal(asset)" class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-500/20 text-purple-600 hover:bg-purple-100 dark:hover:bg-purple-500/30 flex items-center justify-center transition-colors">
                                                    <i class="fa-solid fa-hand-holding text-xs"></i>
                                                </button>
                                            </template>
                                            <template x-if="asset.status === 'Loaned'">
                                                <button @click="returnAsset(asset)" class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-500/30 flex items-center justify-center transition-colors">
                                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                                </button>
                                            </template>
                                            <button @click="deleteAsset(asset)" class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-500/20 text-rose-600 hover:bg-rose-100 dark:hover:bg-rose-500/30 flex items-center justify-center transition-colors">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="filteredAssets.length === 0">
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                                <i class="fa-solid fa-box-open text-2xl text-gray-400"></i>
                                            </div>
                                            <p class="text-gray-500 font-medium">No assets found</p>
                                            <p class="text-xs text-gray-400 mt-1">Add your first asset to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="modal-backdrop absolute inset-0" @click="closeModal()"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white" x-text="editingAsset ? 'Edit Asset' : 'Add New Asset'"></h3>
                </div>
                <form @submit.prevent="saveAsset()" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Asset Name *</label>
                        <input type="text" x-model="form.name" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Category *</label>
                            <select x-model="form.category" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                                <option value="">Select...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Acquisition Date *</label>
                            <input type="date" x-model="form.acquisition_date" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Cost (Rp) *</label>
                        <input type="number" x-model="form.cost" required min="0" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Location</label>
                        <input type="text" x-model="form.location" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Status *</label>
                            <select x-model="form.status" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Condition *</label>
                            <select x-model="form.condition" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500">
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition }}">{{ $condition }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-bold hover:shadow-lg transition-all" :disabled="saving">
                            <span x-show="!saving" x-text="editingAsset ? 'Update' : 'Save'"></span>
                            <span x-show="saving"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loan Modal -->
        <div x-show="showLoanModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="modal-backdrop absolute inset-0" @click="closeLoanModal()"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md" @click.stop>
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">Loan Asset</h3>
                    <p class="text-sm text-gray-500 mt-1" x-text="loaningAsset?.name"></p>
                </div>
                <form @submit.prevent="confirmLoan()" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Loaned To *</label>
                        <input type="text" x-model="loanTo" required placeholder="Enter recipient name..." class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="closeLoanModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-bold">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-bold">Confirm Loan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function assetRegister() {
            return {
                assets: @json($assets),
                searchQuery: '',
                showModal: false,
                showLoanModal: false,
                editingAsset: null,
                loaningAsset: null,
                loanTo: '',
                saving: false,
                form: {
                    name: '',
                    category: '',
                    acquisition_date: '',
                    cost: '',
                    location: '',
                    status: 'Active',
                    condition: 'Good',
                },

                get filteredAssets() {
                    if (!this.searchQuery) return this.assets;
                    const q = this.searchQuery.toLowerCase();
                    return this.assets.filter(a =>
                        a.name.toLowerCase().includes(q) ||
                        a.code.toLowerCase().includes(q) ||
                        a.category.toLowerCase().includes(q)
                    );
                },

                formatCurrency(val) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
                },

                getStatusClass(status) {
                    const classes = {
                        'Active': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                        'Disposed': 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-400',
                        'Damaged': 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400',
                        'In-Repair': 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
                        'Maintenance': 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400',
                        'Loaned': 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400',
                    };
                    return classes[status] || classes['Active'];
                },

                openModal() {
                    this.editingAsset = null;
                    this.form = { name: '', category: '', acquisition_date: '', cost: '', location: '', status: 'Active', condition: 'Good' };
                    this.showModal = true;
                },

                editAsset(asset) {
                    this.editingAsset = asset;
                    this.form = {
                        name: asset.name,
                        category: asset.category,
                        acquisition_date: asset.acquisition_date,
                        cost: asset.cost,
                        location: asset.location || '',
                        status: asset.status,
                        condition: asset.condition,
                    };
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                    this.editingAsset = null;
                },

                async saveAsset() {
                    this.saving = true;
                    const url = this.editingAsset ? `/inventory/${this.editingAsset.id}` : '/inventory';
                    const method = this.editingAsset ? 'PUT' : 'POST';

                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(this.form),
                        });
                        const data = await response.json();
                        if (data.success) {
                            if (this.editingAsset) {
                                const index = this.assets.findIndex(a => a.id === this.editingAsset.id);
                                this.assets[index] = data.asset;
                            } else {
                                this.assets.unshift(data.asset);
                            }
                            this.closeModal();
                        } else {
                            alert(data.message || 'Error saving asset');
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                    this.saving = false;
                },

                async deleteAsset(asset) {
                    if (!confirm(`Delete "${asset.name}"?`)) return;
                    try {
                        const response = await fetch(`/inventory/${asset.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.assets = this.assets.filter(a => a.id !== asset.id);
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                },

                openLoanModal(asset) {
                    this.loaningAsset = asset;
                    this.loanTo = '';
                    this.showLoanModal = true;
                },

                closeLoanModal() {
                    this.showLoanModal = false;
                    this.loaningAsset = null;
                },

                async confirmLoan() {
                    if (!this.loanTo) return;
                    try {
                        const response = await fetch(`/inventory/${this.loaningAsset.id}/loan`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({ loaned_to: this.loanTo }),
                        });
                        const data = await response.json();
                        if (data.success) {
                            const index = this.assets.findIndex(a => a.id === this.loaningAsset.id);
                            this.assets[index] = data.asset;
                            this.closeLoanModal();
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                },

                async returnAsset(asset) {
                    if (!confirm(`Return "${asset.name}" from loan?`)) return;
                    try {
                        const response = await fetch(`/inventory/${asset.id}/return`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });
                        const data = await response.json();
                        if (data.success) {
                            const index = this.assets.findIndex(a => a.id === asset.id);
                            this.assets[index] = data.asset;
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                },
            }
        }
    </script>
</x-app-layout>
