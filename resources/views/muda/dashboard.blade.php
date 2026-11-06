<x-portal-layout>
    <x-slot:title>
        Verifikasi Persyaratan - Kurator Keperdataan Muda BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ 
        searchLayanan: '{{ $search ?? '' }}'
    }">

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Header Halaman Sesuai Desain Fungsional Muda -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold tracking-widest text-[#1d68d8] uppercase block">
                    DASHBOARD KURATOR MUDA
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight mt-1">
                    Verifikasi Persyaratan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Periksa kesesuaian input pemohon dengan dokumen persyaratan yang diunggah.
                </p>
            </div>

            <!-- Tanggal Widget Kanan Atas Sesuai Desain -->
            <div class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-200/90 rounded-2xl shadow-2xs text-xs font-semibold text-gray-700 shrink-0 self-start">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                </svg>
                <span>Jumat, 30 Mei 2025</span>
            </div>
        </div>

        <!-- Main Card: Daftar Layanan -->
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7 space-y-6">
            
            <!-- Card Header: Title + Badge & Search Box -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-lg font-bold text-gray-900">Daftar Layanan</h2>
                        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full bg-blue-50 text-[#1d68d8]">
                            {{ count($verifikasiList) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5 font-medium">
                        Layanan hasil disposisi yang perlu Anda verifikasi
                    </p>
                </div>

                <!-- Input Pencarian -->
                <div class="relative w-full sm:w-80">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" x-model="searchLayanan" 
                           placeholder="Cari nomor atau pemohon..." 
                           class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1d68d8]/20 focus:border-[#1d68d8] transition" />
                </div>
            </div>

            <!-- Tabel Data Layanan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[760px]">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                DETAIL LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL MASUK
                            </th>
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 text-right">
                                AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($verifikasiList as $item)
                            <tr class="hover:bg-gray-50/50 transition group"
                                x-show="!searchLayanan || '{{ strtolower($item['nomor_layanan'].' '.$item['nama_pemohon'].' '.$item['jenis_layanan'].' '.$item['detail_layanan']) }}'.includes(searchLayanan.toLowerCase())">
                                
                                <!-- NOMOR LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm font-bold text-gray-900 block font-mono">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-xs text-gray-400 block mt-0.5 font-normal">
                                        {{ $item['nama_pemohon'] }}
                                    </span>
                                </td>

                                <!-- JENIS LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if (strtoupper($item['jenis_layanan']) === 'SKHW')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#e0f2fe] text-[#0284c7] border border-[#bae6fd]">
                                            SKHW
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#f3e8ff] text-[#9333ea] border border-[#e9d5ff]">
                                            Wasiat
                                        </span>
                                    @endif
                                </td>

                                <!-- DETAIL LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap text-xs sm:text-sm text-gray-700 font-medium">
                                    {{ $item['detail_layanan'] }}
                                </td>

                                <!-- TANGGAL MASUK -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm text-gray-800 font-medium block">
                                        {{ $item['tanggal_masuk'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5 font-normal">
                                        {{ $item['waktu_masuk'] ?? 'Pukul 11:00' }}
                                    </span>
                                </td>

                                <!-- AKSI -->
                                <td class="py-4 px-4 whitespace-nowrap text-right">
                                    <a href="{{ route('muda.verifikasi.show', $item['id']) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer">
                                        <span>Verifikasi Persyaratan</span>
                                        <svg class="w-3.5 h-3.5 text-white/80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-xs text-gray-400 font-medium">
                                    Tidak ada permohonan yang perlu diverifikasi saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-portal-layout>
