<x-portal-layout>
    <x-slot name="title">
        Manual Guide - Balai Harta Peninggalan
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#0c2a55] tracking-tight">
                Panduan Penggunaan Aplikasi
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Ikuti langkah berikut untuk menggunakan layanan dan memantau permohonan Anda.
            </p>
        </div>

        <div class="space-y-4">
            <section class="bg-white rounded-xl border border-gray-200/80 p-5 sm:p-6 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                <h3 class="text-base font-bold text-[#0c2a55] mb-4">Mulai menggunakan aplikasi</h3>
                <ol class="space-y-4">
                    <li class="flex gap-3">
                        <span class="w-7 h-7 rounded-full bg-blue-50 text-[#0066d6] flex items-center justify-center text-xs font-bold shrink-0">1</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Pilih layanan</p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Buka menu Layanan untuk melihat layanan yang tersedia bagi jenis akun Anda, lalu pilih layanan yang ingin digunakan.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-7 h-7 rounded-full bg-blue-50 text-[#0066d6] flex items-center justify-center text-xs font-bold shrink-0">2</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Lengkapi pengajuan</p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Untuk layanan Pembukaan Wasiat Tertutup, isi data pewasiat pada Tahap 1, unggah berkas pada Tahap 2, isi informasi voucher PNBP pada Tahap 3, lalu periksa pratinjau dan kirim permohonan pada Tahap 4. Anda juga dapat menyimpan pengajuan sebagai draft.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-7 h-7 rounded-full bg-blue-50 text-[#0066d6] flex items-center justify-center text-xs font-bold shrink-0">3</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Pantau status permohonan</p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Buka Histori Permohonan untuk melihat daftar pengajuan dan statusnya. Jika permohonan perlu revisi atau tindakan lanjutan, buka kembali permohonan dari daftar tersebut.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-7 h-7 rounded-full bg-blue-50 text-[#0066d6] flex items-center justify-center text-xs font-bold shrink-0">4</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Perbarui informasi akun</p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Gunakan Profil Akun untuk memperbarui data diri dan informasi akun agar tetap sesuai.</p>
                        </div>
                    </li>
                </ol>
            </section>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10.5 12 3l9 7.5M5.25 9v11.25h5.25v-6h3v6h5.25V9" />
                    </svg>
                    <span>Buka Layanan</span>
                </a>
                <a href="{{ route('permohonan.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-[#0c2a55] font-semibold text-xs sm:text-sm rounded-xl border border-gray-200 transition">
                    <span>Lihat Histori Permohonan</span>
                </a>
            </div>
        </div>
    </div>
</x-portal-layout>
