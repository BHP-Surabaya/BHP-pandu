<x-guest-layout :full-bleed="true">
    <div class="relative min-h-screen w-full flex items-center justify-center overflow-x-hidden bg-slate-900">
        <!-- Background Image of BHP Surabaya Building -->
        <div class="absolute inset-0 bg-cover bg-center sm:bg-[center_top_20%] bg-no-repeat transition-all duration-700 scale-100" 
             style="background-image: url('{{ asset('images/bg-gedung-bhp-clean.jpg') }}');">
        </div>

        <!-- Subtle Dark Overlay for contrast and readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/60 via-slate-900/30 to-slate-950/40"></div>

        <!-- Main Content Area -->
        <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-10 sm:px-10 lg:px-12 flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-16 min-h-screen">
            
            <!-- Left Side: Institutional Branding & Motto -->
            <div class="w-full lg:max-w-xl text-white flex flex-col items-start select-none pt-8 lg:pt-0">
                
                <!-- Logo & Brand Header -->
                <div class="flex items-center gap-4 sm:gap-5 mb-3 sm:mb-4">
                    <!-- BHP Pillars Building Icon (Exact Vector Replica) -->
                    <div class="flex-shrink-0 drop-shadow-[0_4px_10px_rgba(0,0,0,0.3)]">
                        <svg class="w-14 h-14 sm:w-16 sm:h-16 lg:w-[72px] lg:h-[72px]" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight drop-shadow-[0_4px_12px_rgba(0,0,0,0.35)] leading-none">
                        <span class="text-white">Pandu</span><span class="text-[#FBBF24]">BHP</span>
                    </h1>
                </div>

                <!-- Subtitle / Application Description -->
                <p class="text-base sm:text-lg lg:text-[21px] font-medium text-white/95 leading-snug drop-shadow-[0_2px_8px_rgba(0,0,0,0.3)] mt-1">
                    Sistem Pendukung Administrasi Terpadu<br class="hidden sm:inline" />
                    Balai Harta Peninggalan
                </p>

                <!-- Yellow Accent Line -->
                <div class="w-14 h-1 sm:h-[4px] bg-[#FBBF24] rounded-full my-5 sm:my-6 shadow-[0_2px_6px_rgba(0,0,0,0.2)]"></div>

                <!-- Motto -->
                <p class="text-sm sm:text-base text-white/90 font-normal leading-relaxed drop-shadow-[0_2px_6px_rgba(0,0,0,0.3)]">
                    Melayani dengan Integritas,<br />
                    Menuju Kepastian Hukum
                </p>
            </div>

            <!-- Right Side: Frosted Glass Login Card -->
            <div class="w-full max-w-[430px] flex-shrink-0 pb-8 lg:pb-0">
                <div class="relative backdrop-blur-xl bg-white/20 sm:bg-white/[0.18] border border-white/40 rounded-[28px] p-7 sm:p-9 shadow-[0_20px_60px_rgba(0,0,0,0.35)] transition-all duration-300 hover:border-white/50" 
                     x-data="{ showPassword: false }">

                    <!-- Top Avatar Circle & Header -->
                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="w-16 h-16 sm:w-[68px] sm:h-[68px] rounded-full border-2 border-white/70 bg-white/10 flex items-center justify-center text-white mb-3 shadow-inner">
                            <!-- Circular User Outline Icon -->
                            <svg class="w-9 h-9 sm:w-10 sm:h-10 text-white/95" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>

                        <h2 class="text-2xl sm:text-[28px] font-bold text-white tracking-tight drop-shadow-sm">
                            Login
                        </h2>
                        <p class="text-xs sm:text-sm text-white/85 mt-1 font-normal drop-shadow-sm">
                            Masuk untuk mengakses aplikasi PanduBHP
                        </p>
                    </div>

                    <!-- Session Status Alert -->
                    @if (session('status'))
                        <div class="mb-4 text-xs font-medium text-emerald-100 bg-emerald-950/60 p-3 rounded-xl border border-emerald-400/40">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Username / Email Input -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <!-- User icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
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
                                       placeholder="Username" 
                                       class="w-full pl-11 pr-4 py-3 bg-[#e2e8f0]/95 hover:bg-white focus:bg-white text-slate-900 placeholder:text-slate-500 rounded-xl text-sm font-medium border border-white/40 focus:outline-none focus:ring-2 focus:ring-[#0066d6] shadow-sm transition @error('email') border-red-400 ring-2 ring-red-400/40 @enderror" />
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-100 bg-red-950/70 py-1.5 px-3 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <!-- Padlock icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input id="password" 
                                       name="password" 
                                       :type="showPassword ? 'text' : 'password'" 
                                       required 
                                       autocomplete="current-password" 
                                       placeholder="Password" 
                                       class="w-full pl-11 pr-11 py-3 bg-[#e2e8f0]/95 hover:bg-white focus:bg-white text-slate-900 placeholder:text-slate-500 rounded-xl text-sm font-medium border border-white/40 focus:outline-none focus:ring-2 focus:ring-[#0066d6] shadow-sm transition @error('password') border-red-400 ring-2 ring-red-400/40 @enderror" />
                                
                                <!-- Show / Hide Password Button -->
                                <button type="button" 
                                        @click="showPassword = !showPassword" 
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-700 focus:outline-none cursor-pointer"
                                        tabindex="-1"
                                        aria-label="Toggle password visibility">
                                    <!-- Eye icon (visible password) -->
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <!-- Eye-slash icon (hidden password) -->
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-100 bg-red-950/70 py-1.5 px-3 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between pt-1 text-xs text-white/90">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       name="remember" 
                                       class="w-4 h-4 rounded border-white/40 bg-white/20 text-[#0066d6] focus:ring-[#0066d6] focus:ring-offset-0 cursor-pointer">
                                <span class="ml-2 drop-shadow-sm">{{ __('Ingat saya') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" 
                                   class="font-medium hover:text-amber-300 transition underline-offset-2 hover:underline drop-shadow-sm">
                                    {{ __('Lupa Kata Sandi?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button (Masuk ->) -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full py-3 px-6 bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white font-semibold text-sm sm:text-base rounded-xl shadow-lg shadow-blue-900/30 flex items-center justify-center gap-2 transition duration-200 ease-in-out cursor-pointer group">
                                <span>Masuk</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <div class="pt-2 text-center text-xs text-white/85">
                                {{ __('Belum memiliki akun?') }}
                                <a href="{{ route('register') }}" class="font-bold text-amber-300 hover:text-amber-200 hover:underline ml-1 transition">
                                    {{ __('Daftar Akun Baru') }}
                                </a>
                            </div>
                        @endif

                        <!-- Footer Card Divider & Subtext -->
                        <div class="pt-4 mt-4 border-t border-white/25 text-center">
                            <p class="text-[11px] sm:text-xs text-white/75 font-normal tracking-wide drop-shadow-sm">
                                Balai Harta Peninggalan dan Kurator Negara Surabaya
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
