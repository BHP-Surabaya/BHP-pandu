<x-portal-layout>
    <x-slot:title>
        History Layanan - Kepala Balai Harta Peninggalan Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ 
        items: {{ Js::from($historyLayanan) }},
        searchHistory: '',
        filterJenis: 'all',
        startDate: '',
        endDate: '',

        resetFilter() {
            this.filterJenis = 'all';
            this.startDate = '';
            this.endDate = '';
            this.searchHistory = '';
        },

        isItemVisible(item) {
            if (this.filterJenis !== 'all' && item.jenis_layanan !== this.filterJenis) {
                return false;
            }
            if (this.searchHistory) {
                const text = ((item.nomor_layanan || '') + ' ' + (item.jenis_layanan || '') + ' ' + (item.detail_layanan || '') + ' ' + (item.pemohon || '')).toLowerCase();
                if (!text.includes(this.searchHistory.toLowerCase())) {
                    return false;
                }
            }
            if (this.startDate && item.tanggal_selesai_iso < this.startDate) {
                return false;
            }
            if (this.endDate && item.tanggal_selesai_iso > this.endDate) {
                return false;
            }
            return true;
        },

        get visibleCount() {
            return this.items.filter(item => this.isItemVisible(item)).length;
        }
    }">
        
        <!-- Header Page -->
        <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    History Layanan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Daftar rekam jejak penyelesaian layanan dan rekapitulasi data layanan Balai Harta Peninggalan Surabaya.
                </p>
            </div>
            <a href="{{ route('kepala.dashboard') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- Rekapitulasi & Filter -->
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 sm:px-7 sm:py-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-gray-100">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Rekapitulasi Layanan Selesai
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5 font-normal">
                        Menampilkan <span class="font-bold text-gray-700" x-text="visibleCount"></span> dari {{ count($historyLayanan) }} riwayat layanan
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <!-- Search Input -->
                    <div class="relative w-44 sm:w-52">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchHistory" 
                               placeholder="Cari nomor/pemohon..." 
                               class="w-full pl-8 pr-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition" />
                    </div>

                    <!-- Filter Tanggal Mulai -->
                    <div class="flex items-center gap-1.5">
                        <label class="text-xs font-semibold text-gray-500 whitespace-nowrap">Mulai:</label>
                        <input type="date" 
                               x-model="startDate" 
                               class="w-36 px-2.5 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-700 shadow-2xs focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition cursor-pointer" />
                    </div>

                    <!-- Filter Tanggal Sampai -->
                    <div class="flex items-center gap-1.5">
                        <label class="text-xs font-semibold text-gray-500 whitespace-nowrap">Sampai:</label>
                        <input type="date" 
                               x-model="endDate" 
                               class="w-36 px-2.5 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-700 shadow-2xs focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition cursor-pointer" />
                    </div>

                    <button type="button" 
                            x-show="startDate || endDate || searchHistory" 
                            @click="resetFilter()"
                            class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold transition cursor-pointer">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Tabel History -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS &amp; DETAIL LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PEMOHON
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL SELESAI
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                DURASI PENYELESAIAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center">
                                STATUS
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        <template x-for="item in items" :key="item.id">
                            <tr class="hover:bg-slate-50/70 transition" x-show="isItemVisible(item)">
                                <td class="py-4 px-5">
                                    <span class="font-extrabold text-[#0c2a55] block leading-tight" x-text="item.nomor_layanan"></span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5" x-text="'Masuk: ' + item.tanggal_masuk"></span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-bold text-gray-800 block" x-text="item.jenis_layanan"></span>
                                    <span class="text-[11px] text-gray-500 block mt-0.5" x-text="item.detail_layanan"></span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-semibold text-gray-800 block" x-text="item.pemohon"></span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-bold text-gray-700 block" x-text="item.tanggal_selesai"></span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-semibold text-gray-800 block" x-text="item.durasi_hari + ' Hari'"></span>
                                    <span class="text-[10px] text-emerald-600 font-bold" x-text="item.durasi_hari <= 14 ? 'Memenuhi Standar SLA' : 'Selesai Terlambat'"></span>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>Selesai</span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</x-portal-layout>
