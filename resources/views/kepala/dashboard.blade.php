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
        <!-- KARTU STATISTIK REKAPITULASI LAYANAN (GRID RAPI) -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">
            <!-- Card 1: Total Layanan -->
            <div class="bg-gradient-to-br from-[#0c2a55] to-[#143c72] rounded-2xl p-4.5 text-white shadow-xs flex flex-col justify-between col-span-2 sm:col-span-1 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-blue-200 uppercase tracking-wider">
                        Total Layanan
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                </div>
                <div class="my-2">
                    <span class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        {{ $stats['total_layanan'] }}
                    </span>
                </div>
                <span class="text-[10px] text-blue-200/80 font-medium">
                    10 Jenis Layanan Publik
                </span>
            </div>

            <!-- Card 2: Pendaftaran Wasiat -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs hover:shadow-md hover:border-sky-200 transition group flex flex-col justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    Wasiat Tercatat
                </span>
                <div class="my-2 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-gray-900 tracking-tight">
                        {{ $stats['pendaftaran_wasiat'] }}
                    </span>
                </div>
                <span class="text-[10px] text-sky-600 font-semibold truncate">
                    Registrasi Notaris
                </span>
            </div>

            <!-- Card 3: Pembukaan Wasiat -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs hover:shadow-md hover:border-purple-200 transition group flex flex-col justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    Wasiat Tertutup
                </span>
                <div class="my-2 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-gray-900 tracking-tight">
                        {{ $stats['pembukaan_wasiat'] }}
                    </span>
                </div>
                <span class="text-[10px] text-purple-600 font-semibold truncate">
                    Sidang Pembukaan
                </span>
            </div>

            <!-- Card 4: Harta Orang Tidak Hadir & Tidak Terurus -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs hover:shadow-md hover:border-teal-200 transition group flex flex-col justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    Harta Kurator
                </span>
                <div class="my-2 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-gray-900 tracking-tight">
                        {{ $stats['harta_tidak_hadir'] + $stats['harta_tidak_terurus'] }}
                    </span>
                </div>
                <span class="text-[10px] text-teal-600 font-semibold truncate">
                    Afwezigheid &amp; Boedel
                </span>
            </div>

            <!-- Card 5: Kepailitan & UPK -->
            <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs hover:shadow-md hover:border-indigo-200 transition group flex flex-col justify-between">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    Kepailitan &amp; UPK
                </span>
                <div class="my-2 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-gray-900 tracking-tight">
                        {{ $stats['kepailitan'] + $stats['uang_pihak_ketiga'] }}
                    </span>
                </div>
                <span class="text-[10px] text-indigo-600 font-semibold truncate">
                    Konsinyasi &amp; Pailit
                </span>
            </div>

            <!-- Card 6: Atensi SLA Terlambat (Warning Red) -->
            <div @click="filterSla = (filterSla === 'terlambat' ? 'all' : 'terlambat')" 
                 class="bg-rose-50/70 border border-rose-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md hover:border-rose-300 transition cursor-pointer group flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-700 uppercase tracking-wider">
                        SLA Terlambat
                    </span>
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                </div>
                <div class="my-2 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-rose-600 tracking-tight">
                        {{ $stats['layanan_terlambat'] }}
                    </span>
                </div>
                <span class="text-[10px] text-rose-700 font-bold truncate">
                    &gt; 14 Hari Kerja (Atensi)
                </span>
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
