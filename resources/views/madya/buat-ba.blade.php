<x-portal-layout>
    <x-slot:title>
        Buat & Reviu Berita Acara — Kurator Keperdataan Madya BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="buatBaApp()">
        
        <!-- Breadcrumbs & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('madya.dashboard') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        <span>Daftar Layanan</span>
                    </a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Buat & Reviu Berita Acara</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    Berita Acara Pembukaan Wasiat Tertutup
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    No. Layanan: <span class="font-mono font-bold text-blue-700">{{ $permohonan->nomor_permohonan ?: ('WST-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT)) }}</span> &bull; 
                    Pemohon: <span class="font-semibold text-slate-800">{{ $permohonan->user?->name ?? 'Pemohon' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('madya.layanan.upload.page', $permohonan->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 shadow-2xs transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    <span>Berkas Sidang (Upload)</span>
                </a>

                @if(!empty($permohonan->nomor_berita_acara) || !empty($permohonan->data_berita_acara))
                    <a href="{{ route('madya.layanan.cetak.page', $permohonan->id) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.672-2.13-1.27-3.086m0 0A10.02 10.02 0 0112 4.5c4.76 0 8.746 3.324 9.77 7.784M12 4.5v15m0 0l-3-3m3 3l3-3" />
                        </svg>
                        <span>Cetak 2 Salinan</span>
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Grid 2 Kolom: Form Input (Kiri) & Live Preview Dokumen (Kanan) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- ================= KOLOM KIRI: FORMULIR BERITA ACARA & OTP ================= -->
            <div class="lg:col-span-5 space-y-6">
                
                <form id="formBuatBa" action="{{ route('madya.layanan.buat-ba', $permohonan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Hidden field submit action -->
                    <input type="hidden" name="submit_action" id="submitAction" value="save">
                    <input type="hidden" name="approval_code" :value="otp.code">

                    <!-- Kartu 1: Parameter Dokumen & Penomoran -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                                <span>Nomor & Identitas Warkah</span>
                            </h2>
                            <span class="text-[11px] font-medium text-slate-400">Standar BHP</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Nomor Berita Acara (BA) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nomor_ba" x-model="form.nomor_ba" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15 focus:border-blue-600" />
                            <span class="text-[11px] text-slate-400 mt-1 block">Format baku: W15.BHP.02-xxxxx/BA-WT/Bulan/Tahun.</span>
                        </div>

                        <!-- Toggle Surat Kuasa -->
                        <div class="p-3.5 rounded-xl border border-blue-100 bg-blue-50/50 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="pr-2">
                                    <span class="text-xs font-bold text-slate-900 block">Surat Kuasa Khusus Pelaksanaan</span>
                                    <span class="text-[11px] text-slate-500 block leading-tight">
                                        Dicentang jika Kepala Balai memberikan kuasa kepada Kurator Madya.
                                    </span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input type="checkbox" name="ada_surat_kuasa" value="1" 
                                           :checked="form.ada_surat_kuasa"
                                           @change="toggleSuratKuasa($event.target.checked)"
                                           class="sr-only peer">
                                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <div x-show="form.ada_surat_kuasa" x-transition class="pt-2 border-t border-blue-100/70">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Tanggal Surat Kuasa</label>
                                <input type="date" name="tanggal_surat_kuasa" x-model="form.tanggal_surat_kuasa"
                                       class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                        </div>

                        <!-- Hari, Tanggal, dan Tempat Pelaksanaan -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Hari Pelaksanaan</label>
                                <input type="text" name="hari" x-model="form.hari" required
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Sidang</label>
                                <input type="date" name="tanggal" x-model="form.tanggal" @change="updateHariDariTanggal()" required
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tempat Dibuat</label>
                            <input type="text" name="tempat_dibuat" x-model="form.tempat_dibuat" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15" />
                        </div>
                    </div>

                    <!-- Kartu 2: Para Pihak (Pihak Pertama & Kedua) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                                <span>Identitas Para Pihak</span>
                            </h2>
                            <span class="text-[11px] font-medium text-slate-400" x-text="form.ada_surat_kuasa ? 'Kuasa Madya' : 'Kepala Balai'"></span>
                        </div>

                        <!-- PIHAK PERTAMA -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 space-y-2.5">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-700 block">PIHAK PERTAMA (Pejabat BHP)</span>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Pejabat</label>
                                <input type="text" name="pihak_pertama_nama" x-model="form.pihak_pertama_nama" required
                                       class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-900 focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">NIP Pejabat</label>
                                    <input type="text" name="pihak_pertama_nip" x-model="form.pihak_pertama_nip" required
                                           class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-mono text-slate-900 focus:ring-2 focus:ring-blue-600/15" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Jabatan Pejabat</label>
                                    <input type="text" name="pihak_pertama_jabatan" x-model="form.pihak_pertama_jabatan" required
                                           class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 focus:ring-2 focus:ring-blue-600/15" />
                                </div>
                            </div>
                        </div>

                        <!-- PIHAK KEDUA -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 space-y-2.5">
                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-700 block">PIHAK KEDUA (Notaris / Pemohon)</span>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Notaris / Pemohon</label>
                                <input type="text" name="pihak_kedua_nama" x-model="form.pihak_kedua_nama" required
                                       class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-900 focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Jabatan</label>
                                <input type="text" name="pihak_kedua_jabatan" x-model="form.pihak_kedua_jabatan" required
                                       class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Alamat Kantor / Domisili</label>
                                <textarea name="pihak_kedua_alamat" x-model="form.pihak_kedua_alamat" rows="2" required
                                          class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-900 focus:ring-2 focus:ring-blue-600/15"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu 3: Substansi Wasiat & Saksi-Saksi -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">3</span>
                                <span>Substansi Wasiat & Saksi</span>
                            </h2>
                            <span class="text-[11px] font-medium text-slate-400">Pasal 942 KUHPerdata</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pewasiat</label>
                            <input type="text" name="nama_pewasiat" x-model="form.nama_pewasiat" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Fisik Sampul Wasiat</label>
                            <textarea name="deskripsi_wasiat" x-model="form.deskripsi_wasiat" rows="2" required
                                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15"></textarea>
                            <span class="text-[11px] text-slate-400 mt-1 block">Contoh: 1 (satu) buah amplop coklat ukuran A4 dalam keadaan tertutup dan tersegel lak merah.</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Saksi I (Pegawai BHP)</label>
                                <input type="text" name="saksi_1" x-model="form.saksi_1" required
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Saksi II (Pegawai BHP)</label>
                                <input type="text" name="saksi_2" x-model="form.saksi_2" required
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan Pelaksanaan (Opsional)</label>
                            <textarea name="catatan" rows="2" placeholder="Catatan jalannya sidang pembukaan wasiat..."
                                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-600/15"></textarea>
                        </div>
                    </div>

                    <!-- ================= KARTU 4: OTORISASI KODE PERSETUJUAN (OTP EMAIL) ================= -->
                    <div class="bg-gradient-to-br from-slate-900 to-[#0c2a55] text-white rounded-2xl p-5 sm:p-6 shadow-md space-y-4">
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-500 text-white flex items-center justify-center font-bold text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Otorisasi Kurator Madya</h3>
                                    <p class="text-[11px] text-blue-200">Verifikasi 2-Faktor sebelum penerbitan & cetak BA</p>
                                </div>
                            </div>
                            <template x-if="otp.verified">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500 text-white shadow-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Terverifikasi
                                </span>
                            </template>
                            <template x-if="!otp.verified">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-white/15 text-white/80">
                                    Menunggu OTP
                                </span>
                            </template>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs text-slate-300">
                                <span>Kirim ke email: <strong class="text-white font-mono">{{ $maskedEmail }}</strong></span>
                                <button type="button" 
                                        @click="requestOtp()"
                                        :disabled="otp.requesting || otp.cooldown > 0"
                                        class="px-3 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed text-xs font-bold text-white transition flex items-center gap-1.5 cursor-pointer">
                                    <template x-if="otp.requesting">
                                        <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                        </svg>
                                    </template>
                                    <span x-text="otp.cooldown > 0 ? ('Kirim ulang (' + otp.cooldown + 's)') : (otp.sent ? 'Kirim Ulang Kode' : 'Minta Kode Persetujuan')"></span>
                                </button>
                            </div>

                            <!-- Input 6 Digit OTP -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-200 mb-1">
                                    Masukkan 6 Digit Kode Persetujuan (OTP)
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" 
                                           maxlength="6" 
                                           x-model="otp.code" 
                                           @input="checkCodeLength()"
                                           placeholder="••••••"
                                           :disabled="otp.verified"
                                           class="w-full text-center tracking-[0.5em] font-mono text-lg font-extrabold px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white/15 disabled:bg-emerald-500/20 disabled:border-emerald-500/50" />
                                    
                                    <button type="button"
                                            @click="verifyOtp()"
                                            :disabled="otp.code.length !== 6 || otp.checking || otp.verified"
                                            class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 disabled:opacity-40 disabled:cursor-not-allowed text-xs font-bold text-white transition shrink-0 cursor-pointer">
                                        <template x-if="otp.checking">
                                            <span>Cek...</span>
                                        </template>
                                        <template x-if="!otp.checking">
                                            <span x-text="otp.verified ? 'Selesai' : 'Verifikasi'"></span>
                                        </template>
                                    </button>
                                </div>
                            </div>

                            <!-- Pesan Status OTP -->
                            <template x-if="otp.message">
                                <p class="text-xs" :class="otp.verified ? 'text-emerald-300 font-medium' : 'text-rose-300'" x-text="otp.message"></p>
                            </template>

                            <!-- Kotak Bantuan Simulasi Lokal -->
                            <template x-if="otp.previewCode">
                                <div class="p-2.5 rounded-lg bg-blue-900/60 border border-blue-400/30 text-[11px] text-blue-200 flex items-center justify-between">
                                    <span>Mode Simulasi Lokal: Kode OTP adalah <strong class="text-yellow-300 font-mono font-extrabold" x-text="otp.previewCode"></strong></span>
                                    <button type="button" @click="otp.code = otp.previewCode; verifyOtp()" class="underline text-white font-bold cursor-pointer">Isi Otomatis</button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Tombol Aksi Penyimpanan -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                        <a href="{{ route('madya.dashboard') }}"
                           class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold text-center transition">
                            Batal
                        </a>
                        
                        <button type="button" 
                                @click="submitForm('save')"
                                :disabled="!otp.verified"
                                :class="!otp.verified ? 'opacity-40 cursor-not-allowed bg-slate-300 text-slate-600' : 'bg-blue-600 hover:bg-blue-700 text-white cursor-pointer'"
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-xs font-bold shadow-xs transition flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <span>Simpan Berita Acara</span>
                        </button>

                        <button type="button" 
                                @click="submitForm('save_print')"
                                :disabled="!otp.verified"
                                :class="!otp.verified ? 'opacity-40 cursor-not-allowed bg-slate-300 text-slate-600' : 'bg-emerald-600 hover:bg-emerald-700 text-white cursor-pointer'"
                                class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-xs font-bold shadow-xs transition flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.672-2.13-1.27-3.086m0 0A10.02 10.02 0 0112 4.5c4.76 0 8.746 3.324 9.77 7.784M12 4.5v15m0 0l-3-3m3 3l3-3" />
                            </svg>
                            <span>Simpan & Buka Cetak 2 Salinan</span>
                        </button>
                    </div>

                </form>

            </div>

            <!-- ================= KOLOM KANAN: LIVE PRATINJAU DOKUMEN HUKUM BA ================= -->
            <div class="lg:col-span-7 sticky top-6">
                
                <div class="bg-slate-200/60 p-3 sm:p-5 rounded-2xl border border-slate-300/80 shadow-inner">
                    
                    <div class="flex items-center justify-between mb-3 px-1 text-xs text-slate-600">
                        <span class="font-bold flex items-center gap-1.5 text-slate-800">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Pratinjau Lembar Berita Acara (Realtime)</span>
                        </span>
                        <span class="text-[11px] text-slate-500 font-mono">Format Kertas A4/F4</span>
                    </div>

                    <!-- Kertas Dokumen Resmi Warkah BHP -->
                    <div class="bg-white text-slate-900 rounded-xl shadow-xl p-6 sm:p-10 border border-slate-200 text-[12.5px] leading-[1.6] font-serif select-none">
                        
                        <!-- Kop Surat Resmi Kementerian Hukum RI / BHP Surabaya -->
                        <header class="flex items-center gap-4 pb-2">
                            <img src="{{ asset('images/pengayoman.svg') }}" 
                                 alt="Logo Kementerian Hukum RI" 
                                 class="w-16 h-16 shrink-0 object-contain" />
                            
                            <div class="flex-1 text-center font-sans leading-[1.2]">
                                <p class="text-[11.5px] font-medium uppercase tracking-[0.03em] text-slate-900">
                                    Kementerian Hukum Republik Indonesia
                                </p>
                                <p class="text-[13.5px] font-bold uppercase tracking-[0.02em] text-slate-950">
                                    Balai Harta Peninggalan Surabaya
                                </p>
                                <p class="text-[9.5px] text-slate-700 mt-0.5">
                                    Jalan Jenderal S. Parman No. 58, Waru, Sidoarjo
                                </p>
                                <p class="text-[9.5px] text-slate-700">
                                    Telepon (031) 8531785
                                </p>
                                <p class="text-[9.5px] text-slate-700">
                                    Laman: <span class="text-blue-800 underline">http://bhpsurabaya.kemenkum.go.id</span>, 
                                    Pos-el: <span class="text-blue-800 underline">bhp.surabaya@kemenkum.go.id</span>
                                </p>
                            </div>
                        </header>

                        <div class="border-b-2 border-blue-950 mt-1"></div>
                        <div class="mt-[2px] border-b border-blue-950"></div>

                        <!-- Judul Berita Acara -->
                        <div class="mt-5 text-center font-sans leading-snug">
                            <h2 class="text-[14px] font-bold uppercase tracking-wide text-slate-950">Berita Acara</h2>
                            <p class="text-[13px] font-bold uppercase tracking-wide text-slate-950">
                                Pembukaan dan Pembacaan Wasiat Tertutup/Rahasia
                            </p>
                            <p class="text-[12px] font-bold text-slate-950 mt-0.5">
                                NOMOR: <span class="font-mono text-blue-950 font-bold" x-text="form.nomor_ba || '…'"></span>
                            </p>
                        </div>

                        <!-- Paragraf Pembuka -->
                        <p class="mt-4 text-justify indent-8 leading-relaxed">
                            Sesuai dengan Pasal 942 Kitab Undang-Undang Hukum Perdata <em>jo.</em> Pasal 14 Huruf d Peraturan Menteri Hukum Nomor 16 Tahun 2026 Tentang Organisasi dan Tata Kerja di Lingkungan Kementerian Hukum<template x-if="form.ada_surat_kuasa"><span> dan surat kuasa tgl <strong x-text="formatTanggalIndo(form.tanggal_surat_kuasa)"></strong></span></template>. Pada hari ini, <strong x-text="form.hari || '……'"></strong>, tanggal <strong x-text="formatTanggalIndo(form.tanggal)"></strong>, Kami masing-masing:
                        </p>

                        <!-- PIHAK PERTAMA -->
                        <div class="mt-3 pl-4">
                            <table class="w-full border-collapse text-left text-[12px]">
                                <tbody>
                                    <tr>
                                        <td class="w-28 py-0.5 text-slate-600">Nama Pejabat</td>
                                        <td class="w-3 py-0.5">:</td>
                                        <td class="py-0.5 font-bold text-slate-900" x-text="form.pihak_pertama_nama || '…'"></td>
                                    </tr>
                                    <tr>
                                        <td class="py-0.5 text-slate-600">NIP</td>
                                        <td class="w-3 py-0.5">:</td>
                                        <td class="py-0.5 font-mono text-[11.5px] tabular-nums" x-text="form.pihak_pertama_nip || '…'"></td>
                                    </tr>
                                    <tr>
                                        <td class="py-0.5 text-slate-600">Jabatan</td>
                                        <td class="w-3 py-0.5">:</td>
                                        <td class="py-0.5" x-text="form.pihak_pertama_jabatan || '…'"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="mt-0.5 text-[11.5px]">
                                selanjutnya disebut <strong class="text-slate-900">PIHAK PERTAMA</strong>
                            </p>
                        </div>

                        <p class="my-2 text-center font-medium italic text-[11.5px]">Dan</p>

                        <!-- PIHAK KEDUA -->
                        <div class="pl-4">
                            <table class="w-full border-collapse text-left text-[12px]">
                                <tbody>
                                    <tr>
                                        <td class="w-28 py-0.5 text-slate-600">Nama Pemohon</td>
                                        <td class="w-3 py-0.5">:</td>
                                        <td class="py-0.5 font-bold text-slate-900" x-text="form.pihak_kedua_nama || '…'"></td>
                                    </tr>
                                    <tr>
                                        <td class="py-0.5 text-slate-600">Jabatan Pemohon</td>
                                        <td class="w-3 py-0.5">:</td>
                                        <td class="py-0.5" x-text="form.pihak_kedua_jabatan || '…'"></td>
                                    </tr>
                                    <tr class="align-top">
                                        <td class="py-0.5 text-slate-600">Alamat Pemohon</td>
                                        <td class="w-3 py-0.5">:</td>
                                        <td class="py-0.5" x-text="form.pihak_kedua_alamat || '…'"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="mt-0.5 text-[11.5px]">
                                selanjutnya disebut <strong class="text-slate-900">PIHAK KEDUA</strong>
                            </p>
                        </div>

                        <!-- Isi Poin 1 - 3 -->
                        <p class="mt-3 font-sans text-[12px] font-semibold text-slate-900">
                            Telah melaksanakan hal-hal sebagai berikut:
                        </p>

                        <ol class="mt-1 list-decimal space-y-1.5 pl-6 text-justify text-[12px]">
                            <li>
                                PIHAK KEDUA telah menyerahkan kepada PIHAK PERTAMA, berupa <strong x-text="form.deskripsi_wasiat || '(deskripsi tampilan akta wasiat tertutup)'"></strong> yang berisi akta wasiat tertutup/rahasia yang dibuat dan diserahkan untuk disimpan Notaris penyimpan oleh <strong x-text="form.nama_pewasiat || '(nama Pewasiat)'"></strong>;
                            </li>
                            <li>
                                PIHAK PERTAMA membuka penyimpanan akta wasiat tertutup/rahasia tersebut dan telah membacakan isi akta wasiat tertutup/rahasia tersebut di hadapan PIHAK KEDUA, para ahli waris Pewasiat, dan para saksi (akta wasiat tertutup/rahasia terlampir); dan
                            </li>
                            <li>
                                PIHAK PERTAMA telah mengembalikan akta wasiat tertutup/rahasia tersebut kepada PIHAK KEDUA untuk kemudian dilakukan pendaftaran wasiat tercatat ke Balai Harta Peninggalan Surabaya sebelum pelaksanaan isi wasiat tersebut.
                            </li>
                        </ol>

                        <p class="mt-4 text-justify indent-8 text-[12px]">
                            Berita acara ini dibuat dengan sesungguhnya dalam 2 (dua) rangkap yang sama dan ditandatangani oleh kedua pihak pada hari tanggal tersebut di atas untuk dapat dipergunakan sebagaimana mestinya.
                        </p>

                        <!-- Blok Tanda Tangan Para Pihak -->
                        <div class="mt-7 grid grid-cols-2 gap-8 text-center text-[12px]">
                            <div>
                                <p class="font-bold">&nbsp;</p>
                                <p class="font-bold">PIHAK KEDUA,</p>
                                <div class="h-16"></div>
                                <p class="font-bold underline underline-offset-4" x-text="form.pihak_kedua_nama || '……………'"></p>
                            </div>

                            <div>
                                <p>Dibuat di <strong x-text="form.tempat_dibuat || 'Sidoarjo'"></strong></p>
                                <p class="font-bold">PIHAK PERTAMA,</p>
                                <div class="h-16"></div>
                                <p class="font-bold underline underline-offset-4" x-text="form.pihak_pertama_nama || '……………'"></p>
                            </div>
                        </div>

                        <!-- Saksi-Saksi -->
                        <div class="mt-6 text-[12px]">
                            <p class="font-bold">Saksi-saksi:</p>
                            <div class="mt-2 space-y-3">
                                <div class="grid grid-cols-2 items-end gap-8">
                                    <div class="flex items-baseline gap-2">
                                        <span class="w-4 tabular-nums">1.</span>
                                        <span class="flex-1 border-b border-dotted border-slate-600 pb-0.5 font-medium" x-text="form.saksi_1 || '……………'"></span>
                                    </div>
                                    <div class="border-b border-dotted border-slate-600 pb-0.5 text-right text-[11px] text-slate-400">
                                        (Tanda Tangan Saksi I)
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 items-end gap-8">
                                    <div class="flex items-baseline gap-2">
                                        <span class="w-4 tabular-nums">2.</span>
                                        <span class="flex-1 border-b border-dotted border-slate-600 pb-0.5 font-medium" x-text="form.saksi_2 || '……………'"></span>
                                    </div>
                                    <div class="border-b border-dotted border-slate-600 pb-0.5 text-right text-[11px] text-slate-400">
                                        (Tanda Tangan Saksi II)
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Alpine.js Application Logic -->
    <script>
        function buatBaApp() {
            return {
                form: @json($baForm),
                otp: {
                    code: '',
                    sent: false,
                    requesting: false,
                    checking: false,
                    verified: false,
                    cooldown: 0,
                    message: '',
                    previewCode: ''
                },
                cooldownInterval: null,

                init() {
                    // Update hari otomatis saat tanggal diubah
                    this.$watch('form.tanggal', (val) => {
                        this.updateHariDariTanggal();
                    });
                },

                toggleSuratKuasa(isChecked) {
                    this.form.ada_surat_kuasa = isChecked;
                    if (isChecked) {
                        this.form.pihak_pertama_nama = 'Ayu Rachmawati, S.H., M.Kn.';
                        this.form.pihak_pertama_nip = '198405122010122001';
                        this.form.pihak_pertama_jabatan = 'Kurator Keperdataan Ahli Madya';
                    } else {
                        this.form.pihak_pertama_nama = 'Hendro Setyawan, S.H., M.H.';
                        this.form.pihak_pertama_nip = '197503182001121001';
                        this.form.pihak_pertama_jabatan = 'Kepala Balai Harta Peninggalan Surabaya';
                    }
                },

                updateHariDariTanggal() {
                    if (!this.form.tanggal) return;
                    const d = new Date(this.form.tanggal);
                    if (isNaN(d.getTime())) return;
                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    this.form.hari = days[d.getDay()];
                },

                formatTanggalIndo(dateStr) {
                    if (!dateStr) return '……';
                    const parts = dateStr.split('-');
                    if (parts.length !== 3) return dateStr;
                    const months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    const day = parseInt(parts[2], 10);
                    const month = months[parseInt(parts[1], 10)] || parts[1];
                    const year = parts[0];
                    return `${day} ${month} ${year}`;
                },

                async requestOtp() {
                    if (this.otp.requesting || this.otp.cooldown > 0) return;
                    this.otp.requesting = true;
                    this.otp.message = '';
                    this.otp.code = '';
                    this.otp.verified = false;

                    try {
                        const res = await fetch("{{ route('madya.layanan.kode-persetujuan', $permohonan->id) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            }
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.otp.sent = true;
                            this.otp.message = 'Kode OTP berhasil dikirim ke ' + data.masked_email;
                            this.otp.previewCode = data.preview_code || '';
                            this.startCooldown(30);
                        } else {
                            this.otp.message = data.error || 'Gagal mengirim kode OTP.';
                        }
                    } catch (e) {
                        this.otp.message = 'Terjadi kesalahan jaringan saat meminta OTP.';
                    } finally {
                        this.otp.requesting = false;
                    }
                },

                startCooldown(sec) {
                    this.otp.cooldown = sec;
                    if (this.cooldownInterval) clearInterval(this.cooldownInterval);
                    this.cooldownInterval = setInterval(() => {
                        this.otp.cooldown--;
                        if (this.otp.cooldown <= 0) {
                            clearInterval(this.cooldownInterval);
                            this.cooldownInterval = null;
                        }
                    }, 1000);
                },

                checkCodeLength() {
                    if (this.otp.code.length === 6) {
                        this.verifyOtp();
                    } else {
                        this.otp.verified = false;
                    }
                },

                async verifyOtp() {
                    if (this.otp.code.length !== 6 || this.otp.checking) return;
                    this.otp.checking = true;
                    this.otp.message = '';

                    try {
                        const res = await fetch("{{ route('madya.layanan.verifikasi-kode', $permohonan->id) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({ code: this.otp.code })
                        });
                        const data = await res.json();
                        if (data.valid) {
                            this.otp.verified = true;
                            this.otp.message = '✓ Kode persetujuan terverifikasi sah.';
                        } else {
                            this.otp.verified = false;
                            this.otp.message = data.message || 'Kode persetujuan tidak sesuai.';
                        }
                    } catch (e) {
                        this.otp.verified = false;
                        this.otp.message = 'Gagal memverifikasi kode persetujuan.';
                    } finally {
                        this.otp.checking = false;
                    }
                },

                submitForm(action) {
                    if (!this.otp.verified) {
                        alert('Silakan verifikasi Kode Persetujuan (OTP) terlebih dahulu.');
                        return;
                    }
                    document.getElementById('submitAction').value = action;
                    document.getElementById('formBuatBa').submit();
                }
            };
        }
    </script>
</x-portal-layout>
