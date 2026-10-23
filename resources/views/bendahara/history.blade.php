<x-portal-layout>
    <x-slot:title>
        Riwayat Verifikasi PNBP - Bendahara Penerimaan BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-7" x-data="{
        copiedNtpn: null,
        detailModalOpen: false,
        selectedItem: null,

        copyToClipboard(text, id) {
            navigator.clipboard.writeText(text);
            this.copiedNtpn = id;
            setTimeout(() => {
                this.copiedNtpn = null;
            }, 2000);
        },

        openDetailModal(item) {
            this.selectedItem = item;
            this.detailModalOpen = true;
        }
    }">

        <!-- Header Page -->
        <div class="pb-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">
                        <a href="{{ route('bendahara.verifikasi.index') }}" class="hover:underline flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            <span>Verifikasi PNBP</span>
                        </a>
                        <span>/</span>
                        <span>Riwayat PNBP</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                        Riwayat Verifikasi PNBP
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar seluruh transaksi PNBP yang telah berhasil diverifikasi, divalidasi NTPN, dan disetorkan ke kas negara.
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <!-- Export CSV Button -->
                    <a href="{{ route('bendahara.history.export') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-xs transition hover:shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        <span>Ekspor Laporan (CSV/Excel)</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 p-4.5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-2xl sm:text-3xl font-black text-gray-900 leading-none tracking-tight block">
                        Rp {{ number_format($totalNominal ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-xs font-bold text-gray-800 mt-1 block">
                        Total Penerimaan PNBP
                    </span>
                    <span class="text-[11px] font-semibold text-emerald-600 block truncate">
                        Telah Disetor ke Kas Negara
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-4.5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-2xl sm:text-3xl font-black text-gray-900 leading-none tracking-tight block">
                        {{ count($historyList) }}
                    </span>
                    <span class="text-xs font-bold text-gray-800 mt-1 block">
                        Total Transaksi Terverifikasi
                    </span>
                    <span class="text-[11px] font-semibold text-blue-600 block truncate">
                        Status Lunas 100%
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-4.5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-2xl sm:text-3xl font-black text-gray-900 leading-none tracking-tight block">
                        100%
                    </span>
                    <span class="text-xs font-bold text-gray-800 mt-1 block">
                        Kelengkapan Bukti Voucher
                    </span>
                    <span class="text-[11px] font-semibold text-purple-600 block truncate">
                        Tervalidasi Simponi
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Controls -->
        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-xs">
            <form action="{{ route('bendahara.history.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center gap-3">
                <!-- Search Query -->
                <div class="relative flex-1">
                    <input type="text" 
                           name="q" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Cari NTPN, nomor layanan, nama pemohon, atau pewasiat..." 
                           class="w-full pl-9 pr-3.5 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition" />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>

                <!-- Date Range -->
                <div class="flex items-center gap-2">
                    <input type="date" 
                           name="date_from" 
                           value="{{ $dateFrom ?? '' }}" 
                           class="text-xs px-3 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" 
                           title="Dari tanggal bayar" />
                    <span class="text-xs text-gray-400">s/d</span>
                    <input type="date" 
                           name="date_to" 
                           value="{{ $dateTo ?? '' }}" 
                           class="text-xs px-3 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" 
                           title="Sampai tanggal bayar" />
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" 
                            class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition">
                        Filter
                    </button>
                    @if(!empty($search) || !empty($dateFrom) || !empty($dateTo))
                        <a href="{{ route('bendahara.history.index') }}" 
                           class="px-3 py-2 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th scope="col" class="py-3.5 px-4 sm:px-6">Nomor Layanan</th>
                            <th scope="col" class="py-3.5 px-4">Jenis Layanan</th>
                            <th scope="col" class="py-3.5 px-4">Pemohon &amp; Pewasiat</th>
                            <th scope="col" class="py-3.5 px-4">NTPN</th>
                            <th scope="col" class="py-3.5 px-4">Nominal</th>
                            <th scope="col" class="py-3.5 px-4">Tanggal Bayar</th>
                            <th scope="col" class="py-3.5 px-4">Bukti Voucher</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                            <th scope="col" class="py-3.5 px-4 sm:px-6 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($historyList as $item)
                            <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                <!-- 1. Nomor Layanan -->
                                <td class="py-4 px-4 sm:px-6 font-mono font-bold text-gray-900 select-all">
                                    {{ $item['nomor_layanan'] }}
                                </td>

                                <!-- 2. Jenis Layanan -->
                                <td class="py-4 px-4">
                                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-bold 
                                        {{ str_contains(strtolower($item['jenis_layanan']), 'skhw') ? 'bg-sky-50 text-sky-800 border border-sky-100' : 'bg-purple-50 text-purple-800 border border-purple-100' }}">
                                        {{ $item['jenis_layanan'] }}
                                    </div>
                                </td>

                                <!-- 3. Pemohon & Pewasiat -->
                                <td class="py-4 px-4">
                                    <div class="font-bold text-gray-900 leading-snug">
                                        {{ $item['nama_pemohon'] }}
                                    </div>
                                    <div class="text-[11px] text-gray-500">
                                        Pewasiat: {{ $item['nama_pewasiat'] ?: '-' }}
                                    </div>
                                </td>

                                <!-- 4. NTPN -->
                                <td class="py-4 px-4">
                                    <div class="inline-flex items-center gap-1.5 bg-gray-100/80 px-2 py-1 rounded-lg border border-gray-200">
                                        <span class="font-mono font-bold text-gray-900 select-all">
                                            {{ $item['ntpn'] }}
                                        </span>
                                        <button type="button" 
                                                @click="copyToClipboard('{{ $item['ntpn'] }}', '{{ $item['id'] }}')" 
                                                class="text-gray-400 hover:text-blue-600 transition" 
                                                title="Salin NTPN">
                                            <template x-if="copiedNtpn === '{{ $item['id'] }}'">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </template>
                                            <template x-if="copiedNtpn !== '{{ $item['id'] }}'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                                </svg>
                                            </template>
                                        </button>
                                    </div>
                                </td>

                                <!-- 5. Nominal -->
                                <td class="py-4 px-4 font-bold text-gray-900 whitespace-nowrap">
                                    Rp {{ number_format($item['nominal'] ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- 6. Tanggal Bayar & Verifikasi -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="font-semibold text-gray-900">{{ $item['tanggal_bayar'] }}</div>
                                    <div class="text-[10px] text-gray-500">Verif: {{ $item['tanggal_verifikasi'] ?? '-' }}</div>
                                </td>

                                <!-- 7. Bukti Voucher -->
                                <td class="py-4 px-4">
                                    @if(!empty($item['file_voucher_url']))
                                        <a href="{{ $item['file_voucher_url'] }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold transition border border-blue-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                            <span>Lihat Berkas</span>
                                        </a>
                                    @else
                                        <div class="inline-flex items-center gap-1 text-[11px] text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-200">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            <span class="truncate max-w-[120px]">{{ $item['file_voucher_nama'] ?? 'Voucher Simponi' }}</span>
                                        </div>
                                    @endif
                                </td>

                                <!-- 8. Status -->
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Lunas
                                    </span>
                                </td>

                                <!-- 9. Detail -->
                                <td class="py-4 px-4 sm:px-6 text-center">
                                    <button type="button" 
                                            @click="openDetailModal({{ json_encode($item) }})"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-100 text-xs font-semibold transition">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Rincian</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-12 px-6 text-center text-gray-500">
                                    <p class="font-bold text-gray-900 text-sm">Belum Ada Riwayat Verifikasi PNBP</p>
                                    <p class="text-xs text-gray-500 mt-1">Data pembayaran yang telah selesai diverifikasi akan tampil di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="detailModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            
            <div @click.away="detailModalOpen = false" 
                 class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 transform transition-all overflow-hidden flex flex-col">
                
                <!-- Modal Header -->
                <div class="px-6 pt-6 pb-4 sm:px-7 sm:pt-7 sm:pb-5 flex items-start justify-between border-b border-slate-100 bg-white">
                    <div class="flex items-start gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-emerald-700 tracking-widest uppercase block">
                                DATA TERVERIFIKASI · RESMI
                            </span>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight mt-0.5">
                                Rincian Setoran PNBP
                            </h3>
                            <p class="text-xs text-slate-500 font-normal mt-0.5">
                                Bukti transaksi validasi kas negara dan kode billing Simponi.
                            </p>
                        </div>
                    </div>
                    <button @click="detailModalOpen = false" 
                            type="button" 
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 sm:p-7 space-y-4 overflow-y-auto custom-scrollbar">
                    <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-4.5 text-xs space-y-2.5">
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Nomor Layanan:</span>
                            <span class="font-mono font-bold text-right text-slate-900 break-all select-all" x-text="selectedItem?.nomor_layanan"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Jenis Layanan:</span>
                            <span class="font-bold text-slate-800 text-right" x-text="selectedItem?.jenis_layanan"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Nama Pemohon:</span>
                            <span class="font-bold text-slate-900 text-right" x-text="selectedItem?.nama_pemohon"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Nama Pewasiat:</span>
                            <span class="font-semibold text-slate-700 text-right" x-text="selectedItem?.nama_pewasiat || '-'"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Kode NTPN:</span>
                            <span class="font-mono font-bold text-emerald-800 bg-emerald-100/70 border border-emerald-200/80 px-2 py-0.5 rounded-lg select-all" x-text="selectedItem?.ntpn"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Nominal Setoran:</span>
                            <span class="font-black text-slate-900 text-sm text-right" x-text="'Rp ' + Number(selectedItem?.nominal || 0).toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Tanggal Bayar:</span>
                            <span class="font-semibold text-slate-800 text-right" x-text="selectedItem?.tanggal_bayar"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Waktu Verifikasi:</span>
                            <span class="font-semibold text-slate-800 text-right" x-text="selectedItem?.tanggal_verifikasi"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 gap-3">
                            <span class="text-slate-500 font-medium">Diverifikasi Oleh:</span>
                            <span class="font-bold text-[#1d68d8] text-right" x-text="selectedItem?.diverifikasi_oleh"></span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 sm:px-7 py-4 bg-slate-50/80 border-t border-slate-100 flex justify-end">
                    <button type="button" 
                            @click="detailModalOpen = false" 
                            class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
