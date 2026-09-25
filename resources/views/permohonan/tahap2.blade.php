<x-portal-layout>
    <x-slot name="title">
        Form Pengajuan Wasiat Tertutup - Tahap 2
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
        files: {
            surat_kuasa: null,
            akta_kematian: null,
            surat_keterangan_wasiat: null,
            akta_penyimpanan_wasiat: null,
            buku_nikah: null,
            akta_lahir_ktp_kk: null,
            dokumen_lainnya: null
        },
        handleFileChange(event, key) {
            const file = event.target.files[0];
            if (file) {
                this.files[key] = {
                    name: file.name,
                    size: (file.size / 1024 / 1024).toFixed(2) + ' MB'
                };
            }
        },
        triggerUpload(key) {
            this.$refs['input_' + key].click();
        }
    }">
        <!-- Header: Pembukaan Wasiat Tertutup -->
        <div class="mb-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Pembukaan Wasiat Tertutup
            </span>
        </div>

        <!-- Breadcrumb / Back button -->
        <div class="mb-3">
            <a href="{{ route('permohonan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Header Title -->
        <div class="mb-6">
            <h2 class="text-2xl sm:text-[28px] font-bold text-[#0f172a] tracking-tight">
                Form Pengajuan Wasiat Tertutup
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Lengkapi data di bawah ini untuk memulai proses pengajuan wasiat tertutup.
            </p>
        </div>

        <!-- Stepper Progress Bar (Tahap 1, 2, 3, 4) -->
        <div class="bg-white rounded-xl border border-gray-200/80 p-4 sm:p-5 mb-8 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
            <div class="flex items-center justify-between gap-2" style="display: flex; flex-direction: row; width: 100%;">
                <!-- Tahap 1 (Selesai/Link) -->
                <a href="{{ route('permohonan.create') }}" class="flex-1 flex items-center gap-3 group" style="flex: 1;">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-700 group-hover:text-purple-700 leading-tight transition">Tahap 1</div>
                        <div class="text-[11px] text-gray-500 hidden sm:block">Data Pewasiat</div>
                    </div>
                </a>

                <!-- Tahap 2 (Active) -->
                <div class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-[#0b2942] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                        2
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#0b2942] leading-tight">Tahap 2</div>
                        <div class="text-[11px] text-gray-600 font-medium hidden sm:block">Upload Berkas</div>
                    </div>
                </div>

                <!-- Tahap 3 (Link) -->
                <a href="{{ route('permohonan.tahap3', $permohonan->id) }}" class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6 group" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-purple-50 border border-gray-200 group-hover:border-purple-300 text-gray-400 group-hover:text-purple-700 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        3
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 group-hover:text-purple-700 leading-tight transition">Tahap 3</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Voucher PNBP</div>
                    </div>
                </a>

                <!-- Tahap 4 (Link) -->
                <a href="{{ route('permohonan.tahap4', $permohonan->id) }}" class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6 group" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-purple-50 border border-gray-200 group-hover:border-purple-300 text-gray-400 group-hover:text-purple-700 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        4
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 group-hover:text-purple-700 leading-tight transition">Tahap 4</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Preview Data</div>
                    </div>
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Terdapat kesalahan pada berkas yang diunggah:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Upload Berkas -->
        <form action="{{ route('permohonan.tahap2.store', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- 1. Surat Kuasa -->
            @php $docSuratKuasa = $dokumens->get('surat_kuasa'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Surat Kuasa
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Surat Kuasa dari pasangan atau anak pewasiat kepada pemohon
                        </p>
                        
                        <template x-if="files.surat_kuasa">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.surat_kuasa.name"></strong> (<span x-text="files.surat_kuasa.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docSuratKuasa)
                            <template x-if="!files.surat_kuasa">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docSuratKuasa->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="surat_kuasa" 
                           x-ref="input_surat_kuasa" 
                           @change="handleFileChange($event, 'surat_kuasa')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('surat_kuasa')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.surat_kuasa ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- 2. Akta Kematian -->
            @php $docAktaKematian = $dokumens->get('akta_kematian'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Akta Kematian
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Apabila dalam dokumen diatas sudah memiliki barcode tidak wajib legalisir.
                        </p>

                        <template x-if="files.akta_kematian">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.akta_kematian.name"></strong> (<span x-text="files.akta_kematian.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docAktaKematian)
                            <template x-if="!files.akta_kematian">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docAktaKematian->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @else
                            <template x-if="!files.akta_kematian">
                                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Belum Diunggah</span>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="akta_kematian" 
                           x-ref="input_akta_kematian" 
                           @change="handleFileChange($event, 'akta_kematian')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('akta_kematian')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.akta_kematian ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- 3. Surat Keterangan Wasiat -->
            @php $docSuratWasiat = $dokumens->get('surat_keterangan_wasiat'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Surat Keterangan Wasiat
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Apabila dalam dokumen diatas sudah memiliki barcode tidak wajib legalisir.
                        </p>

                        <template x-if="files.surat_keterangan_wasiat">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.surat_keterangan_wasiat.name"></strong> (<span x-text="files.surat_keterangan_wasiat.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docSuratWasiat)
                            <template x-if="!files.surat_keterangan_wasiat">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docSuratWasiat->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @else
                            <template x-if="!files.surat_keterangan_wasiat">
                                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Belum Diunggah</span>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="surat_keterangan_wasiat" 
                           x-ref="input_surat_keterangan_wasiat" 
                           @change="handleFileChange($event, 'surat_keterangan_wasiat')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('surat_keterangan_wasiat')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.surat_keterangan_wasiat ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- 4. Akta Penyimpanan Wasiat -->
            @php $docAktaPenyimpanan = $dokumens->get('akta_penyimpanan_wasiat'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Akta Penyimpanan Wasiat
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Akta yang dibuat oleh Notaris saat penyerahan wasiat.
                        </p>

                        <template x-if="files.akta_penyimpanan_wasiat">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.akta_penyimpanan_wasiat.name"></strong> (<span x-text="files.akta_penyimpanan_wasiat.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docAktaPenyimpanan)
                            <template x-if="!files.akta_penyimpanan_wasiat">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docAktaPenyimpanan->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @else
                            <template x-if="!files.akta_penyimpanan_wasiat">
                                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Belum Diunggah</span>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="akta_penyimpanan_wasiat" 
                           x-ref="input_akta_penyimpanan_wasiat" 
                           @change="handleFileChange($event, 'akta_penyimpanan_wasiat')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('akta_penyimpanan_wasiat')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.akta_penyimpanan_wasiat ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- 5. Akta Perkawinan / Buku Nikah pewasiat -->
            @php $docBukuNikah = $dokumens->get('buku_nikah'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Akta Perkawinan / Buku Nikah pewasiat
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Apabila dalam dokumen diatas sudah memiliki barcode tidak wajib legalisir.
                        </p>

                        <template x-if="files.buku_nikah">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.buku_nikah.name"></strong> (<span x-text="files.buku_nikah.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docBukuNikah)
                            <template x-if="!files.buku_nikah">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docBukuNikah->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @else
                            <template x-if="!files.buku_nikah">
                                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Belum Diunggah</span>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="buku_nikah" 
                           x-ref="input_buku_nikah" 
                           @change="handleFileChange($event, 'buku_nikah')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('buku_nikah')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.buku_nikah ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- 6. Akta Lahir, KTP dan KK Pasangan dan anak Pewasiat -->
            @php $docAktaLahir = $dokumens->get('akta_lahir_ktp_kk'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Akta Lahir, KTP dan KK Pasangan dan anak Pewasiat
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Apabila dalam dokumen diatas sudah memiliki barcode tidak wajib legalisir.
                        </p>

                        <template x-if="files.akta_lahir_ktp_kk">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.akta_lahir_ktp_kk.name"></strong> (<span x-text="files.akta_lahir_ktp_kk.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docAktaLahir)
                            <template x-if="!files.akta_lahir_ktp_kk">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docAktaLahir->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @else
                            <template x-if="!files.akta_lahir_ktp_kk">
                                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Belum Diunggah</span>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="akta_lahir_ktp_kk" 
                           x-ref="input_akta_lahir_ktp_kk" 
                           @change="handleFileChange($event, 'akta_lahir_ktp_kk')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('akta_lahir_ktp_kk')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.akta_lahir_ktp_kk ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- 7. Dokumen lainnya -->
            @php $docLainnya = $dokumens->get('dokumen_lainnya'); @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 p-5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-300">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-11 h-11 rounded-lg bg-[#edf4fb] text-[#0066cc] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-tight">
                            Dokumen lainnya
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            tidak terbatas pada penetapan ganti nama, penetapan beda nama dsb.
                        </p>

                        <template x-if="files.dokumen_lainnya">
                            <div class="flex items-center gap-1.5 text-xs text-[#0066cc] font-medium mt-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>File dipilih: <strong x-text="files.dokumen_lainnya.name"></strong> (<span x-text="files.dokumen_lainnya.size"></span>)</span>
                            </div>
                        </template>

                        @if ($docLainnya)
                            <template x-if="!files.dokumen_lainnya">
                                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Sudah Diunggah</span>
                                    <a href="{{ Storage::url($docLainnya->file_path) }}" target="_blank" class="underline text-gray-500 hover:text-gray-800 ml-1">(Lihat Berkas)</a>
                                </div>
                            </template>
                        @else
                            <template x-if="!files.dokumen_lainnya">
                                <div class="flex items-center gap-1.5 text-xs text-gray-400 font-medium mt-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Opsional</span>
                                </div>
                            </template>
                        @endif
                    </div>
                </div>

                <div class="flex items-center flex-shrink-0">
                    <input type="file" 
                           name="dokumen_lainnya" 
                           x-ref="input_dokumen_lainnya" 
                           @change="handleFileChange($event, 'dokumen_lainnya')" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="hidden" />
                    <button type="button" 
                            @click="triggerUpload('dokumen_lainnya')" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#0066cc] hover:bg-[#0052a3] text-white text-xs font-bold rounded-lg flex items-center justify-center gap-2 shadow-sm transition duration-150 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span x-text="files.dokumen_lainnya ? 'Ganti File' : 'Unggah'">Unggah</span>
                    </button>
                </div>
            </div>

            <!-- Tombol Batal & Simpan & Lanjut -->
            <div class="flex items-center justify-end gap-3 pt-6 pb-12">
                <a href="{{ route('permohonan.index') }}" 
                   class="px-6 py-2.5 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                    Batal
                </a>

                <button type="submit" 
                        class="px-7 py-2.5 bg-[#0b2942] hover:bg-[#081f33] active:bg-[#051522] text-white font-bold text-sm rounded-lg shadow-sm hover:shadow transition duration-150 cursor-pointer">
                    Simpan & Lanjut
                </button>
            </div>
        </form>
    </div>
</x-portal-layout>
