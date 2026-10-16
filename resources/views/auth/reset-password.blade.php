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

            <!-- Right Side: Frosted Glass Reset Password Card -->
            <div class="w-full max-w-[460px] flex-shrink-0">
                <div class="relative backdrop-blur-2xl bg-white/[0.18] border border-white/40 rounded-2xl sm:rounded-[28px] p-5 sm:p-8 shadow-[0_20px_60px_rgba(0,0,0,0.4)] transition-all duration-300 hover:border-white/50"
                     x-data="{ showPass: false, showPassConfirm: false }">

                    <!-- Top Icon & Header -->
                    <div class="flex flex-col items-center text-center mb-4 sm:mb-6">
                        <div class="w-14 h-14 sm:w-[64px] sm:h-[64px] rounded-full border-2 border-amber-300/80 bg-amber-400/20 flex items-center justify-center text-amber-300 mb-2 sm:mb-3 shadow-inner">
                            <!-- Shield Check / Padlock Icon -->
                            <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>

                        <h2 class="text-xl sm:text-[24px] font-bold text-white tracking-tight drop-shadow-sm">
                            Atur Ulang Kata Sandi
                        </h2>
                        <p class="text-xs sm:text-sm text-white/85 mt-1 font-normal leading-relaxed drop-shadow-sm">
                            Silakan masukkan kata sandi baru untuk akun PanduBHP Anda
                        </p>
                    </div>

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.store') }}" class="space-y-3.5 sm:space-y-4">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-white/90 mb-1 drop-shadow-sm">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <!-- Mail Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email', $request->email) }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username" 
                                       placeholder="email@example.com" 
                                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-[#e2e8f0]/95 hover:bg-white focus:bg-white text-slate-900 placeholder:text-slate-500 rounded-xl text-base sm:text-sm font-medium border border-white/40 focus:outline-none focus:ring-2 focus:ring-[#0066d6] shadow-sm transition @error('email') border-red-400 ring-2 ring-red-400/40 @enderror" />
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-100 bg-red-950/70 py-1.5 px-3 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-xs font-medium text-white/90 mb-1 drop-shadow-sm">
                                Kata Sandi Baru
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <!-- Padlock Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input id="password" 
                                       name="password" 
                                       :type="showPass ? 'text' : 'password'" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="Minimal 8 karakter" 
                                       class="w-full pl-11 pr-11 py-2.5 sm:py-3 bg-[#e2e8f0]/95 hover:bg-white focus:bg-white text-slate-900 placeholder:text-slate-500 rounded-xl text-base sm:text-sm font-medium border border-white/40 focus:outline-none focus:ring-2 focus:ring-[#0066d6] shadow-sm transition @error('password') border-red-400 ring-2 ring-red-400/40 @enderror" />
                                
                                <button type="button" 
                                        @click="showPass = !showPass" 
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-700 focus:outline-none cursor-pointer"
                                        tabindex="-1"
                                        aria-label="Toggle password visibility">
                                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
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

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-white/90 mb-1 drop-shadow-sm">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <!-- Shield Check Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </div>
                                <input id="password_confirmation" 
                                       name="password_confirmation" 
                                       :type="showPassConfirm ? 'text' : 'password'" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="Ulangi kata sandi baru" 
                                       class="w-full pl-11 pr-11 py-2.5 sm:py-3 bg-[#e2e8f0]/95 hover:bg-white focus:bg-white text-slate-900 placeholder:text-slate-500 rounded-xl text-base sm:text-sm font-medium border border-white/40 focus:outline-none focus:ring-2 focus:ring-[#0066d6] shadow-sm transition @error('password_confirmation') border-red-400 ring-2 ring-red-400/40 @enderror" />
                                
                                <button type="button" 
                                        @click="showPassConfirm = !showPassConfirm" 
                                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-700 focus:outline-none cursor-pointer"
                                        tabindex="-1"
                                        aria-label="Toggle password confirmation visibility">
                                    <svg x-show="showPassConfirm" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="!showPassConfirm" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1.5 text-xs text-red-100 bg-red-950/70 py-1.5 px-3 rounded-lg border border-red-400/40 font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full py-2.5 sm:py-3 px-6 bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white font-semibold text-sm sm:text-base rounded-xl shadow-lg shadow-blue-900/30 flex items-center justify-center gap-2 transition duration-200 ease-in-out cursor-pointer group">
                                <span>Simpan Kata Sandi Baru</span>
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
                                <span>Batal & Kembali ke Halaman Masuk</span>
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
