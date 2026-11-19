<x-guest-layout :full-bleed="true">
    <div class="relative min-h-screen w-full flex flex-col justify-between overflow-x-hidden bg-slate-950 py-2.5 sm:py-3.5 tall:py-6 px-4 sm:px-6 lg:px-8">
        <!-- Background Image of BHP Surabaya Building -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-all duration-700 scale-100" 
             style="background-image: url('{{ asset('images/bg-gedung-bhp-clean.jpg') }}');">
        </div>

        <!-- Rich Cinematic Dual-Flank Overlay (Strong contrast for branding & card, clear center view) -->
        <div class="absolute inset-0 bg-gradient-to-b lg:bg-gradient-to-r from-slate-950/90 via-slate-950/50 to-slate-950/85 backdrop-blur-[1px]"></div>

        <!-- Top Spacer for Balanced Vertical Centering (Only active on tall desktop displays) -->
        <div class="hidden tall:lg:block tall:h-10 2xl:tall:h-14"></div>

        <!-- Main Content Area: Floating Two-Column Layout (Opsi 2) -->
        <div class="relative z-10 w-full max-w-6xl mx-auto my-auto flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-6 sm:gap-8 lg:gap-10 2xl:gap-16 py-1 sm:py-2">
            
            <!-- Left Side: Hero Brand & Official Tagline (Floating Refined) -->
            <div class="w-full lg:max-w-lg xl:max-w-xl text-white flex flex-col items-center text-center lg:items-start lg:text-left select-none">
                
                <!-- Hero PanduBHP Logo -->
                <div class="mb-2 sm:mb-3 tall:mb-4">
                    <h1 class="sr-only">PanduBHP - Balai Harta Peninggalan Surabaya</h1>
                    <img src="{{ asset('images/logo-pandubhp-clean.png') }}" 
                         alt="PanduBHP" 
                         class="h-12 sm:h-16 lg:h-[72px] tall:lg:h-[88px] w-auto object-contain drop-shadow-[0_6px_24px_rgba(0,0,0,0.6)]" />
                </div>

                <!-- Official Tagline Badge (PASTI SETIA) -->
                <div class="w-full max-w-[340px] sm:max-w-[420px] lg:max-w-[460px] tall:lg:max-w-[520px]">
                    <img src="{{ asset('images/tagline-pasti-setia.png') }}" 
                         alt="PASTI SETIA - Profesional Akuntabel Sinergi Transparan Inovatif | Santun Empati Tanggap Integritas Amanah" 
                         class="w-full h-auto object-contain drop-shadow-[0_8px_24px_rgba(0,0,0,0.5)]" />
                </div>
            </div>

            <!-- Right Side: Frosted Glass Login Card (Solid Contrast) -->
            <div class="w-full max-w-[420px] lg:max-w-[390px] xl:max-w-[420px] flex-shrink-0 lg:translate-y-7 tall:lg:translate-y-8 transition-transform">
                <div class="relative backdrop-blur-2xl bg-slate-900/75 border border-white/25 rounded-2xl sm:rounded-[24px] tall:rounded-[28px] p-5 sm:p-6 tall:p-8 shadow-[0_25px_60px_rgba(0,0,0,0.6)] transition-all duration-300 hover:border-white/35" 
                     x-data="{ showPassword: false }">

                    <!-- Top Avatar Circle & Header -->
                    <div class="flex flex-col items-center text-center mb-3 sm:mb-4 tall:mb-6">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 tall:w-[56px] tall:h-[56px] rounded-full border-2 border-white/60 bg-white/10 flex items-center justify-center text-white mb-1.5 sm:mb-2 shadow-inner">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 tall:w-7 tall:h-7 text-white/95" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>

                        <h2 class="text-lg sm:text-xl tall:text-2xl font-bold text-white tracking-tight drop-shadow-sm">
                            Masuk ke Akun
                        </h2>
                        <p class="text-[11px] sm:text-xs tall:text-sm text-white/80 mt-0.5 sm:mt-1 font-normal drop-shadow-sm">
                            Silakan masukkan kredensial akun PanduBHP
                        </p>
                    </div>

                    <!-- Session Status & Error Alert -->
                    @if (session('status'))
                        <div class="mb-3 text-xs font-medium text-emerald-100 bg-emerald-950/70 p-2.5 sm:p-3 rounded-xl border border-emerald-400/40 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-3 text-xs font-medium text-red-100 bg-red-950/80 p-2.5 sm:p-3 rounded-xl border border-red-400/40 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-3 sm:space-y-3.5 tall:space-y-4">
                        @csrf

                        <!-- Username / Email Input -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-white/90 mb-1">Username / Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <input id="email" 
                                       name="email" 
                                       type="text" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username" 
                                       placeholder="Masukkan username atau email" 
                                       class="w-full pl-10 sm:pl-11 pr-4 py-2 sm:py-2.5 tall:py-3 bg-slate-800/80 hover:bg-slate-800 focus:bg-slate-900 text-white placeholder:text-slate-400 rounded-xl text-sm font-medium border border-white/20 focus:border-[#0066d6] focus:outline-none focus:ring-2 focus:ring-[#0066d6]/50 shadow-inner transition @error('email') border-red-400 ring-2 ring-red-400/40 @enderror" />
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-100 bg-red-950/70 py-1 px-2.5 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-xs font-medium text-white/90 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input id="password" 
                                       name="password" 
                                       :type="showPassword ? 'text' : 'password'" 
                                       required 
                                       autocomplete="current-password" 
                                       placeholder="Masukkan password" 
                                       class="w-full pl-10 sm:pl-11 pr-10 py-2 sm:py-2.5 tall:py-3 bg-slate-800/80 hover:bg-slate-800 focus:bg-slate-900 text-white placeholder:text-slate-400 rounded-xl text-sm font-medium border border-white/20 focus:border-[#0066d6] focus:outline-none focus:ring-2 focus:ring-[#0066d6]/50 shadow-inner transition @error('password') border-red-400 ring-2 ring-red-400/40 @enderror" />
                                
                                <!-- Show / Hide Password Button -->
                                <button type="button" 
                                        @click="showPassword = !showPassword" 
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white focus:outline-none cursor-pointer transition"
                                        tabindex="-1"
                                        aria-label="Toggle password visibility">
                                    <svg x-show="showPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="!showPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-100 bg-red-950/70 py-1 px-2.5 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between pt-0.5 text-xs text-white/90">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       name="remember" 
                                       class="w-4 h-4 rounded border-white/30 bg-slate-800 text-[#0066d6] focus:ring-[#0066d6] focus:ring-offset-0 cursor-pointer">
                                <span class="ml-2 drop-shadow-sm">{{ __('Ingat saya') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" 
                                   class="font-medium text-amber-300 hover:text-amber-200 transition underline-offset-2 hover:underline drop-shadow-sm">
                                    {{ __('Lupa Kata Sandi?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button (Masuk ->) -->
                        <div class="pt-1 sm:pt-1.5 tall:pt-2">
                            <button type="submit" 
                                    class="w-full py-2 sm:py-2.5 tall:py-3 px-6 bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white font-semibold text-sm sm:text-sm tall:text-base rounded-xl shadow-lg shadow-blue-900/40 flex items-center justify-center gap-2 transition duration-200 ease-in-out cursor-pointer group">
                                <span>Masuk</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <div class="pt-1 sm:pt-1.5 text-center text-xs text-white/80">
                                {{ __('Belum memiliki akun?') }}
                                <a href="{{ route('register') }}" class="font-bold text-amber-300 hover:text-amber-200 hover:underline ml-1 transition">
                                    {{ __('Daftar Akun Baru') }}
                                </a>
                            </div>
                        @endif

                        <!-- Footer Card Divider & Subtext -->
                        <div class="pt-2 mt-2 sm:pt-2.5 sm:mt-2.5 tall:pt-3.5 tall:mt-3.5 border-t border-white/15 text-center">
                            <p class="text-[10px] sm:text-[11px] tall:text-xs text-white/70 font-normal tracking-wide drop-shadow-sm">
                                Balai Harta Peninggalan Surabaya
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Web Area: Official Accreditation & Endorsement Logos (RAW ASSET PANDU BHP-2) -->
        <div class="relative z-10 w-full max-w-4xl mx-auto mt-2 sm:mt-3 tall:mt-6 pt-0.5 pb-1 flex flex-col items-center select-none">
            <div class="inline-flex items-center justify-center px-4 sm:px-6 tall:px-8 py-1.5 sm:py-2 tall:py-3 rounded-xl sm:rounded-2xl tall:rounded-full bg-slate-900/75 backdrop-blur-md border border-white/20 shadow-[0_8px_24px_rgba(0,0,0,0.5)]">
                <img src="{{ asset('images/footer-logos-bhp.png') }}" 
                     alt="Kementerian Hukum RI, BerAKHLAK, Bangga Melayani Bangsa, Wilayah Bebas dari Korupsi (WBK), ISO" 
                     class="h-6 sm:h-7 lg:h-7 tall:lg:h-11 w-auto max-w-full object-contain drop-shadow" />
            </div>
            <p class="text-[9px] sm:text-[10px] tall:text-[11px] text-white/60 font-normal tracking-wide mt-1 sm:mt-1.5 tall:mt-2 drop-shadow-sm text-center">
                &copy; {{ date('Y') }} Balai Harta Peninggalan Surabaya &bull; Kementerian Hukum Republik Indonesia
            </p>
        </div>
    </div>
</x-guest-layout>
