<x-portal-layout>
    <x-slot:title>
        History Layanan - Kepala Seksi BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ 
        items: {{ Js::from($rawHistoryLayanan ?? $historyLayanan) }},
        searchHistory: '{{ request('q', '') }}',
        filterJenis: '{{ request('jenis', 'all') }}',
        dateField: '{{ request('date_field', 'tanggal_masuk') }}',
        startDate: '{{ request('start_date', '') }}',
        endDate: '{{ request('end_date', '') }}',
        filterDropdownOpen: false,

        resetFilter() {
            this.filterJenis = 'all';
            this.startDate = '';
            this.endDate = '';
            this.searchHistory = '';
        },

        isItemVisible(jenis, text, isoMasuk, isoSelesai) {
            if (this.filterJenis !== 'all' && jenis !== this.filterJenis) {
                return false;
            }
            if (this.searchHistory && !text.includes(this.searchHistory.toLowerCase())) {
                return false;
            }
            let targetDate = this.dateField === 'tanggal_selesai' ? isoSelesai : isoMasuk;
            if (this.startDate && (!targetDate || targetDate < this.startDate)) {
                return false;
            }
            if (this.endDate && (!targetDate || targetDate > this.endDate)) {
                return false;
            }
            return true;
        },

        get activeFilterCount() {
            let count = 0;
            if (this.filterJenis !== 'all') count++;
            if (this.startDate || this.endDate) count++;
            return count;
        },

        get visibleCount() {
            return this.items.filter(item => {
                let text = ((item.nomor_layanan || '') + ' ' + (item.jenis_layanan || '') + ' ' + (item.detail_layanan || '') + ' ' + (item.pemohon || '')).toLowerCase();
                return this.isItemVisible(item.jenis_layanan, text, item.tanggal_masuk_iso || '', item.tanggal_selesai_iso || '');
            }).length;
        },

        get skhwCount() {
            return this.items.filter(item => {
                let text = ((item.nomor_layanan || '') + ' ' + (item.jenis_layanan || '') + ' ' + (item.detail_layanan || '') + ' ' + (item.pemohon || '')).toLowerCase();
                return this.isItemVisible('SKHW', text, item.tanggal_masuk_iso || '', item.tanggal_selesai_iso || '');
            }).length;
        },

        get wasiatCount() {
            return this.items.filter(item => {
                let text = ((item.nomor_layanan || '') + ' ' + (item.jenis_layanan || '') + ' ' + (item.detail_layanan || '') + ' ' + (item.pemohon || '')).toLowerCase();
                return this.isItemVisible('Wasiat', text, item.tanggal_masuk_iso || '', item.tanggal_selesai_iso || '');
            }).length;
        },

        getDateRangeLabel() {
            if (this.startDate && this.endDate) {
                return this.formatDateDisplay(this.startDate) + ' - ' + this.formatDateDisplay(this.endDate);
            } else if (this.startDate) {
                return 'Dari ' + this.formatDateDisplay(this.startDate);
            } else if (this.endDate) {
                return 'Sampai ' + this.formatDateDisplay(this.endDate);
            }
            return '';
        },

        formatDateDisplay(dateStr) {
            if (!dateStr) return '';
            const parts = dateStr.split('-');
            if (parts.length === 3) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const mIdx = parseInt(parts[1], 10) - 1;
                return parts[2] + ' ' + (months[mIdx] || parts[1]) + ' ' + parts[0];
            }
            return dateStr;
        }
    }">
        
        <!-- Header Page -->
        <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    History Layanan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Daftar rekam jejak penyelesaian layanan dan rekapitulasi data layanan BHP Surabaya.
                </p>
            </div>
            <a href="{{ route('kasi.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Disposisi</span>
            </a>
        </div>

        <!-- ======================================================== -->
        <!-- KARTU RINGKASAN REKAPITULASI (MODEL SEJAJAR SEPERTI DISPOSISI) -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
            <!-- Card 1: Layanan Masuk -->
            <div @click="filterJenis = 'all'" 
                 class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-emerald-200 hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight" x-text="visibleCount">
                        {{ $statsHistory['layanan_masuk'] ?? count($historyLayanan) }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Layanan Masuk
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-emerald-600 leading-snug truncate">
                            Total Riwayat
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Layanan Selesai -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-teal-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 border border-teal-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight" x-text="visibleCount">
                        {{ $statsHistory['layanan_selesai'] ?? count($historyLayanan) }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Layanan Selesai
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-teal-600 leading-snug truncate">
                            Telah Terkirim
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 3: SLA Perhatian (Kuning) -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-amber-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 border border-amber-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-amber-600 leading-none shrink-0 tracking-tight">
                        {{ $statsHistory['sla_kuning'] ?? 1 }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            SLA Perhatian
                        </span>
                        <span class="text-[11px] sm:text-xs font-bold text-amber-600 leading-snug truncate">
                            Kuning (Hari 8-12)
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 4: SLA Mendesak (Merah) -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-rose-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 border border-rose-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-rose-600 leading-none shrink-0 tracking-tight">
                        {{ $statsHistory['sla_merah'] ?? 2 }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                                SLA Mendesak
                            </span>
                            @if (($statsHistory['sla_merah'] ?? 2) > 0)
                                <span class="relative flex h-2 w-2 shrink-0">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                </span>
                            @endif
                        </div>
                        <span class="text-[11px] sm:text-xs font-bold text-rose-600 leading-snug truncate">
                            Merah (Hari 13-14)
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION: REKAPITULASI DATA LAYANAN (PERSIS WIREFRAME)   -->
        <!-- ======================================================== -->
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Header Section with Title, Subtitle, and Filter Buttons -->
            <div class="px-6 py-5 sm:px-7 sm:py-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-gray-100">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Rekapitulasi Data Layanan
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5 font-normal">
                        Daftar layanan yang telah selesai dan dikirim kepada pemohon
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <!-- Search Input -->
                    <div class="relative w-40 sm:w-52">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchHistory" 
                               placeholder="Cari nomor/pemohon..." 
                               class="w-full pl-8 pr-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0d5c46]/20 focus:border-[#0d5c46] transition" />
                    </div>

                    <!-- Filter Tanggal Mulai -->
                    <div class="flex items-center gap-1.5">
                        <label for="filter_start_date" class="text-xs font-semibold text-gray-500 whitespace-nowrap">Mulai:</label>
                        <input type="date" 
                               id="filter_start_date"
                               x-model="startDate" 
                               class="w-36 px-2.5 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-700 shadow-2xs focus:outline-none focus:ring-2 focus:ring-[#0d5c46]/20 focus:border-[#0d5c46] transition cursor-pointer" />
                    </div>

                    <!-- Filter Tanggal Sampai -->
                    <div class="flex items-center gap-1.5">
                        <label for="filter_end_date" class="text-xs font-semibold text-gray-500 whitespace-nowrap">Sampai:</label>
                        <input type="date" 
                               id="filter_end_date"
                               x-model="endDate" 
                               class="w-36 px-2.5 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-700 shadow-2xs focus:outline-none focus:ring-2 focus:ring-[#0d5c46]/20 focus:border-[#0d5c46] transition cursor-pointer" />
                    </div>

                    <!-- Reset Tanggal jika terisi -->
                    <button type="button" 
                            x-show="startDate || endDate" 
                            @click="startDate = ''; endDate = ''"
                            title="Reset Tanggal"
                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl border border-gray-200 bg-white hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 text-gray-500 text-xs font-medium shadow-2xs transition cursor-pointer"
                            style="display: none;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Reset</span>
                    </button>

                    <!-- Filter Layanan Button & Popover -->
                    <div class="relative">
                        <button type="button" 
                                @click="filterDropdownOpen = !filterDropdownOpen"
                                :class="filterJenis !== 'all' ? 'border-[#0d5c46] bg-emerald-50/70 text-[#0d5c46] font-bold ring-1 ring-[#0d5c46]/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50 font-semibold'"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs shadow-2xs transition cursor-pointer">
                            <svg class="w-3.5 h-3.5" :class="filterJenis !== 'all' ? 'text-[#0d5c46]' : 'text-gray-500'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>
                            <span>Filter Layanan</span>
                            <span x-show="filterJenis !== 'all'" class="w-1.5 h-1.5 rounded-full bg-[#0d5c46]" style="display: none;"></span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="filterDropdownOpen" 
                             @click.away="filterDropdownOpen = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 p-2 z-20 space-y-1 text-xs"
                             style="display: none;">
                            <div class="px-2.5 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jenis Layanan</div>
                            <button type="button" @click="filterJenis = 'all'; filterDropdownOpen = false" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-gray-50 flex items-center justify-between cursor-pointer" :class="filterJenis === 'all' ? 'text-[#0d5c46] font-bold bg-emerald-50/60' : 'text-gray-700'">
                                <span>Semua Jenis</span>
                                <span class="text-[10px] text-gray-400" x-text="items.length">12</span>
                            </button>
                            <button type="button" @click="filterJenis = 'SKHW'; filterDropdownOpen = false" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-gray-50 flex items-center justify-between cursor-pointer" :class="filterJenis === 'SKHW' ? 'text-[#0d5c46] font-bold bg-emerald-50/60' : 'text-gray-700'">
                                <span>SKHW</span>
                                <span class="text-[10px] text-gray-400" x-text="skhwCount">6</span>
                            </button>
                            <button type="button" @click="filterJenis = 'Wasiat'; filterDropdownOpen = false" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-gray-50 flex items-center justify-between cursor-pointer" :class="filterJenis === 'Wasiat' ? 'text-[#0d5c46] font-bold bg-emerald-50/60' : 'text-gray-700'">
                                <span>Wasiat</span>
                                <span class="text-[10px] text-gray-400" x-text="wasiatCount">6</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters Strip -->
            <div x-show="startDate || endDate || filterJenis !== 'all' || searchHistory" 
                 class="px-6 py-2.5 bg-emerald-50/40 border-b border-gray-100 flex flex-wrap items-center gap-2 text-xs"
                 style="display: none;">
                <span class="text-[11px] font-semibold text-gray-500">Filter Aktif:</span>

                <!-- Chip Rentang Tanggal -->
                <template x-if="startDate || endDate">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-emerald-200 text-[#0d5c46] font-medium text-[11px] shadow-2xs">
                        <svg class="w-3 h-3 text-[#0d5c46]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-text="'Tanggal: ' + getDateRangeLabel()"></span>
                        <button type="button" @click="startDate = ''; endDate = ''" class="hover:text-rose-600 transition ml-0.5 cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </span>
                </template>

                <!-- Chip Jenis Layanan -->
                <template x-if="filterJenis !== 'all'">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-emerald-200 text-[#0d5c46] font-medium text-[11px] shadow-2xs">
                        <span>Jenis: <strong x-text="filterJenis"></strong></span>
                        <button type="button" @click="filterJenis = 'all'" class="hover:text-rose-600 transition ml-0.5 cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </span>
                </template>

                <!-- Chip Pencarian -->
                <template x-if="searchHistory">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-gray-200 text-gray-700 font-medium text-[11px] shadow-2xs">
                        <span>Cari: "<strong x-text="searchHistory"></strong>"</span>
                        <button type="button" @click="searchHistory = ''" class="hover:text-rose-600 transition ml-0.5 cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </span>
                </template>

                <!-- Tombol Hapus Semua Filter -->
                <button type="button" 
                        @click="resetFilter()" 
                        class="text-[11px] font-semibold text-rose-600 hover:text-rose-700 hover:underline ml-1 cursor-pointer">
                    Hapus Semua
                </button>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                DETAIL LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PEMOHON
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL MASUK
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL DISPOSISI
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL SELESAI
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                DURASI LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                HASIL
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse (($rawHistoryLayanan ?? $historyLayanan) as $item)
                            <tr class="hover:bg-gray-50/60 transition group"
                                x-show="isItemVisible('{{ $item['jenis_layanan'] }}', '{{ strtolower($item['nomor_layanan'].' '.$item['jenis_layanan'].' '.$item['detail_layanan'].' '.$item['pemohon']) }}', '{{ $item['tanggal_masuk_iso'] ?? '' }}', '{{ $item['tanggal_selesai_iso'] ?? '' }}')">
                                
                                <!-- Nomor Layanan -->
                                <td class="py-4 px-6 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item['nomor_layanan'] }}
                                </td>

                                <!-- Jenis Layanan Badge -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if ($item['jenis_layanan'] === 'SKHW')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#e0f2fe] text-[#0284c7] border border-[#bae6fd]">
                                            SKHW
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#f3e8ff] text-[#9333ea] border border-[#e9d5ff]">
                                            Wasiat
                                        </span>
                                    @endif
                                </td>

                                <!-- Detail Layanan -->
                                <td class="py-4 px-6 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item['detail_layanan'] }}
                                </td>

                                <!-- Pemohon -->
                                <td class="py-4 px-6 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $item['pemohon'] }}
                                </td>

                                <!-- Tanggal Masuk -->
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_masuk'] ?? '28 Mei 2025' }}
                                </td>

                                <!-- Tanggal Disposisi -->
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_disposisi'] }}
                                </td>

                                <!-- Tanggal Selesai -->
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_selesai'] ?? $item['selesai_pada'] ?? '30 Mei 2025' }}
                                </td>

                                <!-- Durasi Layanan -->
                                <td class="py-4 px-6 font-bold text-gray-900 whitespace-nowrap">
                                    {{ $item['durasi_layanan'] ?? '3 hari kerja' }}
                                </td>

                                <!-- Hasil Column (Selesai Pill & Subtext) -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#f0fdf4] text-[#15803d] border border-[#dcfce7] text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-[#15803d]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span>Selesai</span>
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-1 font-normal">
                                        {{ $item['keterangan_hasil'] ?? 'Dikirim ke akun pemohon' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-400">
                                    Tidak ada riwayat layanan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse

                        <!-- Empty State saat filter tidak menemukan hasil -->
                        <tr x-show="visibleCount === 0 && {{ count($rawHistoryLayanan ?? $historyLayanan) }} > 0" style="display: none;">
                            <td colspan="9" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-gray-700 text-xs">Tidak ada riwayat layanan yang sesuai kriteria filter.</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Coba ubah rentang tanggal, jenis layanan, atau kata kunci pencarian.</p>
                                    <button type="button" @click="resetFilter()" class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-[#0d5c46] bg-emerald-50 hover:bg-emerald-100 rounded-lg transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        <span>Reset Filter</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-portal-layout>

