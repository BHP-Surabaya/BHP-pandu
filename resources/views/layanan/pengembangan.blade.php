<x-portal-layout>
    <x-slot name="title">
        Layanan Sedang Tahap Pengembangan - {{ $layanan['nama'] }}
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-6" x-data="{ showDetails: false }">

        <!-- ================= BREADCRUMB & BACK LINK ================= -->
        <div class="flex items-center justify-between gap-4">
            <nav class="flex items-center gap-2 text-xs text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-[#1d68d8] flex items-center gap-1.5 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Katalog Layanan</span>
                </a>
                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-slate-800 font-semibold truncate">{{ $layanan['nama'] }}</span>
            </nav>

            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-2xs transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- ================= MAIN MAINTENANCE / UNDER DEVELOPMENT CARD ================= -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 text-center space-y-6">
            
            <!-- Category Tag Pill -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-50/80 text-[#0b2e66] border border-blue-100 text-xs font-semibold">
                <img src="{{ asset('images/pengayoman.svg') }}" alt="Pengayoman" class="w-4 h-4 object-contain" />
                <span>Balai Harta Peninggalan Surabaya &bull; {{ $layanan['kategori'] ?? 'Layanan Hukum' }}</span>
            </div>

            <!-- Custom Clean Vector Graphic (Under Maintenance / Construction - Theme BHP) -->
            <div class="py-2">
                <svg class="w-full max-w-lg h-auto mx-auto select-none" viewBox="0 0 540 280" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Ground line -->
                    <path d="M 40 250 L 500 250" stroke="#0b2e66" stroke-width="2" stroke-linecap="round" opacity="0.8" />
                    <path d="M 80 258 L 130 258" stroke="#0b2e66" stroke-width="1.5" stroke-linecap="round" opacity="0.25" />
                    <path d="M 410 258 L 470 258" stroke="#0b2e66" stroke-width="1.5" stroke-linecap="round" opacity="0.25" />

                    <!-- Monitor Base & Stand -->
                    <path d="M 230 250 L 235 210 L 265 210 L 270 250 Z" fill="#f0f7ff" stroke="#0b2e66" stroke-width="2" stroke-linejoin="round" />
                    <path d="M 215 250 L 285 250" stroke="#0b2e66" stroke-width="2.5" stroke-linecap="round" />

                    <!-- Monitor Screen Outer -->
                    <rect x="145" y="95" width="210" height="135" rx="10" fill="#ffffff" stroke="#0b2e66" stroke-width="2.2" />
                    <!-- Monitor Screen Inner Display -->
                    <rect x="153" y="103" width="194" height="110" rx="6" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1" />
                    
                    <!-- Wireframe & Blueprint Lines inside screen -->
                    <path d="M 168 120 L 210 120" stroke="#93c5fd" stroke-width="3" stroke-linecap="round" />
                    <path d="M 168 132 L 235 132" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round" />
                    <path d="M 168 144 L 200 144" stroke="#bfdbfe" stroke-width="2.5" stroke-linecap="round" />
                    
                    <path d="M 168 165 L 180 165" stroke="#60a5fa" stroke-width="2.5" stroke-linecap="round" />
                    <path d="M 186 165 L 220 165" stroke="#93c5fd" stroke-width="2.5" stroke-linecap="round" />
                    
                    <!-- Screen diagonal glare -->
                    <path d="M 220 104 L 255 104 L 185 212 L 168 212 Z" fill="#ffffff" opacity="0.6" />

                    <!-- Bottom bezel power light -->
                    <circle cx="250" cy="221" r="2" fill="#1d68d8" />

                    <!-- Stepladder leaning on monitor screen -->
                    <g transform="translate(155, 125) rotate(-6)">
                        <path d="M 0 0 L 0 125" stroke="#0b2e66" stroke-width="2" stroke-linecap="round" />
                        <path d="M 16 0 L 16 125" stroke="#0b2e66" stroke-width="2" stroke-linecap="round" />
                        <path d="M 0 20 L 16 20" stroke="#0b2e66" stroke-width="1.8" />
                        <path d="M 0 40 L 16 40" stroke="#0b2e66" stroke-width="1.8" />
                        <path d="M 0 60 L 16 60" stroke="#0b2e66" stroke-width="1.8" />
                        <path d="M 0 80 L 16 80" stroke="#0b2e66" stroke-width="1.8" />
                        <path d="M 0 100 L 16 100" stroke="#0b2e66" stroke-width="1.8" />
                    </g>

                    <!-- Potted Plant on Desk (Left) -->
                    <g transform="translate(100, 210)">
                        <path d="M 8 20 L 14 40 L 32 40 L 38 20 Z" fill="#e0f2fe" stroke="#0b2e66" stroke-width="2" stroke-linejoin="round" />
                        <path d="M 5 20 L 41 20" stroke="#0b2e66" stroke-width="2" stroke-linecap="round" />
                        <!-- Cactus -->
                        <path d="M 23 20 C 23 10, 16 8, 16 -2 C 16 -10, 23 -12, 23 -12 C 23 -12, 30 -10, 30 -2 C 30 8, 23 10, 23 20 Z" fill="#d1fae5" stroke="#059669" stroke-width="1.8" />
                        <path d="M 16 2 C 10 2, 7 -3, 7 -7 C 7 -11, 12 -11, 14 -8 L 16 -2" fill="#d1fae5" stroke="#059669" stroke-width="1.5" />
                        <path d="M 30 5 C 36 5, 39 0, 39 -4 C 39 -8, 34 -8, 32 -5 L 30 1" fill="#d1fae5" stroke="#059669" stroke-width="1.5" />
                    </g>

                    <!-- Crane Structure on Right -->
                    <g transform="translate(370, 25)">
                        <!-- Vertical Mast Legs -->
                        <path d="M 25 225 L 25 35" stroke="#0b2e66" stroke-width="2.5" />
                        <path d="M 45 225 L 45 35" stroke="#0b2e66" stroke-width="2.5" />
                        <!-- X-bracing in mast -->
                        <path d="M 25 225 L 45 205 M 45 225 L 25 205" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 205 L 45 185 M 45 205 L 25 185" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 185 L 45 165 M 45 185 L 25 165" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 165 L 45 145 M 45 165 L 25 145" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 145 L 45 125 M 45 145 L 25 125" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 125 L 45 105 M 45 125 L 25 105" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 105 L 45 85 M 45 105 L 25 85" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 85 L 45 65 M 45 85 L 25 65" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 65 L 45 45 M 45 65 L 25 45" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M 25 45 L 45 35 M 45 45 L 25 35" stroke="#0b2e66" stroke-width="1.5" />

                        <!-- Tower Apex -->
                        <path d="M 25 35 L 35 15 L 45 35" stroke="#0b2e66" stroke-width="2" fill="#eff6ff" />

                        <!-- Jib (Horizontal Arm) -->
                        <path d="M -85 35 L 80 35" stroke="#0b2e66" stroke-width="2.5" />
                        <path d="M -85 43 L 80 43" stroke="#0b2e66" stroke-width="1.8" />
                        <!-- Jib internal trussing -->
                        <path d="M -85 43 L -75 35 L -65 43 L -55 35 L -45 43 L -35 35 L -25 43 L -15 35 L -5 43 L 5 35 L 15 43 L 25 35 L 45 35 L 55 43 L 65 35 L 75 43" stroke="#0b2e66" stroke-width="1.2" opacity="0.8" />
                        <!-- Counter-weight -->
                        <rect x="62" y="44" width="16" height="14" fill="#0b2e66" rx="2" />
                        <!-- Cable stay from top apex -->
                        <path d="M 35 15 L -65 35" stroke="#0b2e66" stroke-width="1.4" stroke-dasharray="3 2" />
                        <path d="M 35 15 L 70 35" stroke="#0b2e66" stroke-width="1.4" stroke-dasharray="3 2" />

                        <!-- Trolley & Hoist Cable -->
                        <rect x="-42" y="42" width="12" height="6" fill="#1d68d8" rx="1" />
                        <line x1="-36" y1="48" x2="-36" y2="85" stroke="#0b2e66" stroke-width="1.5" />
                        <circle cx="-36" cy="87" r="3" fill="#1d68d8" stroke="#0b2e66" stroke-width="1.5" />
                        
                        <!-- Cable Slings to the suspended component -->
                        <line x1="-36" y1="89" x2="-65" y2="108" stroke="#0b2e66" stroke-width="1.2" />
                        <line x1="-36" y1="89" x2="-8" y2="108" stroke="#0b2e66" stroke-width="1.2" />
                    </g>

                    <!-- Suspended Window Component (being installed on screen) -->
                    <g transform="translate(300, 110) rotate(-7)">
                        <rect x="-35" y="0" width="76" height="54" rx="6" fill="#ffffff" stroke="#1d68d8" stroke-width="2.2" />
                        <!-- Header bar of window -->
                        <path d="M -35 12 L 41 12" stroke="#1d68d8" stroke-width="1.5" />
                        <circle cx="-27" cy="6" r="2" fill="#ef4444" />
                        <circle cx="-20" cy="6" r="2" fill="#f59e0b" />
                        <circle cx="-13" cy="6" r="2" fill="#10b981" />
                        
                        <!-- Illustration content inside suspended window -->
                        <rect x="-28" y="18" width="62" height="30" fill="#f0f9ff" rx="3" />
                        <path d="M -22 44 L -8 28 L 8 44 Z" fill="#60a5fa" opacity="0.85" />
                        <path d="M 0 44 L 14 32 L 28 44 Z" fill="#93c5fd" opacity="0.85" />
                        <circle cx="20" cy="24" r="3.5" fill="#f59e0b" />
                    </g>

                    <!-- Traffic Cone on Desk -->
                    <g transform="translate(425, 222)">
                        <path d="M 2 28 L 10 2 L 18 2 L 26 28 Z" fill="#f97316" stroke="#0b2e66" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M 6 18 L 22 18 L 20 12 L 8 12 Z" fill="#ffffff" stroke="#0b2e66" stroke-width="1.5" />
                        <path d="M -2 28 L 30 28" stroke="#0b2e66" stroke-width="2.5" stroke-linecap="round" />
                    </g>

                    <!-- Safety Barrier on Ground -->
                    <g transform="translate(455, 226)">
                        <rect x="0" y="4" width="36" height="16" fill="#ffffff" stroke="#0b2e66" stroke-width="1.8" rx="2" />
                        <path d="M 6 20 L 14 4 M 14 20 L 22 4 M 22 20 L 30 4" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M 4 20 L 4 24 M 32 20 L 32 24" stroke="#0b2e66" stroke-width="2" />
                    </g>

                    <!-- Floating Accents -->
                    <!-- Gear -->
                    <g transform="translate(195, 55)" stroke="#1d68d8" stroke-width="1.8" fill="none">
                        <circle cx="10" cy="10" r="5" fill="#eff6ff" />
                        <path d="M 10 2 L 10 5 M 10 15 L 10 18 M 2 10 L 5 10 M 15 10 L 18 10 M 4 4 L 6 6 M 14 14 L 16 16 M 4 16 L 6 14 M 14 4 L 16 6" />
                    </g>

                    <!-- Clock -->
                    <g transform="translate(245, 62)" stroke="#0b2e66" stroke-width="1.6" fill="none">
                        <circle cx="12" cy="12" r="10" fill="#ffffff" stroke-width="1.8" />
                        <path d="M 12 7 L 12 12 L 16 14" stroke="#1d68d8" stroke-width="1.8" stroke-linecap="round" />
                        <line x1="26" y1="9" x2="31" y2="9" stroke="#93c5fd" stroke-width="1.5" stroke-linecap="round" />
                        <line x1="26" y1="14" x2="34" y2="14" stroke="#93c5fd" stroke-width="1.5" stroke-linecap="round" />
                    </g>

                    <!-- Magnifying Glass -->
                    <g transform="translate(305, 80) rotate(-20)" stroke="#1d68d8" stroke-width="1.5" fill="none">
                        <circle cx="6" cy="6" r="5" fill="#eff6ff" />
                        <line x1="10" y1="10" x2="16" y2="16" stroke-linecap="round" stroke-width="2" />
                    </g>

                    <!-- Sparkles & Dots -->
                    <path d="M 125 105 L 131 105 M 128 102 L 128 108" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M 235 40 L 241 40 M 238 37 L 238 43" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M 445 130 L 451 130 M 448 127 L 448 133" stroke="#93c5fd" stroke-width="1.5" stroke-linecap="round" />
                    
                    <circle cx="160" cy="80" r="2" fill="#93c5fd" />
                    <circle cx="430" cy="180" r="1.5" fill="#64748b" />
                    <circle cx="110" cy="160" r="1.5" fill="#64748b" />
                </svg>
            </div>

            <!-- Typography (Directly matching user screenshot composition) -->
            <div class="space-y-2 max-w-xl mx-auto">
                <h1 class="text-2xl sm:text-3xl font-black text-[#0b2e66] tracking-tight">
                    Layanan Sedang Tahap Pengembangan
                </h1>

                <p class="text-sm sm:text-base font-bold text-[#1d68d8]">
                    {{ $layanan['nama'] }}
                </p>

                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-normal pt-1">
                    {{ $layanan['deskripsi'] ?? 'Modul pengajuan daring untuk layanan ini sedang disiapkan oleh tim Balai Harta Peninggalan Surabaya. Seluruh fitur otomasi berkas daring akan segera hadir untuk memudahkan Anda.' }}
                </p>
            </div>

            <!-- Status Indicator Pill -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span>Tahap Digitalisasi Sistem &bull; Segera Hadir</span>
            </div>

            <!-- Centered Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('dashboard') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs sm:text-sm font-bold shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Katalog Layanan</span>
                </a>

                <button @click="showDetails = !showDetails" 
                        type="button" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold shadow-2xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-[#1d68d8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span x-text="showDetails ? 'Sembunyikan Informasi Berkas' : 'Lihat Persyaratan & Pengajuan Fisik'"></span>
                    <svg class="w-3.5 h-3.5 transition-transform" :class="showDetails ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <!-- ================= EXPANDABLE OFFLINE DETAILS (SMOOTH ACCORDION) ================= -->
            <div x-show="showDetails" 
                 x-collapse
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="pt-6 border-t border-slate-100 text-left" 
                 style="display: none;">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Persyaratan Dokumen -->
                    <div class="bg-slate-50/90 rounded-2xl p-5 border border-slate-200/80 space-y-3">
                        <div class="flex items-center gap-2 text-[#0b2e66]">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-[#1d68d8] flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-[#071d40]">
                                Dokumen yang Diperlukan:
                            </h4>
                        </div>

                        <ul class="space-y-2 text-xs text-slate-700">
                            @foreach ($layanan['syarat'] as $item)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span class="leading-relaxed">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Loket Tatap Muka -->
                    <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-100 space-y-3">
                        <div class="flex items-center gap-2 text-[#0b2e66]">
                            <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.406 48.406 0 0012 9.75c-2.551 0-5.056.2-7.5.583V21" />
                                </svg>
                            </div>
                            <h4 class="text-xs sm:text-sm font-bold text-[#071d40]">
                                Pengajuan Offline / Tatap Muka:
                            </h4>
                        </div>

                        <div class="space-y-2.5 text-xs text-slate-700">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-[#1d68d8] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <div>
                                    <span class="font-bold text-slate-800">Loket PTSP BHP Surabaya:</span>
                                    <p class="text-slate-600">Jl. Gayung Kebonsari No. 56, Gayungan, Wonocolo, Surabaya</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-[#1d68d8] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <span class="font-bold text-slate-800">Jam Layanan:</span>
                                    <p class="text-slate-600">Senin &ndash; Jumat, 08.00 &ndash; 15.00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Siluet Panorama Memanjang Surabaya & BHP Watermark -->
        <div class="pointer-events-none select-none -mx-4 sm:-mx-6 lg:-mx-8 -mb-6 sm:-mb-8 pt-2 overflow-hidden">
            <img src="{{ asset('images/panorama-skyline-surabaya-bhp.svg') }}" 
                 alt="Panorama Skyline Surabaya &amp; Balai Harta Peninggalan" 
                 class="w-full h-auto max-h-28 object-cover object-bottom opacity-60" />
        </div>

    </div>
</x-portal-layout>
