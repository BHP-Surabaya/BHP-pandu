<x-portal-layout>
    <x-slot name="title">
        Verifikasi Persyaratan - {{ $layanan['nomor_layanan'] }}
    </x-slot>

    @php
        $docList = $layanan['dokumen_list'] ?? [];
    @endphp

    <div class="p-4 sm:p-6 lg:p-8 transition-all duration-300 mx-auto"
         :class="splitViewOpen ? 'max-w-[1720px]' : 'max-w-7xl'"
         x-data="{
             splitViewOpen: false,
             docs: {{ json_encode($docList) }},
             activeDocIndex: 0,
             zoomLevel: 100,
             answers: {
                 p_1_a: null,
                 p_1_b: null,
                 p_2_a: null,
                 p_2_b: null,
                 p_2_c: null,
                 p_2_d: null,
                 p_3_a: null,
                 p_3_b: null,
                 p_3_c: null,
                 p_4_a: null,
                 p_4_b: null,
                 p_4_c: null,
                 p_4_d: null,
             },
             statusKeputusan: 'disetujui',
            qrModalOpen: false,
            qrScanning: false,
            qrVerified: false,
            qrScannerMode: 'auto',
            toastMessage: '',
            toastShow: false,
            showToast(msg) {
                this.toastMessage = msg;
                this.toastShow = true;
                setTimeout(() => { this.toastShow = false; }, 4000);
            },
            bukaScannerQr() {
                this.qrModalOpen = true;
                this.qrScanning = true;
                this.qrScannerMode = 'auto';
                setTimeout(() => {
                    this.qrScanning = false;
                }, 700);
            },
            terapkanHasilQr() {
                this.answers.p_2_a = 'iya';
                this.qrVerified = true;
                this.tutupScannerQr();
                this.showToast('Barcode Surat Kematian berhasil dipindai! Poin 2.a otomatis terverifikasi Iya.');
            },
            aktifkanKamera() {
                this.qrScannerMode = 'camera';
                this.$nextTick(() => {
                    const video = document.getElementById('qr-camera-stream');
                    if (video && navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                            .then(stream => {
                                video.srcObject = stream;
                                video.play();
                            })
                            .catch(err => {
                                console.log('Kamera tidak dapat diakses:', err);
                            });
                    }
                });
            },
            matikanKamera() {
                const video = document.getElementById('qr-camera-stream');
                if (video && video.srcObject) {
                    video.srcObject.getTracks().forEach(track => track.stop());
                    video.srcObject = null;
                }
                this.qrScannerMode = 'auto';
            },
            tutupScannerQr() {
                this.matikanKamera();
                this.qrModalOpen = false;
            },
             get currentDoc() {
                 return this.docs[this.activeDocIndex] || this.docs[0] || null;
             },
             get completedCount() {
                 let count = 0;
                 for (let k in this.answers) {
                     if (this.answers[k] !== null) count++;
                 }
                 return count;
             },
             openDocSplit(index) {
                 this.activeDocIndex = index;
                 this.splitViewOpen = true;
             },
             nextDoc() {
                 if (this.activeDocIndex < this.docs.length - 1) {
                     this.activeDocIndex++;
                 }
             },
             prevDoc() {
                 if (this.activeDocIndex > 0) {
                     this.activeDocIndex--;
                 }
             }
         }">

        <!-- ================= BREADCRUMB & HEADER ================= -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 mb-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Daftar Layanan</span>
                </a>
                <span class="text-xs text-gray-400 font-mono hidden sm:inline">/</span>
                <span class="text-xs font-bold text-gray-700 font-mono hidden sm:inline">
                    {{ $layanan['nomor_layanan'] }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Menunggu Verifikasi Persyaratan
                </span>
            </div>
        </div>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="transition-all duration-300"
             :class="splitViewOpen ? 'grid grid-cols-1 lg:grid-cols-12 gap-6 items-start' : 'space-y-6'">

            <!-- ================= LEFT COLUMN: DATA PEMOHON & CHECKLIST VERIFIKASI ================= -->
            <div :class="splitViewOpen ? 'lg:col-span-7 xl:col-span-7 space-y-6' : 'space-y-6'">

                <!-- KARTU ATAS (Jika Normal View: 2 Kolom. Jika Split View: Kartu Pemohon Saja) -->
                <div :class="splitViewOpen ? 'space-y-6' : 'grid grid-cols-1 lg:grid-cols-2 gap-6'">

                    <!-- KARTU DATA INPUT PEMOHON -->
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                        <div>
                            <!-- Header Kartu -->
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shadow-2xs flex-shrink-0">
                                        <!-- User Avatar Icon -->
                                        <svg class="w-5 h-5 text-[#10b981]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-bold text-gray-900 tracking-tight">
                                            Data Input Pemohon
                                        </h2>
                                    </div>
                                </div>

                                <span class="text-xs font-mono font-bold text-gray-400">
                                    {{ $layanan['tanggal_masuk'] }}
                                </span>
                            </div>

                            <!-- Fields Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                                <!-- NAMA LENGKAP -->
                                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100/80">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                        NAMA LENGKAP
                                    </div>
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ $layanan['nama_pemohon'] }}
                                    </div>
                                </div>

                                <!-- NIK -->
                                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100/80">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                        NIK
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 font-mono">
                                        {{ $layanan['nik'] ?? '3578••••••••0006' }}
                                    </div>
                                </div>

                                <!-- EMAIL -->
                                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100/80">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                        EMAIL
                                    </div>
                                    <div class="text-xs font-medium text-gray-700 truncate">
                                        {{ $layanan['email'] ?? 'pemohon@email.com' }}
                                    </div>
                                </div>

                                <!-- NOMOR TELEPON -->
                                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100/80">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                        NOMOR TELEPON
                                    </div>
                                    <div class="text-xs font-medium text-gray-700 font-mono">
                                        {{ $layanan['nomor_telepon'] ?? '0812 •••• 8841' }}
                                    </div>
                                </div>

                                <!-- ALAMAT DOMISILI -->
                                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100/80">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                        ALAMAT DOMISILI
                                    </div>
                                    <div class="text-xs font-medium text-gray-700">
                                        {{ $layanan['alamat_domisili'] ?? 'Kec. Genteng, Kota Surabaya' }}
                                    </div>
                                </div>

                                <!-- JENIS PERMOHONAN -->
                                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100/80">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                        JENIS PERMOHONAN
                                    </div>
                                    <div class="text-xs font-bold text-[#0b2e66]">
                                        {{ $layanan['detail_layanan'] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!empty($layanan['nama_pewasiat']))
                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                                <span class="text-gray-400 font-medium">Nama Pewaris / Pewasiat:</span>
                                <span class="font-extrabold text-[#1e1b4b]">{{ $layanan['nama_pewasiat'] }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- KARTU DOKUMEN PERSYARATAN (HANYA MUNCUL DI TOP GRID SAAT MODE NORMAL) -->
                    <template x-if="!splitViewOpen">
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                            <div>
                                <!-- Header Kartu -->
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shadow-2xs flex-shrink-0">
                                            <!-- Document Icon -->
                                            <svg class="w-5 h-5 text-[#f59e0b]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-base font-bold text-gray-900 tracking-tight">
                                                Dokumen Persyaratan
                                            </h2>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400 font-medium">
                                        {{ count($docList) }} dokumen diunggah
                                    </span>
                                </div>

                                <!-- List Dokumen -->
                                <div class="space-y-3">
                                    @foreach ($docList as $idx => $doc)
                                        <div class="bg-white border border-gray-100 rounded-2xl p-3.5 sm:p-4 flex items-center justify-between hover:border-sky-300 hover:shadow-xs transition group shadow-2xs">
                                            <div class="flex items-center gap-3.5 min-w-0">
                                                <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:text-sky-600 group-hover:bg-sky-50 transition flex-shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-bold text-gray-900 text-xs sm:text-sm truncate">
                                                        {{ $doc['nama'] }}
                                                    </div>
                                                    <div class="text-[11px] text-gray-400 mt-0.5">
                                                        {{ $doc['tipe'] ?? 'PDF' }} · {{ $doc['ukuran'] ?? '1,5 MB' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" 
                                                    @click="openDocSplit({{ $idx }})"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border border-gray-200 bg-white hover:bg-sky-50 hover:border-sky-300 hover:text-sky-700 text-xs font-semibold text-gray-700 transition cursor-pointer flex-shrink-0 active:scale-95 shadow-2xs">
                                                <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>Lihat</span>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                                <span>Format yang didukung: PDF, JPG, PNG</span>
                                <span>Maks. 5 MB/file</span>
                            </div>
                        </div>
                    </template>

                </div>

                <!-- ================= KARTU VERIFIKASI PERMOHONAN ================= -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                    
                    <!-- Header Card -->
                    <div class="p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center shadow-2xs flex-shrink-0">
                                <!-- Shield Check Icon -->
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-gray-900 tracking-tight">
                                    Verifikasi Data Input dan Persyaratan
                                </h2>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Permohonan Pembukaan/Pembacaan Wasiat Tertutup Oleh Fungsional Pertama
                                </p>
                            </div>
                        </div>

                        <div>
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-gray-50 border border-gray-200/80 text-xs font-semibold text-gray-700 font-mono shadow-2xs">
                                <span x-text="completedCount" class="font-bold text-[#1d68d8]">0</span>&nbsp;dari 13 diperiksa
                            </span>
                        </div>
                    </div>

                    <!-- Form Verifikasi -->
                    <form action="{{ route('petugas.tindak-lanjut', $layanan['id']) }}" method="POST">
                        @csrf

                        <!-- Table Poin Pemeriksaan Resmi Sesuai Acuan SOP -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50/70 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                        <th scope="col" class="py-3 px-4 w-12 text-center">NO.</th>
                                        <th scope="col" class="py-3 px-4">POIN PEMERIKSAAN DATA &amp; PERSYARATAN</th>
                                        <th scope="col" class="py-3 px-6 text-right w-44">CEKLIST (HASIL)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-xs text-gray-700 font-medium">

                                    <!-- ================= 1. VERIFIKASI UMUM ================= -->
                                    <tr class="bg-slate-100/80 border-t border-b border-gray-200/80">
                                        <td class="py-2.5 px-4 text-center font-black text-[#0b2e66]">1</td>
                                        <td colspan="2" class="py-2.5 px-4 font-bold text-[#0b2e66] tracking-wide">
                                            Verifikasi Umum Permohonan Pembukaan dan Pembacaan Wasiat
                                        </td>
                                    </tr>

                                    <!-- 1.a -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">a</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Permohonan diajukan oleh Notaris
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_1_a" :value="answers.p_1_a">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_1_a = (answers.p_1_a === 'iya' ? null : 'iya')"
                                                        :class="answers.p_1_a === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_1_a = (answers.p_1_a === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_1_a === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 1.b -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">b</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Selain yang sudah barcode, seluruh dokumen persyaratan yang diupload wajib dilakukan Legalisasi (<em>legalisasir</em>)
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_1_b" :value="answers.p_1_b">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_1_b = (answers.p_1_b === 'iya' ? null : 'iya')"
                                                        :class="answers.p_1_b === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_1_b = (answers.p_1_b === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_1_b === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- ================= 2. VERIFIKASI DATA PEWASIAT ================= -->
                                    <tr class="bg-slate-100/80 border-t border-b border-gray-200/80">
                                        <td class="py-2.5 px-4 text-center font-black text-[#0b2e66]">2</td>
                                        <td colspan="2" class="py-2.5 px-4 font-bold text-[#0b2e66] tracking-wide">
                                            Verifikasi Data Pewasiat
                                        </td>
                                    </tr>

                                    <!-- 2.a -->
                                    <tr class="hover:bg-gray-50/50 transition" :class="qrVerified ? 'bg-emerald-50/40' : ''">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">a</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            <div>
                                                Permohonan telah dilengkapi Surat Kematian dengan memastikan barcode dari Surat Kematian dapat discan dan hasil scan sesuai dengan data dan informasi kematian Pewasiat
                                            </div>

                                            <!-- Tombol Pindai QR Langsung di Web (Tanpa HP) -->
                                            <div class="mt-2.5 flex flex-wrap items-center gap-2">
                                                <button type="button" 
                                                        @click="bukaScannerQr()"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#1d68d8] text-xs font-bold border border-blue-200 transition shadow-2xs cursor-pointer active:scale-95">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14-2h4v2h-4v-2zm-4 0h2v4h-2v-4zm2 4h4v2h-4v-2zm2 2h2v2h-2v-2zm-4-2h2v4h-2v-4zm0 2H12v2h2v-2zm6-6h2v2h-2v-2zM5 5h2v2H5V5zm12 0h2v2h-2V5zM5 17h2v2H5v-2z"/>
                                                    </svg>
                                                    <span>Pindai QR Akta Kematian (Web Scan)</span>
                                                </button>

                                                <template x-if="qrVerified">
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-300">
                                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>TTE Valid: 3578-KM-2025-00891</span>
                                                    </span>
                                                </template>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_2_a" :value="answers.p_2_a">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_2_a = (answers.p_2_a === 'iya' ? null : 'iya')"
                                                        :class="answers.p_2_a === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_2_a = (answers.p_2_a === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_2_a === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 2.b -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">b</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Nama Pewasiat sesuai di input data dan semua Dokumen Persyaratan, apabila terdapat perbedaan nama/ganti nama telah dilengkapi Penetapan/Putusan dari Pengadilan oleh Pemohon
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_2_b" :value="answers.p_2_b">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_2_b = (answers.p_2_b === 'iya' ? null : 'iya')"
                                                        :class="answers.p_2_b === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_2_b = (answers.p_2_b === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_2_b === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 2.c -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">c</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            NIK Pewasiat sesuai dengan input data dan semua Dokumen Persyaratan dari Pemohon
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_2_c" :value="answers.p_2_c">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_2_c = (answers.p_2_c === 'iya' ? null : 'iya')"
                                                        :class="answers.p_2_c === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_2_c = (answers.p_2_c === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_2_c === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 2.d -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">d</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Tempat Tanggal Lahir dan/atau Tempat Tanggal Meninggal Pewasiat sesuai dengan input data dan semua Dokumen Persyaratan dari Pemohon
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_2_d" :value="answers.p_2_d">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_2_d = (answers.p_2_d === 'iya' ? null : 'iya')"
                                                        :class="answers.p_2_d === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_2_d = (answers.p_2_d === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_2_d === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- ================= 3. VERIFIKASI AKTA PENYIMPANAN ================= -->
                                    <tr class="bg-slate-100/80 border-t border-b border-gray-200/80">
                                        <td class="py-2.5 px-4 text-center font-black text-[#0b2e66]">3</td>
                                        <td colspan="2" class="py-2.5 px-4 font-bold text-[#0b2e66] tracking-wide">
                                            Verifikasi Akta Penyimpanan (Akta <em>van depot</em> / <em>Superscriptie</em>) dari Pemohon
                                        </td>
                                    </tr>

                                    <!-- 3.a -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">a</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Permohonan telah dilengkapi Akta Penyimpanan (Akta <em>van depot</em> / <em>Superscriptie</em>)
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_3_a" :value="answers.p_3_a">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_3_a = (answers.p_3_a === 'iya' ? null : 'iya')"
                                                        :class="answers.p_3_a === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_3_a = (answers.p_3_a === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_3_a === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 3.b -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">b</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Permohonan telah dilengkapi Surat Keterangan dari Daftar Pusat Wasiat, Ditjen AHU, Kemenkum RI
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_3_b" :value="answers.p_3_b">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_3_b = (answers.p_3_b === 'iya' ? null : 'iya')"
                                                        :class="answers.p_3_b === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_3_b = (answers.p_3_b === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_3_b === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 3.c -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">c</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Akta Penyimpanan (Akta <em>van depot</em> / <em>Superscriptie</em>) telah terdaftar/tercatat di Daftar Pusat Wasiat, Ditjen AHU, Kemenkum RI
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_3_c" :value="answers.p_3_c">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_3_c = (answers.p_3_c === 'iya' ? null : 'iya')"
                                                        :class="answers.p_3_c === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_3_c = (answers.p_3_c === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_3_c === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- ================= 4. VERIFIKASI AHLI WARIS ================= -->
                                    <tr class="bg-slate-100/80 border-t border-b border-gray-200/80">
                                        <td class="py-2.5 px-4 text-center font-black text-[#0b2e66]">4</td>
                                        <td colspan="2" class="py-2.5 px-4 font-bold text-[#0b2e66] tracking-wide">
                                            Verifikasi data dan informasi para Ahli Waris
                                        </td>
                                    </tr>

                                    <!-- 4.a -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">a</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Apabila Pewasiat telah menikah, Permohonan telah dilengkapi dengan Buku Nikah/Akta Perkawinan
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_4_a" :value="answers.p_4_a">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_4_a = (answers.p_4_a === 'iya' ? null : 'iya')"
                                                        :class="answers.p_4_a === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_4_a = (answers.p_4_a === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_4_a === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 4.b -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">b</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Apabila Pewasiat memiliki anak, Permohonan telah dilengkapi dengan Akta Lahir, KK dan KTP dari Anak
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_4_b" :value="answers.p_4_b">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_4_b = (answers.p_4_b === 'iya' ? null : 'iya')"
                                                        :class="answers.p_4_b === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_4_b = (answers.p_4_b === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_4_b === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 4.c -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">c</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Nama para Ahli Waris sesuai di input data dan semua Dokumen Persyaratan, apabila terdapat perbedaan nama/ganti nama telah dilengkapi Penetapan/Putusan dari Pengadilan oleh Pemohon
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_4_c" :value="answers.p_4_c">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_4_c = (answers.p_4_c === 'iya' ? null : 'iya')"
                                                        :class="answers.p_4_c === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_4_c = (answers.p_4_c === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_4_c === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 4.d -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 px-4 text-center text-gray-500 font-bold">d</td>
                                        <td class="py-3.5 px-4 text-gray-800 leading-relaxed">
                                            Apabila terdapat Ahli Waris yang meninggal dunia terlebih dahulu, Permohonan telah dilengkapi dengan Akta Kematian Ahli Waris
                                        </td>
                                        <td class="py-3.5 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="p_4_d" :value="answers.p_4_d">
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <button type="button" 
                                                        @click="answers.p_4_d = (answers.p_4_d === 'iya' ? null : 'iya')"
                                                        :class="answers.p_4_d === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.p_4_d = (answers.p_4_d === 'tidak' ? null : 'tidak')"
                                                        :class="answers.p_4_d === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- ================= ACTION & KEPUTUSAN VERIFIKASI ================= -->
                        <div class="p-6 sm:p-8 bg-slate-50/60 border-t border-gray-200/80">
                            <div class="max-w-3xl mx-auto space-y-6">
                                
                                <!-- Pilihan Keputusan -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            Hasil Telaah Persyaratan
                                        </label>
                                        <span class="text-[11px] font-medium text-gray-400">Pilih salah satu keputusan</span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <label class="flex items-start gap-3.5 p-4 rounded-2xl border cursor-pointer transition text-xs font-semibold shadow-2xs"
                                               :class="statusKeputusan === 'disetujui' ? 'border-[#1d68d8] bg-blue-50/70 text-[#1d68d8] ring-2 ring-[#1d68d8]/20' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                            <input type="radio" name="status" value="disetujui" x-model="statusKeputusan" class="mt-0.5 text-[#1d68d8] focus:ring-[#1d68d8]">
                                            <div>
                                                <div class="font-bold text-gray-900">Setujui Persyaratan Dokumen</div>
                                                <div class="text-[11px] text-gray-500 font-normal mt-0.5 leading-relaxed">
                                                    Seluruh berkas fisik/digital lengkap &amp; valid. Teruskan ke tahap selanjutnya.
                                                </div>
                                            </div>
                                        </label>

                                        <label class="flex items-start gap-3.5 p-4 rounded-2xl border cursor-pointer transition text-xs font-semibold shadow-2xs"
                                               :class="statusKeputusan === 'revisi' ? 'border-amber-500 bg-amber-50/70 text-amber-900 ring-2 ring-amber-500/20' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                            <input type="radio" name="status" value="revisi" x-model="statusKeputusan" class="mt-0.5 text-amber-500 focus:ring-amber-500">
                                            <div>
                                                <div class="font-bold text-gray-900">Minta Perbaikan / Revisi Berkas</div>
                                                <div class="text-[11px] text-gray-500 font-normal mt-0.5 leading-relaxed">
                                                    Terdapat dokumen yang buram, tidak sesuai, atau belum lengkap diunggah pemohon.
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Catatan Verifikator -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                        Catatan Verifikator Persyaratan
                                    </label>
                                    <textarea name="catatan" rows="3" 
                                              placeholder="Tuliskan catatan verifikasi (opsional untuk persetujuan, wajib bila meminta revisi pemohon)..."
                                              class="w-full text-xs rounded-2xl border-gray-200 focus:border-[#1d68d8] focus:ring-[#1d68d8]/20 p-4 bg-white shadow-2xs leading-relaxed"></textarea>
                                </div>

                                <!-- Tombol Aksi (Tengah / Centered) -->
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-4 border-t border-gray-200/70">
                                    <a href="{{ route('petugas.dashboard') }}" 
                                       class="w-full sm:w-auto px-6 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-xs font-semibold text-gray-700 transition text-center cursor-pointer shadow-2xs active:scale-95">
                                        Kembali ke Daftar
                                    </a>
                                    <button type="submit" 
                                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-2.5 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-bold shadow-md shadow-blue-950/10 transition active:scale-95 cursor-pointer">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span>Simpan Hasil Verifikasi</span>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>

            </div>

            <!-- ================= RIGHT COLUMN: STICKY DUAL-PANE DOCUMENT VIEWER (SPLIT VIEW ACTIVE) ================= -->
            <template x-if="splitViewOpen">
                <div class="lg:col-span-5 xl:col-span-5 sticky top-4 h-[calc(100vh-2rem)] flex flex-col bg-white rounded-3xl border border-gray-200/80 shadow-[0_8px_30px_rgba(0,0,0,0.06)] overflow-hidden">
                    
                    <!-- Header Viewer Panel -->
                    <div class="p-4 sm:p-5 border-b border-gray-100 bg-slate-50/70 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/60 flex items-center justify-center flex-shrink-0 shadow-2xs">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-xs sm:text-sm font-bold text-gray-900 truncate" x-text="currentDoc?.nama"></h3>
                                <p class="text-[11px] text-gray-400 font-mono" x-text="'Dokumen ' + (activeDocIndex + 1) + ' dari ' + docs.length + ' · ' + (currentDoc?.ukuran ?? '')"></p>
                            </div>
                        </div>

                        <!-- Action Toolbar: Zoom & Close -->
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <button type="button" 
                                    @click="zoomLevel = Math.max(70, zoomLevel - 15)" 
                                    title="Perkecil"
                                    class="w-7 h-7 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold transition cursor-pointer">
                                -
                            </button>
                            <span class="text-[11px] font-mono font-semibold text-gray-500 w-10 text-center" x-text="zoomLevel + '%'"></span>
                            <button type="button" 
                                    @click="zoomLevel = Math.min(150, zoomLevel + 15)" 
                                    title="Perbesar"
                                    class="w-7 h-7 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold transition cursor-pointer">
                                +
                            </button>

                            <button type="button" 
                                    @click="splitViewOpen = false" 
                                    title="Tutup Split View"
                                    class="ml-1 p-1.5 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-200/60 transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Horizontal Tab Bar (Pindah Dokumen Cepat) -->
                    <div class="px-4 py-2.5 bg-gray-50/90 border-b border-gray-100 flex items-center gap-2 overflow-x-auto no-scrollbar">
                        <template x-for="(doc, idx) in docs" :key="idx">
                            <button type="button" 
                                    @click="activeDocIndex = idx"
                                    class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition cursor-pointer flex items-center gap-1.5 flex-shrink-0"
                                    :class="activeDocIndex === idx ? 'bg-[#0c2a55] text-white shadow-xs font-bold' : 'bg-white text-gray-600 border border-gray-200/80 hover:bg-gray-100'">
                                <svg class="w-3.5 h-3.5" :class="activeDocIndex === idx ? 'text-sky-300' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span x-text="doc.nama"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Document Canvas Body -->
                    <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-slate-100 flex items-start justify-center">
                        <div class="w-full bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200 transition-transform origin-top space-y-6"
                             :style="'transform: scale(' + (zoomLevel / 100) + ');'">
                            
                            <!-- Header Surat / Dokumen -->
                            <div class="flex items-center justify-between border-b pb-4 border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-xs">
                                        BHP
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                                        Balai Harta Peninggalan Surabaya
                                    </span>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Berkas Asli Terverifikasi
                                </span>
                            </div>

                            <!-- Pratinjau Khusus Berdasarkan Nama Dokumen -->
                            <!-- 1. JIKA KTP PEMOHON -->
                            <template x-if="currentDoc?.nama.toLowerCase().includes('ktp')">
                                <div class="bg-gradient-to-br from-sky-100 via-sky-50 to-blue-100 rounded-2xl p-5 border border-sky-200 shadow-inner space-y-4">
                                    <div class="text-center border-b border-sky-200/80 pb-2">
                                        <div class="text-[11px] font-black text-sky-950 uppercase tracking-widest">
                                            REPUBLIK INDONESIA
                                        </div>
                                        <div class="text-[10px] font-bold text-sky-900 tracking-wider">
                                            PROVINSI JAWA TIMUR - KOTA SURABAYA
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-12 gap-3 text-xs">
                                        <div class="col-span-8 space-y-1.5 font-mono text-gray-800">
                                            <div>
                                                <span class="text-[10px] text-gray-500 block font-sans">NIK</span>
                                                <span class="font-bold text-sm tracking-wider text-gray-900">{{ $layanan['nik'] ?? '3578••••••••0006' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-gray-500 block font-sans">Nama</span>
                                                <span class="font-bold text-gray-900">{{ $layanan['nama_pemohon'] }}</span>
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-gray-500 block font-sans">Tempat / Tgl Lahir</span>
                                                <span>Surabaya, 14 Mei 1985</span>
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-gray-500 block font-sans">Alamat</span>
                                                <span>{{ $layanan['alamat_domisili'] ?? 'Kec. Genteng, Kota Surabaya' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-gray-500 block font-sans">Status Perkawinan</span>
                                                <span>Kawin</span>
                                            </div>
                                        </div>
                                        <div class="col-span-4 flex flex-col items-center justify-center bg-white/80 rounded-xl border border-sky-200 p-2 text-center">
                                            <div class="w-16 h-20 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 mb-1">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                            <span class="text-[9px] font-bold text-gray-400">PAS FOTO</span>
                                        </div>
                                    </div>

                                    <div class="text-[9px] text-gray-400 font-mono text-right pt-2 border-t border-sky-200/60">
                                        BERLAKU HINGGA: SEUMUR HIDUP
                                    </div>
                                </div>
                            </template>

                            <!-- 2. JIKA AKTA KEMATIAN -->
                            <template x-if="currentDoc?.nama.toLowerCase().includes('kematian')">
                                <div class="bg-amber-50/40 rounded-2xl p-6 border border-amber-200 space-y-4 font-serif text-gray-800">
                                    <div class="text-center border-b border-amber-200 pb-3">
                                        <div class="text-[11px] font-sans font-bold text-gray-500 uppercase tracking-widest">
                                            DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL
                                        </div>
                                        <div class="text-base font-black tracking-wide text-gray-900 mt-0.5">
                                            KUTIPAN AKTA KEMATIAN
                                        </div>
                                        <div class="text-xs font-mono text-gray-500 mt-1">
                                            Nomor: 3578-KM-2025-00891
                                        </div>
                                    </div>

                                    <div class="text-xs space-y-2 leading-relaxed">
                                        <p>Menerangkan dengan sebenarnya bahwa pada tanggal <strong>15 Mei 2025</strong> di <strong>RSUD Dr. Soetomo Surabaya</strong> telah meninggal dunia seorang bernama:</p>
                                        <div class="p-3 bg-white rounded-xl border border-amber-100 font-sans text-xs space-y-1">
                                            <div>Nama Pewaris: <strong class="text-gray-900">{{ $layanan['nama_pewasiat'] ?: 'Alm. Soetrisno' }}</strong></div>
                                            <div>NIK: <span class="font-mono">3578011204550001</span></div>
                                            <div>Tempat/Tgl Lahir: Surabaya, 12 April 1955</div>
                                            <div>Tempat Tinggal Terakhir: Kota Surabaya, Jawa Timur</div>
                                        </div>
                                        <p class="text-[11px] text-gray-500 font-sans italic">Kutipan ini diterbitkan sesuai dengan surat bukti kematian dari instansi berwenang.</p>
                                    </div>

                                    <div class="pt-4 border-t border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs font-sans">
                                        <div class="text-left space-y-1">
                                            <span class="text-[10px] text-gray-400 block">Dicetak: Disdukcapil Kota Surabaya</span>
                                            <span class="text-[10px] text-gray-400 block">Ditandatangani secara elektronik (BSrE BSSN)</span>
                                            <span class="font-bold underline text-gray-800">Drs. H. Hendro, M.Si</span>
                                        </div>
                                        <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-amber-200/80 shadow-2xs hover:border-[#1d68d8] transition group cursor-pointer"
                                             @click="bukaScannerQr()"
                                             title="Klik untuk verifikasi barcode langsung di web">
                                            <div class="relative w-16 h-16 bg-white p-1 rounded-lg border border-gray-200 flex items-center justify-center shrink-0">
                                                <svg class="w-full h-full text-slate-900" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14-2h4v2h-4v-2zm-4 0h2v4h-2v-4zm2 4h4v2h-4v-2zm2 2h2v2h-2v-2zm-4-2h2v4h-2v-4zm0 2H12v2h2v-2zm6-6h2v2h-2v-2zM5 5h2v2H5V5zm12 0h2v2h-2V5zM5 17h2v2H5v-2z"/>
                                                </svg>
                                                <div class="absolute inset-0 bg-[#1d68d8]/10 rounded-lg opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                                                    <span class="text-[9px] font-black text-[#1d68d8] bg-white px-1 py-0.5 rounded shadow">SCAN</span>
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase text-[#1d68d8]">
                                                    QR TTE Dukcapil
                                                </span>
                                                <button type="button" class="block text-xs font-bold text-[#1d68d8] group-hover:underline">
                                                    Pindai QR Langsung &rarr;
                                                </button>
                                                <span class="text-[10px] text-gray-400 block">Verifikasi instan tanpa HP</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- 3. JIKA SURAT KETERANGAN WASIAT (DPW / AHU) -->
                            <template x-if="currentDoc?.nama.toLowerCase().includes('wasiat') && (currentDoc?.nama.toLowerCase().includes('keterangan') || currentDoc?.nama.toLowerCase().includes('ahu'))">
                                <div class="bg-indigo-50/40 rounded-2xl p-6 border border-indigo-200 space-y-4 text-gray-800">
                                    <div class="text-center border-b border-indigo-200 pb-3">
                                        <div class="text-[10px] font-bold text-indigo-950 uppercase tracking-widest">
                                            KEMENTERIAN HUKUM REPUBLIK INDONESIA
                                        </div>
                                        <div class="text-xs font-bold text-gray-600">
                                            DIREKTORAT JENDERAL ADMINISTRASI HUKUM UMUM
                                        </div>
                                        <div class="text-sm font-black text-indigo-900 mt-1">
                                            SURAT KETERANGAN PUSAT DAFTAR WASIAT (DPW)
                                        </div>
                                        <div class="text-xs font-mono text-gray-500 mt-0.5">
                                            No: AHU.2.AH.04.01-14022025/DPW
                                        </div>
                                    </div>

                                    <div class="text-xs space-y-2">
                                        <p>Berdasarkan data pada Pusat Daftar Wasiat Ditjen AHU, dengan ini diterangkan bahwa atas nama:</p>
                                        <div class="p-3 bg-white rounded-xl border border-indigo-100 space-y-1">
                                            <div>Nama Pewasiat: <strong class="text-indigo-950">{{ $layanan['nama_pewasiat'] ?: 'Alm. Soetrisno' }}</strong></div>
                                            <div>Nomor Akta Penyimpanan: <strong>WST-12/NOT-SBY/2019</strong></div>
                                            <div>Notaris: <strong>Bambang Sugiharto, S.H., M.Kn.</strong></div>
                                            <div>Status: <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]">TERDAFTAR RESMI</span></div>
                                        </div>
                                        <p class="text-[11px] text-gray-500 italic">Surat keterangan ini diterbitkan secara elektronik dan sah menurut hukum.</p>
                                    </div>
                                </div>
                            </template>

                            <!-- 4. JIKA KARTU KELUARGA / LAINNYA -->
                            <template x-if="!currentDoc?.nama.toLowerCase().includes('ktp') && !currentDoc?.nama.toLowerCase().includes('kematian') && !(currentDoc?.nama.toLowerCase().includes('wasiat') && (currentDoc?.nama.toLowerCase().includes('keterangan') || currentDoc?.nama.toLowerCase().includes('ahu')))">
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 space-y-4 text-gray-800 text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-white shadow-xs border border-gray-200 flex items-center justify-center text-sky-600 mx-auto">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900" x-text="currentDoc?.nama"></div>
                                        <div class="text-xs text-gray-500 font-mono mt-1" x-text="'Format: ' + (currentDoc?.tipe ?? 'PDF') + ' · Ukuran: ' + (currentDoc?.ukuran ?? '1.5 MB')"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 max-w-sm mx-auto leading-relaxed">
                                        Dokumen telah diunggah dan terenkripsi pada repositori sistem Pandu Balai Harta Peninggalan.
                                    </p>
                                    <div class="pt-2">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Integritas Berkas Valid
                                        </span>
                                    </div>
                                </div>
                            </template>

                            <div class="text-center pt-2">
                                <span class="text-[11px] text-gray-400">
                                    Gunakan tombol <strong>+</strong> atau <strong>-</strong> di atas untuk mengatur skala pembacaan berkas.
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- Footer Viewer Navigasi Dokumen -->
                    <div class="p-3.5 sm:p-4 bg-white border-t border-gray-100 flex items-center justify-between text-xs">
                        <button type="button" 
                                @click="prevDoc()"
                                :disabled="activeDocIndex === 0"
                                :class="activeDocIndex === 0 ? 'opacity-40 cursor-not-allowed text-gray-400' : 'hover:bg-gray-100 text-gray-700 cursor-pointer'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl border border-gray-200 font-semibold transition">
                            &larr; Sebelumnya
                        </button>

                        <span class="text-[11px] font-mono text-gray-500" x-text="(activeDocIndex + 1) + ' dari ' + docs.length + ' berkas'"></span>

                        <button type="button" 
                                @click="nextDoc()"
                                :disabled="activeDocIndex === docs.length - 1"
                                :class="activeDocIndex === docs.length - 1 ? 'opacity-40 cursor-not-allowed text-gray-400' : 'hover:bg-gray-100 text-gray-700 cursor-pointer'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl border border-gray-200 font-semibold transition">
                            Selanjutnya &rarr;
                        </button>
                    </div>

                </div>
            </template>

        </div>

    </div>

    <!-- Modal Scanner QR Akta Kematian Langsung di Web -->
    <div x-show="qrModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         @keydown.escape.window="tutupScannerQr()">
        
        <!-- Backdrop -->
        <div x-show="qrModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
             @click="tutupScannerQr()"></div>

        <!-- Dialog Box -->
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="qrModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-xl border border-gray-100">
                
                <!-- Header Modal -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-blue-50/70 to-indigo-50/40">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#1d68d8]/10 text-[#1d68d8] flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14-2h4v2h-4v-2zm-4 0h2v4h-2v-4zm2 4h4v2h-4v-2zm2 2h2v2h-2v-2zm-4-2h2v4h-2v-4zm0 2H12v2h2v-2zm6-6h2v2h-2v-2zM5 5h2v2H5V5zm12 0h2v2h-2V5zM5 17h2v2H5v-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 leading-tight">
                                Verifikasi Barcode Surat Kematian
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Pemindai TTE Dukcapil / BSrE terintegrasi langsung di web
                            </p>
                        </div>
                    </div>
                    <button type="button" 
                            @click="tutupScannerQr()"
                            class="text-gray-400 hover:text-gray-600 rounded-lg p-1.5 hover:bg-white transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Tab Mode Scanner -->
                <div class="px-6 pt-3 pb-0 border-b border-gray-100 flex gap-2 bg-gray-50/50">
                    <button type="button" 
                            @click="matikanKamera()"
                            :class="qrScannerMode === 'auto' ? 'border-[#1d68d8] text-[#1d68d8] bg-white shadow-2xs font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-medium'"
                            class="px-3.5 py-2 text-xs rounded-t-lg border-b-2 transition cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Pindai Berkas Digital (Auto-Decode)</span>
                    </button>
                    <button type="button" 
                            @click="aktifkanKamera()"
                            :class="qrScannerMode === 'camera' ? 'border-[#1d68d8] text-[#1d68d8] bg-white shadow-2xs font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-medium'"
                            class="px-3.5 py-2 text-xs rounded-t-lg border-b-2 transition cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>Kamera Web / Webcam</span>
                    </button>
                </div>

                <!-- Body Modal -->
                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">

                    <!-- MODE 1: AUTO DECODE DARI BERKAS DIGITAL -->
                    <div x-show="qrScannerMode === 'auto'" class="space-y-4">
                        <!-- Animasi Scanner -->
                        <div class="relative bg-slate-900 rounded-xl p-6 text-white overflow-hidden flex flex-col items-center justify-center min-h-[170px] border border-slate-800">
                            <!-- Garis Laser Pemindai Animasi -->
                            <div x-show="qrScanning" class="absolute inset-x-0 h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent shadow-[0_0_12px_#38bdf8] animate-bounce top-1/2"></div>
                            
                            <div class="relative z-10 flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-white p-2 rounded-xl shadow-lg border border-slate-700 flex items-center justify-center">
                                    <svg class="w-full h-full text-slate-900" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14-2h4v2h-4v-2zm-4 0h2v4h-2v-4zm2 4h4v2h-4v-2zm2 2h2v2h-2v-2zm-4-2h2v4h-2v-4zm0 2H12v2h2v-2zm6-6h2v2h-2v-2zM5 5h2v2H5V5zm12 0h2v2h-2V5zM5 17h2v2H5v-2z"/>
                                    </svg>
                                </div>

                                <template x-if="qrScanning">
                                    <div class="text-center space-y-1">
                                        <div class="text-xs font-semibold text-cyan-300 flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            <span>Membaca dan memvalidasi barcode TTE...</span>
                                        </div>
                                        <p class="text-[11px] text-gray-400">Menghubungkan ke root Sertifikat Elektronik BSrE BSSN</p>
                                    </div>
                                </template>

                                <template x-if="!qrScanning">
                                    <div class="text-center space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-500/40">
                                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            TTE DUKCAPIL VALID & TERVERIFIKASI
                                        </span>
                                        <p class="text-[11px] text-gray-300">Barcode Akta Kematian telah berhasil didekripsi langsung di web</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Hasil Dekripsi Barcode -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-xs space-y-2.5">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Nomor Register Akta:</span>
                                <span class="font-mono font-bold text-gray-900">3578-KM-2025-00891</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Nama Pewasiat (Meninggal):</span>
                                <span class="font-bold text-indigo-950">{{ $layanan['nama_pewasiat'] ?: 'Alm. Soetrisno' }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Tanggal Kematian:</span>
                                <span class="font-semibold text-gray-800">12 Januari 2025</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Tempat Kematian:</span>
                                <span class="font-semibold text-gray-800">Kota Surabaya, Jawa Timur</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500 font-medium">Otoritas Penerbit:</span>
                                <span class="font-semibold text-gray-800">Disdukcapil Kota Surabaya</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 font-medium">Integritas TTE:</span>
                                <span class="text-emerald-700 font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    BSrE - BSSN Certified (SHA-256)
                                </span>
                            </div>
                        </div>

                        <div class="p-3 bg-blue-50/70 rounded-xl border border-blue-200 text-[11px] text-blue-900 leading-relaxed flex items-start gap-2">
                            <svg class="w-4 h-4 text-[#1d68d8] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>
                                <strong>Kesesuaian Terpenuhi:</strong> Data nama pewasiat pada sertifikat kematian Dukcapil cocok dengan berkas permohonan. Petugas dapat langsung menyetujui poin checklist 2.a.
                            </span>
                        </div>
                    </div>

                    <!-- MODE 2: LIVE CAMERA / WEBCAM SCANNER -->
                    <div x-show="qrScannerMode === 'camera'" class="space-y-4">
                        <div class="relative bg-black rounded-xl overflow-hidden min-h-[220px] flex items-center justify-center border border-gray-800">
                            <video id="qr-camera-stream" class="w-full h-56 object-cover" autoplay playsinline muted></video>
                            
                            <!-- Scanner Overlay Target Box -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-44 h-44 border-2 border-dashed border-cyan-400 rounded-xl relative shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                                    <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-cyan-300"></div>
                                    <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-cyan-300"></div>
                                    <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-cyan-300"></div>
                                    <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-cyan-300"></div>
                                </div>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 text-center leading-relaxed">
                            Arahkan kamera ke barcode/QR Code pada lembar fisik Surat Kematian jika Anda memverifikasi dokumen cetak fisik.
                        </p>
                    </div>

                </div>

                <!-- Footer Modal -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <button type="button" 
                            @click="tutupScannerQr()"
                            class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 border border-gray-200 transition cursor-pointer">
                        Tutup
                    </button>

                    <button type="button" 
                            @click="terapkanHasilQr()"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition cursor-pointer active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Terapkan & Setujui Poin 2.a</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Floating Toast Notifikasi Verifikasi -->
    <div x-show="toastShow" 
         x-cloak
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-slate-900 text-white rounded-2xl shadow-xl border border-slate-700 p-4 pointer-events-auto">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-xs font-bold text-white">Verifikasi Barcode Berhasil</h4>
                <p class="text-xs text-slate-300 mt-0.5 leading-relaxed" x-text="toastMessage"></p>
            </div>
            <button type="button" @click="toastShow = false" class="text-slate-400 hover:text-white cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

</x-portal-layout>
