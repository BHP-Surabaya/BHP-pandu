<x-portal-layout>
    <x-slot name="title">
        Dashboard Pemohon - Balai Harta Peninggalan
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
        <!-- Hero Banner Sambutan -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#210936] via-[#2c0b47] to-[#1c082e] p-6 sm:p-8 text-white shadow-sm border border-purple-950/40">
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <!-- Badge BHP Kemenkumham RI -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 border border-white/15 text-xs font-medium backdrop-blur-sm mb-3">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <span>Balai Harta Peninggalan (BHP) Kemenkumham RI</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-2">
                        Selamat Datang, {{ Auth::user()->name ?? 'Pemohon' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-purple-200/85 leading-relaxed max-w-2xl">
                        Pantau progres verifikasi permohonan pembukaan wasiat tertutup Anda, lakukan pemesanan voucher PNBP, hingga jadwal penetapan resmi pembukaan wasiat.
                    </p>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('permohonan.create') }}" 
                       class="inline-flex items-center gap-2 px-5 py-3 bg-[#f59e0b] hover:bg-[#d97706] text-gray-950 font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Buat Permohonan Baru</span>
                    </a>
                </div>
            </div>

            <!-- Background decorative effect -->
            <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- 4 Kartu Metrik Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Total Permohonan -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">TOTAL PERMOHONAN</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 my-2">
                    {{ $stats['total'] ?? 0 }}
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span>Keseluruhan pengajuan</span>
                </div>
            </div>

            <!-- Verifikasi Berkas -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">VERIFIKASI BERKAS</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 my-2">
                    {{ $stats['verifikasi'] ?? 0 }}
                </div>
                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Proses telaah oleh BHP</span>
                </div>
            </div>

            <!-- Voucher PNBP -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">VOUCHER PNBP</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 my-2">
                    {{ $stats['voucher'] ?? 0 }}
                </div>
                <div class="flex items-center gap-1.5 text-xs text-purple-700 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>Perlu input nomor voucher</span>
                </div>
            </div>

            <!-- Siap / Dibuka -->
            <div class="bg-white rounded-2xl p-5 border border-gray-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">SIAP / DIBUKA</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 my-2">
                    {{ $stats['siap'] ?? 0 }}
                </div>
                <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Jadwal resmi terbit</span>
                </div>
            </div>
        </div>

        <!-- Banner Tindakan Diperlukan (Muncul jika ada permohonan yang perlu tindakan) -->
        @if ($permohonanPerluTindakan)
            <div class="bg-white rounded-2xl border-2 border-amber-300 p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start sm:items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-400 text-gray-950 font-black text-sm flex items-center justify-center shrink-0">
                        !
                    </div>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">
                            Tindakan Diperlukan
                        </h2>
                        <p class="text-xs text-gray-600 leading-relaxed mt-0.5">
                            @if ($permohonanPerluTindakan->status === 'menunggu_voucher')
                                Permohonan <strong class="text-purple-900 font-bold">{{ $permohonanPerluTindakan->nomor_permohonan }}</strong> telah disetujui berkasnya. Silakan selesaikan pembayaran PNBP di SIMPADHU AHU.
                            @else
                                Permohonan <strong class="text-purple-900 font-bold">{{ $permohonanPerluTindakan->nomor_permohonan }}</strong> memerlukan revisi berkas.
                                @if ($permohonanPerluTindakan->catatan_revisi)
                                    <span class="font-medium text-gray-500">Catatan: {{ $permohonanPerluTindakan->catatan_revisi }}</span>
                                @endif
                            @endif
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    <a href="https://ahu.go.id/billing/voucher/tambah/id/001008/sub/001008002" target="_blank" rel="noopener noreferrer" 
                       class="px-4 py-2.5 bg-[#2e1065] hover:bg-[#3b0764] text-white font-bold text-xs rounded-xl inline-flex items-center gap-2 shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Buka SIMPADHU AHU &amp; Input Voucher</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Bagian Konten Utama: 2 Kolom (Tabel Permohonan di Kiri, Panduan Alur di Sampingnya) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Kolom Kiri: Tabel Daftar Permohonan Aktif -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.02)] overflow-hidden">
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">
                                Daftar Permohonan Aktif
                            </h2>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Status dan tahapan real-time permohonan pembukaan wasiat tertutup
                            </p>
                        </div>
                        <a href="{{ route('permohonan.index') }}" class="text-xs font-bold text-purple-700 hover:text-purple-900 flex items-center gap-1 transition">
                            <span>Lihat Semua</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>

                    @if ($userPermohonans->isEmpty())
                        <!-- Empty State ketika data permohonan kosong -->
                        <div class="p-10 text-center border-t border-gray-100">
                            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-[#2e1065] flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800">
                                Data Tidak Ditemukan
                            </h3>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1 mb-5 leading-relaxed">
                                Anda belum memiliki pengajuan permohonan pembukaan wasiat tertutup. Klik tombol di bawah untuk membuat permohonan baru.
                            </p>
                            <a href="{{ route('permohonan.create') }}" 
                               class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#f59e0b] hover:bg-[#d97706] text-gray-950 font-bold text-xs rounded-xl shadow-sm transition">
                                <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Mulai Buat Permohonan</span>
                            </a>
                        </div>
                    @else
                        <!-- Tampilan Data Riil jika permohonan ada -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-gray-700">
                                <thead class="bg-gray-50/70 text-gray-400 uppercase text-[10px] font-bold border-y border-gray-100 tracking-wider">
                                    <tr>
                                        <th class="px-5 py-3">NO. PERMOHONAN</th>
                                        <th class="px-5 py-3">NAMA PEWASIAT</th>
                                        <th class="px-5 py-3">TANGGAL PENGAJUAN</th>
                                        <th class="px-5 py-3">STATUS TAHAPAN</th>
                                        <th class="px-5 py-3 text-right">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($userPermohonans as $p)
                                        <tr class="hover:bg-gray-50/60 transition">
                                            <td class="px-5 py-4">
                                                <div class="font-bold text-xs text-[#2e1065]">
                                                    {{ $p->nomor_permohonan ?? 'Draft Pengajuan' }}
                                                </div>
                                                <div class="text-[11px] text-gray-400">BHP Surabaya</div>
                                            </td>
                                            <td class="px-5 py-4">
                                                <div class="font-bold text-xs text-gray-900">
                                                    {{ $p->pewasiat?->nama_lengkap ?? '-' }}
                                                </div>
                                                <div class="text-[11px] text-gray-500">
                                                    @if ($p->pewasiat?->nomor_akta_penyimpanan)
                                                        Akta No. {{ $p->pewasiat->nomor_akta_penyimpanan }}
                                                    @elseif ($p->pewasiat?->nik)
                                                        NIK: {{ $p->pewasiat->nik }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 text-xs text-gray-600 font-medium">
                                                {{ $p->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-5 py-4">
                                                @if ($p->status === 'menunggu_voucher')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#fef3c7] text-[#92400e] border border-[#fde68a]">
                                                        <span class="w-1.5 h-1.5 rounded-sm bg-amber-500"></span>
                                                        <span>Input Voucher PNBP</span>
                                                    </span>
                                                @elseif ($p->status === 'menunggu_verifikasi')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#eff6ff] text-[#1d4ed8] border border-[#bfdbfe]">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                        <span>Verifikasi Berkas</span>
                                                    </span>
                                                @elseif ($p->status === 'revisi')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        <span>Perlu Revisi</span>
                                                    </span>
                                                @elseif ($p->status === 'selesai')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#ecfdf5] text-[#047857] border border-[#a7f3d0]">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        <span>Jadwal Ditetapkan</span>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                        <span>Draft</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-4 text-right">
                                                @if ($p->status === 'menunggu_voucher')
                                                    <a href="https://ahu.go.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-3.5 py-1.5 bg-[#2e1065] hover:bg-[#3b0764] text-white text-xs font-bold rounded-xl shadow-sm transition">
                                                        <span>Pesan &amp; Input</span>
                                                        <span aria-hidden="true">&rarr;</span>
                                                    </a>
                                                @elseif ($p->status === 'draft')
                                                    <a href="{{ route('permohonan.create') }}" class="text-xs font-bold text-purple-700 hover:text-purple-900 hover:underline inline-flex items-center gap-1">
                                                        <span>Lanjutkan</span>
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="{{ route('permohonan.index') }}" class="text-xs font-bold text-purple-700 hover:text-purple-900 hover:underline">
                                                        Lihat Detail
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan: Card Panduan Alur Proses Permohonan Wasiat Tertutup -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 sm:p-6 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">
                            Panduan Alur Proses
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Alur tahapan permohonan pembukaan wasiat tertutup di Balai Harta Peninggalan.
                        </p>
                    </div>

                    <!-- Timeline Vertikal 5 Tahap (Format Global Seragam) -->
                    <div class="mt-6 space-y-4">
                        <!-- Tahap 1 -->
                        <div class="flex items-start gap-3.5 relative">
                            <div class="absolute left-4 top-8 -bottom-4 w-0.5 bg-purple-200"></div>
                            <div class="w-8 h-8 rounded-full bg-[#2e1065] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm z-10">
                                1
                            </div>
                            <div class="pt-1">
                                <div class="font-bold text-xs text-gray-900">1. Data Diri</div>
                                <div class="text-[11px] text-gray-500 mt-0.5">Formulir Seksi I - VI</div>
                            </div>
                        </div>

                        <!-- Tahap 2 -->
                        <div class="flex items-start gap-3.5 relative">
                            <div class="absolute left-4 top-8 -bottom-4 w-0.5 bg-purple-200"></div>
                            <div class="w-8 h-8 rounded-full bg-[#2e1065] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm z-10">
                                2
                            </div>
                            <div class="pt-1">
                                <div class="font-bold text-xs text-gray-900">2. Upload Berkas</div>
                                <div class="text-[11px] text-gray-500 mt-0.5">Checklist 6 Dokumen</div>
                            </div>
                        </div>

                        <!-- Tahap 3 -->
                        <div class="flex items-start gap-3.5 relative">
                            <div class="absolute left-4 top-8 -bottom-4 w-0.5 bg-purple-200"></div>
                            <div class="w-8 h-8 rounded-full bg-[#2e1065] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm z-10">
                                3
                            </div>
                            <div class="pt-1">
                                <div class="font-bold text-xs text-gray-900">3. Voucher PNBP</div>
                                <div class="text-[11px] text-gray-500 mt-0.5">SIMPADHU AHU</div>
                            </div>
                        </div>

                        <!-- Tahap 4 -->
                        <div class="flex items-start gap-3.5 relative">
                            <div class="absolute left-4 top-8 -bottom-4 w-0.5 bg-purple-200"></div>
                            <div class="w-8 h-8 rounded-full bg-[#2e1065] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm z-10">
                                4
                            </div>
                            <div class="pt-1">
                                <div class="font-bold text-xs text-gray-900">4. Verifikasi BHP</div>
                                <div class="text-[11px] text-gray-500 mt-0.5">Pemeriksaan berkas</div>
                            </div>
                        </div>

                        <!-- Tahap 5 -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-full bg-[#2e1065] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm z-10">
                                5
                            </div>
                            <div class="pt-1">
                                <div class="font-bold text-xs text-gray-900">5. Sidang Buka</div>
                                <div class="text-[11px] text-gray-500 mt-0.5">Status &ldquo;Terbuka&rdquo;</div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan Status Tertutup -->
                    <div class="mt-6 p-3 rounded-xl bg-purple-50/70 border border-purple-100/80 text-[11px] text-purple-900 leading-relaxed">
                        <span class="font-semibold">Catatan:</span> Dokumen tetap <em>&ldquo;Tertutup&rdquo;</em> dan hanya berstatus <em>&ldquo;Terbuka&rdquo;</em> saat sidang resmi diselenggarakan.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-portal-layout>
