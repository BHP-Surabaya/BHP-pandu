<x-guest-layout>
    <div class="w-full max-w-[430px] bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.07)] border border-purple-100/70 overflow-hidden">
        <!-- Header with Lavender tint -->
        <div class="bg-[#f7f4fb] pt-8 pb-7 px-6 text-center border-b border-purple-50/60">
            <!-- Logo Pengayoman -->
            <div class="inline-flex items-center justify-center">
                <img src="{{ asset('images/pengayoman.svg') }}" 
                     alt="Logo Kemenkumham Pengayoman" 
                     class="w-16 h-16 sm:w-[68px] sm:h-[68px] rounded-xl object-contain drop-shadow-sm" />
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-[26px] font-bold text-[#1f0947] tracking-tight mt-4">
                BHP Portal
            </h1>

            <!-- Subtitle -->
            <p class="text-sm sm:text-[15px] font-semibold text-[#2f4370] mt-1.5">
                Balai Harta Peninggalan Surabaya
            </p>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-8" x-data="{ showPassword: false }">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email atau Username -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Email atau Username
                    </label>
                    <div class="relative rounded-lg">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <!-- User outline icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
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
                               placeholder="Masukkan email atau username"
                               class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#230352]/20 focus:border-[#230352] transition @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror" />
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kata Sandi -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative rounded-lg">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <!-- Lock outline icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input id="password" 
                               name="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               required 
                               autocomplete="current-password" 
                               placeholder="Masukkan kata sandi"
                               class="w-full pl-11 pr-11 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#230352]/20 focus:border-[#230352] transition @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror" />
                        
                        <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer"
                                tabindex="-1"
                                aria-label="Toggle kata sandi">
                            <!-- Eye icon (visible password) -->
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <!-- Eye slash icon (hidden password) -->
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                        <input id="remember_me" 
                               type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 rounded border-gray-300 text-[#230352] focus:ring-[#230352] focus:ring-offset-0 cursor-pointer transition">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm font-semibold text-[#230352] hover:text-[#3b087a] hover:underline transition">
                            {{ __('Lupa Kata Sandi?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-[#230352] hover:bg-[#1a013e] active:bg-[#12002d] text-white font-semibold text-sm rounded-lg shadow-sm flex items-center justify-center gap-2 transition duration-150 ease-in-out cursor-pointer">
                        <span>{{ __('Masuk') }}</span>
                        <!-- Right arrow into bracket icon (->]) -->
                        <svg class="w-4 h-4 stroke-[2.4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h11m-3-4l4 4-4 4M17 6h2a1 1 0 011 1v10a1 1 0 01-1 1h-2" />
                        </svg>
                    </button>
                </div>

                <!-- Register text -->
                @if (Route::has('register'))
                    <div class="pt-3 text-center text-sm text-gray-600">
                        {{ __('Belum memiliki akun?') }}
                        <a href="{{ route('register') }}" class="font-bold text-[#230352] hover:text-[#3b087a] hover:underline ml-1 transition">
                            {{ __('Daftar Akun Baru') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Footer strip -->
        <div class="bg-[#f7f4fb] border-t border-[#ede6f6] py-3.5 px-4 text-center flex items-center justify-center gap-2">
            <!-- Yellow shield icon -->
            <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            <span class="text-xs text-gray-500 font-medium">
                Portal Resmi Balai Harta Peninggalan
            </span>
        </div>
    </div>
</x-guest-layout>
