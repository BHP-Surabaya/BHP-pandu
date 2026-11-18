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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- 1. Pembukaan Wasiat (LAYANAN KHUSUS NOTARIS) --}}
            @if ($canNotaris)
            <div x-show="matches('Pembukaan Wasiat akta wasiat tertutup terbuka ahli waris notaris', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                
                <div>
                    <!-- Header Kartu: Ikon -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1d68d8] border border-blue-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Document + Seal -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 6h20l10 10v26H10V6z" fill="#f0f7ff" />
                                <path d="M30 6v10h10" />
                                <path d="M16 18h8M16 24h16M16 30h12" />
                                <circle cx="36" cy="34" r="6" fill="#1d68d8" stroke="#1d68d8" />
                                <path d="M34 31h4l-4 6h4" stroke="white" stroke-width="1.8" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Pembukaan Wasiat
                    </h3>
                </div>

                <!-- CTA Button -->
                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('permohonan.create') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Document + Pen / Medal -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 6h20l10 10v26H10V6z" fill="#f0f9ff" />
                                <path d="M30 6v10h10" />
                                <path d="M16 20h10M16 26h8" />
                                <circle cx="35" cy="35" r="6" fill="#0284c7" stroke="#0284c7" />
                                <path d="M33 35l1.5 1.5 3-3" stroke="white" stroke-width="1.8" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Pendaftaran Wasiat
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'pendaftaran-wasiat') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

            <!-- 3. Perwalian -->
            <div x-show="matches('Perwalian anak belum dewasa harta waris wali', 'perlindungan')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Guardian & Child Avatar -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="20" cy="16" r="5" fill="#059669" stroke="#059669" />
                                <path d="M11 36c0-5.5 4-9 9-9s9 3.5 9 9" fill="#059669" stroke="#059669" />
                                <circle cx="34" cy="24" r="3.5" fill="#065f46" stroke="#065f46" />
                                <path d="M29 38c0-3.5 2.5-6 6-6s6 2.5 6 6" fill="#065f46" stroke="#065f46" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Perwalian
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'perwalian') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 4. Pengampuan -->
            <div x-show="matches('Pengampuan curatele kurator perlindungan dewasa gangguan', 'perlindungan')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 border border-teal-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Person + Shield -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="20" cy="18" r="5" fill="#0d9488" stroke="#0d9488" />
                                <path d="M11 38c0-5.5 4-9 9-9h4" stroke="#0d9488" />
                                <path d="M34 24l7 3v6c0 5-7 9-7 9s-7-4-7-9v-6l7-3z" fill="#0d9488" stroke="#0d9488" />
                                <circle cx="34" cy="31" r="1.5" fill="white" stroke="white" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Pengampuan
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'pengampuan') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 5. SKHW (Surat Keterangan Hak Waris) -->
            <div x-show="matches('SKHW Surat Keterangan Hak Waris warisan eropa timur asing', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Certificate + House Emblem -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="10" y="8" width="28" height="32" rx="3" fill="#fffbeb" stroke="#d97706" />
                                <path d="M18 24l6-5 6 5v6H18v-6z" fill="#d97706" stroke="#d97706" />
                                <circle cx="32" cy="34" r="5" fill="#d97706" stroke="#d97706" />
                                <path d="M30 38l2-1 2 1v-3h-4v3z" fill="#d97706" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        SKHW
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'skhw') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 6. Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir -->
            <div x-show="matches('Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir afwezigheid ghaib hilang aset', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- House + Search / Unknown -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22l12-10 12 10v14H12V22z" fill="#eef2ff" stroke="#4f46e5" />
                                <circle cx="32" cy="30" r="6" fill="white" stroke="#312e81" stroke-width="2.5" />
                                <path d="M36 34l6 6" stroke="#312e81" stroke-width="2.5" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'harta-pemilik-tidak-hadir') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 7. Layanan Harta Peninggalan Yang Tidak Terurus -->
            <div x-show="matches('Layanan Harta Peninggalan Yang Tidak Terurus onbeheerde boedel warisan terlantar', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- House on Caring Hands -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 18l8-7 8 7v10H16V18z" fill="#eff6ff" stroke="#1d4ed8" />
                                <path d="M10 32c4 4 10 5 14 5s10-1 14-5M12 36l12 3 12-3" stroke="#1e3a8a" stroke-width="2.2" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Layanan Harta Peninggalan Yang Tidak Terurus
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'harta-tidak-terurus') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 8. Layanan Uang Pihak Ketiga -->
            <div x-show="matches('Layanan Uang Pihak Ketiga konsinyasi penitipan ganti rugi kas', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-700 border border-cyan-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Coin Stack + Currency -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <ellipse cx="20" cy="14" rx="10" ry="4" fill="#ecfeff" stroke="#0891b2" />
                                <path d="M10 14v6c0 2.2 4.5 4 10 4s10-1.8 10-4v-6" stroke="#0891b2" />
                                <path d="M10 20v6c0 2.2 4.5 4 10 4s10-1.8 10-4v-6" stroke="#0891b2" />
                                <path d="M10 26v6c0 2.2 4.5 4 10 4s10-1.8 10-4v-6" stroke="#0891b2" />
                                <circle cx="34" cy="32" r="7" fill="#f59e0b" stroke="#d97706" />
                                <text x="30" y="35" fill="white" font-size="7" font-weight="bold" font-family="sans-serif">Rp</text>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Layanan Uang Pihak Ketiga
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'uang-pihak-ketiga') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- 9. Layanan Kepailitan (LAYANAN KHUSUS PENGACARA) --}}
            @if ($canPengacara)
            <div x-show="matches('Layanan Kepailitan kurator negara pengadilan niaga pailit insolvensi', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-[#1d68d8] shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-700 border border-purple-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- Court Pillars + Gavel -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 18l14-8 14 8v3H8v-3z" fill="#faf5ff" stroke="#7e22ce" />
                                <path d="M12 21v11M18 21v11M26 21v11M32 21v11" stroke="#7e22ce" />
                                <rect x="8" y="32" width="28" height="4" rx="1" fill="#7e22ce" stroke="#7e22ce" />
                                <rect x="28" y="27" width="10" height="5" rx="1" transform="rotate(-30 28 27)" fill="#f59e0b" stroke="#d97706" />
                                <path d="M33 30l6 10" stroke="#d97706" stroke-width="2.2" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Layanan Kepailitan
                    </h3>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a href="{{ route('layanan.pengembangan', 'kepailitan') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
