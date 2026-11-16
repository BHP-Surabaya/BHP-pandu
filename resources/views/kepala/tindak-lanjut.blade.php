<x-portal-layout>
    <x-slot:title>
        Tindak Lanjut &amp; Persetujuan Dokumen Hukum - Kepala Balai Harta Peninggalan Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        activeTab: '{{ $activeTab ?? 'perlu' }}',
        searchQuery: '',
        perluList: {{ Js::from($perluList) }},
        disetujuiList: {{ Js::from($disetujuiList) }},
        selectedItem: null,
        previewModalOpen: false,
        confirmModalOpen: false,
        catatanAkunPertama: '',

        openPreviewModal(item) {
            this.selectedItem = item;
            this.previewModalOpen = true;
        },

        openConfirmModal(item) {
            this.selectedItem = item;
            this.catatanAkunPertama = '';
            this.confirmModalOpen = true;
        },

        isItemVisible(item) {
            if (!this.searchQuery.trim()) return true;
            const q = this.searchQuery.toLowerCase();
            const text = ((item.nomor_berkas || '') + ' ' + (item.jenis_layanan || '') + ' ' + (item.nama_pemohon || '') + ' ' + (item.wilayah || '')).toLowerCase();
            return text.includes(q);
        }
    }">

        <!-- Header Page & Breadcrumb -->
        <div class="pb-2 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
                    <span>BHP Surabaya</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-[#0c2a55] font-semibold">Tindak Lanjut</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    Tindak Lanjut Dokumen Hukum
                </h1>
            </div>
            <a href="{{ route('kepala.dashboard') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition self-start sm:self-auto">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
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

        <!-- Search Bar & Tab Controls Card -->
        <div class="bg-white rounded-2xl border border-gray-100 p-3 sm:p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Search Bar -->
            <div class="relative flex-1 max-w-lg">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Cari nama pemohon, jenis layanan, atau nomor berkas..." 
                       class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50/70 hover:bg-white focus:bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition" />
            </div>

            <!-- Tab Buttons (Perlu Persetujuan & Sudah Disetujui) -->
            <div class="flex items-center gap-1.5 bg-gray-100 p-1 rounded-xl self-start md:self-auto shrink-0">
                <button type="button" 
                        @click="activeTab = 'perlu'" 
                        :class="activeTab === 'perlu' ? 'bg-[#0c2a55] text-white shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="px-4 py-2 rounded-lg text-xs transition cursor-pointer">
                    Perlu Persetujuan ({{ count($perluList) }})
                </button>
                <button type="button" 
                        @click="activeTab = 'disetujui'" 
                        :class="activeTab === 'disetujui' ? 'bg-[#0c2a55] text-white shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="px-4 py-2 rounded-lg text-xs transition cursor-pointer">
                    Sudah Disetujui ({{ count($disetujuiList) }})
                </button>
            </div>
        </div>

        <!-- TAB 1: DAFTAR PERLU PERSETUJUAN -->
        <div x-show="activeTab === 'perlu'" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 w-14 text-center">
                                No Urut
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Jenis Layanan
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Nama Pemohon
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 w-64">
                                SLA
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center w-56">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        <template x-for="(item, idx) in perluList" :key="item.id">
                            <tr class="hover:bg-slate-50/70 transition" x-show="isItemVisible(item)">
                                <!-- No Urut -->
                                <td class="py-4 px-5 font-bold text-gray-400 text-center" x-text="idx + 1"></td>

                                <!-- Jenis Layanan & Nomor Berkas -->
                                <td class="py-4 px-5">
                                    <span class="font-extrabold text-gray-900 text-sm block leading-tight" x-text="item.jenis_layanan"></span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5" x-text="item.nomor_berkas + ' • Masuk ' + item.tanggal_masuk"></span>
                                </td>

                                <!-- Nama Pemohon & Wilayah -->
                                <td class="py-4 px-5">
                                    <span class="font-bold text-gray-900 text-sm block leading-tight" x-text="item.nama_pemohon"></span>
                                    <span class="text-[11px] text-gray-500 block mt-0.5" x-text="item.wilayah"></span>
                                </td>

                                <!-- SLA Progress Bar & Status -->
                                <td class="py-4 px-5">
                                    <div class="space-y-1.5">
                                        <!-- Header SLA Text & Icon -->
                                        <div class="flex items-center gap-1.5">
                                            <!-- SLA Lebih (Red) -->
                                            <template x-if="item.sla_status === 'lebih'">
                                                <div class="flex items-center gap-1.5 text-rose-600 font-extrabold text-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <span x-text="item.hari_berjalan + ' / ' + item.standar_sla + ' Hari • ' + item.sla_label"></span>
                                                </div>
                                            </template>

                                            <!-- SLA Mendekati (Orange) -->
                                            <template x-if="item.sla_status === 'mendekati'">
                                                <div class="flex items-center gap-1.5 text-amber-600 font-extrabold text-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span x-text="item.hari_berjalan + ' / ' + item.standar_sla + ' Hari • ' + item.sla_label"></span>
                                                </div>
                                            </template>

                                            <!-- SLA Aman (Green) -->
                                            <template x-if="item.sla_status === 'aman'">
                                                <div class="flex items-center gap-1.5 text-emerald-600 font-extrabold text-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span x-text="item.hari_berjalan + ' / ' + item.standar_sla + ' Hari • ' + item.sla_label"></span>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Progress Bar Line -->
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full transition-all duration-300"
                                                 :class="{
                                                     'bg-rose-500': item.sla_status === 'lebih',
                                                     'bg-amber-500': item.sla_status === 'mendekati',
                                                     'bg-emerald-500': item.sla_status === 'aman'
                                                 }"
                                                 :style="'width: ' + Math.min(100, item.sla_persen) + '%'"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Aksi Buttons -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Preview Dokumen Hukum -->
                                        <button type="button" 
                                                @click="openPreviewModal(item)"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Preview Dokumen Hukum</span>
                                        </button>

                                        <!-- Tombol Setuju -->
                                        <button type="button" 
                                                @click="openConfirmModal(item)"
                                                class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-lg bg-[#0066d6] hover:bg-[#0055b8] text-white text-xs font-bold transition shadow-xs cursor-pointer">
                                            <span>Setuju</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 2: DAFTAR SUDAH DISETUJUI -->
        <div x-show="activeTab === 'disetujui'" style="display: none;" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 w-14 text-center">
                                No Urut
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Jenis Layanan &amp; Nomor Berkas
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Nama Pemohon
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Tanggal Disetujui
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center">
                                Status Alur
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        <template x-for="(item, idx) in disetujuiList" :key="item.id">
                            <tr class="hover:bg-slate-50/70 transition" x-show="isItemVisible(item)">
                                <td class="py-4 px-5 font-bold text-gray-400 text-center" x-text="idx + 1"></td>
                                <td class="py-4 px-5">
                                    <span class="font-extrabold text-gray-900 text-sm block" x-text="item.jenis_layanan"></span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5" x-text="item.nomor_berkas"></span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-bold text-gray-800 block" x-text="item.nama_pemohon"></span>
                                    <span class="text-[11px] text-gray-500 block" x-text="item.wilayah"></span>
                                </td>
                                <td class="py-4 px-5 font-semibold text-gray-700" x-text="item.tanggal_disetujui"></td>
                                <td class="py-4 px-5 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="item.status_tahap"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL 1: PRATINJAU DOKUMEN HUKUM (PERSIS SCREENSHOT 2)   -->
        <!-- ======================================================== -->
        <div x-show="previewModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="previewModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div class="relative w-full max-w-3xl transform rounded-2xl bg-white text-left shadow-2xl transition-all p-6 sm:p-7 border border-gray-100" 
                     @click.stop>

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between pb-3 border-b border-gray-100">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0c2a55]">
                                Pratinjau Dokumen Hukum &bull; <span x-text="selectedItem?.jenis_layanan"></span>
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Nomor Berkas: <span class="font-semibold text-gray-700" x-text="selectedItem?.nomor_berkas"></span> &bull; 
                                Pemohon: <span class="font-semibold text-gray-700" x-text="selectedItem?.nama_pemohon"></span>
                            </p>
                        </div>
                        <button type="button" @click="previewModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Kertas Pratinjau Dokumen Resmi (Format Kertas Putih) -->
                    <div class="my-4 max-h-[65vh] overflow-y-auto pr-1">
                        <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6 sm:p-8 space-y-5 text-gray-800">
                            <!-- Kop Surat Balai Harta Peninggalan -->
                            <div class="flex items-center gap-4 pb-4 border-b-2 border-gray-800">
                                <div class="w-14 h-14 shrink-0 flex items-center justify-center border border-gray-200 rounded-lg p-1">
                                    <svg class="w-10 h-10 text-[#0c2a55]" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M32 6L4 23H60L32 6Z" fill="#0c2a55"/>
                                        <rect x="6" y="24.5" width="52" height="4" fill="#0c2a55"/>
                                        <rect x="12" y="31" width="7" height="20" fill="#0c2a55"/>
                                        <rect x="28.5" y="31" width="7" height="20" fill="#F59E0B"/>
                                        <rect x="45" y="31" width="7" height="20" fill="#0c2a55"/>
                                        <rect x="6" y="53" width="52" height="3.5" fill="#0c2a55"/>
                                        <rect x="2" y="58" width="60" height="4" fill="#0c2a55"/>
                                    </svg>
                                </div>
                                <div class="text-center flex-1">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-700">
                                        KEMENTERIAN HUKUM REPUBLIK INDONESIA
                                    </h4>
                                    <h5 class="text-xs font-bold uppercase tracking-wider text-gray-800">
                                        KANTOR WILAYAH JAWA TIMUR
                                    </h5>
                                    <h3 class="text-sm sm:text-base font-extrabold uppercase tracking-wide text-gray-900 mt-0.5">
                                        BALAI HARTA PENINGGALAN SURABAYA
                                    </h3>
                                    <p class="text-[10px] text-gray-500 mt-0.5">
                                        Jl. Kayoon No. 50, Embong Kaliasin, Kec. Genteng, Kota Surabaya 60271
                                    </p>
                                </div>
                            </div>

                            <!-- Judul Dokumen -->
                            <div class="text-center pt-2">
                                <h3 class="text-sm sm:text-base font-black uppercase text-gray-900 tracking-wide underline underline-offset-4" 
                                    x-text="selectedItem?.dokumen?.judul"></h3>
                                <p class="text-xs font-semibold text-gray-600 mt-1" 
                                   x-text="'Nomor: ' + (selectedItem?.dokumen?.nomor || '-')"></p>
                            </div>

                            <!-- Grid Metadata Dokumen -->
                            <div class="bg-gray-50/70 border border-gray-200/80 rounded-xl p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Nama Pemohon:</span>
                                    <span class="font-bold text-gray-900 text-sm block mt-0.5" x-text="selectedItem?.nama_pemohon"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Wilayah / Domisili:</span>
                                    <span class="font-semibold text-gray-800 block mt-0.5" x-text="selectedItem?.wilayah"></span>
                                </div>
                                <div class="pt-2 border-t border-gray-200/60">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Tanggal Registrasi:</span>
                                    <span class="font-semibold text-gray-800 block mt-0.5" x-text="selectedItem?.dokumen?.tanggal_registrasi"></span>
                                </div>
                                <div class="pt-2 border-t border-gray-200/60">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Pemeriksa Berkas:</span>
                                    <span class="font-bold text-gray-900 block mt-0.5" x-text="selectedItem?.dokumen?.pemeriksa"></span>
                                </div>
                            </div>

                            <!-- Dasar Hukum -->
                            <div class="space-y-1.5 text-xs text-gray-700">
                                <h5 class="font-black text-gray-900 uppercase tracking-wider text-[11px]">
                                    DASAR HUKUM:
                                </h5>
                                <ol class="list-decimal pl-4 space-y-1 text-gray-600 leading-relaxed">
                                    <template x-for="(dasar, dIdx) in (selectedItem?.dokumen?.dasar_hukum || [])" :key="dIdx">
                                        <li x-text="dasar"></li>
                                    </template>
                                </ol>
                            </div>

                            <!-- Uraian Substansi Hukum -->
                            <div class="space-y-1.5 text-xs text-gray-700">
                                <h5 class="font-black text-gray-900 uppercase tracking-wider text-[11px]">
                                    URAIAN SUBSTANSI HUKUM:
                                </h5>
                                <div class="space-y-2 text-gray-600 leading-relaxed">
                                    <template x-for="(subs, sIdx) in (selectedItem?.dokumen?.substansi || [])" :key="sIdx">
                                        <p x-text="subs"></p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions Footer -->
                    <div class="pt-3 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                        <div class="text-gray-500 font-medium">
                            Status saat ini: <span class="font-bold text-amber-600">Menunggu Persetujuan Kepala BHP</span>
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                            <button type="button" 
                                    @click="previewModalOpen = false" 
                                    class="px-4 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold transition cursor-pointer">
                                Tutup Pratinjau
                            </button>
                            <button type="button" 
                                    @click="previewModalOpen = false; openConfirmModal(selectedItem)" 
                                    class="px-4 py-2 rounded-xl bg-[#0066d6] hover:bg-[#0055b8] text-white font-bold transition shadow-xs cursor-pointer">
                                Setuju &amp; Teruskan ke Akun Pertama
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL 2: KONFIRMASI PERSETUJUAN (PERSIS SCREENSHOT 3)    -->
        <!-- ======================================================== -->
        <div x-show="confirmModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="confirmModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div class="relative w-full max-w-lg transform rounded-2xl bg-white text-left shadow-2xl transition-all p-6 sm:p-7 border border-gray-100" 
                     @click.stop>

                    <!-- Header -->
                    <div class="flex items-start justify-between pb-3 border-b border-gray-100">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0c2a55]">
                                Konfirmasi Persetujuan Dokumen Hukum
                            </h3>
                        </div>
                        <button type="button" @click="confirmModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="'/kepala/tindak-lanjut/' + (selectedItem?.id || 0) + '/setujui'" method="POST" class="mt-4 space-y-4 text-xs">
                        @csrf

                        <!-- Ringkasan Singkat Berkas -->
                        <div class="bg-gray-50 border border-gray-200/80 rounded-xl p-3.5">
                            <h4 class="font-extrabold text-sm text-[#0c2a55]" x-text="selectedItem?.jenis_layanan"></h4>
                            <p class="text-gray-600 text-xs mt-0.5" x-text="'Pemohon: ' + (selectedItem?.nama_pemohon || '-') + ' • ' + (selectedItem?.nomor_berkas || '-')"></p>
                        </div>

                        <!-- Diagram Alur Penerusan Setelah Disetujui -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-700">
                                Alur Penerusan Setelah Disetujui:
                            </label>
                            
                            <div class="grid grid-cols-5 items-center gap-1 bg-slate-50 border border-gray-200/70 p-3 rounded-xl text-center">
                                <!-- Step 1: Kepala BHP -->
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mb-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="font-bold text-[11px] text-gray-800">Kepala BHP</span>
                                    <span class="text-[9px] text-emerald-600 font-semibold">Disetujui</span>
                                </div>

                                <!-- Arrow 1 -->
                                <div class="flex justify-center text-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>

                                <!-- Step 2: Akun Pertama (Target Highlighted) -->
                                <div class="flex flex-col items-center bg-blue-50 border-2 border-[#0066d6] rounded-xl p-2 shadow-xs">
                                    <div class="w-8 h-8 rounded-lg bg-[#0066d6] text-white flex items-center justify-center font-bold mb-1 shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <span class="font-black text-[11px] text-[#0066d6]">Akun Pertama</span>
                                    <span class="text-[9px] text-blue-700 font-bold">Barcode &amp; TTE</span>
                                </div>

                                <!-- Arrow 2 -->
                                <div class="flex justify-center text-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>

                                <!-- Step 3: Pemohon -->
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center font-bold mb-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-[11px] text-gray-700">Pemohon</span>
                                    <span class="text-[9px] text-gray-400">Kirim Final</span>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Prosedur Dokumen -->
                        <div class="p-3 bg-amber-50/70 border border-amber-200/70 rounded-xl text-amber-900 text-[11px] leading-relaxed flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>
                                Sesuai prosedur pengamanan dokumen, berkas yang disetujui tidak langsung dikirim ke Pemohon, melainkan masuk ke <strong>Akun Pertama</strong> untuk dilakukan penyematan <strong>Barcode dan Tanda Tangan Elektronik (TTE)</strong>.
                            </span>
                        </div>

                        <!-- Input Catatan Opsional -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Catatan untuk Akun Pertama (Opsional)
                            </label>
                            <textarea name="catatan" 
                                      rows="3" 
                                      x-model="catatanAkunPertama"
                                      placeholder="Contoh: Segera sematkan Barcode & TTE prioritas hari ini..." 
                                      class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition"></textarea>
                        </div>

                        <!-- Modal Actions Footer -->
                        <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-gray-100">
                            <button type="button" 
                                    @click="confirmModalOpen = false" 
                                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2 rounded-xl bg-[#0066d6] hover:bg-[#0055b8] text-white font-bold transition shadow-xs cursor-pointer">
                                Setuju &amp; Masuk ke Akun Pertama
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
