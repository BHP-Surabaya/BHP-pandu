<x-portal-layout>
    <x-slot:title>
        History Layanan - Kepala Seksi BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ searchHistory: '' }">
        
        <!-- Header Page (Sama persis seperti gaya Admin) -->
        <div class="pb-4 border-b border-gray-200">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                History Layanan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Daftar rekam jejak disposisi dan penyelesaian layanan oleh Seksi BHP Surabaya.
            </p>
        </div>

        <!-- Search Bar & Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="w-full sm:w-72">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           x-model="searchHistory" 
                           placeholder="Cari riwayat layanan..." 
                           class="w-full pl-9 pr-3.5 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0d5c46]/20 focus:border-[#0d5c46] transition" />
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('kasi.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-xs transition">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Disposisi</span>
                </a>
            </div>
        </div>

        <!-- History Card & Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS &amp; DETAIL
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PEMOHON
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL DISPOSISI
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                PIC PETUGAS
                            </th>
                            <th scope="col" class="py-3 px-6 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                STATUS &amp; PENYELESAIAN
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($historyLayanan as $item)
                            <tr class="hover:bg-gray-50/60 transition group"
                                x-show="!searchHistory || '{{ strtolower($item['nomor_layanan'].' '.$item['jenis_layanan'].' '.$item['detail_layanan'].' '.$item['pemohon']) }}'.includes(searchHistory.toLowerCase())">
                                
                                <td class="py-4 px-6 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $item['nomor_layanan'] }}
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if ($item['jenis_layanan'] === 'SKHW')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#e0f2fe] text-[#0284c7] border border-[#bae6fd]">
                                                SKHW
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#f3e8ff] text-[#9333ea] border border-[#e9d5ff]">
                                                Wasiat
                                            </span>
                                        @endif
                                        <span class="font-medium text-gray-800">{{ $item['detail_layanan'] }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-gray-900 font-semibold whitespace-nowrap">
                                    {{ $item['pemohon'] }}
                                </td>

                                <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                    {{ $item['tanggal_disposisi'] }}
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @foreach ((array) $item['pic'] as $pic)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[11px] font-medium border border-gray-200/60">
                                                {{ $pic }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $item['status'] }} ({{ $item['selesai_pada'] }})</span>
                                    </div>
                                    @if (!empty($item['catatan']))
                                        <div class="text-[11px] text-gray-400 mt-1 max-w-xs truncate">{{ $item['catatan'] }}</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    Belum ada riwayat layanan yang selesai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-portal-layout>
