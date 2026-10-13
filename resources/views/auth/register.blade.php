<x-guest-layout :full-bleed="true">
    <div class="relative min-h-screen w-full flex items-center justify-center overflow-x-hidden bg-slate-900 py-4 sm:py-6 lg:py-8 px-4 sm:px-6">
        <!-- Background Image of BHP Surabaya Building -->
        <div class="absolute inset-0 bg-cover bg-center sm:bg-[center_top_20%] bg-no-repeat transition-all duration-700" 
             style="background-image: url('{{ asset('images/bg-gedung-bhp-clean.jpg') }}');">
        </div>

        <!-- Subtle Dark Overlay for contrast and readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/75 via-slate-900/50 to-slate-950/65"></div>

        <!-- Registration Container Modal Card (Fixed consistent height) -->
        <div class="relative z-10 w-full max-w-5xl bg-white rounded-2xl sm:rounded-[28px] shadow-[0_25px_70px_rgba(0,0,0,0.35)] border border-white/40 overflow-hidden flex flex-col lg:flex-row h-[94vh] lg:h-[780px] max-h-[820px] min-h-[580px]">
            
            <!-- Left Side: Royal Blue Hero Banner (Full Height) -->
            <div class="w-full lg:w-[340px] bg-gradient-to-b from-[#0c2a55] via-[#103873] to-[#0a1e3d] flex-shrink-0 flex flex-col justify-between items-center p-6 sm:p-8 text-white relative overflow-hidden h-auto lg:h-full">
                <!-- Decorative Glow Backgrounds -->
                <div class="absolute -top-16 -left-16 w-48 h-48 bg-blue-400/15 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -right-16 w-48 h-48 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Brand & Logo (Anchored at Top) -->
                <div class="flex flex-col items-center text-center relative z-10 w-full">
                    <!-- BHP Pillars Building Icon (Exact Vector Replica) -->
                    <div class="inline-flex items-center justify-center p-3 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/15 shadow-inner">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 drop-shadow-md" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Roof Pediment Triangle -->
                            <path d="M32 6L4 23H60L32 6Z" fill="white" stroke="white" stroke-width="2" stroke-linejoin="round"/>
                            <!-- Inner Triangular Cutout -->
                            <polygon points="32,13 14,22 50,22" fill="#143c72"/>
                            <!-- Upper Architrave Bar -->
                            <rect x="6" y="24.5" width="52" height="4" rx="1.5" fill="white"/>
                            <!-- Left Pillar (White) -->
                            <rect x="12" y="31" width="7" height="20" rx="1.5" fill="white"/>
                            <!-- Center Pillar (Golden Yellow) -->
                            <rect x="28.5" y="31" width="7" height="20" rx="1.5" fill="#F59E0B"/>
                            <!-- Right Pillar (White) -->
                            <rect x="45" y="31" width="7" height="20" rx="1.5" fill="white"/>
                            <!-- Base Steps -->
                            <rect x="6" y="53" width="52" height="3.5" rx="1" fill="white"/>
                            <rect x="2" y="58" width="60" height="4" rx="1.5" fill="white"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-4 leading-none drop-shadow-sm">
                        <span class="text-white">Pandu</span><span class="text-[#FBBF24]">BHP</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-xs sm:text-sm font-medium text-blue-100/90 mt-2 leading-relaxed">
                        Balai Harta Peninggalan Surabaya
                    </p>

                    <!-- Yellow Accent Bar -->
                    <div class="w-12 h-1 bg-[#FBBF24] rounded-full mt-3 shadow-sm"></div>
                </div>

                <!-- Center Highlights (Keeps sidebar vertically stable & attractive) -->
                <div class="hidden lg:flex flex-col gap-2.5 w-full my-auto py-4 relative z-10 bg-white/5 border border-white/10 rounded-2xl p-4 text-xs">
                    <div class="flex items-center gap-2.5 text-blue-100">
                        <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="text-[11px] font-medium">Pendaftaran Wasiat Tertutup</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-blue-100">
                        <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="text-[11px] font-medium">Akun Notaris &amp; Pengacara</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-blue-100">
                        <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="text-[11px] font-medium">Layanan Perorangan Cepat</span>
                    </div>
                </div>

                <!-- Bottom Footer Note -->
                <div class="relative z-10 text-center mt-auto pt-2">
                    <p class="text-[11px] text-blue-200/70 font-medium">
                        Kementerian Hukum dan HAM RI
                    </p>
                </div>
            </div>

            <!-- Right Side: Registration Form with Fixed Header & Scrollable Body -->
            <div class="flex-1 flex flex-col h-full bg-white overflow-hidden" x-data="{ 
                showPassword: false, 
                showPasswordConfirm: false,
                selectedPekerjaan: '{{ old('pekerjaan_select', (old('pekerjaan') === 'Notaris' ? 'Notaris' : (in_array(old('pekerjaan'), ['Pengacara', 'Advokat']) ? 'Pengacara' : (old('pekerjaan') === 'Perorangan' ? 'Perorangan' : '')))) }}',
                skNotarisName: '',
                skNotarisError: '',
                skPpatName: '',
                skPpatError: '',
                baSumpahName: '',
                baSumpahError: '',
                idCardPengacaraName: '',
                idCardPengacaraError: '',
                alamatKtp: @js(old('alamat_ktp', '')),
                domisiliSamaKtp: @js(old('domisili_sama_ktp') ? true : false),
                alamatDomisili: @js(old('alamat_domisili', old('domisili_sama_ktp') ? old('alamat_ktp', '') : '')),
                init() {
                    if (this.domisiliSamaKtp) {
                        this.alamatDomisili = this.alamatKtp;
                    }
                },
                toggleDomisiliSamaKtp() {
                    if (this.domisiliSamaKtp) {
                        this.alamatDomisili = this.alamatKtp;
                    }
                },
                syncDomisili() {
                    if (this.domisiliSamaKtp) {
                        this.alamatDomisili = this.alamatKtp;
                    }
                }
            }">
                <!-- Form Title & Subtitle (Header - Fixed at Top) -->
                <div class="px-6 py-5 sm:px-10 sm:py-6 border-b border-gray-100 flex-shrink-0 bg-white">
                    <h2 class="text-2xl sm:text-[26px] font-bold text-[#0c2a55] tracking-tight">
                        Daftar Akun Baru
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Silakan lengkapi identitas diri Anda untuk mengakses layanan permohonan BHP.
                    </p>
                </div>

                <!-- Scrollable Form Body with Custom Scrollbar -->
                <div class="flex-1 overflow-y-auto px-6 py-6 sm:px-10 sm:py-8 custom-scrollbar">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6"
                      @submit="
                          if (selectedPekerjaan === 'Notaris') {
                              if (!skNotarisName && !$refs.skNotarisInput?.files?.length) {
                                  $event.preventDefault();
                                  skNotarisError = 'Berkas SK Notaris wajib diunggah untuk pendaftar Notaris.';
                                  $refs.skNotarisContainer?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                  return;
                              }
                              if (!skPpatName && !$refs.skPpatInput?.files?.length) {
                                  $event.preventDefault();
                                  skPpatError = 'Berkas SK PPAT wajib diunggah untuk pendaftar Notaris.';
                                  $refs.skPpatContainer?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                  return;
                              }
                          }
                          if (selectedPekerjaan === 'Pengacara') {
                              if (!baSumpahName && !$refs.baSumpahInput?.files?.length) {
                                  $event.preventDefault();
                                  baSumpahError = 'Berkas Berita Acara Sumpah wajib diunggah untuk pendaftar Pengacara.';
                                  $refs.baSumpahContainer?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                  return;
                              }
                              if (!idCardPengacaraName && !$refs.idCardPengacaraInput?.files?.length) {
                                  $event.preventDefault();
                                  idCardPengacaraError = 'Berkas ID Card Pengacara wajib diunggah untuk pendaftar Pengacara.';
                                  $refs.idCardPengacaraContainer?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                  return;
                              }
                          }
                      ">
                    @csrf

                    <!-- ================= BAGIAN 1: INFORMASI DATA DIRI & PROFESI ================= -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-1.5 border-b border-gray-100">
                            <span class="w-5 h-5 rounded-full bg-blue-100 text-[#0066d6] font-bold text-[11px] flex items-center justify-center">1</span>
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Data Identitas & Profesi
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input id="name" 
                                       name="name" 
                                       type="text" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="name" 
                                       placeholder="Contoh: Budi Santoso, S.H."
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition @error('name') border-red-500 @enderror" />
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK (Nomor Induk Kependudukan) -->
                            <div>
                                <label for="nik" class="block text-xs font-semibold text-gray-700 mb-1">
                                    NIK (Nomor Induk Kependudukan)
                                </label>
                                <input id="nik" 
                                       name="nik" 
                                       type="text" 
                                       maxlength="16"
                                       value="{{ old('nik') }}" 
                                       placeholder="16 digit NIK pada KTP"
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition @error('nik') border-red-500 @enderror" />
                                @error('nik')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       placeholder="email@contoh.com"
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition @error('email') border-red-500 @enderror" />
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor WhatsApp/HP -->
                            <div>
                                <label for="phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Nomor WhatsApp / HP
                                </label>
                                <input id="phone" 
                                       name="phone" 
                                       type="tel" 
                                       value="{{ old('phone') }}" 
                                       placeholder="0812 xxxx xxxx"
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition @error('phone') border-red-500 @enderror" />
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pekerjaan / Profesi Dropdown -->
                            <div>
                                <label for="pekerjaan_select" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Jenis Akun / Pekerjaan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="pekerjaan_select" 
                                            name="pekerjaan_select" 
                                            x-model="selectedPekerjaan"
                                            required
                                            class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition appearance-none cursor-pointer @error('pekerjaan_select') border-red-500 @enderror @error('pekerjaan') border-red-500 @enderror">
                                        <option value="" disabled :selected="!selectedPekerjaan">-- Pilih Jenis Akun --</option>
                                        <option value="Notaris">Notaris</option>
                                        <option value="Pengacara">Pengacara</option>
                                        <option value="Perorangan">Perorangan</option>
                                    </select>
                                    <input type="hidden" name="pekerjaan" :value="selectedPekerjaan">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('pekerjaan_select')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                @error('pekerjaan')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kolom Keterangan Jenis Akun (Fixed Height h-[42px] to prevent row shifting) -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    Keterangan Jenis Akun
                                </label>
                                <div class="h-[42px] flex items-center">
                                    <!-- Badge Info Notaris -->
                                    <div x-show="selectedPekerjaan === 'Notaris'" 
                                         x-cloak 
                                         class="w-full h-full px-3 py-2 bg-blue-50/90 border border-blue-200/80 rounded-lg text-xs text-blue-950 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#0066d6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="truncate">Wajib unggah <strong>SK Notaris</strong> &amp; <strong>SK PPAT</strong></span>
                                    </div>

                                    <!-- Badge Info Pengacara -->
                                    <div x-show="selectedPekerjaan === 'Pengacara'" 
                                         x-cloak 
                                         class="w-full h-full px-3 py-2 bg-indigo-50/90 border border-indigo-200/80 rounded-lg text-xs text-indigo-950 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="truncate">Wajib unggah <strong>BA Sumpah PT</strong> &amp; <strong>ID Card</strong></span>
                                    </div>

                                    <!-- Badge Info Perorangan -->
                                    <div x-show="selectedPekerjaan === 'Perorangan'" 
                                         x-cloak 
                                         class="w-full h-full px-3 py-2 bg-emerald-50/90 border border-emerald-200/80 rounded-lg text-xs text-emerald-950 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="truncate">Tanpa berkas profesi khusus (Akses langsung)</span>
                                    </div>

                                    <!-- Default Prompt -->
                                    <div x-show="!selectedPekerjaan" 
                                         class="w-full h-full px-3 py-2 bg-gray-50 border border-dashed border-gray-200 rounded-lg text-xs text-gray-400 flex items-center italic">
                                        <span>*Pilih salah satu jenis akun di samping</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel Informasi Khusus Perorangan -->
                        <div x-show="selectedPekerjaan === 'Perorangan'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-cloak
                             class="p-4 bg-emerald-50/70 border border-emerald-200/80 rounded-xl text-xs text-emerald-950 flex items-start gap-3 shadow-sm">
                            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="space-y-0.5">
                                <h4 class="text-xs sm:text-sm font-bold text-emerald-950">Pendaftaran Akun Perorangan</h4>
                                <p class="text-[11px] text-emerald-900/90 leading-relaxed">
                                    Akun Perorangan tidak memerlukan dokumen legalitas khusus (SK Notaris / BA Sumpah). Anda dapat langsung melengkapi data alamat tinggal dan kata sandi di bawah.
                                </p>
                            </div>
                        </div>

                        <!-- Panel Kelengkapan Berkas & Kantor Khusus Notaris -->
                        <div x-show="selectedPekerjaan === 'Notaris'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-cloak
                             class="p-4 sm:p-5 bg-gradient-to-br from-blue-50/90 via-slate-50 to-blue-50/50 border border-blue-200/80 rounded-xl sm:rounded-2xl space-y-4 shadow-sm">
                            <div class="flex items-center gap-2.5 pb-2 border-b border-blue-100">
                                <div class="w-7 h-7 rounded-lg bg-[#0066d6] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-[#0c2a55]">Kelengkapan Dokumen Notaris &amp; PPAT</h4>
                                    <p class="text-[11px] text-gray-500">Wajib melampirkan SK Notaris, SK PPAT, dan Alamat Kantor untuk verifikasi legalitas akun.</p>
                                </div>
                            </div>

                            <!-- Alert Informasi Status Akun Perorangan Sebelum Verifikasi -->
                            <div class="p-3 bg-amber-50/90 border border-amber-200/80 rounded-xl text-xs text-amber-900 flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="space-y-0.5">
                                    <p class="font-bold text-amber-950">Status Akun Belum Terverifikasi:</p>
                                    <p class="text-[11px] leading-relaxed text-amber-900/90">
                                        Pada saat akun belum diverifikasi oleh Master Admin, maka status akun Anda tetap sebagai <strong>Akun Perorangan</strong>. Status akan diperbarui otomatis menjadi <strong>Akun Notaris</strong> setelah seluruh berkas disetujui.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Upload SK Notaris -->
                                <div>
                                    <label for="sk_notaris" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Upload Berkas SK Notaris <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative" x-ref="skNotarisContainer">
                                        <input id="sk_notaris" 
                                               x-ref="skNotarisInput"
                                               name="sk_notaris" 
                                               type="file" 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               @change="
                                                   skNotarisError = '';
                                                   const file = $event.target.files[0];
                                                   if (file) {
                                                       if (file.size > 25 * 1024 * 1024) {
                                                            skNotarisError = 'Ukuran berkas (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB) melebihi batas maksimal 25 MB.';
                                                            $event.target.value = '';
                                                            skNotarisName = '';
                                                            return;
                                                       }
                                                       skNotarisName = file.name;
                                                   } else {
                                                       skNotarisName = '';
                                                   }
                                               "
                                               class="hidden" />
                                        <label for="sk_notaris" 
                                               class="flex flex-col items-center justify-center px-4 py-3.5 border-2 border-dashed border-blue-300/90 hover:border-[#0066d6] bg-white rounded-xl cursor-pointer transition group text-center hover:bg-blue-50/40 @error('sk_notaris') border-red-500 @enderror"
                                               :class="{ '!border-red-500 bg-red-50/20': skNotarisError }">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-[#0066d6] flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <span x-show="!skNotarisName" class="text-xs font-medium text-gray-700 group-hover:text-[#0066d6]">
                                                Upload File SK Notaris
                                            </span>
                                            <div x-show="skNotarisName" class="text-xs font-bold text-[#0066d6] break-all px-2 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="skNotarisName"></span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 mt-1">Format PDF, JPG, PNG (Maks. 25MB)</span>
                                        </label>
                                    </div>
                                    <p x-show="skNotarisError" x-text="skNotarisError" class="mt-1 text-xs text-red-600 font-medium" x-cloak></p>
                                    @error('sk_notaris')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Upload SK PPAT -->
                                <div>
                                    <label for="sk_ppat" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Upload Berkas SK PPAT <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative" x-ref="skPpatContainer">
                                        <input id="sk_ppat" 
                                               x-ref="skPpatInput"
                                               name="sk_ppat" 
                                               type="file" 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               @change="
                                                   skPpatError = '';
                                                   const file = $event.target.files[0];
                                                   if (file) {
                                                       if (file.size > 25 * 1024 * 1024) {
                                                            skPpatError = 'Ukuran berkas (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB) melebihi batas maksimal 25 MB.';
                                                            $event.target.value = '';
                                                            skPpatName = '';
                                                            return;
                                                       }
                                                       skPpatName = file.name;
                                                   } else {
                                                       skPpatName = '';
                                                   }
                                               "
                                               class="hidden" />
                                        <label for="sk_ppat" 
                                               class="flex flex-col items-center justify-center px-4 py-3.5 border-2 border-dashed border-blue-300/90 hover:border-[#0066d6] bg-white rounded-xl cursor-pointer transition group text-center hover:bg-blue-50/40 @error('sk_ppat') border-red-500 @enderror"
                                               :class="{ '!border-red-500 bg-red-50/20': skPpatError }">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-[#0066d6] flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <span x-show="!skPpatName" class="text-xs font-medium text-gray-700 group-hover:text-[#0066d6]">
                                                Upload File SK PPAT
                                            </span>
                                            <div x-show="skPpatName" class="text-xs font-bold text-[#0066d6] break-all px-2 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="skPpatName"></span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 mt-1">Format PDF, JPG, PNG (Maks. 25MB)</span>
                                        </label>
                                    </div>
                                    <p x-show="skPpatError" x-text="skPpatError" class="mt-1 text-xs text-red-600 font-medium" x-cloak></p>
                                    @error('sk_ppat')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat Kantor Notaris -->
                            <div>
                                <label for="alamat_kantor" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Alamat Kantor Notaris <span class="text-red-500">*</span>
                                </label>
                                <textarea id="alamat_kantor" 
                                          name="alamat_kantor" 
                                          rows="2" 
                                          :disabled="selectedPekerjaan !== 'Notaris'"
                                          :required="selectedPekerjaan === 'Notaris'"
                                          placeholder="Alamat lengkap kantor notaris (Jalan, Nomor, Kelurahan/Desa, Kecamatan, Kota/Kabupaten, Kode Pos)"
                                          class="w-full px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition resize-y @error('alamat_kantor') border-red-500 @enderror">{{ old('alamat_kantor') }}</textarea>
                                @error('alamat_kantor')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Panel Kelengkapan Berkas Khusus Pengacara -->
                        <div x-show="selectedPekerjaan === 'Pengacara'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-cloak
                             class="p-4 sm:p-5 bg-gradient-to-br from-indigo-50/90 via-slate-50 to-indigo-50/50 border border-indigo-200/80 rounded-xl sm:rounded-2xl space-y-4 shadow-sm">
                            <div class="flex items-center gap-2.5 pb-2 border-b border-indigo-100">
                                <div class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-indigo-950">Kelengkapan Dokumen Pengacara / Advokat</h4>
                                    <p class="text-[11px] text-gray-500">Wajib melampirkan Berita Acara Sumpah PT dan ID Card Pengacara untuk verifikasi legalitas akun.</p>
                                </div>
                            </div>

                            <!-- Alert Informasi Status Akun Perorangan Sebelum Verifikasi -->
                            <div class="p-3 bg-amber-50/90 border border-amber-200/80 rounded-xl text-xs text-amber-900 flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="space-y-0.5">
                                    <p class="font-bold text-amber-950">Status Akun Belum Terverifikasi:</p>
                                    <p class="text-[11px] leading-relaxed text-amber-900/90">
                                        Pada saat akun belum diverifikasi oleh Master Admin, maka status akun Anda tetap sebagai <strong>Akun Perorangan</strong>. Status akan diperbarui otomatis menjadi <strong>Akun Pengacara</strong> setelah seluruh berkas disetujui.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Upload Berita Acara Sumpah PT -->
                                <div>
                                    <label for="berita_acara_sumpah" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Upload Berita Acara Sumpah Pengadilan Tinggi <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative" x-ref="baSumpahContainer">
                                        <input id="berita_acara_sumpah" 
                                               x-ref="baSumpahInput"
                                               name="berita_acara_sumpah" 
                                               type="file" 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               @change="
                                                   baSumpahError = '';
                                                   const file = $event.target.files[0];
                                                   if (file) {
                                                       if (file.size > 25 * 1024 * 1024) {
                                                           baSumpahError = 'Ukuran berkas (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB) melebihi batas maksimal 25 MB.';
                                                           $event.target.value = '';
                                                           baSumpahName = '';
                                                           return;
                                                       }
                                                       baSumpahName = file.name;
                                                   } else {
                                                       baSumpahName = '';
                                                   }
                                               "
                                               class="hidden" />
                                        <label for="berita_acara_sumpah" 
                                               class="flex flex-col items-center justify-center px-4 py-3.5 border-2 border-dashed border-indigo-300/90 hover:border-indigo-600 bg-white rounded-xl cursor-pointer transition group text-center hover:bg-indigo-50/40 @error('berita_acara_sumpah') border-red-500 @enderror"
                                               :class="{ '!border-red-500 bg-red-50/20': baSumpahError }">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <span x-show="!baSumpahName" class="text-xs font-medium text-gray-700 group-hover:text-indigo-600">
                                                Upload BA Sumpah PT
                                            </span>
                                            <div x-show="baSumpahName" class="text-xs font-bold text-indigo-600 break-all px-2 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="baSumpahName"></span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 mt-1">Format PDF, JPG, PNG (Maks. 25MB)</span>
                                        </label>
                                    </div>
                                    <p x-show="baSumpahError" x-text="baSumpahError" class="mt-1 text-xs text-red-600 font-medium" x-cloak></p>
                                    @error('berita_acara_sumpah')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Upload ID Card Pengacara -->
                                <div>
                                    <label for="id_card_pengacara" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Upload ID Card Pengacara <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative" x-ref="idCardPengacaraContainer">
                                        <input id="id_card_pengacara" 
                                               x-ref="idCardPengacaraInput"
                                               name="id_card_pengacara" 
                                               type="file" 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               @change="
                                                   idCardPengacaraError = '';
                                                   const file = $event.target.files[0];
                                                   if (file) {
                                                       if (file.size > 25 * 1024 * 1024) {
                                                           idCardPengacaraError = 'Ukuran berkas (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB) melebihi batas maksimal 25 MB.';
                                                           $event.target.value = '';
                                                           idCardPengacaraName = '';
                                                           return;
                                                       }
                                                       idCardPengacaraName = file.name;
                                                   } else {
                                                       idCardPengacaraName = '';
                                                   }
                                               "
                                               class="hidden" />
                                        <label for="id_card_pengacara" 
                                               class="flex flex-col items-center justify-center px-4 py-3.5 border-2 border-dashed border-indigo-300/90 hover:border-indigo-600 bg-white rounded-xl cursor-pointer transition group text-center hover:bg-indigo-50/40 @error('id_card_pengacara') border-red-500 @enderror"
                                               :class="{ '!border-red-500 bg-red-50/20': idCardPengacaraError }">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                </svg>
                                            </div>
                                            <span x-show="!idCardPengacaraName" class="text-xs font-medium text-gray-700 group-hover:text-indigo-600">
                                                Upload ID Card Pengacara
                                            </span>
                                            <div x-show="idCardPengacaraName" class="text-xs font-bold text-indigo-600 break-all px-2 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span x-text="idCardPengacaraName"></span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 mt-1">Format PDF, JPG, PNG (Maks. 25MB)</span>
                                        </label>
                                    </div>
                                    <p x-show="idCardPengacaraError" x-text="idCardPengacaraError" class="mt-1 text-xs text-red-600 font-medium" x-cloak></p>
                                    @error('id_card_pengacara')
                                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat Kantor Pengacara / Law Firm -->
                            <div>
                                <label for="alamat_kantor_pengacara" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Alamat Kantor Pengacara / Law Firm <span class="text-gray-400 font-normal">(Opsional)</span>
                                </label>
                                <textarea id="alamat_kantor_pengacara" 
                                          name="alamat_kantor" 
                                          rows="2" 
                                          :disabled="selectedPekerjaan !== 'Pengacara'"
                                          placeholder="Alamat kantor pengacara / firma hukum (Jalan, Nomor, Kota/Kabupaten)"
                                          class="w-full px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition resize-y">{{ old('alamat_kantor') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ================= BAGIAN 2: ALAMAT LENGKAP & DOMISILI ================= -->
                    <div class="space-y-4 pt-1">
                        <div class="flex items-center gap-2 pb-1.5 border-b border-gray-100">
                            <span class="w-5 h-5 rounded-full bg-blue-100 text-[#0066d6] font-bold text-[11px] flex items-center justify-center">2</span>
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Alamat Tinggal
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                            <!-- Alamat Lengkap Sesuai KTP -->
                            <div>
                                <label for="alamat_ktp" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Alamat Lengkap (Sesuai KTP)
                                </label>
                                <textarea id="alamat_ktp" 
                                          name="alamat_ktp" 
                                          rows="2" 
                                          x-model="alamatKtp"
                                          @input="syncDomisili()"
                                          placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi"
                                          class="w-full px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition resize-y @error('alamat_ktp') border-red-500 @enderror">{{ old('alamat_ktp') }}</textarea>
                                @error('alamat_ktp')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Domisili -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="alamat_domisili" class="block text-xs font-semibold text-gray-700">
                                        Alamat Domisili
                                    </label>
                                    <label class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-blue-50 hover:bg-blue-100/80 border border-blue-200/70 cursor-pointer transition select-none">
                                        <input type="checkbox" 
                                               id="domisili_sama_ktp"
                                               name="domisili_sama_ktp" 
                                               value="1" 
                                               x-model="domisiliSamaKtp"
                                               @change="toggleDomisiliSamaKtp()"
                                               class="w-3.5 h-3.5 rounded border-blue-300 text-[#0066d6] focus:ring-0 cursor-pointer transition">
                                        <span class="text-[11px] font-semibold text-[#0066d6]">Sama dengan KTP</span>
                                    </label>
                                </div>
                                <textarea id="alamat_domisili" 
                                          name="alamat_domisili" 
                                          rows="2" 
                                          x-model="alamatDomisili"
                                          :readonly="domisiliSamaKtp"
                                          :class="domisiliSamaKtp ? 'bg-gray-100/90 text-gray-600 cursor-not-allowed border-gray-200' : 'bg-white text-gray-800 border-gray-300'"
                                          placeholder="Alamat domisili saat ini jika berbeda dengan KTP"
                                          class="w-full px-3.5 py-2 border rounded-lg text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition resize-y @error('alamat_domisili') border-red-500 @enderror">{{ old('alamat_domisili') }}</textarea>
                                @error('alamat_domisili')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                <p x-show="domisiliSamaKtp" x-cloak class="mt-1 text-[11px] text-[#0066d6] font-medium flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-[#0066d6] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Alamat domisili otomatis mengikuti data KTP</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- ================= BAGIAN 3: KEAMANAN AKUN ================= -->
                    <div class="space-y-4 pt-1">
                        <div class="flex items-center gap-2 pb-1.5 border-b border-gray-100">
                            <span class="w-5 h-5 rounded-full bg-blue-100 text-[#0066d6] font-bold text-[11px] flex items-center justify-center">3</span>
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Keamanan Akun
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Kata Sandi -->
                            <div>
                                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Kata Sandi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="password" 
                                           name="password" 
                                           :type="showPassword ? 'text' : 'password'" 
                                           required 
                                           autocomplete="new-password" 
                                           placeholder="Minimal 8 karakter"
                                           class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition @error('password') border-red-500 @enderror" />
                                    
                                    <button type="button" 
                                            @click="showPassword = !showPassword" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer"
                                            tabindex="-1"
                                            aria-label="Toggle kata sandi">
                                        <!-- Eye open icon -->
                                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <!-- Eye slash icon -->
                                        <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Kata Sandi -->
                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation" 
                                           name="password_confirmation" 
                                           :type="showPasswordConfirm ? 'text' : 'password'" 
                                           required 
                                           autocomplete="new-password" 
                                           placeholder="Ulangi kata sandi"
                                           class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition @error('password_confirmation') border-red-500 @enderror" />
                                    
                                    <button type="button" 
                                            @click="showPasswordConfirm = !showPasswordConfirm" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer"
                                            tabindex="-1"
                                            aria-label="Toggle konfirmasi kata sandi">
                                        <!-- Eye open icon -->
                                        <svg x-show="!showPasswordConfirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <!-- Eye slash icon -->
                                        <svg x-show="showPasswordConfirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Condition Checkbox -->
                    <div class="flex items-start gap-2.5 pt-2">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               required 
                               class="w-4 h-4 mt-0.5 rounded border-gray-300 text-[#0066d6] focus:ring-[#0066d6] focus:ring-offset-0 cursor-pointer transition">
                        <label for="terms" class="text-xs sm:text-[13px] text-gray-600 leading-relaxed cursor-pointer select-none">
                            Saya menyatakan data yang saya masukkan adalah benar dan setuju dengan <a href="#" class="font-semibold text-[#0066d6] hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="font-semibold text-[#0066d6] hover:underline">Kebijakan Privasi</a> yang berlaku.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-3 px-6 bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white font-semibold text-sm rounded-xl shadow-md shadow-blue-900/20 flex items-center justify-center gap-2 transition duration-150 ease-in-out cursor-pointer group">
                            <span>Daftar Sekarang</span>
                            <!-- Right arrow icon with hover transition -->
                            <svg class="w-4 h-4 stroke-[2.2] group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="pt-1 text-center text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-bold text-[#0066d6] hover:underline hover:text-[#00479e] ml-1 transition">
                            Masuk di sini
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
