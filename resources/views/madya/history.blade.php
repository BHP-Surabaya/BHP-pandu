<x-portal-layout>
    <x-slot:title>
        Histori Layanan - Kurator Keperdataan Madya BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        searchHistory: '{{ $search ?? '' }}'
    }">

        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold tracking-wider text-[#1d68d8] uppercase block">
                    DASHBOARD MADYA
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight mt-1">
                    Histori Layanan
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Riwayat berita acara, cetak dokumen 2 salinan, dan arsip Layanan Wasiat Tertutup.
                </p>
            </div>

            <!-- Stats Ringkas -->
            <div class="flex items-center gap-3">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-3 px-4 shadow-xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#1d68d8] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Histori</p>
                        <p class="text-lg font-black text-slate-900 leading-tight">{{ $stats['total_riwayat'] }}</p>
                    </div>
                </div>

                <div class="bg-white border border-slate-200/80 rounded-2xl p-3 px-4 shadow-xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Diarsipkan</p>
                        <p class="text-lg font-black text-emerald-600 leading-tight">{{ $stats['total_disetujui'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card: Riwayat Layanan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-7 space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Histori Layanan Selesai</h2>
                    <p class="text-sm text-slate-500 mt-0.5">
                        Daftar Layanan Wasiat Tertutup yang telah dibuat Berita Acara dan diarsipkan resmi.
                    </p>
                </div>

                <div class="relative w-full sm:w-80">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" x-model="searchHistory" 
                           placeholder="Cari nomor atau pemohon..." 
                           class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1d68d8]/20 focus:border-[#1d68d8] transition" />
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[850px]">
                    <thead>
                        <tr class="bg-slate-50/70 border-y border-slate-100 text-xs font-bold text-slate-700">
                            <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                            <th scope="col" class="py-3.5 px-4">No Layanan</th>
                            <th scope="col" class="py-3.5 px-4">Jenis Layanan</th>
                            <th scope="col" class="py-3.5 px-4">Pemohon</th>
                            <th scope="col" class="py-3.5 px-4">Tanggal Selesai</th>
                            <th scope="col" class="py-3.5 px-4">No. Berita Acara</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Status &amp; Arsip</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($historyList as $index => $item)
                            <tr class="hover:bg-slate-50/50 transition"
                                x-show="!searchHistory || '{{ strtolower($item['nomor_layanan'].' '.$item['nama_pemohon'].' '.$item['jenis_layanan'].' '.($item['catatan'] ?? '')) }}'.includes(searchHistory.toLowerCase())">
                                
                                <td class="py-4 px-4 text-center font-medium text-slate-600">
                                    {{ sprintf('%02d', $index + 1) }}
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-bold text-[#1d68d8] block">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-xs text-slate-400 block mt-0.5">
                                        {{ $item['nama_pewasiat'] ?? 'Pewasiat' }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-[#1d68d8] border border-blue-100">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-900 block">
                                        {{ $item['nama_pemohon'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap text-slate-600">
                                    {{ $item['tanggal_selesai'] }}
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-slate-800 block">
                                        {{ $item['nomor_ba'] ?? 'BA.01/WST/BHP.SBY/V/2025' }}
                                    </span>
                                    <span class="text-[11px] text-emerald-600 font-semibold block mt-0.5">
                                        {{ $item['salinan_dicetak'] ?? '2 Salinan Dicetak' }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $item['status_label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center text-sm text-slate-400">
                                    Belum ada histori layanan yang tersimpan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-portal-layout>
