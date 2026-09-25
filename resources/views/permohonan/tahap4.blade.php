<x-portal-layout>
    <x-slot name="title">
        Form Pengajuan Wasiat Tertutup - Tahap 4 (Pratinjau Data)
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header: Pembukaan Wasiat Tertutup -->
        <div class="mb-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Pembukaan Wasiat Tertutup
            </span>
        </div>

        <!-- Breadcrumb / Back button -->
        <div class="mb-3">
            <a href="{{ route('permohonan.tahap3', $permohonan->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali ke Tahap 3</span>
            </a>
        </div>

        <!-- Header Title -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-[28px] font-bold text-[#0f172a] tracking-tight">
                    Pratinjau Data Permohonan
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Silakan teliti kembali seluruh data dan dokumen yang telah diisi sebelum mengirimkan permohonan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" 
                        onclick="window.print()" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 shadow-xs transition print:hidden">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Draft</span>
                </button>
            </div>
        </div>

        <!-- Stepper Progress Bar (Tahap 1, 2, 3, 4) -->
        <div class="bg-white rounded-xl border border-gray-200/80 p-4 sm:p-5 mb-8 shadow-[0_2px_8px_rgba(0,0,0,0.02)] print:hidden">
            <div class="flex items-center justify-between gap-2" style="display: flex; flex-direction: row; width: 100%;">
                <!-- Tahap 1 (Selesai/Link) -->
                <div class="flex-1 flex items-center gap-3 group" style="flex: 1;">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-700 leading-tight">Tahap 1</div>
                        <div class="text-[11px] text-gray-500 hidden sm:block">Data Pewasiat</div>
                    </div>
                </div>

                <!-- Tahap 2 (Selesai/Link) -->
                <a href="{{ route('permohonan.tahap2', $permohonan->id) }}" class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6 group" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 group-hover:bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-700 group-hover:text-purple-700 leading-tight transition">Tahap 2</div>
                        <div class="text-[11px] text-gray-500 hidden sm:block">Upload Berkas</div>
                    </div>
                </a>

                <!-- Tahap 3 (Selesai/Link) -->
                <a href="{{ route('permohonan.tahap3', $permohonan->id) }}" class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6 group" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 group-hover:bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-700 group-hover:text-purple-700 leading-tight transition">Tahap 3</div>
                        <div class="text-[11px] text-gray-500 hidden sm:block">Voucher PNBP</div>
                    </div>
                </a>

                <!-- Tahap 4 (Active) -->
                <div class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-[#0b2942] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                        4
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#0b2942] leading-tight">Tahap 4</div>
                        <div class="text-[11px] text-gray-600 font-medium hidden sm:block">Preview Data</div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <span>Terdapat kendala sebelum pengajuan dapat dikirim:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            <!-- ================= KARTU IDENTITAS PERMOHONAN & PEMOHON ================= -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-[#0b2942] to-[#1e1b4b] px-6 py-4 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white/10 backdrop-blur-sm flex items-center justify-center font-bold text-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-[11px] font-medium text-blue-200 uppercase tracking-wider">Nomor Registrasi Permohonan</div>
                            <div class="text-lg font-extrabold tracking-wide font-mono">{{ $permohonan->nomor_permohonan }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $permohonan->status === 'draft' ? 'bg-amber-400 text-amber-950' : 'bg-blue-400 text-blue-950' }}">
                            {{ $permohonan->status === 'draft' ? 'Draft (Belum Dikirim)' : ucfirst(str_replace('_', ' ', $permohonan->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 bg-slate-50/60 border-b border-gray-100">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Informasi Akun Pemohon</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-xs text-gray-500 block">Nama Pemohon:</span>
                            <span class="font-bold text-gray-900">{{ $permohonan->user?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">NIK Pemohon:</span>
                            <span class="font-semibold text-gray-800 font-mono">{{ $permohonan->user?->nik ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">No. Telepon / WhatsApp:</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->user?->phone ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block">Email Terdaftar:</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->user?->email ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= TAHAP 1: DATA PEWASIAT & KELUARGA ================= -->
            @php $pewasiat = $permohonan->pewasiat; @endphp
            <div class="bg-white rounded-xl border border-gray-200/90 shadow-sm overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                            1
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#2e1065]">
                                Tahap 1: Data Pewasiat &amp; Keluarga
                            </h3>
                            <p class="text-xs text-gray-500">Identitas pewasiat, akta kematian, akta wasiat, dan susunan ahli waris</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Lengkap
                    </span>
                </div>

                <div class="p-6 sm:p-7 space-y-6 divide-y divide-gray-100">
                    <!-- Seksi I: Identitas Pewasiat -->
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-[#4a1d84]"></span>
                            <h4 class="text-sm font-bold text-[#2e1065] uppercase tracking-wide">Seksi I: Identitas Pewasiat</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-6 text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">Nama Lengkap Pewasiat:</span>
                                <span class="font-bold text-gray-900">{{ $pewasiat?->nama_lengkap ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Dahulu Bernama:</span>
                                <span class="text-gray-800">{{ $pewasiat?->dahulu_bernama ?: '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Alias:</span>
                                <span class="text-gray-800">{{ $pewasiat?->alias ?: '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">NIK:</span>
                                <span class="font-mono font-semibold text-gray-800">{{ $pewasiat?->nik ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Jenis Kelamin:</span>
                                <span class="text-gray-800">{{ $pewasiat?->jenis_kelamin === 'L' ? 'Laki-laki' : ($pewasiat?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Tempat, Tanggal Lahir:</span>
                                <span class="text-gray-800">
                                    {{ $pewasiat?->tempat_lahir ?? '-' }}, 
                                    {{ $pewasiat?->tanggal_lahir ? \Carbon\Carbon::parse($pewasiat->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </span>
                            </div>
                            <div class="sm:col-span-2 md:col-span-3">
                                <span class="text-xs text-gray-500 block">Tempat Tinggal Terakhir:</span>
                                <span class="text-gray-800">{{ $pewasiat?->tempat_tinggal_terakhir ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Seksi II: Kematian Pewasiat -->
                    <div class="pt-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-[#4a1d84]"></span>
                            <h4 class="text-sm font-bold text-[#2e1065] uppercase tracking-wide">Seksi II: Kematian Pewasiat</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-6 text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">Tempat Kematian:</span>
                                <span class="font-semibold text-gray-800">{{ $pewasiat?->tempat_kematian ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Tanggal Kematian:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $pewasiat?->tanggal_kematian ? \Carbon\Carbon::parse($pewasiat->tanggal_kematian)->translatedFormat('d F Y') : '-' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Nomor Akta Kematian:</span>
                                <span class="font-mono font-semibold text-gray-800">{{ $pewasiat?->nomor_akta_kematian ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Tanggal Akta Kematian:</span>
                                <span class="text-gray-800">
                                    {{ $pewasiat?->tanggal_akta_kematian ? \Carbon\Carbon::parse($pewasiat->tanggal_akta_kematian)->translatedFormat('d F Y') : '-' }}
                                </span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-xs text-gray-500 block">Pejabat Pembuat Akta Kematian:</span>
                                <span class="text-gray-800">{{ $pewasiat?->pejabat_pembuat_akta_kematian ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Seksi III & IV: Pencatatan Wasiat & Akta Penyimpanan -->
                    <div class="pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Seksi III: Pencatatan Wasiat (DPW) -->
                            <div class="bg-gray-50/80 rounded-xl p-4 border border-gray-100">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-2 h-2 rounded-full bg-[#0066cc]"></span>
                                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Seksi III: Pencatatan Wasiat (DPW)</h4>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-xs text-gray-500 block">Nomor Surat DPW:</span>
                                        <span class="font-mono font-semibold text-gray-900">{{ $pewasiat?->nomor_surat_dpw ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 block">Tanggal Surat DPW:</span>
                                        <span class="text-gray-800">
                                            {{ $pewasiat?->tanggal_surat_dpw ? \Carbon\Carbon::parse($pewasiat->tanggal_surat_dpw)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 block">Status Pencatatan:</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $pewasiat?->status_pencatatan ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Seksi IV: Akta Penyimpanan Notaris -->
                            <div class="bg-gray-50/80 rounded-xl p-4 border border-gray-100">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-2 h-2 rounded-full bg-[#0066cc]"></span>
                                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Seksi IV: Akta Penyimpanan Notaris</h4>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div>
                                        <span class="text-xs text-gray-500 block">Nomor Akta Penyimpanan:</span>
                                        <span class="font-mono font-semibold text-gray-900">{{ $pewasiat?->nomor_akta_penyimpanan ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 block">Tanggal Akta:</span>
                                        <span class="text-gray-800">
                                            {{ $pewasiat?->tanggal_akta_penyimpanan ? \Carbon\Carbon::parse($pewasiat->tanggal_akta_penyimpanan)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 block">Nama &amp; Kedudukan Notaris:</span>
                                        <span class="font-semibold text-gray-900">{{ $pewasiat?->nama_notaris ?? '-' }}</span>
                                        <span class="text-gray-500 block text-xs">({{ $pewasiat?->kedudukan_notaris ?? '-' }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seksi V: Perkawinan & Pasangan -->
                    <div class="pt-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-[#4a1d84]"></span>
                            <h4 class="text-sm font-bold text-[#2e1065] uppercase tracking-wide">Seksi V: Informasi Perkawinan &amp; Pasangan</h4>
                        </div>
                        <div class="mb-4 text-sm">
                            <span class="text-xs text-gray-500 block">Status Perkawinan:</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold {{ $pewasiat?->status_kawin === 'kawin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $pewasiat?->status_kawin === 'kawin' ? 'Kawin (Menikah)' : 'Tidak Kawin / Belum Kawin' }}
                            </span>
                        </div>

                        @if ($pewasiat?->status_kawin === 'kawin' && $pewasiat?->pasangans->isNotEmpty())
                            @php $firstPasangan = $pewasiat->pasangans->first(); @endphp
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-6 text-sm bg-purple-50/40 p-4 rounded-xl border border-purple-100 mb-4">
                                <div>
                                    <span class="text-xs text-gray-500 block">Bukti Perkawinan:</span>
                                    <span class="font-semibold text-gray-800">{{ $firstPasangan->bukti_perkawinan ?: '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Nomor Bukti Perkawinan:</span>
                                    <span class="font-mono font-semibold text-gray-800">{{ $firstPasangan->nomor_bukti_perkawinan ?: '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Tanggal Perkawinan:</span>
                                    <span class="text-gray-800">
                                        {{ $firstPasangan->tanggal_kawin ? \Carbon\Carbon::parse($firstPasangan->tanggal_kawin)->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Tempat Perkawinan:</span>
                                    <span class="text-gray-800">{{ $firstPasangan->tempat_kawin ?: '-' }}</span>
                                </div>
                                <div class="sm:col-span-2">
                                    <span class="text-xs text-gray-500 block">Instansi Penerbit Dokumen:</span>
                                    <span class="text-gray-800">{{ $firstPasangan->pejabat_pembuat_bukti ?: '-' }}</span>
                                </div>
                            </div>

                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="w-full text-xs text-left">
                                    <thead class="bg-gray-50 text-gray-600 font-bold border-b border-gray-200">
                                        <tr>
                                            <th class="px-3 py-2 w-10">No</th>
                                            <th class="px-3 py-2">Nama Pasangan</th>
                                            <th class="px-3 py-2">NIK</th>
                                            <th class="px-3 py-2">Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($pewasiat->pasangans as $idx => $pasangan)
                                            <tr>
                                                <td class="px-3 py-2 text-gray-500">{{ $idx + 1 }}</td>
                                                <td class="px-3 py-2 font-semibold text-gray-900">{{ $pasangan->nama_lengkap }}</td>
                                                <td class="px-3 py-2 font-mono text-gray-700">{{ $pasangan->nik ?: '-' }}</td>
                                                <td class="px-3 py-2 text-gray-700">{{ $pasangan->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-xs text-gray-500 italic">Pewasiat berstatus tidak kawin atau data pasangan tidak dicantumkan.</p>
                        @endif
                    </div>

                    <!-- Seksi VI: Anak Pewasiat / Ahli Waris -->
                    <div class="pt-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-[#4a1d84]"></span>
                            <h4 class="text-sm font-bold text-[#2e1065] uppercase tracking-wide">Seksi VI: Informasi Anak Pewasiat (Ahli Waris)</h4>
                        </div>

                        @if ($pewasiat?->ahliWaris->isNotEmpty())
                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="w-full text-xs text-left">
                                    <thead class="bg-gray-50 text-gray-600 font-bold border-b border-gray-200">
                                        <tr>
                                            <th class="px-3 py-2 w-10">No</th>
                                            <th class="px-3 py-2">Nama Anak Kandung</th>
                                            <th class="px-3 py-2">NIK</th>
                                            <th class="px-3 py-2">JK</th>
                                            <th class="px-3 py-2">Tempat / Tanggal Lahir</th>
                                            <th class="px-3 py-2">Alamat Domisili</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($pewasiat->ahliWaris as $idx => $anak)
                                            <tr>
                                                <td class="px-3 py-2 text-gray-500">{{ $idx + 1 }}</td>
                                                <td class="px-3 py-2 font-semibold text-gray-900">{{ $anak->nama_lengkap }}</td>
                                                <td class="px-3 py-2 font-mono text-gray-700">{{ $anak->nik ?: '-' }}</td>
                                                <td class="px-3 py-2 text-gray-700">{{ $anak->jenis_kelamin === 'L' ? 'L' : 'P' }}</td>
                                                <td class="px-3 py-2 text-gray-700">{{ $anak->tempat_lahir ?: '-' }}</td>
                                                <td class="px-3 py-2 text-gray-700">{{ $anak->alamat ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-3 bg-gray-50 rounded-lg text-xs text-gray-500 italic">
                                Pewasiat tercatat tidak memiliki anak kandung / ahli waris dalam pengajuan ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ================= TAHAP 2: BERKAS PERSYARATAN ================= -->
            <div class="bg-white rounded-xl border border-gray-200/90 shadow-sm overflow-hidden">
                <div class="bg-[#f0f6fc] px-6 py-4 border-b border-blue-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-[#0066cc] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                            2
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#071d40]">
                                Tahap 2: Berkas Dokumen Persyaratan
                            </h3>
                            <p class="text-xs text-gray-500">Kelengkapan dokumen fisik yang telah diunggah dalam format PDF/Gambar</p>
                        </div>
                    </div>
                    <a href="{{ route('permohonan.tahap2', $permohonan->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md border border-blue-200 bg-white hover:bg-blue-50 text-[#0066cc] transition print:hidden">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        <span>Ubah Berkas</span>
                    </a>
                </div>

                <div class="p-6">
                    @php
                        $documentList = [
                            'surat_kuasa' => [
                                'label' => 'Surat Kuasa',
                                'desc' => 'Surat Kuasa dari pasangan atau anak pewasiat kepada pemohon',
                                'required' => false
                            ],
                            'akta_kematian' => [
                                'label' => 'Akta Kematian Pewasiat',
                                'desc' => 'Akta Kematian Pewasiat dari Dinas Kependudukan dan Pencatatan Sipil',
                                'required' => true
                            ],
                            'surat_keterangan_wasiat' => [
                                'label' => 'Surat Keterangan Wasiat',
                                'desc' => 'Surat Keterangan Wasiat dari Ditjen Administrasi Hukum Umum (DPW)',
                                'required' => true
                            ],
                            'akta_penyimpanan_wasiat' => [
                                'label' => 'Akta Penyimpanan Wasiat',
                                'desc' => 'Akta Penyimpanan / Penitipan Wasiat Tertutup dari Notaris',
                                'required' => true
                            ],
                            'buku_nikah' => [
                                'label' => 'Akta Perkawinan / Buku Nikah',
                                'desc' => 'Akta Perkawinan atau Buku Nikah pewasiat',
                                'required' => false
                            ],
                            'akta_lahir_ktp_kk' => [
                                'label' => 'Akta Lahir, KTP dan KK',
                                'desc' => 'Akta Lahir, KTP dan KK Pasangan dan anak Pewasiat',
                                'required' => false
                            ],
                            'dokumen_lainnya' => [
                                'label' => 'Dokumen Lainnya',
                                'desc' => 'Dokumen tambahan / pendukung lainnya (Opsional)',
                                'required' => false
                            ],
                        ];
                    @endphp

                    <div class="divide-y divide-gray-100">
                        @foreach ($documentList as $key => $docInfo)
                            @php $file = $dokumens->get($key); @endphp
                            <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg {{ $file ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                        @if ($file)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h5 class="text-sm font-bold text-gray-900">{{ $docInfo['label'] }}</h5>
                                            @if ($docInfo['required'])
                                                <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-200">Wajib</span>
                                            @else
                                                <span class="text-[10px] font-medium text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">Opsional</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $docInfo['desc'] }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 self-start sm:self-center pl-11 sm:pl-0">
                                    @if ($file)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Terunggah
                                        </span>
                                        <a href="{{ Storage::url($file->file_path) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-md bg-[#edf4fb] text-[#0066cc] hover:bg-[#d8e9f8] transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Lihat Berkas</span>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            Belum Diunggah
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ================= TAHAP 3: VOUCHER PNBP SIMPADHU AHU ================= -->
            <div class="bg-white rounded-xl border border-gray-200/90 shadow-sm overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-[#1e1b4b] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                            3
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#2e1065]">
                                Tahap 3: Informasi Pembayaran &amp; Voucher PNBP
                            </h3>
                            <p class="text-xs text-gray-500">Pemesanan voucher penerimaan negara bukan pajak pada sistem SIMPADHU AHU</p>
                        </div>
                    </div>
                    <a href="{{ route('permohonan.tahap3', $permohonan->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md border border-purple-200 bg-white hover:bg-purple-50 text-[#4a1d84] transition print:hidden">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        <span>Ubah Voucher</span>
                    </a>
                </div>

                <div class="p-6">
                    <div class="bg-gradient-to-br from-blue-50/70 via-indigo-50/40 to-purple-50/50 rounded-xl p-5 border border-blue-100">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
                            <div>
                                <span class="text-xs font-semibold text-gray-500 block mb-1">Nomor Voucher PNBP:</span>
                                @if ($permohonan->voucher?->nomor_voucher)
                                    <div class="font-mono text-base sm:text-lg font-black text-[#0b2942] tracking-wide">
                                        {{ $permohonan->voucher->nomor_voucher }}
                                    </div>
                                @else
                                    <div class="text-xs text-amber-700 font-semibold bg-amber-50 px-2 py-1 rounded inline-block">
                                        Belum Diisi (Akan Disusulkan)
                                    </div>
                                @endif
                            </div>

                            <div>
                                <span class="text-xs font-semibold text-gray-500 block mb-1">Tarif Layanan PNBP:</span>
                                <div class="text-base font-bold text-gray-900">
                                    Rp 500.000,-
                                </div>
                                <span class="text-[11px] text-gray-500 block">Sesuai PP No. 45/2014 &amp; No. 28/2019</span>
                            </div>

                            <div>
                                <span class="text-xs font-semibold text-gray-500 block mb-1">Status Pembayaran:</span>
                                @if ($permohonan->voucher && $permohonan->voucher->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Lunas Terbayar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                        Menunggu Verifikasi Pembayaran
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= FORM KONFIRMASI & SUBMIT FINAL ================= -->
            <form id="formTahap4" 
                  action="{{ route('permohonan.tahap4.store', $permohonan->id) }}" 
                  method="POST" 
                  class="space-y-6 pt-2"
                  x-data="{ 
                      showConfirmModal: false, 
                      isSubmitting: false,
                      openModal() {
                          const checkbox = document.querySelector('input[name=\'konfirmasi_kebenaran\']');
                          if (checkbox && !checkbox.checked) {
                              checkbox.focus();
                              checkbox.reportValidity();
                              return;
                          }
                          this.showConfirmModal = true;
                      },
                      submitForm() {
                          this.isSubmitting = true;
                          document.getElementById('formTahap4').submit();
                      }
                  }">
                @csrf

                <!-- Pernyataan Kebenaran Data (Disclaimer) -->
                <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-6">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                            !
                        </div>
                        <div class="space-y-3">
                            <h4 class="text-sm font-bold text-amber-950">
                                Pernyataan Keabsahan Dokumen &amp; Kebenaran Data
                            </h4>
                            <p class="text-xs text-amber-900/90 leading-relaxed text-justify">
                                Dengan mengirimkan permohonan ini, saya menyatakan dengan sesungguhnya bahwa seluruh data yang saya isikan dan dokumen yang saya unggah adalah <strong>benar, sah, dan sesuai dengan aslinya</strong> menurut peraturan perundang-undangan Republik Indonesia. Apabila di kemudian hari terbukti terdapat ketidakbenaran, pemalsuan, atau keterangan palsu, saya bersedia menerima sanksi hukum sesuai ketentuan perundang-undangan yang berlaku dan permohonan ini dinyatakan batal demi hukum.
                            </p>

                            <div class="pt-2">
                                <label class="inline-flex items-start gap-2.5 cursor-pointer select-none">
                                    <input type="checkbox" 
                                           name="konfirmasi_kebenaran" 
                                           value="1" 
                                           class="mt-0.5 rounded border-amber-300 text-[#0b2942] focus:ring-[#0b2942] h-4 w-4" 
                                           required />
                                    <span class="text-xs sm:text-sm font-bold text-amber-950">
                                        Saya telah memeriksa dan menyetujui pernyataan keabsahan serta kebenaran data di atas. <span class="text-rose-600">*</span>
                                    </span>
                                </label>
                                @error('konfirmasi_kebenaran')
                                    <p class="text-xs text-rose-600 font-bold mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Batal, Kembali & Kirim -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 pb-12 print:hidden">
                    <a href="{{ route('permohonan.tahap3', $permohonan->id) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali ke Tahap 3</span>
                    </a>

                    <div class="w-full sm:w-auto flex items-center justify-end gap-3">
                        <a href="{{ route('permohonan.index') }}" 
                           class="px-5 py-2.5 text-gray-500 hover:text-gray-800 font-semibold text-xs sm:text-sm transition">
                            Simpan Sebagai Draft
                        </a>

                        <button type="button" 
                                @click="openModal()"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-[#0b2942] hover:bg-[#081f33] active:bg-[#051522] text-white font-extrabold text-sm rounded-xl shadow-md hover:shadow-lg transition duration-150 cursor-pointer">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span>Kirim Permohonan Sekarang</span>
                        </button>
                    </div>
                </div>

                <!-- Modal Konfirmasi Pengiriman Permohonan (Modern & Elegan) -->
                <div x-show="showConfirmModal" 
                     x-cloak 
                     class="fixed inset-0 z-50 overflow-y-auto"
                     aria-labelledby="modal-title" 
                     role="dialog" 
                     aria-modal="true"
                     style="display: none;">
                    
                    <!-- Backdrop Blur -->
                    <div x-show="showConfirmModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="if(!isSubmitting) showConfirmModal = false"
                         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

                    <!-- Modal Dialog Container -->
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div x-show="showConfirmModal"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             @keydown.escape.window="if(!isSubmitting) showConfirmModal = false"
                             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
                            
                            <!-- Top Gradient Accent Bar -->
                            <div class="h-2 bg-gradient-to-r from-[#0b2942] via-[#1d68d8] to-[#4a1d84]"></div>

                            <div class="p-6 sm:p-7">
                                <!-- Icon Header & Title -->
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0b2942] border border-blue-100 flex items-center justify-center flex-shrink-0 shadow-xs">
                                        <svg class="w-6 h-6 text-[#1d68d8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 leading-snug" id="modal-title">
                                            Konfirmasi Pengiriman Permohonan
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Layanan Pembukaan Wasiat Tertutup &bull; Balai Harta Peninggalan
                                        </p>
                                    </div>
                                </div>

                                <!-- Info Box Ringkasan -->
                                <div class="mt-5 rounded-xl bg-slate-50 border border-slate-200/80 p-4 space-y-2.5 text-xs text-slate-700">
                                    <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                                        <span class="text-slate-500">Nomor Registrasi:</span>
                                        <span class="font-mono font-bold text-[#0b2942]">{{ $permohonan->nomor_permohonan }}</span>
                                    </div>
                                    <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                                        <span class="text-slate-500">Nama Pewasiat:</span>
                                        <span class="font-bold text-gray-900">{{ $pewasiat?->nama_lengkap ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500">Status Setelah Kirim:</span>
                                        <span class="px-2 py-0.5 rounded-full font-bold bg-amber-100 text-amber-800 text-[10px]">
                                            Menunggu Verifikasi Petugas
                                        </span>
                                    </div>
                                </div>

                                <!-- Pesan Peringatan & Ketentuan -->
                                <div class="mt-4 p-3.5 rounded-xl bg-amber-50/80 border border-amber-200/80 flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    <p class="text-[11px] text-amber-900 leading-relaxed">
                                        Pastikan seluruh data dan berkas yang Anda unggah sudah benar. Setelah dikirim, data permohonan <strong>tidak dapat diubah kembali</strong> selama proses pemeriksaan verifikasi oleh petugas.
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Buttons -->
                            <div class="bg-gray-50/80 px-6 py-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5 border-t border-gray-100">
                                <button type="button" 
                                        @click="showConfirmModal = false" 
                                        :disabled="isSubmitting"
                                        class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-xl shadow-2xs transition disabled:opacity-50 cursor-pointer">
                                    Periksa Kembali
                                </button>

                                <button type="button" 
                                        @click="submitForm()" 
                                        :disabled="isSubmitting"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 text-xs font-bold text-white bg-[#0b2942] hover:bg-[#071d40] active:bg-[#040f1a] rounded-xl shadow-sm hover:shadow transition disabled:opacity-75 cursor-pointer">
                                    <!-- Normal State -->
                                    <template x-if="!isSubmitting">
                                        <div class="inline-flex items-center gap-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                            <span>Ya, Kirim Permohonan</span>
                                        </div>
                                    </template>
                                    <!-- Loading State -->
                                    <template x-if="isSubmitting">
                                        <div class="inline-flex items-center gap-2">
                                            <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Mengirimkan Permohonan...</span>
                                        </div>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-portal-layout>
