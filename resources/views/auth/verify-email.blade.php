<x-guest-layout :full-bleed="true">
    <div class="relative min-h-screen w-full flex items-center justify-center overflow-x-hidden bg-slate-900 py-6 sm:py-10 px-4 sm:px-8">
        <!-- Background Image of BHP Surabaya Building -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-all duration-700 scale-100" 
             style="background-image: url('{{ asset('images/bg-gedung-bhp-clean.jpg') }}');">
        </div>

        <!-- Dark Overlay for contrast and readability -->
        <div class="absolute inset-0 bg-gradient-to-b lg:bg-gradient-to-r from-slate-950/85 via-slate-900/60 to-slate-950/85 lg:from-slate-950/60 lg:via-slate-900/30 lg:to-slate-950/40"></div>

        <!-- Main Content Area -->
        <div class="relative z-10 w-full max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-6 sm:gap-10 lg:gap-16">
            
            <!-- Left Side: Institutional Branding & Motto -->
            <div class="w-full lg:max-w-xl text-white flex flex-col items-center text-center lg:items-start lg:text-left select-none">
                
                <!-- Logo & Brand Header -->
                <div class="mb-2 sm:mb-3">
                    <h1 class="sr-only">PanduBHP - Balai Harta Peninggalan Surabaya</h1>
                    <img src="{{ asset('images/logo-pandubhp-clean.png') }}" 
                         alt="PanduBHP" 
                         class="h-12 sm:h-16 lg:h-[76px] w-auto object-contain drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)]" />
                </div>

                <!-- Official Tagline (PASTI SETIA) -->
                <div class="w-full max-w-[380px] sm:max-w-[460px] lg:max-w-[500px]">
                    <img src="{{ asset('images/tagline-pasti-setia.png') }}" 
                         alt="PASTI SETIA - Profesional Akuntabel Sinergi Transparan Inovatif | Santun Empati Tanggap Integritas Amanah" 
                         class="w-full h-auto object-contain drop-shadow-[0_6px_20px_rgba(0,0,0,0.35)]" />
                </div>
            </div>

            <!-- Right Side: Frosted Glass Verification Card -->
            <div class="w-full max-w-[460px] flex-shrink-0">
                <div class="relative backdrop-blur-2xl bg-white/[0.18] border border-white/40 rounded-2xl sm:rounded-[28px] p-5 sm:p-8 shadow-[0_20px_60px_rgba(0,0,0,0.4)] transition-all duration-300 hover:border-white/50">

                    <!-- Top Icon & Header -->
                    <div class="flex flex-col items-center text-center mb-4 sm:mb-6">
                        <div class="w-14 h-14 sm:w-[68px] sm:h-[68px] rounded-full border-2 border-amber-300/80 bg-amber-400/20 flex items-center justify-center text-amber-300 mb-2 sm:mb-3 shadow-inner">
                            <!-- Mail Check Icon -->
                            <svg class="w-7 h-7 sm:w-9 sm:h-9" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>

                        <h2 class="text-xl sm:text-[24px] font-bold text-white tracking-tight drop-shadow-sm">
                            Aktivasi Akun Anda
                        </h2>
                        <p class="text-xs sm:text-sm text-white/85 mt-1 font-normal leading-relaxed drop-shadow-sm">
                            Satu langkah lagi sebelum Anda dapat mengakses seluruh layanan PanduBHP
                        </p>
                    </div>

                    <!-- Session Status Alert -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 text-xs font-medium text-emerald-100 bg-emerald-950/60 p-3.5 rounded-xl border border-emerald-400/40 flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tautan aktivasi baru telah berhasil dikirimkan ke alamat email Anda. Silakan periksa kotak masuk (inbox) atau folder spam.</span>
                        </div>
                    @endif

                    <!-- User Detail Box -->
                    <div class="p-3.5 sm:p-4 rounded-xl bg-white/10 border border-white/20 text-xs sm:text-sm text-white/90 space-y-2 mb-5">
                        <p class="text-white/80">
                            Kami telah mengirimkan tautan aktivasi akun ke alamat email terdaftar:
                        </p>
                        <div class="font-mono text-sm font-semibold text-amber-300 bg-black/30 px-3 py-1.5 rounded-lg border border-white/15 break-all flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-white/70 leading-relaxed pt-1">
                            Silakan buka email tersebut dan klik tautan untuk mengaktifkan akun. Tautan berlaku selama 60 menit.
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full py-2.5 sm:py-3 px-6 bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white font-semibold text-sm sm:text-base rounded-xl shadow-lg shadow-blue-900/30 flex items-center justify-center gap-2 transition duration-200 ease-in-out cursor-pointer group">
                                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                <span>Kirim Ulang Email Aktivasi</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="text-center">
                            @csrf
                            <button type="submit" class="text-xs text-white/75 hover:text-white underline underline-offset-4 transition">
                                Keluar dan gunakan akun lain
                            </button>
                        </form>
                    </div>

                    <!-- Footer Card Divider & Subtext -->
                    <div class="pt-3 mt-4 sm:pt-4 sm:mt-5 border-t border-white/20 text-center">
                        <p class="text-[11px] sm:text-xs text-white/75 font-normal tracking-wide drop-shadow-sm">
                            Balai Harta Peninggalan Surabaya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
