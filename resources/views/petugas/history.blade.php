<x-portal-layout>
    <x-slot:title>
        History Verifikasi - Petugas BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        searchHistory: '{{ $search ?? '' }}'
    }">

        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold tracking-widest text-[#1d68d8] uppercase block">
                    DASHBOARD FUNGSIONAL
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight mt-1">
                    History Verifikasi
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Riwayat telaah berkas persyaratan permohonan yang telah selesai diperiksa oleh petugas.
                </p>
            </div>

            <!-- Stats Ringkas -->
            <div class="flex items-center gap-3">
                <div class="bg-white border border-gray-200/80 rounded-2xl p-3 px-4 shadow-xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v5h5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l4 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Riwayat</p>
                        <p class="text-lg font-black text-gray-900 leading-tight">{{ $stats['total_riwayat'] }}</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200/80 rounded-2xl p-3 px-4 shadow-xs flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Disetujui</p>
                        <p class="text-lg font-black text-emerald-600 leading-tight">{{ $stats['total_disetujui'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card: Riwayat Verifikasi -->
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7 space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Layanan Selesai Diverifikasi</h2>
                    <p class="text-xs text-gray-400 mt-0.5 font-medium">
                        Daftar berkas yang telah Anda telaah dan berikan keputusan statusnya
                    </p>
                </div>

                <div class="relative w-full sm:w-80">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" x-model="searchHistory" 
                           placeholder="Cari nomor atau pemohon..." 
                           class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1d68d8]/20 focus:border-[#1d68d8] transition" />
                </div>
            </div>

            <!-- Tabel Riwayat Verifikasi -->
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
                                STATUS HASIL
                            </th>
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                TANGGAL SELESAI
                            </th>
                            <th scope="col" class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                CATATAN HASIL TELAAH
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($historyList as $item)
                            <tr class="hover:bg-gray-50/50 transition"
                                x-show="!searchHistory || '{{ strtolower($item['nomor_layanan'].' '.$item['nama_pemohon'].' '.$item['jenis_layanan'].' '.$item['catatan']) }}'.includes(searchHistory.toLowerCase())">
                                
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm font-bold text-gray-900 block font-mono">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-xs text-gray-400 block mt-0.5">
                                        {{ $item['nama_pemohon'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $item['status_hasil'] === 'disetujui' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $item['status_label'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap text-gray-600">
                                    {{ $item['tanggal_selesai'] }}
                                </td>

                                <td class="py-4 px-4 text-xs text-gray-600 max-w-xs">
                                    <p class="truncate font-medium text-gray-800">{{ $item['catatan'] }}</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Oleh: {{ $item['petugas_verifikator'] }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-xs text-gray-400 font-medium">
                                    Belum ada riwayat verifikasi yang tersimpan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-portal-layout>
