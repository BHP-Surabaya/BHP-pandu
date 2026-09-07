<x-guest-layout>
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-[0_15px_45px_rgba(0,0,0,0.07)] border border-purple-100/80 overflow-hidden flex flex-col lg:flex-row my-6">
        <!-- Left Side: Purple Hero Banner -->
        <div class="w-full lg:w-[340px] bg-gradient-to-b from-[#3b127a] via-[#320f69] to-[#240a4e] flex-shrink-0 flex flex-col justify-between p-8 sm:p-10 text-white relative overflow-hidden">
            <!-- Decorative Glow Backgrounds -->
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-purple-400/15 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-16 w-48 h-48 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Top Brand & Logo -->
            <div class="flex flex-col items-center text-center relative z-10">
                <!-- Logo Pengayoman -->
                <div class="inline-flex items-center justify-center p-3 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/15 shadow-inner">
                    <img src="{{ asset('images/pengayoman.svg') }}" 
                         alt="Logo Kemenkumham Pengayoman" 
                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-contain drop-shadow-md" />
                </div>

                <!-- Title -->
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mt-5">
                    BHP Portal
                </h1>

                <!-- Subtitle -->
                <p class="text-sm font-medium text-purple-200/90 mt-1.5 leading-relaxed">
                    Balai Harta Peninggalan Surabaya
                </p>

                <!-- Yellow Accent Bar -->
                <div class="w-12 h-1 bg-[#eab308] rounded-full mt-4"></div>
            </div>

            <!-- Middle: Key Features / Guidance -->
            <div class="my-8 space-y-3.5 relative z-10 hidden sm:block">
                <div class="flex items-start gap-3 text-left">
                    <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 mt-0.5 border border-white/10">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white">Layanan Resmi BHP</h4>
                        <p class="text-[11px] text-purple-200/80 leading-relaxed">Pengajuan permohonan pembukaan wasiat tertutup secara digital.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 text-left">
                    <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 mt-0.5 border border-white/10">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white">Untuk Notaris & Publik</h4>
                        <p class="text-[11px] text-purple-200/80 leading-relaxed">Mendukung akun Notaris, PPAT, maupun pemohon perorangan.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 text-left">
                    <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 mt-0.5 border border-white/10">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-white">Aman & Terintegrasi</h4>
                        <p class="text-[11px] text-purple-200/80 leading-relaxed">Data terlindungi dan verifikasi berkas lebih cepat.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Legal Tag -->
            <div class="pt-4 border-t border-white/10 text-center relative z-10">
                <p class="text-[11px] text-purple-300/80 font-medium">
                    Kementerian Hukum dan Hak Asasi Manusia RI
                </p>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="flex-1 p-6 sm:p-10 bg-white" x-data="{ 
            showPassword: false, 
            showPasswordConfirm: false,
            selectedPekerjaan: '{{ old('pekerjaan_select', (in_array(old('pekerjaan'), ['Notaris', 'PPAT']) ? old('pekerjaan') : (old('pekerjaan') ? 'Lainnya' : ''))) }}',
            customPekerjaan: '{{ old('pekerjaan_custom', (!in_array(old('pekerjaan'), ['Notaris', 'PPAT']) && old('pekerjaan') ? old('pekerjaan') : '')) }}',
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
            <!-- Form Title & Subtitle -->
            <div class="mb-6 pb-4 border-b border-gray-100">
                <h2 class="text-2xl sm:text-[26px] font-bold text-[#3b127a] tracking-tight">
                    Daftar Akun Baru
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Silakan lengkapi identitas diri Anda untuk mengakses layanan permohonan BHP.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- ================= BAGIAN 1: INFORMASI DATA DIRI & PROFESI ================= -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-1.5 border-b border-gray-100">
                        <span class="w-5 h-5 rounded-full bg-purple-100 text-[#3b127a] font-bold text-[11px] flex items-center justify-center">1</span>
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
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('name') border-red-500 @enderror" />
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
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('nik') border-red-500 @enderror" />
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
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('email') border-red-500 @enderror" />
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
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('phone') border-red-500 @enderror" />
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan / Profesi Dropdown -->
                        <div>
                            <label for="pekerjaan_select" class="block text-xs font-semibold text-gray-700 mb-1">
                                Pekerjaan / Profesi
                            </label>
                            <div class="relative">
                                <select id="pekerjaan_select" 
                                        name="pekerjaan_select" 
                                        x-model="selectedPekerjaan"
                                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition appearance-none cursor-pointer @error('pekerjaan_select') border-red-500 @enderror @error('pekerjaan') border-red-500 @enderror">
                                    <option value="" disabled :selected="!selectedPekerjaan">-- Pilih Pekerjaan --</option>
                                    <option value="Notaris">Notaris</option>
                                    <option value="PPAT">PPAT</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
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

                        <!-- Dynamic Kolom Pendamping Pekerjaan -->
                        <div>
                            <!-- Input Jika Pilih Lainnya -->
                            <div x-show="selectedPekerjaan === 'Lainnya'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-cloak>
                                <label for="pekerjaan_custom" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Sebutkan Pekerjaan <span class="text-red-500">*</span>
                                </label>
                                <input id="pekerjaan_custom" 
                                       name="pekerjaan_custom" 
                                       type="text" 
                                       x-model="customPekerjaan"
                                       :required="selectedPekerjaan === 'Lainnya'"
                                       placeholder="Contoh: Advokat, Konsultan Hukum, Swasta, dll"
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('pekerjaan_custom') border-red-500 @enderror" />
                                @error('pekerjaan_custom')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Badge Info Notaris -->
                            <div x-show="selectedPekerjaan === 'Notaris'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-cloak 
                                 class="p-2.5 bg-purple-50/80 border border-purple-100 rounded-lg text-xs text-purple-900 flex items-start gap-2 sm:mt-5">
                                <svg class="w-4 h-4 text-[#3b127a] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Akun terdaftar sebagai Notaris untuk layanan pembukaan wasiat tertutup BHP.</span>
                            </div>

                            <!-- Badge Info PPAT -->
                            <div x-show="selectedPekerjaan === 'PPAT'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-cloak 
                                 class="p-2.5 bg-purple-50/80 border border-purple-100 rounded-lg text-xs text-purple-900 flex items-start gap-2 sm:mt-5">
                                <svg class="w-4 h-4 text-[#3b127a] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Akun terdaftar sebagai Pejabat Pembuat Akta Tanah (PPAT).</span>
                            </div>

                            <!-- Petunjuk awal jika belum memilih -->
                            <div x-show="!selectedPekerjaan" class="hidden sm:flex items-center text-xs text-gray-400 italic pt-7">
                                <span>*Pilih pekerjaan/profesi untuk penyesuaian berkas permohonan.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= BAGIAN 2: ALAMAT LENGKAP & DOMISILI ================= -->
                <div class="space-y-4 pt-1">
                    <div class="flex items-center gap-2 pb-1.5 border-b border-gray-100">
                        <span class="w-5 h-5 rounded-full bg-purple-100 text-[#3b127a] font-bold text-[11px] flex items-center justify-center">2</span>
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
                                      class="w-full px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition resize-y @error('alamat_ktp') border-red-500 @enderror">{{ old('alamat_ktp') }}</textarea>
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
                                <label class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-purple-50 hover:bg-purple-100/80 border border-purple-200/70 cursor-pointer transition select-none">
                                    <input type="checkbox" 
                                           id="domisili_sama_ktp"
                                           name="domisili_sama_ktp" 
                                           value="1" 
                                           x-model="domisiliSamaKtp"
                                           @change="toggleDomisiliSamaKtp()"
                                           class="w-3.5 h-3.5 rounded border-purple-300 text-[#3b127a] focus:ring-0 cursor-pointer transition">
                                    <span class="text-[11px] font-semibold text-[#3b127a]">Sama dengan KTP</span>
                                </label>
                            </div>
                            <textarea id="alamat_domisili" 
                                      name="alamat_domisili" 
                                      rows="2" 
                                      x-model="alamatDomisili"
                                      :readonly="domisiliSamaKtp"
                                      :class="domisiliSamaKtp ? 'bg-gray-100/90 text-gray-600 cursor-not-allowed border-gray-200' : 'bg-white text-gray-800 border-gray-300'"
                                      placeholder="Alamat domisili saat ini jika berbeda dengan KTP"
                                      class="w-full px-3.5 py-2 border rounded-lg text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition resize-y @error('alamat_domisili') border-red-500 @enderror">{{ old('alamat_domisili') }}</textarea>
                            @error('alamat_domisili')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                            <p x-show="domisiliSamaKtp" x-cloak class="mt-1 text-[11px] text-purple-700 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <span class="w-5 h-5 rounded-full bg-purple-100 text-[#3b127a] font-bold text-[11px] flex items-center justify-center">3</span>
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
                                       class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('password') border-red-500 @enderror" />
                                
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
                                       class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3b127a]/20 focus:border-[#3b127a] transition @error('password_confirmation') border-red-500 @enderror" />
                                
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
                           class="w-4 h-4 mt-0.5 rounded border-gray-300 text-[#3b127a] focus:ring-[#3b127a] focus:ring-offset-0 cursor-pointer transition">
                    <label for="terms" class="text-xs sm:text-[13px] text-gray-600 leading-relaxed cursor-pointer select-none">
                        Saya menyatakan data yang saya masukkan adalah benar dan setuju dengan <a href="#" class="font-semibold text-[#3b127a] hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="font-semibold text-[#3b127a] hover:underline">Kebijakan Privasi</a> yang berlaku.
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-[#3b127a] hover:bg-[#2e0e61] active:bg-[#23094c] text-white font-semibold text-sm rounded-lg shadow-sm hover:shadow flex items-center justify-center gap-2 transition duration-150 ease-in-out cursor-pointer">
                        <span>Daftar Sekarang</span>
                        <!-- Right arrow icon -->
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>

                <!-- Login Link -->
                <div class="pt-1 text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-[#3b127a] hover:underline ml-1 transition">
                        Masuk di sini
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
