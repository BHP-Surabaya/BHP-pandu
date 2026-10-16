<x-guest-layout :full-bleed="true">
    <div class="relative min-h-screen w-full flex items-center justify-center overflow-x-hidden bg-slate-900 py-6 sm:py-10 px-4 sm:px-8">
        <!-- Background Image of BHP Surabaya Building -->
        <div class="absolute inset-0 bg-cover bg-center sm:bg-[center_top_20%] bg-no-repeat transition-all duration-700 scale-100" 
             style="background-image: url('{{ asset('images/bg-gedung-bhp-clean.jpg') }}');">
        </div>

        <!-- Dark Overlay for contrast and readability -->
        <div class="absolute inset-0 bg-gradient-to-b lg:bg-gradient-to-r from-slate-950/85 via-slate-900/60 to-slate-950/85 lg:from-slate-950/60 lg:via-slate-900/30 lg:to-slate-950/40"></div>

        <!-- Main Content Area -->
        <div class="relative z-10 w-full max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-6 sm:gap-10 lg:gap-16">
            
            <!-- Left Side: Institutional Branding & Motto -->
            <div class="w-full lg:max-w-xl text-white flex flex-col items-center text-center lg:items-start lg:text-left select-none">
                
                <!-- Logo & Brand Header -->
                <div class="flex items-center gap-3.5 sm:gap-5 mb-2 sm:mb-4">
                    <!-- BHP Pillars Building Icon (Exact Vector Replica) -->
                    <div class="flex-shrink-0 drop-shadow-[0_4px_10px_rgba(0,0,0,0.3)]">
                        <svg class="w-11 h-11 sm:w-16 sm:h-16 lg:w-[72px] lg:h-[72px]" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
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

                    <!-- App Title -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight drop-shadow-[0_4px_12px_rgba(0,0,0,0.35)] leading-none">
                        <span class="text-white">Pandu</span><span class="text-[#FBBF24]">BHP</span>
                    </h1>
                </div>

                <!-- Subtitle / Application Description -->
                <p class="text-sm sm:text-lg lg:text-[21px] font-medium text-white/95 leading-snug drop-shadow-[0_2px_8px_rgba(0,0,0,0.3)]">
                    Sistem Pendukung Administrasi Terpadu<br class="hidden sm:inline" />
                    Balai Harta Peninggalan Surabaya
                </p>

                <!-- Yellow Accent Line (Desktop / Tablet) -->
                <div class="hidden lg:block w-14 h-1 sm:h-[4px] bg-[#FBBF24] rounded-full my-5 sm:my-6 shadow-[0_2px_6px_rgba(0,0,0,0.2)]"></div>

                <!-- Motto (Desktop / Tablet) -->
                <p class="hidden lg:block text-sm sm:text-base text-white/90 font-normal leading-relaxed drop-shadow-[0_2px_6px_rgba(0,0,0,0.3)]">
                    Melayani dengan Integritas,<br />
                    Menuju Kepastian Hukum
                </p>
            </div>

            <!-- Right Side: Frosted Glass Forgot Password Card -->
            <div class="w-full max-w-[460px] flex-shrink-0">
                <div class="relative backdrop-blur-2xl bg-white/[0.18] border border-white/40 rounded-2xl sm:rounded-[28px] p-5 sm:p-8 shadow-[0_20px_60px_rgba(0,0,0,0.4)] transition-all duration-300 hover:border-white/50">

                    <!-- Top Icon & Header -->
                    <div class="flex flex-col items-center text-center mb-4 sm:mb-6">
                        <div class="w-14 h-14 sm:w-[64px] sm:h-[64px] rounded-full border-2 border-amber-300/80 bg-amber-400/20 flex items-center justify-center text-amber-300 mb-2 sm:mb-3 shadow-inner">
                            <!-- Key / Recovery Icon -->
                            <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>
                        </div>

                        <h2 class="text-xl sm:text-[24px] font-bold text-white tracking-tight drop-shadow-sm">
                            Pemulihan Akun
                        </h2>
                        <p class="text-xs sm:text-sm text-white/85 mt-1 font-normal leading-relaxed drop-shadow-sm">
                            Lupa kata sandi atau email akun? Masukkan email atau NIK terdaftar Anda
                        </p>
                    </div>

                    <!-- Session Status Alert -->
                    @if (session('status'))
                        <div class="mb-4 text-xs font-medium text-emerald-100 bg-emerald-950/60 p-3.5 rounded-xl border border-emerald-400/40 flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    <!-- Instructions -->
                    <div class="mb-4 text-xs text-white/80 bg-white/10 p-3 rounded-xl border border-white/15 leading-relaxed">
                        Kami akan memverifikasi identitas akun Anda dan mengirimkan tautan untuk mengatur ulang kata sandi ke email Anda.
                    </div>

                    <!-- Forgot Password Form -->
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                        @csrf

                        <!-- Email or NIK Input -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-white/90 mb-1.5 drop-shadow-sm">
                                Alamat Email atau NIK (16 Digit)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <!-- Identification / At Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                    </svg>
                                </div>
                                <input id="email" 
                                       name="email" 
                                       type="text" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       placeholder="contoh: user@gmail.com atau 357801..." 
                                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-[#e2e8f0]/95 hover:bg-white focus:bg-white text-slate-900 placeholder:text-slate-500 rounded-xl text-base sm:text-sm font-medium border border-white/40 focus:outline-none focus:ring-2 focus:ring-[#0066d6] shadow-sm transition @error('email') border-red-400 ring-2 ring-red-400/40 @enderror" />
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-100 bg-red-950/70 py-1.5 px-3 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-1">
                            <button type="submit" 
                                    class="w-full py-2.5 sm:py-3 px-6 bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white font-semibold text-sm sm:text-base rounded-xl shadow-lg shadow-blue-900/30 flex items-center justify-center gap-2 transition duration-200 ease-in-out cursor-pointer group">
                                <span>Kirim Tautan Pemulihan</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>

                        <!-- Back to Login Link -->
                        <div class="pt-2 text-center text-xs text-white/85">
                            <a href="{{ route('login') }}" class="font-medium text-amber-300 hover:text-amber-200 hover:underline transition inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                </svg>
                                <span>Kembali ke Halaman Masuk</span>
                            </a>
                        </div>

                        <!-- Footer Card Divider & Subtext -->
                        <div class="pt-3 mt-3 sm:pt-4 sm:mt-4 border-t border-white/20 text-center">
                            <p class="text-[11px] sm:text-xs text-white/75 font-normal tracking-wide drop-shadow-sm">
                                Balai Harta Peninggalan Surabaya
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
