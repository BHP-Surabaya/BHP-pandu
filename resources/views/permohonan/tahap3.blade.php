<x-portal-layout>
    <x-slot name="title">
        Form Pengajuan Wasiat Tertutup - Tahap 3
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
            <a href="{{ route('permohonan.tahap2', $permohonan->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Header Title -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-[28px] font-bold text-[#0f172a] tracking-tight">
                    Form Pengajuan Wasiat Tertutup
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Lengkapi data di bawah ini untuk memulai proses pengajuan wasiat tertutup.
                </p>
            </div>
            <div>
                <button type="button" 
                        onclick="const input = document.getElementById('nomor_voucher'); if(input) { input.value = 'AHU-001008002-{{ $permohonan->id }}' + Math.floor(1000000 + Math.random() * 9000000); input.dispatchEvent(new Event('input')); }" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-lg border border-purple-200 bg-purple-50 hover:bg-purple-100 text-[#4a1d84] shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-[#4a1d84]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>Isi Kode Voucher Dummy</span>
                </button>
            </div>
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

                <!-- Tahap 3 (Active) -->
                <div class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-[#0b2942] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                        3
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#0b2942] leading-tight">Tahap 3</div>
                        <div class="text-[11px] text-gray-600 font-medium hidden sm:block">Voucher PNBP</div>
                    </div>
                </div>

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

        <form action="{{ route('permohonan.tahap3.store', $permohonan->id) }}" method="POST">
            @csrf

            <!-- Card Utama: Panduan Pemesanan di SIMPADHU AHU -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <!-- Header Card -->
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full border border-purple-600 text-purple-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        i
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Panduan Pemesanan di SIMPADHU AHU
                    </h3>
                </div>

                <!-- Body Card -->
                <div class="p-6 sm:p-7 space-y-6">
                    <!-- Tombol Buka Portal SIMPADHU AHU -->
                    <div>
                        <a href="https://ahu.go.id/billing/voucher/tambah/id/001008/sub/001008002" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#facc15] hover:bg-[#eab308] text-gray-900 font-bold text-xs rounded-lg shadow-sm transition duration-150 cursor-pointer">
                            <span>Buka Portal SIMPADHU AHU</span>
                            <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>

                    <!-- List Panduan Berurutan -->
                    <div class="space-y-4">
                        <!-- Langkah 1 -->
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-100 text-[#4a1d84] font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                1
                            </div>
                            <p class="text-sm text-gray-700 font-medium leading-relaxed pt-0.5">
                                Klik tombol <strong>Buka Portal SIMPADHU AHU</strong> di atas. Halaman akan otomatis mengarahkan ke formulir pemesanan voucher layanan <em>Balai Harta Peninggalan &bull; Pewarisan</em>.
                            </p>
                        </div>

                        <!-- Langkah 2 -->
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-100 text-[#4a1d84] font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                2
                            </div>
                            <div class="space-y-3 flex-1">
                                <p class="text-sm text-gray-700 font-medium leading-relaxed pt-0.5">
                                    Pada formulir SIMPADHU AHU yang terbuka, silakan pilih opsi berikut:
                                </p>

                                <!-- Box Pilihan Layanan AHU -->
                                <div class="bg-amber-50/70 border border-amber-200/90 rounded-xl p-4 sm:p-5 space-y-3 text-xs sm:text-sm text-gray-800">
                                    <div class="flex items-center gap-2 text-amber-900 font-bold text-xs uppercase tracking-wider">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        <span>Pilihan Yang Harus Dipilih di Portal AHU</span>
                                    </div>

                                    <div class="space-y-2.5 pt-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 p-2.5 rounded-lg bg-white border border-amber-200/60 shadow-2xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-5 h-5 rounded-md bg-blue-100 text-[#0b2e66] font-bold text-[10px] flex items-center justify-center">A</span>
                                                <span class="font-bold text-gray-700">Pelayanan Jasa Hukum:</span>
                                            </div>
                                            <span class="inline-flex items-center gap-1.5 font-bold text-[#0b2e66] text-xs">
                                                Balai Harta Peninggalan &bull; Pewarisan
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">Sudah Otomatis Terpilih</span>
                                            </span>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 p-2.5 rounded-lg bg-white border border-amber-300 shadow-2xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-900 font-bold text-[10px] flex items-center justify-center">B</span>
                                                <span class="font-bold text-gray-700">Kolom "Kantor BHP":</span>
                                            </div>
                                            <span class="inline-flex items-center gap-1.5 font-extrabold text-[#0b2e66] text-xs">
                                                Pilih &rarr; <span class="px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-[#1d68d8]">BHP SURABAYA</span>
                                            </span>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 p-2.5 rounded-lg bg-white border border-amber-300 shadow-2xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-900 font-bold text-[10px] flex items-center justify-center">C</span>
                                                <span class="font-bold text-gray-700">Kolom "Jenis Layanan / Sub-Transaksi":</span>
                                            </div>
                                            <span class="inline-flex items-center gap-1.5 font-extrabold text-[#0b2e66] text-xs">
                                                Pilih &rarr; <span class="px-2.5 py-1 rounded-md bg-blue-50 border border-blue-200 text-[#1d68d8]">Pembukaan Wasiat Tertutup/Rahasia</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Box Detail Formulir Data Pemohon -->
                                <div class="bg-gray-50/70 border border-gray-200/90 rounded-xl p-5 space-y-3 text-xs sm:text-sm text-gray-800" x-data="{ copied: '' }">
                                    <div class="flex items-center justify-between pb-2 border-b border-gray-200/80">
                                        <div>
                                            <span class="font-bold text-gray-800 text-sm">Data Pemohon untuk Formulir AHU</span>
                                            <p class="text-[11px] text-slate-500 mt-0.5">Gunakan tombol salin untuk mempermudah pengisian di portal SIMPADHU</p>
                                        </div>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#facc15] text-[#1e1b4b] shadow-xs shrink-0">
                                            DATA AKUN ANDA
                                        </span>
                                    </div>

                                    <div class="space-y-2 pt-1">
                                        <div class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-white transition">
                                            <span class="text-gray-600 font-medium">Nama Pemohon:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $user->name }}'); copied = 'name'; setTimeout(() => copied = '', 2000)"
                                                        class="p-1 rounded hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition" 
                                                        title="Salin Nama">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-white transition">
                                            <span class="text-gray-600 font-medium">NIK / NPWP 16 Digit:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-900 font-mono">{{ $user->nik ?? '3171XXXXXXXXXXXX' }}</span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $user->nik ?? '' }}'); copied = 'nik'; setTimeout(() => copied = '', 2000)"
                                                        class="p-1 rounded hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition" 
                                                        title="Salin NIK">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-white transition">
                                            <span class="text-gray-600 font-medium">Email Pemohon:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-900">{{ $user->email }}</span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $user->email }}'); copied = 'email'; setTimeout(() => copied = '', 2000)"
                                                        class="p-1 rounded hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition" 
                                                        title="Salin Email">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-white transition">
                                            <span class="text-gray-600 font-medium">Nomor HP:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-900 font-mono">{{ $user->phone ?? '0812XXXXXXXX' }}</span>
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $user->phone ?? '' }}'); copied = 'phone'; setTimeout(() => copied = '', 2000)"
                                                        class="p-1 rounded hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition" 
                                                        title="Salin No HP">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-white transition">
                                            <span class="text-gray-600 font-medium">Jumlah Pembelian:</span>
                                            <span class="font-bold text-gray-900">1</span>
                                        </div>
                                    </div>

                                    <div x-show="copied" x-transition class="text-right">
                                        <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Tersalin ke clipboard!</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Langkah 3 -->
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-100 text-[#4a1d84] font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                3
                            </div>
                            <p class="text-sm text-gray-700 font-medium leading-relaxed pt-0.5">
                                Centang kotak persetujuan Syarat &amp; Ketentuan.
                            </p>
                        </div>

                        <!-- Langkah 4 -->
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-100 text-[#4a1d84] font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                4
                            </div>
                            <p class="text-sm text-gray-700 font-medium leading-relaxed pt-0.5">
                                Klik tombol Simpan.
                            </p>
                        </div>

                        <!-- Langkah 5 -->
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-100 text-[#4a1d84] font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                5
                            </div>
                            <p class="text-sm text-gray-700 font-medium leading-relaxed pt-0.5">
                                Setelah berhasil disimpan, klik <strong>Download</strong> untuk mengunduh bukti pemesanan voucher Anda (berisi Kode Voucher &amp; Kode Billing).
                            </p>
                        </div>

                        <!-- Langkah 6: Input Kode Voucher Hasil dari AHU -->
                        <div class="flex items-start gap-3 pt-2">
                            <div class="w-6 h-6 rounded-full bg-[#0b2e66] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5 shadow-xs">
                                6
                            </div>
                            <div class="space-y-3 flex-1">
                                <p class="text-sm text-gray-900 font-bold leading-relaxed pt-0.5">
                                    Masukkan Kode / Nomor Voucher yang Anda peroleh dari SIMPADHU AHU:
                                </p>

                                <div class="bg-blue-50/70 border border-blue-200/90 rounded-2xl p-5 space-y-3"
                                     x-data="{ 
                                         voucherVal: '{{ old('nomor_voucher', $permohonan->voucher?->nomor_voucher) }}',
                                         setDummy(val) {
                                             this.voucherVal = val;
                                         },
                                         randomVoucher() {
                                             const rand = Math.floor(1000000 + Math.random() * 9000000);
                                             this.voucherVal = 'AHU-001008002-{{ $permohonan->id }}' + rand;
                                         }
                                     }">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <label for="nomor_voucher" class="block text-xs sm:text-sm font-extrabold text-[#071d40]">
                                            Nomor Voucher PNBP <span class="text-rose-500">*</span>
                                        </label>
                                        <button type="button" 
                                                @click="randomVoucher()" 
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-lg border border-purple-200 bg-purple-50 hover:bg-purple-100 text-[#4a1d84] shadow-2xs transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-[#4a1d84]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            <span>Acak Kode Dummy Baru</span>
                                        </button>
                                    </div>

                                    <div class="relative max-w-lg">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-5 h-5 text-[#1d68d8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               name="nomor_voucher" 
                                               id="nomor_voucher" 
                                               x-model="voucherVal"
                                               value="{{ old('nomor_voucher', $permohonan->voucher?->nomor_voucher) }}"
                                               placeholder="Contoh: AHU-001008002-XXXXXXXX atau Kode Billing" 
                                               class="w-full pl-11 pr-4 py-3 bg-white border border-blue-200 rounded-xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1d68d8] focus:border-transparent transition shadow-xs uppercase tracking-wide" />
                                    </div>

                                    <!-- Quick Dummy Badges (Guaranteed Unique) -->
                                    <div class="flex flex-wrap items-center gap-2 pt-1">
                                        <span class="text-[11px] font-semibold text-slate-500">Pilihan Cepat Dummy Unik:</span>
                                        <button type="button" 
                                                @click="setDummy('AHU-001008002-{{ $permohonan->id }}' + Math.floor(1000000 + Math.random() * 9000000))" 
                                                class="px-2.5 py-1 bg-white hover:bg-blue-50 text-[#1d68d8] text-[11px] font-mono font-bold rounded-md border border-blue-200 transition cursor-pointer shadow-2xs">
                                            + Format AHU Baru
                                        </button>
                                        <button type="button" 
                                                @click="setDummy('82024092400{{ $permohonan->id }}' + Math.floor(1000 + Math.random() * 9000))" 
                                                class="px-2.5 py-1 bg-white hover:bg-amber-50 text-amber-800 text-[11px] font-mono font-bold rounded-md border border-amber-300 transition cursor-pointer shadow-2xs">
                                            + Format Billing Simponi (15 Digit)
                                        </button>
                                    </div>

                                    <p class="text-[11px] text-slate-600 leading-relaxed">
                                        Salin dan tempelkan Nomor Voucher yang tertera pada bukti unduhan SIMPADHU AHU Anda di atas sebelum menekan tombol <strong>Simpan &amp; Lanjut</strong>.
                                    </p>

                                    @error('nomor_voucher')
                                        <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Batal & Simpan & Lanjut -->
            <div class="flex items-center justify-end gap-3 pt-6 pb-12">
                <a href="{{ route('permohonan.index') }}" 
                   class="px-6 py-2.5 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                    Batal
                </a>

                <button type="submit" 
                        class="inline-flex items-center gap-2 px-7 py-2.5 bg-[#0b2942] hover:bg-[#081f33] active:bg-[#051522] text-white font-bold text-sm rounded-lg shadow-sm hover:shadow transition duration-150 cursor-pointer">
                    <span>Simpan &amp; Lanjut ke Tahap 4</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-portal-layout>
