<x-portal-layout>
    <x-slot:title>
        Riwayat Pengiriman Dokumen - Gateway Layanan BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        previewModalOpen: false,
        selectedDoc: null,

        openPreview(doc) {
            this.selectedDoc = doc;
            this.previewModalOpen = true;
        }
    }">

        <!-- Breadcrumb & Top Bar -->
        <div class="pb-2 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
                    <span>Gateway Layanan</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-[#0c2a55] font-semibold">Riwayat Pengiriman</span>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                        Riwayat Upload dan Pengiriman Dokumen
                    </h1>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-[#0066d6] border border-blue-200/60">
                        {{ count($filteredRiwayat) }} dokumen terkirim
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    Daftar seluruh dokumen hukum yang telah berhasil disematkan Barcode verifikasi, e-TTD, dan diterbitkan kepada pemohon.
                </p>
            </div>

            <!-- Link Kembali ke Antrean Proses -->
            <a href="{{ route('petugas.gateway.index') }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition self-start sm:self-auto cursor-pointer">
                <svg class="w-4 h-4 text-[#0066d6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Antrean Barcode &amp; e-TTD ({{ $stats['total_siap_proses'] }})</span>
            </a>
        </div>

        <!-- Filter & Search Controls Card -->
        <div class="bg-white rounded-2xl border border-gray-100 p-3 sm:p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('petugas.gateway.riwayat') }}" class="relative flex-1 max-w-md flex items-center gap-2">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Cari nomor layanan, pemohon, berkas..." 
                           class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50/70 hover:bg-white focus:bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition" />
                </div>
                @if ($filterBulan !== 'all')
                    <input type="hidden" name="bulan" value="{{ $filterBulan }}">
                @endif
                @if ($filterTahun !== 'all')
                    <input type="hidden" name="tahun" value="{{ $filterTahun }}">
                @endif
                <button type="submit" class="px-3.5 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                    Cari
                </button>
            </form>

            <!-- Dropdown Filters (Bulan, Tahun, Ekspor) -->
            <form method="GET" action="{{ route('petugas.gateway.riwayat') }}" class="flex flex-wrap items-center gap-2">
                @if ($search !== '')
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif

                <!-- Filter Bulan -->
                <select name="bulan" 
                        onchange="this.form.submit()" 
                        class="px-3 py-2 bg-gray-50 hover:bg-white border border-gray-200 rounded-xl text-xs text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] cursor-pointer transition">
                    <option value="all" {{ $filterBulan === 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    <option value="10" {{ $filterBulan === '10' ? 'selected' : '' }}>Oktober</option>
                    <option value="11" {{ $filterBulan === '11' ? 'selected' : '' }}>November</option>
                </select>

                <!-- Filter Tahun -->
                <select name="tahun" 
                        onchange="this.form.submit()" 
                        class="px-3 py-2 bg-gray-50 hover:bg-white border border-gray-200 rounded-xl text-xs text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] cursor-pointer transition">
                    <option value="all" {{ $filterTahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    <option value="2026" {{ $filterTahun === '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2025" {{ $filterTahun === '2025' ? 'selected' : '' }}>2025</option>
                </select>

                <!-- Tombol Ekspor -->
                <button type="button" 
                        onclick="window.print()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Ekspor</span>
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Pengiriman Dokumen -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[980px]">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/60">
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400 w-14 text-center">
                                No. Urut
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                No. Layanan
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Pemohon &amp; Layanan
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Penanggungjawab
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Berkas Terkirim
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Tanggal Selesai
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Waktu Kirim
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($filteredRiwayat as $idx => $item)
                            <tr class="hover:bg-slate-50/70 transition">
                                <!-- No Urut -->
                                <td class="py-4 px-4 font-bold text-gray-400 text-center">
                                    {{ str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- No Layanan -->
                                <td class="py-4 px-4 font-mono font-bold text-gray-900 text-xs whitespace-nowrap">
                                    {{ $item['nomor_layanan'] }}
                                </td>

                                <!-- Pemohon & Layanan -->
                                <td class="py-4 px-4">
                                    <span class="font-bold text-gray-900 text-xs sm:text-sm block leading-tight">
                                        {{ $item['nama_pemohon'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5">
                                        {{ $item['email_pemohon'] }}
                                    </span>
                                    <span class="text-[11px] font-semibold text-[#0066d6] block mt-1">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                </td>

                                <!-- Penanggungjawab -->
                                <td class="py-4 px-4 font-semibold text-gray-700 whitespace-nowrap">
                                    {{ $item['penanggungjawab'] }}
                                </td>

                                <!-- Berkas Terkirim -->
                                <td class="py-4 px-4">
                                    <div class="flex items-start gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200/70 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <button type="button" 
                                                    @click="openPreview({{ Js::from($item) }})" 
                                                    class="font-bold text-gray-900 text-xs hover:text-[#0066d6] block text-left transition cursor-pointer">
                                                {{ $item['nama_file_terkirim'] }}
                                            </button>
                                            <span class="text-[10px] text-gray-400 block mt-0.5">
                                                {{ $item['ukuran_file'] }} &bull; {{ $item['keterangan_file'] }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Tanggal Selesai -->
                                <td class="py-4 px-4 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_selesai'] }}
                                </td>

                                <!-- Waktu Kirim -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-800 block">
                                        {{ $item['waktu_kirim'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Terkirim ke Pemohon
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-400">
                                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-semibold text-gray-600">Tidak ada riwayat pengiriman dokumen ditemukan.</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Semua berkas yang selesai diproses Barcode &amp; e-TTD akan tercatat di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-5 py-3.5 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <div>
                    Menampilkan <strong>{{ count($filteredRiwayat) }}</strong> dokumen terkirim
                </div>
                <div class="text-[11px] text-gray-400">
                    Sertifikasi Tanda Tangan Elektronik oleh Balai Sertifikasi Elektronik (BSrE)
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL PRATINJAU DOKUMEN TERKIRIM                         -->
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
                <div class="relative w-full max-w-lg transform rounded-2xl bg-white text-left shadow-2xl transition-all p-6 sm:p-7 border border-gray-100" 
                     @click.stop>

                    <div class="flex items-start justify-between pb-3 border-b border-gray-100">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0c2a55]">
                                Detail Berkas Terkirim
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5" x-text="selectedDoc?.nomor_layanan"></p>
                        </div>
                        <button type="button" @click="previewModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="mt-4 space-y-3.5 text-xs">
                        <div class="p-3.5 bg-emerald-50/70 border border-emerald-200/70 rounded-xl space-y-1.5">
                            <div class="flex items-center gap-2 text-emerald-800 font-bold">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Status: Berkas Resmi Terbit &amp; Terkirim</span>
                            </div>
                            <p class="text-[11px] text-emerald-700 leading-relaxed" x-text="selectedDoc?.keterangan_file"></p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-3.5 border border-gray-200/80 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nama Dokumen:</span>
                                <span class="font-bold text-gray-900" x-text="selectedDoc?.nama_file_terkirim"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pemohon:</span>
                                <span class="font-semibold text-gray-800" x-text="selectedDoc?.nama_pemohon"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Email Tujuan:</span>
                                <span class="font-mono text-gray-700" x-text="selectedDoc?.email_pemohon"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Penanggungjawab:</span>
                                <span class="font-semibold text-gray-800" x-text="selectedDoc?.penanggungjawab"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Waktu Pengiriman:</span>
                                <span class="font-semibold text-gray-800" x-text="selectedDoc?.waktu_kirim"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100 mt-4">
                        <button type="button" 
                                @click="previewModalOpen = false" 
                                class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
