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
                 poin1: null,
                 poin2: null,
                 poin3: null,
                 poin4: '',
                 poin5: null,
                 poin6: null,
                 poin7: null,
             },
             statusKeputusan: 'disetujui',
             get currentDoc() {
                 return this.docs[this.activeDocIndex] || this.docs[0] || null;
             },
             get completedCount() {
                 let count = 0;
                 if (this.answers.poin1 !== null) count++;
                 if (this.answers.poin2 !== null) count++;
                 if (this.answers.poin3 !== null) count++;
                 if (this.answers.poin4 !== '') count++;
                 if (this.answers.poin5 !== null) count++;
                 if (this.answers.poin6 !== null) count++;
                 if (this.answers.poin7 !== null) count++;
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

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Toggle Button Mode Bandingkan / Split View -->
                <button type="button" 
                        @click="splitViewOpen = !splitViewOpen"
                        :class="splitViewOpen ? 'bg-sky-50 text-sky-700 border-sky-300 ring-2 ring-sky-500/20' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border text-xs font-bold transition active:scale-95 shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4" :class="splitViewOpen ? 'text-sky-600' : 'text-gray-500'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <span x-text="splitViewOpen ? 'Tutup Mode Bandingkan (Side-by-Side)' : 'Mode Bandingkan Dokumen (Side-by-Side)'"></span>
                    <span class="text-[10px] uppercase tracking-wider px-1.5 py-0.5 rounded font-bold"
                          :class="splitViewOpen ? 'bg-sky-200 text-sky-900' : 'bg-gray-100 text-gray-500'"
                          x-text="splitViewOpen ? 'Aktif' : 'Split'"></span>
                </button>

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
                                        <p class="text-[11px] text-gray-400">Data resmi yang dimasukkan pada form permohonan</p>
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
                                            <p class="text-[11px] text-gray-400">Klik "Lihat" untuk membuka mode perbandingan langsung</p>
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
                                <span>Format: PDF, JPG, PNG</span>
                                <span class="text-sky-600 font-semibold cursor-pointer hover:underline" @click="openDocSplit(0)">
                                    Buka Mode Bandingkan &rarr;
                                </span>
                            </div>
                        </div>
                    </template>

                </div>

                <!-- ================= KARTU VERIFIKASI PERMOHONAN ================= -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                    
                    <!-- Header Card -->
                    <div class="p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center shadow-2xs flex-shrink-0">
                                <!-- Shield Check Icon -->
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-gray-900 tracking-tight">
                                    Verifikasi Permohonan
                                </h2>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    Bandingkan data permohonan dengan dokumen yang telah diunggah.
                                </p>
                            </div>
                        </div>

                        <div>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-200/80 text-xs font-semibold text-gray-600 font-mono shadow-2xs">
                                <span x-text="completedCount" class="font-bold text-[#1d68d8]">0</span>&nbsp;dari 7 diperiksa
                            </span>
                        </div>
                    </div>

                    <!-- Form Verifikasi -->
                    <form action="{{ route('petugas.tindak-lanjut', $layanan['id']) }}" method="POST">
                        @csrf

                        <!-- Table Poin Pemeriksaan -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/40 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                        <th scope="col" class="py-3 px-4 w-12 text-center">NO.</th>
                                        <th scope="col" class="py-3 px-4">POIN PEMERIKSAAN</th>
                                        <th scope="col" class="py-3 px-6 text-right">HASIL PEMERIKSAAN</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-xs text-gray-700 font-medium">

                                    <!-- POIN 1 -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold">1</td>
                                        <td class="py-4 px-4 text-gray-800">
                                            Ada Akta Kematian dan scan Akta Kematian.
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="poin1" :value="answers.poin1">
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <button type="button" 
                                                        @click="answers.poin1 = (answers.poin1 === 'iya' ? null : 'iya')"
                                                        :class="answers.poin1 === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.poin1 = (answers.poin1 === 'tidak' ? null : 'tidak')"
                                                        :class="answers.poin1 === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- POIN 2 -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold">2</td>
                                        <td class="py-4 px-4 text-gray-800">
                                            Ada Surat Keterangan Wasiat dari DPW, Ditjen AHU, dan hasil scan.
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="poin2" :value="answers.poin2">
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <button type="button" 
                                                        @click="answers.poin2 = (answers.poin2 === 'iya' ? null : 'iya')"
                                                        :class="answers.poin2 === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.poin2 = (answers.poin2 === 'tidak' ? null : 'tidak')"
                                                        :class="answers.poin2 === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- POIN 3 -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold">3</td>
                                        <td class="py-4 px-4 text-gray-800">
                                            Data pada Surat Keterangan Wasiat dari DPW dan Ditjen AHU sama dengan Akta Penyimpanan Wasiat.
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="poin3" :value="answers.poin3">
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <button type="button" 
                                                        @click="answers.poin3 = (answers.poin3 === 'iya' ? null : 'iya')"
                                                        :class="answers.poin3 === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.poin3 = (answers.poin3 === 'tidak' ? null : 'tidak')"
                                                        :class="answers.poin3 === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- POIN 4 (DROPDOWN) -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold align-middle">4</td>
                                        <td class="py-4 px-4">
                                            <div class="text-gray-800">
                                                Kesesuaian nama pewasiat pada Akta Kematian dan Akta Penyimpanan Wasiat.
                                            </div>
                                            <div class="text-[11px] text-gray-400 mt-0.5">
                                                Pilih kondisi yang ditemukan pada kedua dokumen.
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap align-middle">
                                            <select name="poin4" 
                                                    x-model="answers.poin4"
                                                    class="text-xs font-medium rounded-xl border border-gray-200 bg-white py-2 px-3 text-gray-700 focus:ring-1 focus:ring-sky-500 focus:border-sky-500 transition shadow-2xs">
                                                <option value="">Pilih kondisi nama</option>
                                                <option value="sesuai">Nama Sama Sesuai</option>
                                                <option value="beda_dengan_keterangan">Perbedaan Nama (Ada Penetapan / Keterangan)</option>
                                                <option value="tidak_sesuai">Nama Tidak Sesuai (Perlu Revisi)</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- POIN 5 -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold">5</td>
                                        <td class="py-4 px-4 text-gray-800">
                                            Dokumen perkawinan pewasiat tersedia dan sesuai.
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="poin5" :value="answers.poin5">
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <button type="button" 
                                                        @click="answers.poin5 = (answers.poin5 === 'iya' ? null : 'iya')"
                                                        :class="answers.poin5 === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.poin5 = (answers.poin5 === 'tidak' ? null : 'tidak')"
                                                        :class="answers.poin5 === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- POIN 6 -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold">6</td>
                                        <td class="py-4 px-4 text-gray-800">
                                            Pewasiat memiliki ahli waris.
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="poin6" :value="answers.poin6">
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <button type="button" 
                                                        @click="answers.poin6 = (answers.poin6 === 'iya' ? null : 'iya')"
                                                        :class="answers.poin6 === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.poin6 = (answers.poin6 === 'tidak' ? null : 'tidak')"
                                                        :class="answers.poin6 === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- POIN 7 -->
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4 text-center text-gray-400 font-semibold">7</td>
                                        <td class="py-4 px-4 text-gray-800">
                                            Semua data dan dokumen ahli waris yang diinput telah lengkap dan sesuai.
                                        </td>
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <input type="hidden" name="poin7" :value="answers.poin7">
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <button type="button" 
                                                        @click="answers.poin7 = (answers.poin7 === 'iya' ? null : 'iya')"
                                                        :class="answers.poin7 === 'iya' ? 'bg-[#10b981] text-white border-[#10b981] shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Iya
                                                </button>
                                                <button type="button" 
                                                        @click="answers.poin7 = (answers.poin7 === 'tidak' ? null : 'tidak')"
                                                        :class="answers.poin7 === 'tidak' ? 'bg-rose-500 text-white border-rose-500 shadow-xs font-bold' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'"
                                                        class="px-4 py-1.5 rounded-lg border text-xs font-semibold transition cursor-pointer active:scale-95">
                                                    Tidak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- ================= ACTION & KEPUTUSAN VERIFIKASI ================= -->
                        <div class="p-6 sm:p-7 bg-slate-50/50 border-t border-gray-100 space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">
                                    Hasil Telaah Persyaratan
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
                                    <label class="flex items-start gap-3 p-4 rounded-2xl border cursor-pointer transition text-xs font-semibold shadow-2xs"
                                           :class="statusKeputusan === 'disetujui' ? 'border-[#1d68d8] bg-blue-50/60 text-[#1d68d8] ring-2 ring-[#1d68d8]/20' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                        <input type="radio" name="status" value="disetujui" x-model="statusKeputusan" class="mt-0.5 text-[#1d68d8] focus:ring-[#1d68d8]">
                                        <div>
                                            <div class="font-bold text-gray-900">Setujui Persyaratan Dokumen</div>
                                            <div class="text-[11px] text-gray-500 font-normal mt-0.5">
                                                Seluruh berkas fisik/digital lengkap & valid. Teruskan ke tahap selanjutnya.
                                            </div>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 p-4 rounded-2xl border cursor-pointer transition text-xs font-semibold shadow-2xs"
                                           :class="statusKeputusan === 'revisi' ? 'border-amber-500 bg-amber-50/60 text-amber-900 ring-2 ring-amber-500/20' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                        <input type="radio" name="status" value="revisi" x-model="statusKeputusan" class="mt-0.5 text-amber-500 focus:ring-amber-500">
                                        <div>
                                            <div class="font-bold text-gray-900">Minta Perbaikan / Revisi Berkas</div>
                                            <div class="text-[11px] text-gray-500 font-normal mt-0.5">
                                                Terdapat dokumen yang buram, tidak sesuai, atau belum lengkap diunggah pemohon.
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Catatan Verifikator -->
                            <div class="max-w-3xl">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Catatan Verifikator Persyaratan
                                </label>
                                <textarea name="catatan" rows="3" 
                                          placeholder="Tuliskan catatan verifikasi (opsional untuk persetujuan, wajib bila meminta revisi pemohon)..."
                                          class="w-full text-xs rounded-2xl border-gray-200 focus:border-[#1d68d8] focus:ring-[#1d68d8]/20 p-3.5 bg-white shadow-2xs"></textarea>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-200/60">
                                <a href="{{ route('petugas.dashboard') }}" 
                                   class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-100 transition text-center cursor-pointer">
                                    Kembali ke Daftar
                                </a>
                                <button type="submit" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-bold shadow-md shadow-blue-950/10 transition active:scale-95 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span>Simpan Hasil Verifikasi</span>
                                </button>
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

                                    <div class="pt-4 border-t border-amber-200 flex justify-between items-end text-xs font-sans">
                                        <span class="text-[10px] text-gray-400">Dicetak: Disdukcapil Surabaya</span>
                                        <div class="text-center">
                                            <span class="text-[10px] text-gray-400 block mb-1">Kepala Dinas</span>
                                            <span class="font-bold underline text-gray-800">Drs. H. Hendro, M.Si</span>
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
</x-portal-layout>
