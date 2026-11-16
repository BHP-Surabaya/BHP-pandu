<x-portal-layout>
    <x-slot:title>
        Dashboard Layanan &amp; Atensi Keterlambatan SLA - Kepala Balai Harta Peninggalan Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-7" x-data="{
        searchLayanan: '',
        filterSla: 'all',
        filterBulan: '{{ $filterBulan }}',
        filterTahun: '{{ $filterTahun }}',
        ringkasanModalOpen: false,
        selectedItem: null,
        arahanInput: '',

        openRingkasanModal(item) {
            this.selectedItem = item;
            this.arahanInput = item.arahan_kepala || '';
            this.ringkasanModalOpen = true;
        },

        isItemVisible(item) {
            if (this.filterSla === 'terlambat' && item.status_sla !== 'terlambat') {
                return false;
            }
            if (this.filterSla === 'sesuai' && item.status_sla !== 'sesuai') {
                return false;
            }
            if (this.searchLayanan.trim() !== '') {
                const q = this.searchLayanan.toLowerCase();
                const text = ((item.nomor_layanan || '') + ' ' + (item.jenis_layanan || '') + ' ' + (item.detail_layanan || '') + ' ' + (item.pemohon || '')).toLowerCase();
                if (!text.includes(q)) {
                    return false;
                }
            }
            return true;
        }
    }">

        <!-- Header Page & Controls -->
        <div class="pb-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    Dashboard Layanan &amp; Atensi SLA
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Portal Eksekutif Kepala Balai Harta Peninggalan (BHP) Surabaya.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Filter Bulan -->
                <div class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-xl px-3 py-1.5 shadow-2xs text-xs font-semibold text-gray-700">
                    <span class="text-gray-400 font-normal">Bulan:</span>
                    <select x-model="filterBulan" class="bg-transparent border-none text-xs font-semibold text-gray-800 focus:ring-0 cursor-pointer p-0">
                        <option value="all">Semua Bulan (Jan-Des)</option>
                        <option value="10">Oktober 2026</option>
                        <option value="11">November 2026</option>
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-xl px-3 py-1.5 shadow-2xs text-xs font-semibold text-gray-700">
                    <span class="text-gray-400 font-normal">Tahun:</span>
                    <select x-model="filterTahun" class="bg-transparent border-none text-xs font-semibold text-gray-800 focus:ring-0 cursor-pointer p-0">
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                    </select>
                </div>

                <!-- Tombol Tindak Lanjut Cepat -->
                <a href="{{ route('kepala.tindak-lanjut') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0066d6] hover:bg-[#0055b8] text-white text-xs font-bold shadow-md shadow-blue-900/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                    </svg>
                    <span>Tindak Lanjut ({{ $stats['layanan_terlambat'] }})</span>
                </a>
            </div>
        </div>

        <!-- Flash Message Notification -->
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-xs" x-data="{ show: true }" x-show="show">
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

        <!-- ======================================================== -->
        <!-- KARTU RINGKASAN REKAPITULASI LAYANAN & SLA (MODEL SEJAJAR PERSIS KASI) -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-4">
            <!-- Card 1: Total Layanan -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-blue-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['total_layanan'] }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Total Layanan
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-blue-600 leading-snug truncate">
                            10 Jenis Publik
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Pendaftaran Wasiat Tercatat -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-sky-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-sky-50 text-sky-600 border border-sky-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['pendaftaran_wasiat'] }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Wasiat Tercatat
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-sky-600 leading-snug truncate">
                            Registrasi Notaris
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Pembukaan Wasiat Tertutup -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-purple-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 border border-purple-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['pembukaan_wasiat'] }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Wasiat Tertutup
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-purple-600 leading-snug truncate">
                            Sidang Pembukaan
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Harta Kurator -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-teal-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 border border-teal-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.42 48.42 0 0012 9.75c-2.551 0-5.056.2-7.5.583V21" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['harta_tidak_hadir'] + $stats['harta_tidak_terurus'] }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Harta Kurator
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-teal-600 leading-snug truncate">
                            Afwezigheid &amp; Boedel
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 5: Kepailitan & UPK -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-indigo-200 hover:-translate-y-0.5 transition-all duration-200 group flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['kepailitan'] + $stats['uang_pihak_ketiga'] }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Kepailitan &amp; UPK
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-indigo-600 leading-snug truncate">
                            Konsinyasi &amp; Pailit
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 6: SLA Terlambat (Warning Red) -->
            <div @click="filterSla = (filterSla === 'terlambat' ? 'all' : 'terlambat')" 
                 class="bg-white rounded-2xl border border-rose-100 p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:border-rose-300 hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer flex items-center gap-3.5 sm:gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 border border-rose-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-rose-600 leading-none shrink-0 tracking-tight">
                        {{ $stats['layanan_terlambat'] }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                                SLA Terlambat
                            </span>
                            <span class="relative flex h-2 w-2 shrink-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                            </span>
                        </div>
                        <span class="text-[11px] sm:text-xs font-bold text-rose-600 leading-snug truncate">
                            &gt; 14 Hari (Atensi)
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- DAFTAR LAYANAN PUBLIK & PEMANTAUAN KETERLAMBATAN SLA -->
        <!-- ======================================================== -->
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-5 sm:px-7 sm:py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                            Daftar Layanan Publik &amp; Pemantauan SLA
                        </h2>
                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200/60">
                            Standar 14 Hari Kerja
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 font-normal">
                        Pemantauan durasi waktu berjalan permohonan layanan dan atensi keterlambatan proses penanganan
                    </p>
                </div>

                <!-- Controls: Filter & Search -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Toggle Filter Terlambat -->
                    <button type="button" 
                            @click="filterSla = (filterSla === 'terlambat' ? 'all' : 'terlambat')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition cursor-pointer"
                            :class="filterSla === 'terlambat' ? 'bg-rose-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-text="filterSla === 'terlambat' ? 'Tampilkan Semua Layanan' : 'Hanya Layanan Terlambat (' + {{ $stats['layanan_terlambat'] }} + ')'"></span>
                    </button>

                    <!-- Search Input Bar -->
                    <div class="w-full sm:w-64">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   x-model="searchLayanan" 
                                   placeholder="Cari nomor/pemohon..." 
                                   class="w-full pl-9 pr-3.5 py-2 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 w-12 text-center">
                                NO
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PEMOHON
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                WAKTU BERJALAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center">
                                STATUS SLA
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center w-36">
                                AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @foreach ($layananList as $idx => $item)
                            <tr class="hover:bg-slate-50/70 transition" x-show="isItemVisible({{ Js::from($item) }})">
                                <!-- No Urut -->
                                <td class="py-4 px-5 font-bold text-gray-400 text-center">
                                    {{ $idx + 1 }}
                                </td>

                                <!-- Nomor Layanan -->
                                <td class="py-4 px-5">
                                    <span class="font-extrabold text-[#0c2a55] block leading-tight">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5">
                                        Masuk: {{ $item['tanggal_masuk'] }}
                                    </span>
                                </td>

                                <!-- Jenis Layanan -->
                                <td class="py-4 px-5">
                                    <span class="font-bold text-gray-800 block">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-500 truncate max-w-xs block mt-0.5">
                                        {{ $item['detail_layanan'] }}
                                    </span>
                                </td>

                                <!-- Pemohon -->
                                <td class="py-4 px-5">
                                    <span class="font-semibold text-gray-800 block">
                                        {{ $item['pemohon'] }}
                                    </span>
                                </td>

                                <!-- Waktu Berjalan -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-1.5 font-bold {{ $item['status_sla'] === 'terlambat' ? 'text-rose-600' : 'text-gray-700' }}">
                                        <span>Berjalan {{ $item['hari_berjalan'] }} Hari</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400">
                                        (Standar 14 hari)
                                    </span>
                                </td>

                                <!-- Status SLA Badge -->
                                <td class="py-4 px-5 text-center">
                                    @if ($item['status_sla'] === 'terlambat')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-700 border border-rose-200">
                                            +{{ $item['keterlambatan'] }} Hari
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Sesuai SLA
                                        </span>
                                    @endif
                                </td>

                                <!-- Tombol Aksi (Ringkasan Layanan) -->
                                <td class="py-4 px-5 text-center">
                                    <button type="button" 
                                            @click="openRingkasanModal({{ Js::from($item) }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:bg-[#0c2a55] hover:text-white hover:border-[#0c2a55] text-gray-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Ringkasan Layanan</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- MODAL: RINGKASAN LAYANAN & ATENSI KETERLAMBATAN SLA -->
        <!-- ======================================================== -->
        <div x-show="ringkasanModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="ringkasanModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div class="relative w-full max-w-2xl transform rounded-2xl bg-white text-left shadow-2xl transition-all p-6 sm:p-7 border border-gray-100" 
                     @click.stop>

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between pb-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-lg sm:text-xl font-black text-[#0c2a55] tracking-tight">
                                Ringkasan Layanan &amp; Atensi Keterlambatan SLA
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Balai Harta Peninggalan Surabaya &bull; <span class="font-bold text-gray-700" x-text="selectedItem?.nomor_layanan"></span>
                            </p>
                        </div>
                        <button type="button" 
                                @click="ringkasanModalOpen = false" 
                                class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body Printable Content -->
                    <div class="space-y-4 py-4 max-h-[70vh] overflow-y-auto pr-1" id="printable-ringkasan">
                        <!-- 1. Box Info Layanan -->
                        <div class="bg-gray-50/80 border border-gray-200/70 rounded-xl p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Nomor Layanan</span>
                                <span class="font-extrabold text-[#0c2a55] text-sm block mt-0.5" x-text="selectedItem?.nomor_layanan"></span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Tanggal Permohonan</span>
                                <span class="font-semibold text-gray-800 text-sm block mt-0.5" x-text="selectedItem?.tanggal_masuk"></span>
                            </div>
                            <div class="sm:col-span-2 pt-1 border-t border-gray-200/50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Jenis Layanan</span>
                                <span class="font-bold text-gray-900 block mt-0.5" x-text="selectedItem?.jenis_layanan"></span>
                                <span class="text-gray-500 text-[11px] block mt-0.5" x-text="'Pemohon: ' + (selectedItem?.pemohon || '-')"></span>
                            </div>
                        </div>

                        <!-- 2. Box Atensi Keterlambatan SLA -->
                        <template x-if="selectedItem?.status_sla === 'terlambat'">
                            <div class="bg-rose-50/80 border border-rose-200 rounded-xl p-4 text-xs space-y-3">
                                <div class="flex items-center gap-2 text-rose-700 font-bold">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Keterlambatan SLA (Batas Standar 14 Hari Kerja)</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 text-center py-2 bg-white/80 rounded-lg border border-rose-100">
                                    <div>
                                        <span class="text-[10px] text-gray-500 block">Standar SLA</span>
                                        <span class="font-black text-gray-800 text-sm">14 Hari</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-gray-500 block">Waktu Berjalan</span>
                                        <span class="font-black text-gray-800 text-sm" x-text="(selectedItem?.hari_berjalan || 0) + ' Hari'"></span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-rose-600 block font-bold">Keterlambatan</span>
                                        <span class="font-black text-rose-600 text-sm" x-text="'+' + (selectedItem?.keterlambatan || 0) + ' Hari'"></span>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-700 block mb-0.5">Catatan Progres Kendala:</span>
                                    <p class="text-gray-600 text-[11px] leading-relaxed italic" x-text="selectedItem?.catatan_progres || 'Belum ada catatan kendala'"></p>
                                </div>
                            </div>
                        </template>

                        <!-- 3. Penanggung Jawab Penanganan Layanan -->
                        <div class="border border-gray-200/80 rounded-xl p-4 text-xs">
                            <h4 class="font-bold text-gray-800 mb-2.5 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Penanggung Jawab Penanganan Layanan</span>
                            </h4>
                            <div class="divide-y divide-gray-100">
                                <div class="py-1.5 flex items-center justify-between">
                                    <span class="text-gray-500 font-medium">Kepala Seksi</span>
                                    <span class="font-bold text-gray-800" x-text="selectedItem?.kasi || 'H. Ahmad Fauzi, S.H., M.H.'"></span>
                                </div>
                                <div class="py-1.5 flex items-center justify-between">
                                    <span class="text-gray-500 font-medium">Fungsional JFKK Pertama</span>
                                    <span class="font-bold text-gray-800" x-text="selectedItem?.kurator_pertama || 'Rizky Pratama, S.H.'"></span>
                                </div>
                                <div class="py-1.5 flex items-center justify-between">
                                    <span class="text-gray-500 font-medium">Fungsional JFKK Muda</span>
                                    <span class="font-bold text-gray-800" x-text="selectedItem?.kurator_muda || 'Ratna Sari Dewi, S.H., M.Kn.'"></span>
                                </div>
                                <div class="py-1.5 flex items-center justify-between">
                                    <span class="text-gray-500 font-medium">Fungsional JFKK Madya</span>
                                    <span class="font-bold text-gray-800" x-text="selectedItem?.kurator_madya || 'Bagus Santoso, S.H., M.H.'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Form Tindak Lanjut Kepala BHP -->
                        <div class="border border-blue-100 bg-blue-50/40 rounded-xl p-4 text-xs space-y-2">
                            <h4 class="font-bold text-[#0c2a55] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Tindak Lanjut Kepala BHP</span>
                            </h4>
                            <p class="text-[11px] text-gray-500">
                                Disposisi / Arahan Atensi Kepala untuk percepatan penyelesaian layanan
                            </p>
                            
                            <form :action="'/kepala/tindak-lanjut/' + (selectedItem?.id || 0)" method="POST" class="space-y-2.5">
                                @csrf
                                <textarea name="arahan" 
                                          rows="3" 
                                          x-model="arahanInput"
                                          placeholder="Tuliskan arahan percepatan atensi kepada Tim KASI & Kurator Keperdataan..." 
                                          class="w-full p-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition"></textarea>
                                
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#0066d6] hover:bg-[#0055b8] text-white text-xs font-bold transition shadow-xs cursor-pointer">
                                        <span>Kirim Arahan Atensi</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Actions Footer -->
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                        <button type="button" 
                                onclick="window.print()" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            <span>Print</span>
                        </button>

                        <button type="button" 
                                @click="ringkasanModalOpen = false" 
                                class="px-4 py-2 rounded-xl bg-[#0c2a55] hover:bg-[#143c72] text-white text-xs font-bold transition shadow-sm cursor-pointer">
                            Tutup Ringkasan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
