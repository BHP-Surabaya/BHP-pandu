<x-portal-layout>
    <x-slot:title>
        Disposisi &amp; Pemantauan SLA Layanan - Kepala Seksi BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-7" x-data="{
        searchLayanan: '',
        filterSla: 'all',
        disposisiModalOpen: false,
        tindakLanjutModalOpen: false,
        selectedItem: null,
        selectedPics: [],
        alasanKeterlambatan: '',
        komitmenPenyelesaian: '',

        scrollToSection(id) {
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },

        openDisposisiModal(item) {
            this.selectedItem = item;
            this.selectedPics = [];
            this.disposisiModalOpen = true;
        },

        toggleKurator(name, tier) {
            if (tier === 'madya') {
                const madyaList = ['Inara', 'Lisa'];
                if (this.selectedPics.includes(name)) {
                    this.selectedPics = this.selectedPics.filter(p => p !== name);
                } else {
                    this.selectedPics = this.selectedPics.filter(p => !madyaList.includes(p));
                    this.selectedPics.push(name);
                }
            } else {
                if (this.selectedPics.includes(name)) {
                    this.selectedPics = this.selectedPics.filter(p => p !== name);
                } else {
                    this.selectedPics.push(name);
                }
            }
        },

        isPicSelected(name) {
            return this.selectedPics.includes(name);
        },

        openTindakLanjutModal(item) {
            this.selectedItem = item;
            this.alasanKeterlambatan = '';
            this.komitmenPenyelesaian = '';
            this.tindakLanjutModalOpen = true;
        }
    }">

        <!-- Header Page -->
        <div class="pb-4 border-b border-gray-200">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                Disposisi Layanan &amp; Pemantauan SLA
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Portal Pelayanan Kepala Seksi (KASI) Balai Harta Peninggalan Surabaya.
            </p>
        </div>

        <!-- Flash Message Notification -->
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('success') }}
                </div>
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-sm flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('info') }}
                </div>
                <button type="button" @click="show = false" class="text-blue-700 hover:text-blue-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- KOMPONEN BAR RINGKASAN DISPOSISI & SLA (SEJAJAR KESAMPING) -->
        <!-- ======================================================== -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-2.5 sm:p-3">
            <div class="grid grid-cols-4 divide-x divide-gray-100">
                <!-- Item 1: Perlu Disposisi -->
                <div @click="scrollToSection('layanan-baru')" 
                     class="flex items-center gap-3 px-3 sm:px-4 py-1.5 rounded-xl hover:bg-emerald-50/50 transition group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <div class="flex items-baseline gap-2 min-w-0">
                        <span class="text-2xl font-black text-gray-900 leading-none">
                            {{ $stats['perlu_disposisi'] ?? $totalLayananBaru }}
                        </span>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-gray-800 leading-tight truncate">Perlu Disposisi</span>
                            <span class="block text-[10px] text-emerald-600 font-medium leading-tight truncate">Layanan Baru</span>
                        </div>
                    </div>
                </div>

                <!-- Item 2: SLA Berjalan -->
                <div @click="filterSla = 'all'; scrollToSection('pemantauan-sla')" 
                     class="flex items-center gap-3 px-3 sm:px-4 py-1.5 rounded-xl hover:bg-blue-50/50 transition group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex items-baseline gap-2 min-w-0">
                        <span class="text-2xl font-black text-gray-900 leading-none">
                            {{ $stats['sla_berjalan'] ?? $totalSla }}
                        </span>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-gray-800 leading-tight truncate">SLA Berjalan</span>
                            <span class="block text-[10px] text-blue-600 font-medium leading-tight truncate">Proses PIC</span>
                        </div>
                    </div>
                </div>

                <!-- Item 3: SLA Mendesak -->
                <div @click="filterSla = 'danger'; scrollToSection('pemantauan-sla')" 
                     class="flex items-center gap-3 px-3 sm:px-4 py-1.5 rounded-xl hover:bg-rose-50/50 transition group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="flex items-baseline gap-2 min-w-0">
                        <span class="text-2xl font-black text-rose-600 leading-none">
                            {{ $stats['sla_mendesak'] ?? 0 }}
                        </span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="block text-xs font-bold text-gray-800 leading-tight truncate">SLA Mendesak</span>
                                @if (($stats['sla_mendesak'] ?? 0) > 0)
                                    <span class="relative flex h-1.5 w-1.5 shrink-0">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-rose-500"></span>
                                    </span>
                                @endif
                            </div>
                            <span class="block text-[10px] text-rose-600 font-bold leading-tight truncate">Hari 13-14</span>
                        </div>
                    </div>
                </div>

                <!-- Item 4: SLA Terkendali -->
                <div @click="filterSla = 'normal'; scrollToSection('pemantauan-sla')" 
                     class="flex items-center gap-3 px-3 sm:px-4 py-1.5 rounded-xl hover:bg-teal-50/50 transition group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 border border-teal-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <div class="flex items-baseline gap-2 min-w-0">
                        <span class="text-2xl font-black text-emerald-700 leading-none">
                            {{ ($stats['sla_normal'] ?? 0) + ($stats['sla_perhatian'] ?? 0) }}
                        </span>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-gray-800 leading-tight truncate">SLA Terkendali</span>
                            <span class="block text-[10px] text-emerald-600 font-medium leading-tight truncate">Hari 1-12</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 1: LAYANAN BARU (BELUM DIDISPOSISIKAN) -->
        <section id="layanan-baru" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden scroll-mt-6">
            <!-- Header Section -->
            <div class="px-6 py-5 sm:px-7 sm:py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                            Layanan Baru
                        </h2>
                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 text-xs font-bold rounded-full bg-gray-100 text-gray-800">
                            {{ $totalLayananBaru }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 font-normal">
                        Layanan masuk yang belum didisposisikan, urut dari terbaru
                    </p>
                </div>

                <!-- Search Input Bar -->
                <div class="w-full md:w-72">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <!-- Search Icon -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchLayanan" 
                               placeholder="Cari layanan..." 
                               class="w-full pl-9 pr-3.5 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0d5c46]/20 focus:border-[#0d5c46] transition" />
                        <button x-show="searchLayanan.length > 0" 
                                @click="searchLayanan = ''" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                style="display: none;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
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
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center">
                                AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($layananBaru as $item)
                            <tr class="hover:bg-gray-50/60 transition group"
                                x-show="!searchLayanan || '{{ strtolower($item['nomor_layanan'].' '.$item['jenis_layanan'].' '.$item['detail_layanan'].' '.$item['pemohon']) }}'.includes(searchLayanan.toLowerCase())">
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
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $item['tanggal_masuk'] }}</div>
                                    <div class="text-[11px] text-gray-400 font-normal">{{ $item['waktu_masuk'] }}</div>
                                </td>

                                <!-- Aksi Disposisikan Button (Wireframe Match) -->
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <button @click="openDisposisiModal({{ json_encode($item) }})" 
                                            type="button" 
                                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl border border-gray-200 bg-white hover:border-[#0d5c46] hover:text-[#0d5c46] hover:bg-emerald-50/50 text-gray-700 text-xs font-semibold shadow-2xs transition active:scale-95 cursor-pointer">
                                        <span>Disposisikan</span>
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    Tidak ada layanan baru yang menunggu disposisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: PEMANTAUAN SLA LAYANAN -->
        <section id="pemantauan-sla" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden scroll-mt-6">
            <!-- Header Section with SLA Legend (Interactive Filter) -->
            <div class="px-6 py-5 sm:px-7 sm:py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                            Pemantauan SLA Layanan
                        </h2>
                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 text-xs font-bold rounded-full bg-gray-100 text-gray-700">
                            {{ $totalSla }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 font-normal">
                        Layanan yang telah didisposisikan dan belum diselesaikan dalam SLA 14 hari kerja
                    </p>
                </div>

                <!-- SLA Legend & Quick Filter Buttons (Wireframe Match + Interactive) -->
                <div class="flex flex-wrap items-center gap-1.5 p-1 bg-gray-50/90 rounded-xl border border-gray-100 text-xs">
                    <button type="button" 
                            @click="filterSla = 'all'"
                            :class="filterSla === 'all' ? 'bg-white text-gray-900 font-bold shadow-2xs border-gray-200' : 'text-gray-500 hover:text-gray-900 border-transparent'"
                            class="px-3 py-1 rounded-lg border text-[11px] transition cursor-pointer">
                        Semua ({{ $totalSla }})
                    </button>
                    <button type="button" 
                            @click="filterSla = (filterSla === 'normal' ? 'all' : 'normal')"
                            :class="filterSla === 'normal' ? 'bg-emerald-50 text-emerald-800 font-bold border-emerald-200 shadow-2xs' : 'text-gray-600 hover:text-gray-900 border-transparent'"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border text-[11px] transition cursor-pointer">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                        <span>1-7 hari</span>
                        <span class="text-[10px] text-gray-400 font-normal">({{ $stats['sla_normal'] ?? 0 }})</span>
                    </button>
                    <button type="button" 
                            @click="filterSla = (filterSla === 'warning' ? 'all' : 'warning')"
                            :class="filterSla === 'warning' ? 'bg-amber-50 text-amber-800 font-bold border-amber-200 shadow-2xs' : 'text-gray-600 hover:text-gray-900 border-transparent'"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border text-[11px] transition cursor-pointer">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shrink-0"></span>
                        <span>8-12 hari</span>
                        <span class="text-[10px] text-gray-400 font-normal">({{ $stats['sla_perhatian'] ?? 0 }})</span>
                    </button>
                    <button type="button" 
                            @click="filterSla = (filterSla === 'danger' ? 'all' : 'danger')"
                            :class="filterSla === 'danger' ? 'bg-rose-50 text-rose-800 font-bold border-rose-200 shadow-2xs' : 'text-gray-600 hover:text-gray-900 border-transparent'"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border text-[11px] transition cursor-pointer">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span>
                        <span>13-14 hari</span>
                        <span class="text-[10px] text-rose-600 font-bold">({{ $stats['sla_mendesak'] ?? 0 }})</span>
                    </button>
                </div>
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
                                TANGGAL DISPOSISI
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PIC
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                SLA
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-right">
                                TINDAKAN
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($pemantauanSla as $sla)
                            <tr class="hover:bg-gray-50/60 transition group"
                                x-show="filterSla === 'all' || filterSla === '{{ $sla['sla_level'] }}'">
                                <!-- Nomor Layanan -->
                                <td class="py-4 px-6 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $sla['nomor_layanan'] }}
                                </td>

                                <!-- Jenis Layanan Badge -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if ($sla['jenis_layanan'] === 'SKHW')
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
                                    {{ $sla['detail_layanan'] }}
                                </td>

                                <!-- Pemohon -->
                                <td class="py-4 px-6 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $sla['pemohon'] }}
                                </td>

                                <!-- Tanggal Disposisi -->
                                <td class="py-4 px-6 text-gray-800 font-medium whitespace-nowrap">
                                    {{ $sla['tanggal_disposisi'] }}
                                </td>

                                <!-- PIC Pills (Januar, Indra, etc.) -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @foreach ((array) $sla['pic'] as $picName)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[11px] font-medium border border-gray-200/60">
                                                {{ $picName }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- SLA Box Container (Color-coded based on days) -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if ($sla['sla_level'] === 'danger')
                                        <!-- Mendesak: 13-14 Hari (Red Tint) -->
                                        <div class="bg-[#fef2f2] border border-[#fecaca] rounded-lg px-3 py-1.5 min-w-[145px]">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="font-bold text-rose-700 text-xs">{{ $sla['sla_label'] }}</span>
                                                <span class="text-[9px] font-extrabold text-rose-700 tracking-wider uppercase">{{ $sla['sla_status'] }}</span>
                                            </div>
                                            <div class="text-[10px] text-rose-500 font-medium mt-0.5">
                                                Batas: {{ $sla['batas_waktu'] }}
                                            </div>
                                        </div>
                                    @elseif ($sla['sla_level'] === 'warning')
                                        <!-- Perhatian: 8-12 Hari (Amber Tint) -->
                                        <div class="bg-[#fffbeb] border border-[#fef3c7] rounded-lg px-3 py-1.5 min-w-[145px]">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="font-bold text-amber-800 text-xs">{{ $sla['sla_label'] }}</span>
                                                <span class="text-[9px] font-extrabold text-amber-700 tracking-wider uppercase">{{ $sla['sla_status'] }}</span>
                                            </div>
                                            <div class="text-[10px] text-amber-600 font-medium mt-0.5">
                                                Batas: {{ $sla['batas_waktu'] }}
                                            </div>
                                        </div>
                                    @else
                                        <!-- Normal / Aman: 1-7 Hari (Green Tint) -->
                                        <div class="bg-[#f0fdf4] border border-[#dcfce7] rounded-lg px-3 py-1.5 min-w-[145px]">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="font-bold text-emerald-800 text-xs">{{ $sla['sla_label'] }}</span>
                                                <span class="text-[9px] font-extrabold text-emerald-700 tracking-wider uppercase">{{ $sla['sla_status'] }}</span>
                                            </div>
                                            <div class="text-[10px] text-emerald-600 font-medium mt-0.5">
                                                Batas: {{ $sla['batas_waktu'] }}
                                            </div>
                                        </div>
                                    @endif
                                </td>

                                <!-- Tindakan Button -->
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <button @click="openTindakLanjutModal({{ json_encode($sla) }})" 
                                            type="button" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:border-[#0d5c46] hover:text-[#0d5c46] text-gray-700 text-xs font-semibold shadow-xs transition cursor-pointer">
                                        <span>Tindak Lanjut</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400">
                                    Tidak ada data SLA aktif saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- MODAL 1: PILIH PIC / FUNGSIONAL (Persis Gambar Wireframe) -->
        <!-- ======================================================== -->
        <div x-show="disposisiModalOpen" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6" 
             style="display: none;">
            
            <div @click.away="disposisiModalOpen = false" 
                 class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 transform transition-all space-y-6 max-h-[92vh] overflow-y-auto custom-scrollbar">
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between pb-1">
                    <div>
                        <span class="text-[11px] font-bold tracking-widest text-[#0d5c46] uppercase">
                            PENUGASAN LAYANAN
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-1">
                            Pilih PIC / Fungsional
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 font-normal mt-0.5">
                            Pilih Kurator Keperdataan yang bertanggung jawab.
                        </p>
                    </div>
                    <button @click="disposisiModalOpen = false" 
                            type="button" 
                            class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-400 hover:text-gray-700 flex items-center justify-center transition cursor-pointer shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Disposisi -->
                <form :action="'{{ url('/kasi/disposisi') }}/' + (selectedItem ? selectedItem.id : '')" method="POST" class="space-y-6">
                    @csrf

                    <!-- Hidden inputs for selected PICs -->
                    <template x-for="pic in selectedPics" :key="pic">
                        <input type="hidden" name="pic[]" :value="pic">
                    </template>

                    <!-- Card 1: Layanan yang Didisposisikan -->
                    <div class="bg-[#f4f9f7] border border-[#d2ebe3] rounded-2xl p-4 sm:p-5 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">
                                LAYANAN YANG DIDISPOSISIKAN
                            </span>
                            <h4 class="text-base sm:text-lg font-bold text-[#0d5c46] font-mono mt-0.5" 
                                x-text="selectedItem ? selectedItem.nomor_layanan : ''">
                            </h4>
                            <p class="text-xs text-gray-500 font-medium mt-0.5" 
                               x-text="selectedItem ? (selectedItem.pemohon + ' · ' + selectedItem.tanggal_masuk) : ''">
                            </p>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white text-[#0d5c46] border border-[#d2ebe3] shadow-xs" 
                                  x-text="selectedItem ? selectedItem.jenis_layanan : 'SKHW'">
                            </span>
                        </div>
                    </div>

                    <!-- Card 2: Petunjuk Sebelum Memilih Petugas -->
                    <div class="bg-[#fffcf4] border border-[#fae2b8] rounded-2xl p-4 sm:p-5 text-xs text-[#785117]">
                        <h5 class="font-bold text-xs text-[#9a6721] tracking-wider uppercase mb-2">
                            PETUNJUK SEBELUM MEMILIH PETUGAS
                        </h5>
                        <div class="space-y-1.5 text-xs text-[#785117] leading-relaxed font-normal">
                            <p><strong class="font-bold">a.</strong> Pastikan petugas tidak dalam keadaan sakit atau cuti.</p>
                            <p><strong class="font-bold">b.</strong> Pastikan jumlah disposisi antarpetugas tetap seimbang.</p>
                        </div>
                    </div>

                    <!-- Group 1: KURATOR KEPERDATAAN PERTAMA -->
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700 tracking-wider uppercase">
                                KURATOR KEPERDATAAN PERTAMA
                            </span>
                            <span class="text-xs text-gray-400">
                                Dapat memilih lebih dari 1
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Iman -->
                            <div @click="toggleKurator('Iman', 'pertama')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Iman') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Iman') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Iman')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Iman</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">6 disposisi aktif</p>
                                </div>
                            </div>

                            <!-- Rahmat -->
                            <div @click="toggleKurator('Rahmat', 'pertama')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Rahmat') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Rahmat') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Rahmat')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Rahmat</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">10 disposisi aktif</p>
                                </div>
                            </div>

                            <!-- Januar -->
                            <div @click="toggleKurator('Januar', 'pertama')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Januar') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Januar') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Januar')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Januar</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">8 disposisi aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group 2: KURATOR KEPERDATAAN MUDA -->
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700 tracking-wider uppercase">
                                KURATOR KEPERDATAAN MUDA
                            </span>
                            <span class="text-xs text-gray-400">
                                Dapat memilih lebih dari 1
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Lutfy -->
                            <div @click="toggleKurator('Lutfy', 'muda')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Lutfy') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Lutfy') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Lutfy')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Lutfy</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">9 disposisi aktif</p>
                                </div>
                            </div>

                            <!-- Kemal -->
                            <div @click="toggleKurator('Kemal', 'muda')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Kemal') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Kemal') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Kemal')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Kemal</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">8 disposisi aktif</p>
                                </div>
                            </div>

                            <!-- Maya -->
                            <div @click="toggleKurator('Maya', 'muda')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Maya') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Maya') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Maya')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Maya</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">7 disposisi aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group 3: KURATOR KEPERDATAAN MADYA -->
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700 tracking-wider uppercase">
                                KURATOR KEPERDATAAN MADYA
                            </span>
                            <span class="text-xs text-gray-400">
                                Pilih maksimal 1
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Inara -->
                            <div @click="toggleKurator('Inara', 'madya')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Inara') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Inara') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Inara')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Inara</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">11 disposisi aktif</p>
                                </div>
                            </div>

                            <!-- Lisa -->
                            <div @click="toggleKurator('Lisa', 'madya')" 
                                 class="rounded-2xl border p-3.5 flex items-center gap-3 transition cursor-pointer select-none"
                                 :class="isPicSelected('Lisa') ? 'border-[#0d5c46] bg-[#f0f8f5] ring-1 ring-[#0d5c46]' : 'border-gray-200/90 bg-white hover:border-gray-300 hover:bg-gray-50/50'">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center transition shrink-0"
                                     :class="isPicSelected('Lisa') ? 'bg-[#0d5c46] border-[#0d5c46] text-white' : 'border-gray-300 bg-white'">
                                    <svg x-show="isPicSelected('Lisa')" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900 leading-tight">Lisa</p>
                                    <p class="text-xs text-gray-400 font-normal mt-0.5">13 disposisi aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Action Buttons (Footer matching Image 2) -->
                    <div class="border-t border-gray-100 pt-5 mt-6 flex items-center justify-end gap-3">
                        <button @click="disposisiModalOpen = false" 
                                type="button" 
                                class="px-6 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                :disabled="selectedPics.length === 0"
                                class="px-6 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-1.5"
                                :class="selectedPics.length > 0 ? 'bg-[#87b2a5] hover:bg-[#6c9c8e] text-white shadow-sm active:scale-95 cursor-pointer' : 'bg-[#87b2a5]/60 text-white cursor-not-allowed'">
                            <span>Simpan Disposisi</span>
                            <span>(<span x-text="selectedPics.length"></span>)</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL 2: KONFIRMASI PENYELESAIAN LAYANAN (Tindak Lanjut) -->
        <!-- ======================================================== -->
        <div x-show="tindakLanjutModalOpen" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6" 
             style="display: none;">
            
            <div @click.away="tindakLanjutModalOpen = false" 
                 class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 transform transition-all space-y-6 max-h-[92vh] overflow-y-auto custom-scrollbar">
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between pb-1">
                    <div>
                        <span class="text-[11px] font-bold tracking-widest text-[#c2410c] uppercase">
                            TINDAK LANJUT SLA
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-1">
                            Konfirmasi Penyelesaian Layanan
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-normal mt-0.5">
                            Catat alasan dan komitmen penyelesaian dari PIC.
                        </p>
                    </div>
                    <button @click="tindakLanjutModalOpen = false" 
                            type="button" 
                            class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-400 hover:text-gray-700 flex items-center justify-center transition cursor-pointer shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Tindak Lanjut -->
                <form :action="'{{ url('/kasi/tindak-lanjut') }}/' + (selectedItem ? selectedItem.id : '')" method="POST" class="space-y-5">
                    @csrf

                    <!-- Card Info Layanan & SLA Berjalan -->
                    <div class="bg-[#f8faf9] border border-gray-200/80 rounded-2xl p-4 sm:p-5 space-y-3.5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">
                                    NOMOR LAYANAN
                                </span>
                                <h4 class="text-base sm:text-lg font-bold text-[#0d5c46] font-mono mt-0.5" 
                                    x-text="selectedItem ? selectedItem.nomor_layanan : ''">
                                </h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">
                                    <span x-text="selectedItem ? selectedItem.detail_layanan : ''"></span> · <span x-text="selectedItem ? selectedItem.pemohon : ''"></span>
                                </p>
                            </div>
                            <div>
                                <div class="bg-[#fae8e8] border border-[#f5d0d0] rounded-xl px-4 py-2 text-center min-w-[125px]">
                                    <span class="text-[9px] font-bold text-rose-800/80 uppercase tracking-wider block">
                                        SLA BERJALAN
                                    </span>
                                    <span class="text-sm font-extrabold text-rose-800 mt-0.5 block" 
                                          x-text="selectedItem ? selectedItem.sla_label : 'Hari ke-14'">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Divider & PIC Chips -->
                        <div class="border-t border-gray-200/60 pt-3 flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">PIC:</span>
                            <template x-for="picName in (selectedItem && selectedItem.pic ? selectedItem.pic : ['Januar', 'Inara'])" :key="picName">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white border border-gray-200 text-gray-700 text-xs font-semibold shadow-2xs" 
                                      x-text="picName">
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Input 1: Alasan Keterlambatan -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Alasan keterlambatan <span class="text-rose-500 font-bold">*</span>
                        </label>
                        <textarea name="alasan_keterlambatan" 
                                  x-model="alasanKeterlambatan" 
                                  rows="4" 
                                  required 
                                  class="w-full text-xs sm:text-sm rounded-2xl border-gray-200 focus:border-[#0d5c46] focus:ring focus:ring-[#0d5c46]/20 p-4 transition text-gray-800 placeholder-gray-400" 
                                  placeholder="Tuliskan kendala atau alasan layanan belum diselesaikan..."></textarea>
                    </div>

                    <!-- Input 2: Komitmen Penyelesaian oleh PIC -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Komitmen penyelesaian oleh PIC <span class="text-rose-500 font-bold">*</span>
                        </label>
                        <textarea name="komitmen_penyelesaian" 
                                  x-model="komitmenPenyelesaian" 
                                  rows="4" 
                                  required 
                                  class="w-full text-xs sm:text-sm rounded-2xl border-gray-200 focus:border-[#0d5c46] focus:ring focus:ring-[#0d5c46]/20 p-4 transition text-gray-800 placeholder-gray-400" 
                                  placeholder="Tuliskan rencana dan target penyelesaian layanan..."></textarea>
                    </div>

                    <!-- Modal Action Buttons (Footer matching wireframe) -->
                    <div class="border-t border-gray-100 pt-5 mt-6 flex items-center justify-end gap-3">
                        <button @click="tindakLanjutModalOpen = false" 
                                type="button" 
                                class="px-6 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-[#87b2a5] hover:bg-[#6c9c8e] text-white text-sm font-semibold shadow-sm transition active:scale-95 cursor-pointer">
                            Simpan Tindak Lanjut
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-portal-layout>
