<x-portal-layout>
    <x-slot name="title">
        Verifikasi Persyaratan - {{ $layanan['nomor_layanan'] }}
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6"
         x-data="{
             previewModalOpen: false,
             selectedDoc: null,
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
             openPreview(doc) {
                 this.selectedDoc = doc;
                 this.previewModalOpen = true;
             }
         }">

        <!-- ================= BREADCRUMB & HEADER ================= -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Daftar Layanan</span>
                </a>
                <span class="text-xs text-gray-400 font-mono hidden sm:inline">/</span>
                <span class="text-xs font-bold text-gray-500 font-mono hidden sm:inline">
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

        <!-- ================= TOP GRID (2 COLUMNS) ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- KARTU KIRI: DATA INPUT PEMOHON -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                <div>
                    <!-- Header Kartu -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shadow-2xs flex-shrink-0">
                            <!-- User Avatar Icon -->
                            <svg class="w-5 h-5 text-[#10b981]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-gray-900 tracking-tight">
                            Data Input Pemohon
                        </h2>
                    </div>

                    <!-- Fields Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-6">
                        <!-- NAMA LENGKAP -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                                NAMA LENGKAP
                            </div>
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $layanan['nama_pemohon'] }}
                            </div>
                        </div>

                        <!-- NIK -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                                NIK
                            </div>
                            <div class="text-sm font-semibold text-gray-900 font-mono">
                                {{ $layanan['nik'] ?? '3578••••••••0006' }}
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                                EMAIL
                            </div>
                            <div class="text-sm font-medium text-gray-700">
                                {{ $layanan['email'] ?? 'pemohon@email.com' }}
                            </div>
                        </div>

                        <!-- NOMOR TELEPON -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                                NOMOR TELEPON
                            </div>
                            <div class="text-sm font-medium text-gray-700 font-mono">
                                {{ $layanan['nomor_telepon'] ?? '0812 •••• 8841' }}
                            </div>
                        </div>

                        <!-- ALAMAT DOMISILI -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                                ALAMAT DOMISILI
                            </div>
                            <div class="text-sm font-medium text-gray-700">
                                {{ $layanan['alamat_domisili'] ?? 'Kec. Genteng, Kota Surabaya' }}
                            </div>
                        </div>

                        <!-- JENIS PERMOHONAN -->
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                                JENIS PERMOHONAN
                            </div>
                            <div class="text-sm font-medium text-gray-700">
                                {{ $layanan['detail_layanan'] }}
                            </div>
                        </div>
                    </div>
                </div>

                @if (!empty($layanan['nama_pewasiat']))
                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="text-gray-400 font-medium">Nama Pewaris / Pewasiat:</span>
                        <span class="font-bold text-gray-800">{{ $layanan['nama_pewasiat'] }}</span>
                    </div>
                @endif
            </div>

            <!-- KARTU KANAN: DOKUMEN PERSYARATAN -->
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
                            <h2 class="text-base font-bold text-gray-900 tracking-tight">
                                Dokumen Persyaratan
                            </h2>
                        </div>
                        <span class="text-xs text-gray-400 font-medium">
                            {{ count($layanan['dokumen_list'] ?? []) }} dokumen diunggah
                        </span>
                    </div>

                    <!-- List Dokumen -->
                    <div class="space-y-3">
                        @forelse ($layanan['dokumen_list'] ?? [] as $doc)
                            <div class="bg-white border border-gray-100 rounded-2xl p-3.5 sm:p-4 flex items-center justify-between hover:border-gray-200 transition group shadow-2xs">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:text-gray-600 transition flex-shrink-0">
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
                                        @click="openPreview({{ json_encode($doc) }})"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 text-xs font-semibold text-gray-700 transition cursor-pointer flex-shrink-0 active:scale-95 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Lihat</span>
                                </button>
                            </div>
                        @empty
                            <div class="p-6 text-center text-xs text-gray-400">
                                Belum ada dokumen persyaratan yang diunggah.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                    <span>Format yang didukung: PDF, JPG, PNG</span>
                    <span>Maks. 5 MB/file</span>
                </div>
            </div>

        </div>

        <!-- ================= BOTTOM CARD: VERIFIKASI PERMOHONAN ================= -->
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
                        <span x-text="completedCount">0</span>&nbsp;dari 7 diperiksa
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

        <!-- ================= MODAL PREVIEW DOKUMEN ================= -->
        <div x-show="previewModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4" 
             style="display: none;" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div @click.away="previewModalOpen = false" 
                 class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl space-y-5 border border-gray-100">
                
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900" x-text="selectedDoc?.nama">Pratinjau Dokumen</h3>
                            <p class="text-[11px] text-gray-400 font-mono mt-0.5" x-text="(selectedDoc?.tipe ?? 'PDF') + ' · ' + (selectedDoc?.ukuran ?? '')"></p>
                        </div>
                    </div>
                    <button @click="previewModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-xl hover:bg-gray-100 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Preview Dummy Document Box -->
                <div class="h-80 bg-gray-50 border border-dashed border-gray-200 rounded-2xl flex flex-col items-center justify-center p-6 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-xs border border-gray-200/80 flex items-center justify-center text-gray-400 mb-3">
                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-800 text-sm" x-text="selectedDoc?.nama"></div>
                    <div class="text-xs text-gray-400 max-w-sm mt-1">
                        Dokumen digital terenkripsi tersimpan pada repositori berkas Balai Harta Peninggalan.
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mt-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Status File: Terunggah &amp; Valid
                    </span>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" @click="previewModalOpen = false" 
                            class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                        Tutup
                    </button>
                </div>

            </div>
        </div>

    </div>
</x-portal-layout>
