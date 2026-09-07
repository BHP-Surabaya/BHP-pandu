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
        <div class="mb-6">
            <h2 class="text-2xl sm:text-[28px] font-bold text-[#0f172a] tracking-tight">
                Form Pengajuan Wasiat Tertutup
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Lengkapi data di bawah ini untuk memulai proses pengajuan wasiat tertutup.
            </p>
        </div>

        <!-- Stepper Progress Bar (Tahap 1, 2, 3) -->
        <div class="bg-white rounded-xl border border-gray-200/80 p-4 sm:p-5 mb-8 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
            <div class="grid grid-cols-3 items-center gap-2">
                <!-- Tahap 1 (Selesai/Link) -->
                <a href="{{ route('permohonan.create') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-purple-50 border border-gray-200 group-hover:border-purple-300 text-gray-400 group-hover:text-purple-700 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        1
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 group-hover:text-purple-700 leading-tight transition">Tahap 1</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Data Pewasiat</div>
                    </div>
                </a>

                <!-- Tahap 2 (Selesai/Link) -->
                <a href="{{ route('permohonan.tahap2', $permohonan->id) }}" class="flex items-center gap-3 border-l border-gray-100 pl-4 sm:pl-8 group">
                    <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-purple-50 border border-gray-200 group-hover:border-purple-300 text-gray-400 group-hover:text-purple-700 flex items-center justify-center font-bold text-xs flex-shrink-0 transition">
                        2
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 group-hover:text-purple-700 leading-tight transition">Tahap 2</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Data Wasiat</div>
                    </div>
                </a>

                <!-- Tahap 3 (Active) -->
                <div class="flex items-center gap-3 border-l border-gray-100 pl-4 sm:pl-8">
                    <div class="w-8 h-8 rounded-full bg-[#0b2942] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                        3
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#0b2942] leading-tight">Tahap 3</div>
                        <div class="text-[11px] text-gray-600 font-medium hidden sm:block">Dokumen</div>
                    </div>
                </div>
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
                                Klik tombol atau link portal di atas (layanan BHP &amp; Pembukaan Wasiat Tertutup Surabaya otomatis terpilih).
                            </p>
                        </div>

                        <!-- Langkah 2 -->
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-purple-100 text-[#4a1d84] font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                2
                            </div>
                            <div class="space-y-3 flex-1">
                                <p class="text-sm text-gray-700 font-medium leading-relaxed pt-0.5">
                                    Lengkapi informasi pemesanan dengan rincian berikut:
                                </p>

                                <!-- Box Detail Formulir -->
                                <div class="bg-gray-50/70 border border-gray-200/90 rounded-xl p-5 space-y-3 text-xs sm:text-sm text-gray-800">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <span class="font-bold text-gray-700">Pelayanan:</span>
                                        <span class="sm:col-span-2 text-gray-800">Balai Harta Peninggalan dan Kurator Negara &bull; Pewarisan <span class="text-[11px] font-bold text-emerald-600 ml-1">(Otomatis)</span></span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <span class="font-bold text-gray-700">Kantor BHP:</span>
                                        <span class="sm:col-span-2 text-gray-800">BHP Surabaya &bull; Pembukaan Wasiat Tertutup/Rahasia <span class="text-[11px] font-bold text-emerald-600 ml-1">(Otomatis)</span></span>
                                    </div>

                                    <div class="border-t border-gray-200/80 pt-3 mt-3">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="font-bold text-gray-700">Data Pemohon</span>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#facc15] text-[#1e1b4b] shadow-xs">
                                                OTOMATIS DARI AKUN
                                            </span>
                                        </div>

                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Nama Pemohon:</span>
                                                <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">NIK:</span>
                                                <span class="font-bold text-gray-900">{{ $user->nik ?? '3171XXXXXXXXXXXX' }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Email:</span>
                                                <span class="font-bold text-gray-900">{{ $user->email }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Nomor HP:</span>
                                                <span class="font-bold text-gray-900">{{ $user->phone ?? '0812XXXXXXXX' }}</span>
                                            </div>
                                        </div>
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
                                Setelah berhasil disimpan, klik Download untuk menyimpan bukti voucher PNBP Anda.
                            </p>
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
                        class="px-7 py-2.5 bg-[#0b2942] hover:bg-[#081f33] active:bg-[#051522] text-white font-bold text-sm rounded-lg shadow-sm hover:shadow transition duration-150 cursor-pointer">
                    Simpan &amp; Lanjut
                </button>
            </div>
        </form>
    </div>
</x-portal-layout>
