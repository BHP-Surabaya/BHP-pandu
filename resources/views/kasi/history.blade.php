<x-portal-layout>
    <x-slot:title>
        History Layanan - Kepala Seksi BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ 
        searchHistory: '',
        filterJenis: 'all',
        filterDropdownOpen: false
    }">
        
        <!-- Header Page -->
        <div class="pb-3 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    History Layanan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Daftar rekam jejak penyelesaian layanan dan rekapitulasi data layanan BHP Surabaya.
                </p>
            </div>
            <a href="{{ route('kasi.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Disposisi</span>
            </a>
        </div>

        <!-- ======================================================== -->
        <!-- 4 TOP STAT CARDS (PERSIS WIREFRAME SCREENSHOT)          -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Card 1: Layanan Masuk -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-2xs hover:shadow-xs transition">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">Layanan Masuk</span>
                        <div class="text-3xl font-black text-gray-900 mt-1.5 tracking-tight">
                            {{ $statsHistory['layanan_masuk'] ?? count($historyLayanan) }}
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                </div>
                <div class="text-[11px] text-gray-400 mt-2 font-medium">
                    Berdasarkan filter aktif
                </div>
            </div>

            <!-- Card 2: Jenis Layanan -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-2xs hover:shadow-xs transition">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">Jenis Layanan</span>
                        <div class="flex items-center gap-6 mt-1.5 divide-x divide-gray-100">
                            <div>
                                <span class="text-2xl font-black text-gray-900 tracking-tight">{{ $statsHistory['jenis_skhw'] ?? 6 }}</span>
                                <div class="text-[11px] text-gray-400 font-medium">SKHW</div>
                            </div>
                            <div class="pl-6">
                                <span class="text-2xl font-black text-gray-900 tracking-tight">{{ $statsHistory['jenis_wasiat'] ?? 6 }}</span>
                                <div class="text-[11px] text-gray-400 font-medium">Wasiat</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 3: Jumlah SLA Aktif -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-2xs hover:shadow-xs transition">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">Jumlah SLA Aktif</span>
                        <div class="flex items-center gap-5 mt-1.5">
                            <div>
                                <span class="text-2xl font-black text-rose-600 tracking-tight">{{ $statsHistory['sla_merah'] ?? 2 }}</span>
                                <div class="text-[11px] text-gray-400 font-medium">Merah</div>
                            </div>
                            <div>
                                <span class="text-2xl font-black text-amber-500 tracking-tight">{{ $statsHistory['sla_kuning'] ?? 1 }}</span>
                                <div class="text-[11px] text-gray-400 font-medium">Kuning</div>
                            </div>
                            <div>
                                <span class="text-2xl font-black text-emerald-600 tracking-tight">{{ $statsHistory['sla_hijau'] ?? 1 }}</span>
                                <div class="text-[11px] text-gray-400 font-medium">Hijau</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 4: Layanan Selesai -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-2xs hover:shadow-xs transition">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">Layanan Selesai</span>
                        <div class="text-3xl font-black text-gray-900 mt-1.5 tracking-tight">
                            {{ $statsHistory['layanan_selesai'] ?? count($historyLayanan) }}
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-[11px] text-gray-400 mt-2 font-medium">
                    Telah dikirim ke akun pemohon
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION: REKAPITULASI DATA LAYANAN (PERSIS WIREFRAME)   -->
        <!-- ======================================================== -->
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Header Section with Title, Subtitle, and Filter Button -->
            <div class="px-6 py-5 sm:px-7 sm:py-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 tracking-tight">
                        Rekapitulasi Data Layanan
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5 font-normal">
                        Daftar layanan yang telah selesai dan dikirim kepada pemohon
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search Input -->
                    <div class="relative w-44 sm:w-56">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchHistory" 
                               placeholder="Cari nomor/pemohon..." 
                               class="w-full pl-8 pr-3 py-1.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0d5c46]/20 focus:border-[#0d5c46] transition" />
                    </div>

                    <!-- Filter Layanan Button & Popover -->
                    <div class="relative">
                        <button type="button" 
                                @click="filterDropdownOpen = !filterDropdownOpen"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>
                            <span>Filter Layanan</span>
                            <span x-show="filterJenis !== 'all'" class="w-1.5 h-1.5 rounded-full bg-[#0d5c46]" style="display: none;"></span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="filterDropdownOpen" 
                             @click.away="filterDropdownOpen = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 p-2 z-20 space-y-1 text-xs"
                             style="display: none;">
                            <div class="px-2.5 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jenis Layanan</div>
                            <button type="button" @click="filterJenis = 'all'; filterDropdownOpen = false" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-gray-50 flex items-center justify-between" :class="filterJenis === 'all' ? 'text-[#0d5c46] font-bold bg-emerald-50/60' : 'text-gray-700'">
                                <span>Semua Jenis</span>
                                <span class="text-[10px] text-gray-400">12</span>
                            </button>
                            <button type="button" @click="filterJenis = 'SKHW'; filterDropdownOpen = false" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-gray-50 flex items-center justify-between" :class="filterJenis === 'SKHW' ? 'text-[#0d5c46] font-bold bg-emerald-50/60' : 'text-gray-700'">
                                <span>SKHW</span>
                                <span class="text-[10px] text-gray-400">6</span>
                            </button>
                            <button type="button" @click="filterJenis = 'Wasiat'; filterDropdownOpen = false" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-gray-50 flex items-center justify-between" :class="filterJenis === 'Wasiat' ? 'text-[#0d5c46] font-bold bg-emerald-50/60' : 'text-gray-700'">
                                <span>Wasiat</span>
                                <span class="text-[10px] text-gray-400">6</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                DETAIL LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PEMOHON
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL MASUK
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL DISPOSISI
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL SELESAI
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                DURASI LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                HASIL
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($historyLayanan as $item)
                            <tr class="hover:bg-gray-50/60 transition group"
                                x-show="(filterJenis === 'all' || '{{ $item['jenis_layanan'] }}' === filterJenis) && (!searchHistory || '{{ strtolower($item['nomor_layanan'].' '.$item['jenis_layanan'].' '.$item['detail_layanan'].' '.$item['pemohon']) }}'.includes(searchHistory.toLowerCase()))">
                                
                                <!-- Nomor Layanan -->
                                <td class="py-4 px-6 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item['nomor_layanan'] }}
                                </td>

                                <!-- Jenis Layanan Badge -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if ($item['jenis_layanan'] === 'SKHW')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#e0f2fe] text-[#0284c7] border border-[#bae6fd]">
                                            SKHW
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#f3e8ff] text-[#9333ea] border border-[#e9d5ff]">
                                            Wasiat
                                        </span>
                                    @endif
                                </td>

                                <!-- Detail Layanan -->
                                <td class="py-4 px-6 text-gray-700 whitespace-nowrap font-medium">
                                    {{ $item['detail_layanan'] }}
                                </td>

                                <!-- Pemohon -->
                                <td class="py-4 px-6 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $item['pemohon'] }}
                                </td>

                                <!-- Tanggal Masuk -->
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_masuk'] ?? '28 Mei 2025' }}
                                </td>

                                <!-- Tanggal Disposisi -->
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_disposisi'] }}
                                </td>

                                <!-- Tanggal Selesai -->
                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_selesai'] ?? $item['selesai_pada'] ?? '30 Mei 2025' }}
                                </td>

                                <!-- Durasi Layanan -->
                                <td class="py-4 px-6 font-bold text-gray-900 whitespace-nowrap">
                                    {{ $item['durasi_layanan'] ?? '3 hari kerja' }}
                                </td>

                                <!-- Hasil Column (Selesai Pill & Subtext) -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#f0fdf4] text-[#15803d] border border-[#dcfce7] text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-[#15803d]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span>Selesai</span>
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-1 font-normal">
                                        {{ $item['keterangan_hasil'] ?? 'Dikirim ke akun pemohon' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-400">
                                    Tidak ada riwayat layanan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-portal-layout>

