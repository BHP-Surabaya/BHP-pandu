<x-portal-layout>
    <x-slot:title>
        Verifikasi Lanjutan - Kurator Keperdataan Muda BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ 
        activeTab: 'jadwal',
        searchLayanan: '{{ $search ?? '' }}',
        modalLihatOpen: false,
        modalTindakLanjutOpen: false,
        modalPenerbitanOpen: false,
        selectedJadwal: null,
        selectedPenerbitan: null,
        tindakLanjutStatus: 'disetujui',
        openLihatModal(item) {
            this.selectedJadwal = item;
            this.modalLihatOpen = true;
        },
        openTindakLanjutModal(item) {
            this.selectedJadwal = item;
            this.tindakLanjutStatus = item.status === 'disetujui' ? 'terbitkan' : 'disetujui';
            this.modalTindakLanjutOpen = true;
        },
        openPenerbitanModal(item) {
            this.selectedPenerbitan = item;
            this.modalPenerbitanOpen = true;
        }
    }">

        <!-- Alert Notifikasi Flash Sesuai Desain Petugas & Kasi -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold px-2 py-1">✕</button>
            </div>
        @endif

        <!-- ================= HEADER RUANG KERJA (Format Sama Akun Petugas/Kasi) ================= -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold tracking-widest text-[#1d68d8] uppercase block">
                    DASHBOARD FUNGSIONAL MUDA
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight mt-1">
                    Verifikasi Lanjutan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Tinjau hasil verifikasi awal dan tindak lanjuti layanan wasiat.
                </p>
            </div>

            <!-- Tanggal Widget Kanan Atas Format Standar Akun Lain -->
            <div class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-200/90 rounded-2xl shadow-2xs text-xs font-semibold text-gray-700 shrink-0 self-start">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                </svg>
                <span>Jumat, 30 Mei 2025</span>
            </div>
        </div>

        <!-- ================= 3 TABS NAVIGASI UTAMA (Warna Standar Biru BHP) ================= -->
        <div class="flex items-center gap-2 border-b border-gray-200/80 pb-2 overflow-x-auto">
            
            <!-- Tab 1: Hasil Verifikasi Pertama -->
            <button type="button" @click="activeTab = 'verifikasi'"
                    :class="activeTab === 'verifikasi' 
                        ? 'bg-blue-50 text-[#1d68d8] border-[#1d68d8] shadow-2xs font-bold' 
                        : 'bg-white text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-gray-200/80 font-medium'"
                    class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl border text-xs sm:text-sm transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4" :class="activeTab === 'verifikasi' ? 'text-[#1d68d8]' : 'text-gray-400'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
                <span>Hasil Verifikasi Pertama</span>
                <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 text-[11px] font-extrabold rounded-full"
                      :class="activeTab === 'verifikasi' ? 'bg-[#1d68d8] text-white' : 'bg-gray-100 text-gray-600'">
                    {{ count($verifikasiList) }}
                </span>
            </button>

            <!-- Tab 2: Penjadwalan Pembukaan (Active by default) -->
            <button type="button" @click="activeTab = 'jadwal'"
                    :class="activeTab === 'jadwal' 
                        ? 'bg-blue-50 text-[#1d68d8] border-[#1d68d8] shadow-2xs font-bold' 
                        : 'bg-white text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-gray-200/80 font-medium'"
                    class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl border text-xs sm:text-sm transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4" :class="activeTab === 'jadwal' ? 'text-[#1d68d8]' : 'text-gray-400'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                </svg>
                <span>Penjadwalan Pembukaan</span>
                <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 text-[11px] font-extrabold rounded-full"
                      :class="activeTab === 'jadwal' ? 'bg-[#1d68d8] text-white' : 'bg-gray-100 text-gray-600'">
                    {{ count($jadwalList) }}
                </span>
            </button>

            <!-- Tab 3: Penerbitan Dokumen -->
            <button type="button" @click="activeTab = 'penerbitan'"
                    :class="activeTab === 'penerbitan' 
                        ? 'bg-blue-50 text-[#1d68d8] border-[#1d68d8] shadow-2xs font-bold' 
                        : 'bg-white text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-gray-200/80 font-medium'"
                    class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl border text-xs sm:text-sm transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4" :class="activeTab === 'penerbitan' ? 'text-[#1d68d8]' : 'text-gray-400'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span>Penerbitan Dokumen</span>
                <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 text-[11px] font-extrabold rounded-full"
                      :class="activeTab === 'penerbitan' ? 'bg-[#1d68d8] text-white' : 'bg-gray-100 text-gray-600'">
                    {{ count($penerbitanList) }}
                </span>
            </button>

        </div>

        <!-- ================= TAB 2 CONTENT: JADWAL PEMBUKAAN WASIAT ================= -->
        <div x-show="activeTab === 'jadwal'" class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7 space-y-6">
            
            <!-- Header Kartu -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-lg font-bold text-gray-900">Jadwal Pembukaan Wasiat</h2>
                        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full bg-blue-50 text-[#1d68d8]">
                            {{ count($jadwalList) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5 font-medium">
                        Permohonan pembukaan wasiat terbuka yang menunggu tindak lanjut
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

            <!-- Tabel Data Jadwal Pembukaan Wasiat -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                            <th scope="col" class="py-3 px-3 w-12 text-center">NO.</th>
                            <th scope="col" class="py-3 px-4">NOMOR LAYANAN</th>
                            <th scope="col" class="py-3 px-4">NAMA PEMOHON</th>
                            <th scope="col" class="py-3 px-4">BATAS SLA</th>
                            <th scope="col" class="py-3 px-4">JADWAL PEMOHON</th>
                            <th scope="col" class="py-3 px-4">NO. TELEPON</th>
                            <th scope="col" class="py-3 px-4 text-left">STATUS &amp; AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($jadwalList as $item)
                            <tr class="hover:bg-gray-50/50 transition group"
                                x-show="!searchLayanan || '{{ strtolower($item['nomor_layanan'].' '.$item['nama_pemohon'].' '.$item['jenis_layanan']) }}'.includes(searchLayanan.toLowerCase())">
                                
                                <!-- NO. -->
                                <td class="py-4 px-3 text-center font-mono text-gray-400">
                                    {{ $item['no'] ?? sprintf('%02d', $loop->iteration) }}
                                </td>

                                <!-- NOMOR LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm font-bold text-[#1d68d8] block font-mono hover:underline cursor-pointer"
                                          @click="openLihatModal({{ json_encode($item) }})">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5 font-normal">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                </td>

                                <!-- NAMA PEMOHON -->
                                <td class="py-4 px-4 whitespace-nowrap font-bold text-gray-900 text-xs sm:text-sm">
                                    {{ $item['nama_pemohon'] }}
                                </td>

                                <!-- BATAS SLA -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs font-bold text-gray-800 block">
                                        {{ $item['batas_sla'] }}
                                    </span>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        @if (($item['sla_level'] ?? '') === 'danger' || ($item['sla_hari_tersisa'] ?? 0) <= 2)
                                            <span class="w-2 h-2 rounded-full bg-red-500 inline-block shrink-0"></span>
                                            <span class="text-xs font-semibold text-gray-700">{{ $item['sla_hari_tersisa'] }} hari tersisa</span>
                                        @elseif (($item['sla_level'] ?? '') === 'warning' || ($item['sla_hari_tersisa'] ?? 0) <= 6)
                                            <span class="w-2 h-2 rounded-full bg-amber-500 inline-block shrink-0"></span>
                                            <span class="text-xs font-semibold text-gray-700">{{ $item['sla_hari_tersisa'] }} hari tersisa</span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block shrink-0"></span>
                                            <span class="text-xs font-semibold text-gray-700">{{ $item['sla_hari_tersisa'] }} hari tersisa</span>
                                        @endif
                                        <span class="text-[11px] text-gray-400">Hari ke-{{ $item['sla_hari_ke'] }} dari {{ $item['sla_total_hari'] }}</span>
                                    </div>
                                </td>

                                <!-- JADWAL PEMOHON -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs font-bold text-gray-800 block">
                                        {{ $item['jadwal_pemohon_tanggal'] }}
                                    </span>
                                    <span class="text-xs text-gray-500 block mt-0.5">
                                        {{ $item['jadwal_pemohon_waktu'] }}
                                    </span>
                                </td>

                                <!-- NO. TELEPON -->
                                <td class="py-4 px-4 whitespace-nowrap font-mono text-gray-700 text-xs">
                                    {{ $item['nomor_telepon'] }}
                                </td>

                                <!-- STATUS & AKSI (Warna & Tombol Standar Akun Petugas/BHP) -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-2 items-start">
                                        <!-- Status Badge -->
                                        @if (($item['status'] ?? '') === 'disetujui')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                                <span>{{ $item['status_label'] ?? 'Disetujui' }}</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                                                <span>{{ $item['status_label'] ?? 'Menunggu persetujuan' }}</span>
                                            </span>
                                        @endif

                                        <!-- Tombol Aksi -->
                                        <div class="inline-flex items-center gap-2">
                                            <!-- Tombol Lihat -->
                                            <button type="button" 
                                                    @click="openLihatModal({{ json_encode($item) }})"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 active:bg-gray-100 text-gray-700 text-xs font-semibold shadow-2xs transition active:scale-95 cursor-pointer">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>Lihat</span>
                                            </button>

                                            <!-- Tombol Tindak lanjut Sesuai Warna BHP (#0c2a55) -->
                                            <button type="button" 
                                                    @click="openTindakLanjutModal({{ json_encode($item) }})"
                                                    class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer">
                                                <span>Tindak lanjut</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-xs text-gray-400 font-medium">
                                    Tidak ada jadwal pembukaan wasiat yang menunggu tindak lanjut saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Tabel -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100 text-xs text-gray-500">
                <p>Menampilkan {{ count($jadwalList) }} layanan</p>
                <div class="inline-flex items-center gap-1">
                    <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white text-gray-400 hover:text-gray-600 flex items-center justify-center cursor-pointer">
                        ‹
                    </button>
                    <button class="w-7 h-7 rounded-lg bg-[#0c2a55] text-white font-bold flex items-center justify-center shadow-2xs">
                        1
                    </button>
                    <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white text-gray-400 hover:text-gray-600 flex items-center justify-center cursor-pointer">
                        ›
                    </button>
                </div>
            </div>

        </div>

        <!-- ================= TAB 1 CONTENT: HASIL VERIFIKASI PERTAMA ================= -->
        <div x-show="activeTab === 'verifikasi'" class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-lg font-bold text-gray-900">Hasil Verifikasi Fungsional Pertama</h2>
                        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full bg-blue-50 text-[#1d68d8]">
                            {{ count($verifikasiList) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5 font-medium">
                        Daftar berkas persyaratan yang telah diverifikasi oleh Petugas Pertama dan siap ditelaah lanjut
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[760px]">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                            <th scope="col" class="py-3 px-4">NOMOR LAYANAN</th>
                            <th scope="col" class="py-3 px-4">JENIS LAYANAN</th>
                            <th scope="col" class="py-3 px-4">DETAIL LAYANAN</th>
                            <th scope="col" class="py-3 px-4">VERIFIKATOR PERTAMA</th>
                            <th scope="col" class="py-3 px-4">STATUS BERKAS</th>
                            <th scope="col" class="py-3 px-4 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($verifikasiList as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm font-bold text-gray-900 block font-mono">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-xs text-gray-400 block mt-0.5 font-normal">
                                        {{ $item['nama_pemohon'] }}
                                    </span>
                                </td>
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
                                <td class="py-4 px-4 text-gray-700 font-medium whitespace-nowrap">
                                    {{ $item['detail_layanan'] }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600">
                                    <span class="font-bold text-gray-800">{{ $item['petugas_pertama'] ?? 'Iman, S.H.' }}</span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5">Kurator Pertama</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $item['status_label'] ?? 'Disetujui Pertama' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-right">
                                    <a href="{{ route('muda.verifikasi.show', $item['id']) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer">
                                        <span>Telaah Berkas</span>
                                        <svg class="w-3.5 h-3.5 text-white/80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-xs text-gray-400 font-medium">
                                    Belum ada berkas dari Fungsional Pertama yang perlu ditelaah saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= TAB 3 CONTENT: PENERBITAN DOKUMEN ================= -->
        <div x-show="activeTab === 'penerbitan'" class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-lg font-bold text-gray-900">Penerbitan Dokumen &amp; Berita Acara</h2>
                        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full bg-blue-50 text-[#1d68d8]">
                            {{ count($penerbitanList) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5 font-medium">
                        Layanan yang telah melalui proses pembukaan wasiat dan siap diterbitkan dokumen resminya
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[760px]">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                            <th scope="col" class="py-3 px-4">NOMOR LAYANAN</th>
                            <th scope="col" class="py-3 px-4">NAMA PEMOHON</th>
                            <th scope="col" class="py-3 px-4">DOKUMEN TERBIT</th>
                            <th scope="col" class="py-3 px-4">TANGGAL PEMBUKAAN</th>
                            <th scope="col" class="py-3 px-4">STATUS DOKUMEN</th>
                            <th scope="col" class="py-3 px-4 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($penerbitanList as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-xs sm:text-sm font-bold text-gray-900 block font-mono">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5 font-mono">
                                        {{ $item['nomor_akta'] ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap font-bold text-gray-900">
                                    {{ $item['nama_pemohon'] }}
                                    <span class="text-[11px] text-gray-400 block mt-0.5 font-normal">{{ $item['nomor_telepon'] ?? '' }}</span>
                                </td>
                                <td class="py-4 px-4 text-gray-700 font-medium whitespace-nowrap">
                                    <span class="font-bold text-[#0c2a55]">{{ $item['dokumen_terbit'] }}</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-600">
                                    {{ $item['tanggal_pembukaan'] }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if (($item['status_level'] ?? '') === 'success')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>{{ $item['status_dokumen'] }}</span>
                                        </span>
                                    @elseif (($item['status_level'] ?? '') === 'warning')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>{{ $item['status_dokumen'] }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            <span>{{ $item['status_dokumen'] }}</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-right">
                                    <button type="button" 
                                            @click="openPenerbitanModal({{ json_encode($item) }})"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer">
                                        <svg class="w-3.5 h-3.5 text-white/80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span>Proses Dokumen</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-xs text-gray-400 font-medium">
                                    Belum ada permohonan yang masuk ke tahap penerbitan dokumen saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= MODAL 1: LIHAT DETAIL JADWAL ================= -->
        <div x-show="modalLihatOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="modalLihatOpen = false" 
                 class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 space-y-6 shadow-2xl border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
                
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#1d68d8]">DETAIL PERMOHONAN</span>
                        <h3 class="text-base font-bold text-gray-900" x-text="selectedJadwal?.nomor_layanan"></h3>
                    </div>
                    <button type="button" @click="modalLihatOpen = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold p-1">✕</button>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold">Pemohon</p>
                            <p class="font-bold text-gray-900 mt-0.5" x-text="selectedJadwal?.nama_pemohon"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold">Kontak</p>
                            <p class="font-mono text-gray-800 mt-0.5" x-text="selectedJadwal?.nomor_telepon"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold">Batas SLA</p>
                            <p class="font-bold text-gray-800 mt-0.5" x-text="selectedJadwal?.batas_sla"></p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold">Status</p>
                            <p class="font-bold text-[#1d68d8] mt-0.5" x-text="selectedJadwal?.status_label"></p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100 space-y-2">
                        <div class="flex items-center gap-2 text-[#1d68d8] font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                            </svg>
                            <span>Jadwal yang Diajukan Pemohon</span>
                        </div>
                        <p class="text-sm font-extrabold text-gray-900" x-text="selectedJadwal?.jadwal_pemohon_tanggal + ' - Pukul ' + selectedJadwal?.jadwal_pemohon_waktu"></p>
                        <p class="text-gray-600"><span class="font-bold">Lokasi / Sesi:</span> <span x-text="selectedJadwal?.lokasi || 'Ruang Sidang Balai Harta Peninggalan Surabaya'"></span></p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-gray-400 text-[10px] uppercase font-bold">Catatan Layanan</p>
                        <p class="p-3 bg-gray-50 rounded-xl text-gray-700 leading-relaxed" x-text="selectedJadwal?.catatan || 'Tidak ada catatan tambahan.'"></p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" @click="modalLihatOpen = false" 
                            class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-xs font-semibold text-gray-700 cursor-pointer">
                        Tutup
                    </button>
                    <button type="button" 
                            @click="modalLihatOpen = false; openTindakLanjutModal(selectedJadwal)" 
                            class="px-5 py-2.5 rounded-xl bg-[#0c2a55] hover:bg-[#103873] text-white text-xs font-bold cursor-pointer">
                        Tindak Lanjut Jadwal
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= MODAL 2: TINDAK LANJUT JADWAL ================= -->
        <div x-show="modalTindakLanjutOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="modalTindakLanjutOpen = false" 
                 class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 space-y-6 shadow-2xl border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
                
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#1d68d8]">TINDAK LANJUT LAYANAN</span>
                        <h3 class="text-base font-bold text-gray-900" x-text="selectedJadwal?.nomor_layanan"></h3>
                    </div>
                    <button type="button" @click="modalTindakLanjutOpen = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold p-1">✕</button>
                </div>

                <form :action="'{{ url('/muda/jadwal') }}/' + selectedJadwal?.id + '/tindak-lanjut'" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-700">Pilih Keputusan Tindak Lanjut:</label>
                        <div class="grid grid-cols-1 gap-2.5">
                            
                            <!-- Opsi 1: Setujui Jadwal -->
                            <label class="flex items-start gap-3 p-3 rounded-2xl border cursor-pointer transition"
                                   :class="tindakLanjutStatus === 'disetujui' ? 'border-[#1d68d8] bg-blue-50/50' : 'border-gray-200 hover:bg-gray-50'">
                                <input type="radio" name="status" value="disetujui" x-model="tindakLanjutStatus" class="mt-0.5 text-[#1d68d8] focus:ring-[#1d68d8]">
                                <div>
                                    <p class="text-xs font-bold text-gray-900">Setujui Jadwal Pembukaan</p>
                                    <p class="text-[11px] text-gray-500">Jadwal yang diajukan pemohon dikonfirmasi dan disepakati.</p>
                                </div>
                            </label>

                            <!-- Opsi 2: Reschedule / Jadwal Ulang -->
                            <label class="flex items-start gap-3 p-3 rounded-2xl border cursor-pointer transition"
                                   :class="tindakLanjutStatus === 'reschedule' ? 'border-[#1d68d8] bg-blue-50/50' : 'border-gray-200 hover:bg-gray-50'">
                                <input type="radio" name="status" value="reschedule" x-model="tindakLanjutStatus" class="mt-0.5 text-[#1d68d8] focus:ring-[#1d68d8]">
                                <div>
                                    <p class="text-xs font-bold text-gray-900">Sesuaikan / Reschedule Jadwal</p>
                                    <p class="text-[11px] text-gray-500">Tentukan jadwal alternatif jika terdapat bentrokan agenda sidang.</p>
                                </div>
                            </label>

                            <!-- Opsi 3: Teruskan ke Penerbitan Dokumen -->
                            <label class="flex items-start gap-3 p-3 rounded-2xl border cursor-pointer transition"
                                   :class="tindakLanjutStatus === 'terbitkan' ? 'border-[#1d68d8] bg-blue-50/50' : 'border-gray-200 hover:bg-gray-50'">
                                <input type="radio" name="status" value="terbitkan" x-model="tindakLanjutStatus" class="mt-0.5 text-[#1d68d8] focus:ring-[#1d68d8]">
                                <div>
                                    <p class="text-xs font-bold text-gray-900">Teruskan ke Penerbitan Dokumen</p>
                                    <p class="text-[11px] text-gray-500">Sidang pembukaan telah terlaksana, lanjutkan pembuatan Berita Acara.</p>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- Input Jadwal Baru (Jika Reschedule) -->
                    <div x-show="tindakLanjutStatus === 'reschedule'" class="grid grid-cols-2 gap-3 p-3.5 rounded-2xl bg-amber-50/50 border border-amber-200">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700">Tanggal Baru</label>
                            <input type="text" name="jadwal_tanggal" placeholder="Contoh: Rabu, 28 Mei 2025" 
                                   class="w-full text-xs rounded-xl border-gray-300 focus:ring-[#1d68d8] p-2 mt-1">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700">Waktu (WIB)</label>
                            <input type="text" name="jadwal_waktu" placeholder="Contoh: 10.00 WIB" 
                                   class="w-full text-xs rounded-xl border-gray-300 focus:ring-[#1d68d8] p-2 mt-1">
                        </div>
                    </div>

                    <!-- Lokasi Pembukaan -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700">Lokasi / Ruang Pembukaan</label>
                        <input type="text" name="lokasi" 
                               :value="selectedJadwal?.lokasi || 'Ruang Sidang Balai Harta Peninggalan Surabaya'"
                               class="w-full text-xs rounded-xl border-gray-300 focus:ring-[#1d68d8] p-2.5 mt-1">
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700">Catatan Tindak Lanjut untuk Pemohon</label>
                        <textarea name="catatan" rows="3" 
                                  placeholder="Tuliskan catatan konfirmasi, kelengkapan berkas fisik yang harus dibawa, atau link virtual zoom..."
                                  class="w-full text-xs rounded-xl border-gray-300 focus:ring-[#1d68d8] p-3 mt-1"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                        <button type="button" @click="modalTindakLanjutOpen = false" 
                                class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-xs font-semibold text-gray-700 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-bold shadow-md cursor-pointer">
                            Simpan &amp; Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL 3: PROSES PENERBITAN DOKUMEN ================= -->
        <div x-show="modalPenerbitanOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="modalPenerbitanOpen = false" 
                 class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 space-y-6 shadow-2xl border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
                
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#1d68d8]">PROSES DOKUMEN</span>
                        <h3 class="text-base font-bold text-gray-900" x-text="selectedPenerbitan?.dokumen_terbit"></h3>
                    </div>
                    <button type="button" @click="modalPenerbitanOpen = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold p-1">✕</button>
                </div>

                <form :action="'{{ url('/muda/dokumen') }}/' + selectedPenerbitan?.id + '/terbitkan'" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 text-xs space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Nomor Layanan:</span>
                            <span class="font-bold text-gray-800" x-text="selectedPenerbitan?.nomor_layanan"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Pemohon:</span>
                            <span class="font-bold text-gray-800" x-text="selectedPenerbitan?.nama_pemohon"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Nomor Akta/BA:</span>
                            <span class="font-mono text-gray-700" x-text="selectedPenerbitan?.nomor_akta"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700">Ubah Status Penerbitan:</label>
                        <select name="status_dokumen" class="w-full text-xs rounded-xl border-gray-300 focus:ring-[#1d68d8] p-2.5 mt-1">
                            <option value="Draft Siap Diterbitkan">Draft Siap Diterbitkan</option>
                            <option value="Menunggu Tanda Tangan Kasi">Menunggu Tanda Tangan Kasi</option>
                            <option value="Selesai &amp; Terdistribusi">Selesai &amp; Terdistribusi ke Pemohon</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700">Catatan Penerbitan</label>
                        <textarea name="catatan" rows="3" 
                                  placeholder="Catatan penerbitan dokumen atau paraf berita acara..."
                                  class="w-full text-xs rounded-xl border-gray-300 focus:ring-[#1d68d8] p-3 mt-1"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                        <button type="button" @click="modalPenerbitanOpen = false" 
                                class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-xs font-semibold text-gray-700 cursor-pointer">
                            Tutup
                        </button>
                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-[#0c2a55] hover:bg-[#103873] active:bg-[#00479e] text-white text-xs font-bold shadow-md cursor-pointer">
                            Simpan Status Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-portal-layout>
