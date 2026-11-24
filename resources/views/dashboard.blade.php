<x-portal-layout>
    <x-slot name="title">
        Layanan Terpadu - Balai Harta Peninggalan
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8" 
         x-data="{ 
             search: '', 
             activeTab: 'all',
             matches(keywords, category) {
                 const query = this.search.trim().toLowerCase();
                 const matchesSearch = !query || keywords.toLowerCase().includes(query);
                 const matchesCategory = this.activeTab === 'all' || this.activeTab === category;
                 return matchesSearch && matchesCategory;
             }
         }">
        
        @if (session('error'))
            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 text-sm flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('error') }}
                </div>
                <button type="button" @click="show = false" class="text-red-700 hover:text-red-900 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if (session('status'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('status') }}
                </div>
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <!-- ================= HERO BANNER EKSEKUTIF (DESAIN RESMI SURABAYA SKYLINE & BATIK) ================= -->
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-[#082455] px-6 py-5 sm:px-8 sm:py-6 lg:py-7 text-white shadow-xl border border-blue-800/40">
            <!-- Background Image Artwork Surabaya Skyline & Batik Motif (RAW ASSET PANDU BHP-5) -->
            <div class="absolute inset-0 bg-cover bg-right-bottom sm:bg-right bg-no-repeat pointer-events-none" 
                 style="background-image: url('{{ asset('images/bg-dashboard-hero.png') }}');">
            </div>

            <!-- Soft Mobile Vignette for Maximum Text Contrast on Small Screens -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#082455]/95 via-[#082455]/85 to-transparent sm:hidden pointer-events-none"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 sm:gap-6">
                <div class="space-y-3 sm:space-y-4 max-w-xl">
                    <div class="space-y-0.5">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white tracking-tight leading-tight drop-shadow-sm">
                            Selamat Datang, {{ Auth::user()->name ?? 'Pemohon' }}
                        </h1>
                        <p class="text-xs sm:text-sm font-medium text-blue-200/90 tracking-wide">
                            {{ Auth::user()->pekerjaan && strcasecmp(Auth::user()->pekerjaan, 'perorangan') !== 0 ? Auth::user()->pekerjaan : (Auth::user()->status_akun === 'notaris' ? 'Notaris' : (Auth::user()->status_akun === 'pengacara' ? 'Pengacara / Advokat' : (Auth::user()->status_akun_label ?? 'Pemohon'))) }}
                        </p>
                    </div>

                    <!-- Shortcut Action: Minimalist Link Histori Permohonan -->
                    <div class="pt-1">
                        <a href="{{ route('permohonan.index') }}" 
                           class="group inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-blue-200 hover:text-white transition-colors">
                            <span>Lihat Histori Permohonan</span>
                            @php
                                $userCount = Auth::user()?->permohonans()->count() ?? 0;
                            @endphp
                            @if ($userCount > 0)
                                <span class="px-2 py-0.5 rounded-full bg-blue-500/25 border border-blue-400/30 text-white text-[11px] font-bold group-hover:bg-blue-500/40 transition-colors">
                                    {{ $userCount }}
                                </span>
                            @endif
                            <svg class="w-4 h-4 text-blue-300 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Penanda Tanggal & Waktu Resmi di Langit Kanan Atas Banner -->
                <div class="sm:text-right shrink-0 pt-1 pointer-events-none"
                     x-data="{ 
                         date: '', 
                         time: '',
                         update() {
                             const now = new Date();
                             this.date = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                             this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                         }
                     }"
                     x-init="update(); setInterval(() => update(), 1000)">
                    <div class="text-[11px] sm:text-xs font-semibold text-blue-200/90 tracking-wide" x-text="date">
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                    </div>
                    <div class="text-base sm:text-lg font-bold text-white font-mono tabular-nums tracking-tight mt-0.5" x-text="time">
                        {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()?->isVerifikasiPending())
            <!-- Banner Status Akun Perorangan Menunggu Verifikasi -->
            <div class="p-4 sm:p-5 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/90 rounded-2xl flex items-start gap-3.5 shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1 space-y-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-sm font-bold text-amber-950">Status Akun Saat Ini: Akun Perorangan</h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-200/70 text-amber-900 uppercase tracking-wider">
                            Menunggu Verifikasi Master Admin
                        </span>
                    </div>
                    <p class="text-xs text-amber-900/90 leading-relaxed">
                        Anda mendaftar sebagai <strong>{{ ucfirst(Auth::user()->jenis_akun) }}</strong>. Selama berkas legalitas belum diverifikasi oleh Master Admin, akun Anda tetap berstatus dan dapat digunakan sebagai <strong>Akun Perorangan</strong>.
                    </p>
                </div>
                <a href="{{ route('profile.edit') }}" class="shrink-0 px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs rounded-lg transition shadow-xs">
                    Lihat Berkas
                </a>
            </div>
        @endif

        <!-- ================= PENCARIAN CEPAT & FILTER KATEGORI ================= -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-extrabold text-[#071d40] tracking-tight">
                        Pilih Layanan Yang Ingin Anda Ajukan
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        Layanan terpadu Balai Harta Peninggalan dan Kurator Negara Surabaya
                    </p>
                </div>

                <!-- Live Search Box -->
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" 
                           x-model="search" 
                           placeholder="Cari layanan (wasiat, waris, wali...)" 
                           class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1d68d8] focus:bg-white transition" />
                    <button x-show="search.length > 0" 
                            @click="search = ''" 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

        <!-- Tab Filter Kategori & Search Bar -->
        @php
            $canNotaris = Auth::user()?->canAccessNotarisServices() ?? false;
            $canPengacara = Auth::user()?->canAccessPengacaraServices() ?? false;
            $wasiatCount = 1 + ($canNotaris ? 2 : 0);
            $hartaCount = 3 + ($canPengacara ? 1 : 0);
            $totalServices = 2 + $wasiatCount + $hartaCount;
        @endphp
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold no-scrollbar">
                <button type="button" 
                        @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'bg-[#0b2e66] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-lg transition shrink-0">
                    Semua Layanan ({{ $totalServices }})
                </button>
                <button type="button" 
                        @click="activeTab = 'wasiat'" 
                        :class="activeTab === 'wasiat' ? 'bg-[#0b2e66] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-lg transition shrink-0">
                    Wasiat &amp; Waris ({{ $wasiatCount }})
                </button>
                <button type="button" 
                        @click="activeTab = 'perlindungan'" 
                        :class="activeTab === 'perlindungan' ? 'bg-[#0b2e66] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-lg transition shrink-0">
                    Perlindungan Hukum (2)
                </button>
                <button type="button" 
                        @click="activeTab = 'harta'" 
                        :class="activeTab === 'harta' ? 'bg-[#0b2e66] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-lg transition shrink-0">
                    Pengurusan Harta &amp; Kepailitan ({{ $hartaCount }})
                </button>
            </div>
        </div>

        <!-- ================= KATALOG LAYANAN ================= -->
        <div class="flex flex-wrap justify-center gap-3.5 sm:gap-4">
            
            {{-- 1. Pembukaan Wasiat (LAYANAN KHUSUS NOTARIS) --}}
            @if ($canNotaris)
            <div x-show="matches('Pembukaan Wasiat akta wasiat tertutup terbuka ahli waris notaris', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                
                <div class="flex flex-col items-center w-full">
                    <!-- Header Kartu: Ikon di Tengah -->
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-pembukaan-wasiat.png') }}" 
                             alt="Pembukaan Wasiat" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Pembukaan Wasiat
                        </h3>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('permohonan.create') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            {{-- 2. Pendaftaran Wasiat (LAYANAN KHUSUS NOTARIS) --}}
            @if ($canNotaris)
            <div x-show="matches('Pendaftaran Wasiat register akta notaris lapor', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-pendaftaran-wasiat.png') }}" 
                             alt="Pendaftaran Wasiat" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Pendaftaran Wasiat
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'pendaftaran-wasiat') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            <!-- 3. Perwalian -->
            <div x-show="matches('Perwalian anak belum dewasa harta waris wali', 'perlindungan')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-perwalian.png') }}" 
                             alt="Perwalian" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Perwalian
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'perwalian') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 4. Pengampuan -->
            <div x-show="matches('Pengampuan curatele kurator perlindungan dewasa gangguan', 'perlindungan')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-pengampuan.png') }}" 
                             alt="Pengampuan" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Pengampuan
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'pengampuan') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 5. SKHW (Surat Keterangan Hak Waris) -->
            <div x-show="matches('SKHW Surat Keterangan Hak Waris warisan eropa timur asing', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-skhw.png') }}" 
                             alt="SKHW" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            SKHW
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'skhw') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 6. Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir -->
            <div x-show="matches('Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir afwezigheid ghaib hilang aset', 'harta')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-harta-pemilik-tidak-hadir.png') }}" 
                             alt="Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'harta-pemilik-tidak-hadir') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 7. Layanan Harta Peninggalan Yang Tidak Terurus -->
            <div x-show="matches('Layanan Harta Peninggalan Yang Tidak Terurus onbeheerde boedel warisan terlantar', 'harta')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-harta-tidak-terurus.png') }}" 
                             alt="Layanan Harta Peninggalan Yang Tidak Terurus" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Layanan Harta Peninggalan Yang Tidak Terurus
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'harta-tidak-terurus') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 8. Layanan Uang Pihak Ketiga -->
            <div x-show="matches('Layanan Uang Pihak Ketiga konsinyasi penitipan ganti rugi kas', 'harta')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-uang-pihak-ketiga.png') }}" 
                             alt="Layanan Uang Pihak Ketiga" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Layanan Uang Pihak Ketiga
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'uang-pihak-ketiga') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- 9. Layanan Kepailitan (LAYANAN KHUSUS PENGACARA) --}}
            @if ($canPengacara)
            <div x-show="matches('Layanan Kepailitan kurator negara pengadilan niaga pailit insolvensi', 'harta')" 
                 x-transition
                 class="group bg-white rounded-xl p-3.5 sm:p-4 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between items-center text-center w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-0.7rem)] lg:w-[calc(20%-0.85rem)] shrink-0">
                <div class="flex flex-col items-center w-full">
                    <div class="mb-2 sm:mb-2.5 flex justify-center">
                        <img src="{{ asset('images/layanan/layanan-kepailitan.png') }}" 
                             alt="Layanan Kepailitan" 
                             class="w-12 h-12 sm:w-14 sm:h-14 object-contain group-hover:scale-105 transition-transform" />
                    </div>

                    <div class="min-h-[2.75rem] flex items-center justify-center w-full">
                        <h3 class="text-xs sm:text-sm font-bold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug line-clamp-2 text-center">
                            Layanan Kepailitan
                        </h3>
                    </div>
                </div>

                <div class="pt-2.5 sm:pt-3 mt-2 sm:mt-2.5 border-t border-slate-100 w-full">
                    <a href="{{ route('layanan.pengembangan', 'kepailitan') }}" 
                       class="w-full py-2 px-3 rounded-lg bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

        </div>

        <!-- Siluet Panorama Memanjang Surabaya & BHP (Jembatan Suramadu, Tugu Pahlawan, Skyline & Gedung BHP) -->
        <div class="pointer-events-none select-none -mx-4 sm:-mx-6 lg:-mx-8 -mb-6 sm:-mb-8 pt-4 overflow-hidden">
            <img src="{{ asset('images/panorama-skyline-surabaya-bhp.svg') }}" 
                 alt="Panorama Skyline Surabaya &amp; Balai Harta Peninggalan" 
                 class="w-full h-auto max-h-36 sm:max-h-48 object-cover object-bottom" />
        </div>

    </div>
</x-portal-layout>
