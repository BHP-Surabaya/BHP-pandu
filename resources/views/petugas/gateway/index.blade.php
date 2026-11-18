<x-portal-layout>
    <x-slot:title>
        Proses Barcode &amp; e-TTD - Gateway Layanan BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        searchQuery: '{{ $search ?? '' }}',
        filterJenis: '{{ $filterJenis ?? 'all' }}',
        uploadModalOpen: false,
        selectedItem: null,
        fileName: '',
        fileSize: '',
        konfirmasiValid: true,

        openUploadModal(item) {
            this.selectedItem = item;
            this.fileName = (item.nama_dokumen || 'Dokumen.pdf').replace('Konsep_Disetujui_', 'Final_Signed_');
            this.fileSize = '245.8 KB';
            this.uploadModalOpen = true;
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                this.fileSize = (file.size / 1024).toFixed(1) + ' KB';
            }
        }
    }">

        <!-- Breadcrumb & Top Bar -->
        <div class="pb-2 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
                    <span>Gateway Layanan</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-[#0c2a55] font-semibold">Proses Barcode&amp;e-Ttd</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    Proses Barcode &amp; e-TTD
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                    Penyematan Barcode verifikasi dan Tanda Tangan Elektronik Kepala Balai sebelum dokumen dikirimkan ke pemohon.
                </p>
            </div>

            <!-- Link Navigasi Cepat ke Riwayat -->
            <a href="{{ route('petugas.gateway.riwayat') }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition self-start sm:self-auto cursor-pointer">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Lihat Riwayat Terkirim ({{ $stats['total_terkirim'] }})</span>
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
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="flex-1 font-medium leading-relaxed">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Filter Card: Search Input & Jenis Layanan Dropdown -->
        <div class="bg-white rounded-2xl border border-gray-100 p-3 sm:p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('petugas.gateway.index') }}" class="relative flex-1 max-w-md flex items-center gap-2">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Cari No. Layanan, pemohon, penanggungjawab..." 
                           class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50/70 hover:bg-white focus:bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition" />
                </div>
                @if ($filterJenis !== 'all')
                    <input type="hidden" name="jenis" value="{{ $filterJenis }}">
                @endif
                <button type="submit" class="px-3.5 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                    Cari
                </button>
            </form>

            <!-- Dropdown Filter: Semua Jenis Layanan -->
            <form method="GET" action="{{ route('petugas.gateway.index') }}" class="flex items-center gap-2">
                @if ($search !== '')
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif
                <select name="jenis" 
                        onchange="this.form.submit()" 
                        class="px-3.5 py-2.5 bg-gray-50 hover:bg-white border border-gray-200 rounded-xl text-xs sm:text-sm text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] cursor-pointer transition">
                    <option value="all" {{ $filterJenis === 'all' ? 'selected' : '' }}>Semua Jenis Layanan</option>
                    @foreach ($daftarJenisLayanan as $jenis)
                        <option value="{{ $jenis }}" {{ $filterJenis === $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Tabel Antrean Barcode & e-TTD -->
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
                                Jenis Layanan
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Nama Pemohon
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Penanggungjawab
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Tanggal Permohonan
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Tanggal Selesai
                            </th>
                            <th scope="col" class="py-3 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center w-56">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($filteredAntrean as $idx => $item)
                            <tr class="hover:bg-slate-50/70 transition">
                                <!-- No Urut -->
                                <td class="py-4 px-4 font-bold text-gray-400 text-center">
                                    {{ str_pad((string)($idx + 1), 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- No Layanan -->
                                <td class="py-4 px-4 font-mono font-bold text-gray-900 text-xs whitespace-nowrap">
                                    {{ $item['nomor_layanan'] }}
                                </td>

                                <!-- Jenis Layanan & Nama File Konsep -->
                                <td class="py-4 px-4">
                                    <span class="font-extrabold text-gray-900 text-xs sm:text-sm block leading-tight">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                    <div class="flex items-center gap-1 text-[11px] text-gray-400 mt-0.5">
                                        <svg class="w-3 h-3 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                        </svg>
                                        <span class="truncate max-w-[200px]" title="{{ $item['nama_dokumen'] }}">
                                            {{ $item['nama_dokumen'] }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Nama Pemohon & Email -->
                                <td class="py-4 px-4">
                                    <span class="font-bold text-gray-900 text-xs sm:text-sm block leading-tight">
                                        {{ $item['nama_pemohon'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5">
                                        {{ $item['email_pemohon'] }}
                                    </span>
                                </td>

                                <!-- Penanggungjawab -->
                                <td class="py-4 px-4 font-semibold text-gray-700 whitespace-nowrap">
                                    {{ $item['penanggungjawab'] }}
                                </td>

                                <!-- Tanggal Permohonan -->
                                <td class="py-4 px-4 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_permohonan'] }}
                                </td>

                                <!-- Status Dokumen (Dokumen Siap vs Menunggu Dokumen) -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if ($item['status_dokumen'] === 'siap')
                                        <div class="flex items-start gap-1.5">
                                            <svg class="w-4 h-4 text-[#0066d6] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <span class="font-bold text-[#0066d6] text-xs block leading-tight">
                                                    Dokumen Siap
                                                </span>
                                                <span class="text-[10px] text-gray-500 block">
                                                    {{ $item['status_detail'] }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-start gap-1.5">
                                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <span class="font-bold text-amber-600 text-xs block leading-tight">
                                                    Menunggu Dokumen
                                                </span>
                                                <span class="text-[10px] text-gray-400 block">
                                                    {{ $item['status_detail'] }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </td>

                                <!-- Aksi Buttons -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($item['bisa_diproses'])
                                            <!-- Download Dokumen -->
                                            <a href="{{ route('petugas.gateway.download', $item['id']) }}" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition cursor-pointer"
                                               title="Unduh draf konsep dokumen">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                <span>Download Dokumen</span>
                                            </a>

                                            <!-- Upload & Kirim Dokumen -->
                                            <button type="button" 
                                                    @click="openUploadModal({{ Js::from($item) }})" 
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#0066d6] hover:bg-[#0055b8] text-white text-xs font-bold transition shadow-xs cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span>Upload &amp; Kirim Dokumen</span>
                                            </button>
                                        @else
                                            <!-- Disabled Buttons -->
                                            <button type="button" disabled 
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-400 text-xs font-medium cursor-not-allowed border border-gray-200/50">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                <span>Download Dokumen</span>
                                            </button>
                                            <button type="button" disabled 
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-gray-100 text-gray-400 text-xs font-medium cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span>Upload &amp; Kirim Dokumen</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-400">
                                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-semibold text-gray-600">Tidak ada antrean dokumen ditemukan.</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Silakan sesuaikan filter atau kata kunci pencarian Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-5 py-3.5 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-gray-500">
                <div>
                    Menampilkan <strong>{{ count($filteredAntrean) }}</strong> dari <strong>{{ $stats['total_semua_antrean'] }}</strong> layanan dalam antrean Barcode &amp; e-TTD
                </div>
                <div class="text-[11px] text-gray-400 italic">
                    Status Dokumen Siap dapat diunduh dan diunggah hasilnya untuk langsung masuk ke Riwayat Pengiriman
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL: UPLOAD & KIRIM DOKUMEN FINAL (BARCODE & e-TTD)    -->
        <!-- ======================================================== -->
        <div x-show="uploadModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="uploadModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div class="relative w-full max-w-lg transform rounded-2xl bg-white text-left shadow-2xl transition-all p-6 sm:p-7 border border-gray-100" 
                     @click.stop>

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between pb-3 border-b border-gray-100">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0c2a55]">
                                Upload &amp; Kirim Dokumen Final
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Berkas telah disematkan Barcode &amp; e-TTD resmi Kepala Balai Harta Peninggalan.
                            </p>
                        </div>
                        <button type="button" @click="uploadModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="'/petugas/gateway/' + (selectedItem?.id || 0) + '/upload-kirim'" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4 text-xs">
                        @csrf

                        <!-- Ringkasan Singkat Berkas -->
                        <div class="bg-gray-50 border border-gray-200/80 rounded-xl p-3.5 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-[#0c2a55] text-sm" x-text="selectedItem?.jenis_layanan"></span>
                                <span class="text-[11px] font-mono text-gray-500 font-semibold" x-text="selectedItem?.nomor_layanan"></span>
                            </div>
                            <p class="text-gray-600 text-xs">
                                Pemohon: <strong class="text-gray-900" x-text="selectedItem?.nama_pemohon"></strong> &bull; <span x-text="selectedItem?.email_pemohon"></span>
                            </p>
                        </div>

                        <!-- Area Drag & Drop / File Input -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                Unggah Dokumen Ber-Barcode &amp; e-TTD (PDF) <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="border-2 border-dashed border-blue-200 hover:border-[#0066d6] rounded-xl p-5 text-center bg-blue-50/30 transition cursor-pointer relative">
                                <input type="file" 
                                       name="dokumen_final" 
                                       accept=".pdf" 
                                       @change="handleFileSelect($event)" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                
                                <div class="flex flex-col items-center justify-center space-y-1.5">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-[#0066d6] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-700">
                                        Klik untuk memilih file atau seret file PDF ke sini
                                    </p>
                                    <p class="text-[10px] text-gray-400">
                                        Format PDF maksimal 10 MB (Terintegrasi BSrE / e-Sign)
                                    </p>
                                </div>
                            </div>

                            <!-- Preview File Terpilih -->
                            <div class="mt-2.5 p-2.5 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-2 min-w-0">
                                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <span class="font-bold text-gray-800 text-xs block truncate" x-text="fileName"></span>
                                        <span class="text-[10px] text-gray-400 block" x-text="fileSize"></span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 shrink-0">
                                    Siap Kirim
                                </span>
                            </div>
                        </div>

                        <!-- Catatan Prosedur Dokumen -->
                        <div class="p-3 bg-amber-50/70 border border-amber-200/70 rounded-xl text-amber-900 text-[11px] leading-relaxed flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>
                                Pastikan berkas telah disematkan <strong>Barcode verifikasi</strong> dan <strong>Tanda Tangan Elektronik (e-TTD)</strong> resmi Kepala Balai Harta Peninggalan sebelum diteruskan kepada Pemohon.
                            </span>
                        </div>

                        <!-- Checkbox Konfirmasi Validasi -->
                        <label class="flex items-start gap-2 cursor-pointer pt-1">
                            <input type="checkbox" 
                                   name="konfirmasi" 
                                   value="1" 
                                   x-model="konfirmasiValid" 
                                   required 
                                   class="rounded text-[#0066d6] focus:ring-[#0066d6] mt-0.5" />
                            <span class="text-xs text-gray-700 leading-snug">
                                Saya menyatakan dokumen ini telah valid, bertanda tangan elektronik, dan siap dikirimkan kepada pemohon.
                            </span>
                        </label>

                        <!-- Modal Actions Footer -->
                        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-gray-100">
                            <button type="button" 
                                    @click="uploadModalOpen = false" 
                                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" 
                                    :disabled="!konfirmasiValid"
                                    :class="konfirmasiValid ? 'bg-[#0066d6] hover:bg-[#0055b8] cursor-pointer' : 'bg-gray-300 cursor-not-allowed'"
                                    class="px-5 py-2 rounded-xl text-white font-bold transition shadow-xs flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span>Upload &amp; Kirim ke Pemohon</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
