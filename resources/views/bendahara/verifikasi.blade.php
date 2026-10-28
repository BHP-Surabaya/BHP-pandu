<x-portal-layout>
    <x-slot:title>
        Verifikasi PNBP &amp; Pemantauan SLA - Bendahara Penerimaan BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-7" x-data="{
        searchQuery: '{{ addslashes($search ?? '') }}',
        activeFilter: '{{ $statusFilter ?? 'all' }}',
        tindakLanjutModalOpen: false,
        slaInfoModalOpen: false,
        selectedItem: null,
        copiedItemNomor: null,

        form: {
            ntpn: '',
            nominal: '',
            tanggal_bayar: '{{ now()->format('Y-m-d') }}',
            catatan: '',
            fileName: '',
            fileSize: ''
        },
        isDragging: false,

        openTindakLanjutModal(item) {
            this.selectedItem = item;
            this.form.ntpn = item.ntpn || '';
            this.form.nominal = item.nominal_tagihan || 200000;
            this.form.tanggal_bayar = '{{ now()->format('Y-m-d') }}';
            this.form.catatan = '';
            this.form.fileName = '';
            this.form.fileSize = '';
            this.isDragging = false;
            this.tindakLanjutModalOpen = true;
        },

        openSlaInfoModal(item) {
            this.selectedItem = item;
            this.slaInfoModalOpen = true;
        },

        formatRupiah(val) {
            if (!val) return 'Rp 0';
            return 'Rp ' + Number(val).toLocaleString('id-ID');
        },

        copyToClipboard(text, id) {
            navigator.clipboard.writeText(text);
            this.copiedItemNomor = id;
            setTimeout(() => {
                this.copiedItemNomor = null;
            }, 2000);
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.fileName = file.name;
                this.form.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            } else {
                this.form.fileName = '';
                this.form.fileSize = '';
            }
        },

        handleDrop(event) {
            this.isDragging = false;
            if (event.dataTransfer.files && event.dataTransfer.files.length > 0) {
                this.$refs.fileInput.files = event.dataTransfer.files;
                const file = event.dataTransfer.files[0];
                this.form.fileName = file.name;
                this.form.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            }
        },

        removeFile() {
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
            this.form.fileName = '';
            this.form.fileSize = '';
        }
    }">

        <!-- Header Page -->
        <div class="pb-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        <span>Portal Bendahara Penerimaan BHP</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                        Verifikasi PNBP &amp; SLA Layanan
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Pemantauan status pembayaran tagihan PNBP, validasi nomor transaksi (NTPN), upload bukti voucher, dan mitigasi batas SLA 14 hari.
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('bendahara.history.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold shadow-xs transition hover:border-gray-300">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Riwayat PNBP ({{ $stats['total_terverifikasi'] ?? 0 }})</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Notification -->
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 shadow-xs flex items-start gap-3 text-emerald-800">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50/90 p-4 shadow-xs flex items-start gap-3 text-rose-800">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <div class="text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- ======================================================== -->
        <!-- KARTU RINGKASAN STATISTIK PNBP (MODEL SEJAJAR RAPI) -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
            <!-- Card 1: Sudah Bayar (Perlu Tindak Lanjut) -->
            <a href="{{ route('bendahara.verifikasi.index', ['status' => 'sudah_bayar', 'q' => request('q')]) }}"
               class="bg-white rounded-2xl border p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer flex items-center gap-3.5 sm:gap-4 {{ ($statusFilter ?? '') === 'sudah_bayar' ? 'border-emerald-400 ring-2 ring-emerald-400/20' : 'border-gray-100 hover:border-emerald-200' }}">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['sudah_bayar'] ?? 0 }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Sudah Bayar
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-emerald-600 leading-snug truncate">
                            Perlu Tindak Lanjut
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 2: Belum Bayar (Aktif SLA 14 Hari) -->
            <a href="{{ route('bendahara.verifikasi.index', ['status' => 'belum_bayar', 'q' => request('q')]) }}"
               class="bg-white rounded-2xl border p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer flex items-center gap-3.5 sm:gap-4 {{ ($statusFilter ?? '') === 'belum_bayar' ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-gray-100 hover:border-amber-200' }}">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 border border-amber-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['belum_bayar'] ?? 0 }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Belum Bayar
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-amber-600 leading-snug truncate">
                            Batas SLA 14 Hari
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 3: Lewat SLA (> 14 Hari / Kadaluarsa) -->
            <a href="{{ route('bendahara.verifikasi.index', ['status' => 'kadaluarsa', 'q' => request('q')]) }}"
               class="bg-white rounded-2xl border p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer flex items-center gap-3.5 sm:gap-4 {{ ($statusFilter ?? '') === 'kadaluarsa' ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-gray-100 hover:border-rose-200' }}">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 border border-rose-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-rose-600 leading-none shrink-0 tracking-tight">
                        {{ $stats['kadaluarsa'] ?? 0 }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            SLA Terlampaui
                        </span>
                        <span class="text-[11px] sm:text-xs font-bold text-rose-600 leading-snug truncate">
                            Harus Daftar Ulang
                        </span>
                    </div>
                </div>
            </a>

            <!-- Card 4: Total Permohonan Masuk -->
            <a href="{{ route('bendahara.verifikasi.index', ['status' => 'all', 'q' => request('q')]) }}"
               class="bg-white rounded-2xl border p-4 sm:p-4.5 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer flex items-center gap-3.5 sm:gap-4 {{ ($statusFilter ?? 'all') === 'all' ? 'border-blue-400 ring-2 ring-blue-400/20' : 'border-gray-100 hover:border-blue-200' }}">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100/80 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                    <span class="text-3xl sm:text-4xl font-black text-gray-900 leading-none shrink-0 tracking-tight">
                        {{ $stats['total_verifikasi'] ?? 0 }}
                    </span>
                    <div class="min-w-0 flex flex-col justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 leading-snug truncate">
                            Total Antrean
                        </span>
                        <span class="text-[11px] sm:text-xs font-semibold text-blue-600 leading-snug truncate">
                            Semua Layanan
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <!-- ======================================================== -->
        <!-- PENCARIAN ANTREAN PNBP (SEARCH BAR TERINTEGRASI RAPI) -->
        <!-- ======================================================== -->
        <div class="bg-white rounded-2xl border border-gray-100 p-3 sm:p-3.5 shadow-xs">
            <form action="{{ route('bendahara.verifikasi.index') }}" method="GET" class="relative w-full">
                <input type="hidden" name="status" value="{{ $statusFilter ?? 'all' }}">
                <div class="relative flex items-center">
                    <!-- Icon Search (Vertically Centered di Sisi Kiri) -->
                    <div class="absolute inset-y-0 left-0 pl-3.5 sm:pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>

                    <!-- Input Box (Tinggi Nyaman, Font Jelas, & Background Lembut) -->
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Cari nomor layanan, nama pemohon, atau nama pewasiat..." 
                           class="w-full pl-10 sm:pl-12 pr-24 sm:pr-28 py-2.5 sm:py-3 bg-gray-50/70 hover:bg-gray-50 focus:bg-white text-xs sm:text-sm text-gray-900 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition placeholder:text-gray-400 shadow-2xs" />

                    <!-- Tombol Aksi di Dalam Kanan Input (Rapi & Tidak Terpotong) -->
                    <div class="absolute inset-y-0 right-0 pr-1.5 sm:pr-2 flex items-center gap-1.5">
                        @if(request('q'))
                            <a href="{{ route('bendahara.verifikasi.index', ['status' => $statusFilter ?? 'all']) }}" 
                               class="p-1 sm:p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-200/60 transition"
                               title="Hapus pencarian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-1.5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-lg shadow-xs transition hover:shadow cursor-pointer">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <span>Cari</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabel Verifikasi PNBP -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-base font-bold text-gray-900">
                        Daftar Antrean Verifikasi PNBP
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Menampilkan permohonan yang memerlukan validasi setoran PNBP dan pemantauan masa tenggang 14 hari.
                    </p>
                </div>
                <div class="text-xs font-semibold text-gray-500 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200/80 whitespace-nowrap shrink-0">
                    Total: <span class="text-gray-900 font-bold">{{ count($pnbpList) }} Layanan</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th scope="col" class="py-3.5 px-4 sm:px-6">Nomor Layanan</th>
                            <th scope="col" class="py-3.5 px-4">Jenis Layanan</th>
                            <th scope="col" class="py-3.5 px-4">Nama Pemohon</th>
                            <th scope="col" class="py-3.5 px-4">Nama Pewasiat</th>
                            <th scope="col" class="py-3.5 px-4">Tanggal Masuk</th>
                            <th scope="col" class="py-3.5 px-4">Status PNBP</th>
                            <th scope="col" class="py-3.5 px-4">Keterangan</th>
                            <th scope="col" class="py-3.5 px-4 sm:px-6 text-center">Tindak Lanjut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($pnbpList as $item)
                            <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                <!-- 1. Nomor Layanan -->
                                <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-gray-900 text-xs select-all">
                                            {{ $item['nomor_layanan'] }}
                                        </span>
                                        <button type="button" 
                                                @click="copyToClipboard('{{ $item['nomor_layanan'] }}', '{{ $item['id'] }}')" 
                                                class="text-gray-400 hover:text-blue-600 p-1 rounded transition" 
                                                title="Salin nomor layanan">
                                            <template x-if="copiedItemNomor === '{{ $item['id'] }}'">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </template>
                                            <template x-if="copiedItemNomor !== '{{ $item['id'] }}'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                                </svg>
                                            </template>
                                        </button>
                                    </div>
                                    <span class="text-[11px] text-gray-500 block mt-0.5">
                                        Tarif: Rp {{ number_format($item['nominal_tagihan'] ?? 200000, 0, ',', '.') }}
                                    </span>
                                </td>

                                <!-- 2. Jenis Layanan -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold 
                                        {{ str_contains(strtolower($item['jenis_layanan']), 'skhw') ? 'bg-sky-50 text-sky-800 border border-sky-100' : 'bg-purple-50 text-purple-800 border border-purple-100' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ str_contains(strtolower($item['jenis_layanan']), 'skhw') ? 'bg-sky-500' : 'bg-purple-500' }}"></span>
                                        <span>{{ $item['jenis_layanan'] }}</span>
                                    </div>
                                </td>

                                <!-- 3. Nama Pemohon -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-800 font-bold text-[11px] flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($item['nama_pemohon'] ?? 'P', 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-gray-900 leading-snug">
                                            {{ $item['nama_pemohon'] }}
                                        </span>
                                    </div>
                                </td>

                                <!-- 4. Nama Pewasiat -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-800">
                                        {{ $item['nama_pewasiat'] ?: '-' }}
                                    </span>
                                </td>

                                <!-- 5. Tanggal Masuk Layanan -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-gray-900 font-medium">
                                        {{ $item['tanggal_masuk'] }}
                                    </span>
                                </td>

                                <!-- 6. Status PNBP -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if (($item['status_pnbp'] ?? '') === 'sudah_bayar')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            Sudah Bayar
                                        </span>
                                    @elseif ($item['is_expired'] ?? false)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200/80 shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                            Lewat SLA
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200/80 shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Belum Bayar
                                        </span>
                                    @endif
                                </td>

                                <!-- 7. Keterangan -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if (($item['status_pnbp'] ?? '') === 'sudah_bayar')
                                        <span class="text-xs font-semibold text-emerald-700">
                                            Siap Input NTPN &amp; Voucher
                                        </span>
                                    @elseif ($item['is_expired'] ?? false)
                                        <span class="text-xs font-semibold text-rose-600">
                                            Harus Daftar Lagi
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">-</span>
                                    @endif
                                </td>

                                <!-- 8. Tindak Lanjut -->
                                <td class="py-4 px-4 sm:px-6 text-center whitespace-nowrap">
                                    @if (($item['status_pnbp'] ?? '') === 'sudah_bayar')
                                        <!-- Tombol Tindak Lanjut: Membuka Form Input NTPN & Upload Voucher -->
                                        <button type="button" 
                                                @click="openTindakLanjutModal({{ json_encode($item) }})"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-xs transition hover:shadow">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            <span>Tindak Lanjut</span>
                                        </button>
                                    @else
                                        <!-- Jika Belum Bayar: Tombol Info SLA / Batas Bayar -->
                                        <button type="button" 
                                                @click="openSlaInfoModal({{ json_encode($item) }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border {{ ($item['is_expired'] ?? false) ? 'border-rose-200 text-rose-700 bg-rose-50/70 hover:bg-rose-100' : 'border-gray-200 text-gray-600 bg-gray-50/70 hover:bg-gray-100' }} text-xs font-semibold transition">
                                            <svg class="w-3.5 h-3.5 {{ ($item['is_expired'] ?? false) ? 'text-rose-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            <span>{{ ($item['is_expired'] ?? false) ? 'Info Kadaluarsa' : 'Info SLA' }}</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center text-gray-500">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                                            </svg>
                                        </div>
                                        <p class="font-bold text-gray-900 text-sm">Tidak Ada Data Permohonan PNBP</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Tidak ditemukan antrean permohonan sesuai filter atau kata kunci pencarian yang dipilih.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL 1: FORM TINDAK LANJUT PNBP (SUDAH BAYAR) -->
        <!-- ======================================================== -->
        <div x-show="tindakLanjutModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            
            <div @click.away="tindakLanjutModalOpen = false" 
                 class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 transform transition-all overflow-hidden max-h-[92vh] flex flex-col">
                
                <!-- Modal Header -->
                <div class="px-6 pt-6 pb-4 sm:px-7 sm:pt-7 sm:pb-5 flex items-start justify-between border-b border-slate-100 bg-white">
                    <div class="flex items-start gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 border border-blue-100/80 text-[#1d68d8] flex items-center justify-center shrink-0 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-[#1d68d8] tracking-widest uppercase block">
                                VERIFIKASI PNBP · BENDAHARA
                            </span>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight mt-0.5">
                                Tindak Lanjut Pembayaran
                            </h3>
                            <p class="text-xs text-slate-500 font-normal mt-0.5">
                                Validasi nomor transaksi negara (NTPN) &amp; bukti setor kas negara.
                            </p>
                        </div>
                    </div>
                    <button @click="tindakLanjutModalOpen = false" 
                            type="button" 
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Tindak Lanjut -->
                <form :action="'{{ url('/bendahara/verifikasi-pnbp') }}/' + (selectedItem ? selectedItem.id : '') + '/tindak-lanjut'" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="flex flex-col flex-1 overflow-hidden">
                    @csrf

                    <!-- Modal Body Scrollable -->
                    <div class="p-6 sm:p-7 space-y-5 overflow-y-auto custom-scrollbar flex-1">
                        
                        <!-- Card Info: Layanan yang Diverifikasi -->
                        <div class="bg-gradient-to-br from-slate-50 to-blue-50/40 border border-slate-200/80 rounded-2xl p-4 sm:p-4.5 space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase block">
                                        NOMOR LAYANAN PNBP
                                    </span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="font-mono text-sm sm:text-base font-bold text-[#1d68d8] break-all select-all tracking-wide" 
                                              x-text="selectedItem ? selectedItem.nomor_layanan : ''">
                                        </span>
                                    </div>
                                </div>
                                <div class="shrink-0 flex flex-col items-end gap-1">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100/80 text-emerald-800 border border-emerald-200/80 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <span>Sudah Bayar</span>
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-white text-slate-600 border border-slate-200 shadow-2xs" 
                                          x-text="selectedItem ? selectedItem.jenis_layanan : ''">
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-slate-200/70 pt-2.5 grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                                <div>
                                    <span class="text-[10px] text-slate-400 block font-medium">Pemohon</span>
                                    <span class="font-bold text-slate-800 truncate block mt-0.5" x-text="selectedItem ? selectedItem.nama_pemohon : ''"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-400 block font-medium">Pewasiat</span>
                                    <span class="font-semibold text-slate-700 truncate block mt-0.5" x-text="selectedItem ? (selectedItem.nama_pewasiat || '-') : ''"></span>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <span class="text-[10px] text-slate-400 block font-medium">Tarif PNBP</span>
                                    <span class="font-bold text-slate-900 block mt-0.5" x-text="'Rp ' + Number(selectedItem ? selectedItem.nominal_tagihan || 200000 : 200000).toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Input 1: NTPN -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="ntpn" class="block text-xs font-bold text-slate-700">
                                    Nomor Transaksi Penerimaan Negara (NTPN) <span class="text-rose-500 font-bold">*</span>
                                </label>
                                <span class="text-[11px] font-mono font-semibold" 
                                      :class="form.ntpn && form.ntpn.length === 16 ? 'text-emerald-600 font-bold' : 'text-slate-400'"
                                      x-text="(form.ntpn ? form.ntpn.length : 0) + ' / 16 digit'">
                                </span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h13.5m-13.5 7.5h13.5M9.75 3v18m4.5-18v18" />
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="ntpn" 
                                       name="ntpn" 
                                       x-model="form.ntpn" 
                                       required
                                       maxlength="30"
                                       placeholder="Misal: 261021B123456789"
                                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-[#1d68d8] focus:ring-4 focus:ring-[#1d68d8]/10 font-mono font-bold text-sm uppercase tracking-wider text-slate-900 placeholder:normal-case placeholder:font-sans placeholder:tracking-normal placeholder:font-normal placeholder:text-slate-400 transition" />
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1 font-normal">
                                Kode 16 digit alfanumerik resmi bukti setoran Simponi / Bank Persepsi / Pos Indonesia.
                            </p>
                        </div>

                        <!-- Input 2: Nominal & Tanggal Bayar -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <!-- Nominal -->
                            <div>
                                <label for="nominal" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nominal Pembayaran <span class="text-rose-500 font-bold">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-xs font-bold text-slate-400">
                                        Rp
                                    </div>
                                    <input type="number" 
                                           id="nominal" 
                                           name="nominal" 
                                           x-model="form.nominal" 
                                           required
                                           min="0"
                                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border border-slate-200 focus:border-[#1d68d8] focus:ring-4 focus:ring-[#1d68d8]/10 text-sm font-bold text-slate-900 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none transition" />
                                </div>
                                <p class="text-[11px] font-bold text-[#1d68d8] mt-1" x-text="formatRupiah(form.nominal)"></p>
                            </div>

                            <!-- Tanggal Bayar -->
                            <div>
                                <label for="tanggal_bayar" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Tanggal Bayar <span class="text-rose-500 font-bold">*</span>
                                </label>
                                <input type="date" 
                                       id="tanggal_bayar" 
                                       name="tanggal_bayar" 
                                       x-model="form.tanggal_bayar" 
                                       required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-[#1d68d8] focus:ring-4 focus:ring-[#1d68d8]/10 text-xs sm:text-sm font-semibold text-slate-800 transition" />
                                <p class="text-[11px] text-slate-400 mt-1">Tanggal transaksi sesuai bukti setor.</p>
                            </div>
                        </div>

                        <!-- Input 3: Unggah Bukti Voucher -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Unggah Berkas Bukti Voucher / NTPN <span class="text-slate-400 font-normal">(PDF, JPG, PNG maks. 5MB)</span>
                            </label>

                            <!-- Hidden Real File Input -->
                            <input type="file" 
                                   x-ref="fileInput" 
                                   id="file_voucher" 
                                   name="file_voucher" 
                                   @change="handleFileChange($event)"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="hidden" />

                            <!-- Dropzone View: When NO file selected -->
                            <template x-if="!form.fileName">
                                <div @click="$refs.fileInput.click()"
                                     @dragover.prevent="isDragging = true"
                                     @dragleave.prevent="isDragging = false"
                                     @drop.prevent="handleDrop($event)"
                                     :class="isDragging ? 'border-[#1d68d8] bg-blue-50/60' : 'border-slate-200 hover:border-[#1d68d8] bg-slate-50/40 hover:bg-blue-50/30'"
                                     class="relative rounded-2xl border-2 border-dashed p-5 transition-all cursor-pointer group text-center">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1d68d8] border border-blue-100 flex items-center justify-center mx-auto mb-2 group-hover:scale-105 transition-transform shadow-2xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-bold text-slate-800">
                                        <span class="text-[#1d68d8] group-hover:underline">Pilih berkas voucher</span> atau seret dokumen ke sini
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        Format didukung: PDF, JPG, atau PNG (Maksimal 5 MB)
                                    </p>
                                </div>
                            </template>

                            <!-- Dropzone View: When file IS selected -->
                            <template x-if="form.fileName">
                                <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-3.5 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-900 truncate" x-text="form.fileName"></p>
                                            <div class="flex items-center gap-2 mt-0.5 text-[11px]">
                                                <span class="text-emerald-700 font-semibold">Siap diverifikasi</span>
                                                <span class="text-slate-300">·</span>
                                                <span class="text-slate-500 font-mono" x-text="form.fileSize"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <button type="button" 
                                                @click="$refs.fileInput.click()" 
                                                class="text-xs font-bold text-[#1d68d8] hover:underline cursor-pointer">
                                            Ganti
                                        </button>
                                        <button type="button" 
                                                @click="removeFile()" 
                                                class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition cursor-pointer"
                                                title="Hapus berkas">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Input 4: Catatan Verifikasi -->
                        <div>
                            <label for="catatan" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Catatan Verifikasi <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <textarea id="catatan" 
                                      name="catatan" 
                                      rows="2" 
                                      x-model="form.catatan" 
                                      class="w-full text-xs rounded-xl border border-slate-200 focus:border-[#1d68d8] focus:ring-4 focus:ring-[#1d68d8]/10 p-3 transition text-slate-800 placeholder-slate-400 resize-none" 
                                      placeholder="Contoh: Pembayaran telah divalidasi lunas via sistem Simponi Kementerian Keuangan..."></textarea>
                        </div>
                    </div>

                    <!-- Modal Actions (Footer) -->
                    <div class="px-6 sm:px-7 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div class="hidden sm:flex items-center gap-1.5 text-[11px] text-slate-500">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <span>Tervalidasi Kas Negara RI</span>
                        </div>
                        <div class="flex items-center gap-2.5 ml-auto">
                            <button @click="tindakLanjutModalOpen = false" 
                                    type="button" 
                                    class="px-4.5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl bg-[#1d68d8] hover:bg-blue-700 text-white text-xs font-bold shadow-sm hover:shadow transition active:scale-95 cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span>Simpan &amp; Verifikasi PNBP</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- MODAL 2: DETAIL INFORMASI SLA 14 HARI (BELUM BAYAR) -->
        <!-- ======================================================== -->
        <div x-show="slaInfoModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            
            <div @click.away="slaInfoModalOpen = false" 
                 class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 transform transition-all overflow-hidden flex flex-col">
                
                <!-- Modal Header -->
                <div class="px-6 pt-6 pb-4 sm:px-7 sm:pt-7 sm:pb-5 flex items-start justify-between border-b border-slate-100 bg-white">
                    <div class="flex items-start gap-3.5">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-2xs border"
                             :class="selectedItem?.is_expired ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-amber-50 text-amber-600 border-amber-100'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold tracking-widest uppercase block"
                                  :class="selectedItem?.is_expired ? 'text-rose-600' : 'text-amber-600'">
                                PEMUTAKHIRAN SLA · 14 HARI
                            </span>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight mt-0.5" 
                                x-text="selectedItem?.is_expired ? 'Masa Pembayaran Kadaluarsa' : 'Pemantauan Batas Waktu PNBP'">
                            </h3>
                            <p class="text-xs text-slate-500 font-normal mt-0.5">
                                Batas pelunasan billing Simponi PNBP 14 hari kalender.
                            </p>
                        </div>
                    </div>
                    <button @click="slaInfoModalOpen = false" 
                            type="button" 
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 sm:p-7 space-y-5 overflow-y-auto custom-scrollbar">
                    
                    <!-- Progress SLA Bar Visual -->
                    <div class="p-4 rounded-2xl border"
                         :class="selectedItem?.is_expired ? 'bg-rose-50/60 border-rose-200/80' : 'bg-amber-50/60 border-amber-200/80'">
                        <div class="flex items-center justify-between text-xs font-bold mb-2">
                            <span class="text-slate-700">Masa Tenggang Simponi:</span>
                            <span :class="selectedItem?.is_expired ? 'text-rose-700' : 'text-amber-800'"
                                  x-text="selectedItem?.is_expired ? '14/14 Hari (Kadaluarsa)' : ((selectedItem?.sla_hari_berjalan || 1) + ' dari 14 Hari')">
                            </span>
                        </div>
                        <!-- Progress Bar Track -->
                        <div class="w-full bg-white/80 rounded-full h-2.5 overflow-hidden border border-slate-200/60 p-0.5">
                            <div class="h-full rounded-full transition-all duration-500"
                                 :class="selectedItem?.is_expired ? 'bg-rose-600' : ((selectedItem?.sla_hari_sisa || 14) <= 3 ? 'bg-rose-500' : 'bg-amber-500')"
                                 :style="'width: ' + Math.min(100, Math.round(((selectedItem?.sla_hari_berjalan || 1) / 14) * 100)) + '%'">
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] font-medium text-slate-500 mt-2">
                            <span>Hari ke-1</span>
                            <span class="font-bold" :class="selectedItem?.is_expired ? 'text-rose-700' : 'text-amber-700'"
                                  x-text="selectedItem?.is_expired ? 'Lewat Batas Waktu' : ('Sisa ' + (selectedItem?.sla_hari_sisa || 0) + ' Hari')">
                            </span>
                            <span>Hari ke-14 (Maksimal)</span>
                        </div>
                    </div>

                    <!-- SLA Details Table Card -->
                    <div class="rounded-2xl p-4 bg-slate-50 border border-slate-200/80 text-xs space-y-2.5">
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Nomor Layanan:</span>
                            <span class="font-mono font-bold text-right break-all text-slate-900" x-text="selectedItem?.nomor_layanan"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Nama Pemohon:</span>
                            <span class="font-bold text-right text-slate-900" x-text="selectedItem?.nama_pemohon"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Tanggal Masuk:</span>
                            <span class="font-semibold text-right text-slate-900" x-text="selectedItem?.tanggal_masuk"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-200/70 gap-3">
                            <span class="text-slate-500 font-medium">Waktu Berjalan:</span>
                            <span class="font-bold text-right text-slate-900" x-text="'Hari ke-' + (selectedItem?.sla_hari_berjalan || 1)"></span>
                        </div>
                        <div class="flex justify-between items-center py-1 font-bold pt-1">
                            <span class="text-slate-700">Status Waktu:</span>
                            <span class="text-sm font-black"
                                  :class="selectedItem?.is_expired ? 'text-rose-700' : 'text-amber-800'" 
                                  x-text="selectedItem?.is_expired ? '0 Hari (Sudah Lewat Batas)' : (selectedItem?.sla_hari_sisa + ' Hari Tersisa')">
                            </span>
                        </div>
                    </div>

                    <!-- Ketentuan Regulasi & Konsekuensi -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-700 space-y-2">
                        <p class="font-bold text-slate-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#1d68d8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <span>Ketentuan SLA Pembayaran:</span>
                        </p>
                        <p class="leading-relaxed text-slate-600">
                            Berdasarkan ketentuan Simponi Kemenkeu, kode billing PNBP berlaku selama <strong>14 hari kalender</strong> sejak diterbitkan.
                        </p>
                        <template x-if="selectedItem?.is_expired">
                            <div class="p-3 rounded-xl bg-rose-100/80 border border-rose-300 text-rose-900 font-semibold text-xs leading-relaxed">
                                ⚠️ <strong>Status Batal Otomatis:</strong> Batas 14 hari telah terlampaui. Kode billing kadaluarsa dan pemohon <strong>harus melakukan registrasi ulang</strong>.
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 sm:px-7 py-4 bg-slate-50/80 border-t border-slate-100 flex justify-end">
                    <button type="button" 
                            @click="slaInfoModalOpen = false" 
                            class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition cursor-pointer">
                        Mengerti &amp; Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
