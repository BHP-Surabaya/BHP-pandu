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
            
            <!-- Brand & Institution Header (Matching Reference Top Header) -->
            <div class="inline-flex flex-col items-center gap-1">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/pengayoman.svg') }}" alt="Pengayoman" class="w-5 h-5 object-contain" />
                    <span class="text-xs font-black tracking-wider text-[#071d40] uppercase">
                        Balai Harta Peninggalan Surabaya
                    </span>
                </div>
                <p class="text-[10px] text-slate-400 font-medium tracking-wide">
                    Kementerian Hukum dan Hak Asasi Manusia RI &bull; {{ $layanan['kategori'] ?? 'Layanan Hukum' }}
                </p>
            </div>

            <!-- Big Bold Punchy Title & Subtitle (Like 'SOMETHING BETTER IS COMING') -->
            <div class="space-y-3 max-w-2xl mx-auto">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight uppercase">
                    Layanan Sedang Tahap Pengembangan
                </h1>

                <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed max-w-lg mx-auto">
                    Layanan <span class="font-bold text-slate-800">{{ $layanan['nama'] }}</span> saat ini sedang dalam <span class="font-semibold text-slate-700">Tahap Digitalisasi Sistem</span> untuk menghadirkan pelayanan yang lebih baik.
                </p>
            </div>

            <!-- Custom 3D Illustration (Browser Window, Gear with Wrench, Progress Bar, Barricade & Cone) -->
            <div class="relative py-2 flex justify-center">
                <svg class="w-full max-w-md h-auto select-none" viewBox="0 0 460 270" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <!-- Soft Dropshadow for Browser & Cards -->
                        <filter id="win-shadow" x="50" y="10" width="360" height="230" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feDropShadow dx="0" dy="12" stdDeviation="16" flood-color="#0f172a" flood-opacity="0.08" />
                        </filter>
                        <filter id="gear-shadow" x="160" y="65" width="140" height="140" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feDropShadow dx="0" dy="6" stdDeviation="8" flood-color="#0f172a" flood-opacity="0.15" />
                        </filter>
                        <filter id="barrier-shadow" x="25" y="150" width="110" height="100" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#0f172a" flood-opacity="0.1" />
                        </filter>

                        <!-- Gradients -->
                        <linearGradient id="gear-grad" x1="180" y1="80" x2="280" y2="180" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#f1f5f9" />
                            <stop offset="50%" stop-color="#cbd5e1" />
                            <stop offset="100%" stop-color="#94a3b8" />
                        </linearGradient>
                        <linearGradient id="gear-inner" x1="200" y1="100" x2="260" y2="160" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#94a3b8" />
                            <stop offset="100%" stop-color="#e2e8f0" />
                        </linearGradient>
                        <linearGradient id="wrench-grad" x1="210" y1="110" x2="250" y2="150" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#f87171" />
                            <stop offset="60%" stop-color="#dc2626" />
                            <stop offset="100%" stop-color="#991b1b" />
                        </linearGradient>
                        <linearGradient id="cone-grad" x1="90" y1="180" x2="115" y2="230" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#fb923c" />
                            <stop offset="60%" stop-color="#ea580c" />
                            <stop offset="100%" stop-color="#c2410c" />
                        </linearGradient>

                        <!-- Dot grid pattern for background -->
                        <pattern id="bg-dots" x="0" y="0" width="16" height="16" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" fill="#cbd5e1" opacity="0.6" />
                        </pattern>
                    </defs>

                    <!-- Background Subtle Tech Dot Pattern & Arcs -->
                    <rect x="20" y="10" width="420" height="230" fill="url(#bg-dots)" opacity="0.5" />
                    <circle cx="430" cy="70" r="45" stroke="#e2e8f0" stroke-width="1.5" stroke-dasharray="4 4" fill="none" opacity="0.7" />
                    <circle cx="25" cy="130" r="35" stroke="#fca5a5" stroke-width="1.2" fill="none" opacity="0.5" />

                    <!-- ================= BROWSER WINDOW MOCKUP ================= -->
                    <g filter="url(#win-shadow)">
                        <!-- Window Shell Base -->
                        <rect x="75" y="25" width="310" height="185" rx="12" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5" />

                        <!-- Window Header (Dark Slate like reference) -->
                        <path d="M 75 37 C 75 30.37 80.37 25 87 25 L 373 25 C 379.63 25 385 30.37 385 37 L 385 58 L 75 58 Z" fill="#1e293b" />

                        <!-- Window Traffic Lights (Red, Yellow, Green) -->
                        <circle cx="94" cy="41.5" r="4" fill="#ef4444" />
                        <circle cx="106" cy="41.5" r="4" fill="#f59e0b" />
                        <circle cx="118" cy="41.5" r="4" fill="#10b981" />

                        <!-- Header URL / Tab Bar -->
                        <rect x="135" y="34.5" width="180" height="14" rx="7" fill="#334155" opacity="0.9" />

                        <!-- Header Right Hamburger Icon -->
                        <path d="M 355 38 L 367 38 M 355 42 L 367 42 M 355 46 L 367 46" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" />

                        <!-- Window Canvas Area (Subtle wireframe blocks) -->
                        <!-- Left Thumbnail Picture Card -->
                        <rect x="92" y="70" width="86" height="66" rx="6" fill="#f1f5f9" />
                        <!-- Mountain placeholder inside thumbnail -->
                        <path d="M 98 126 L 115 104 L 128 118 L 142 98 L 168 126 Z" fill="#cbd5e1" opacity="0.7" />
                        <circle cx="120" cy="88" r="4.5" fill="#cbd5e1" opacity="0.7" />

                        <!-- Right Text Wireframe Lines -->
                        <rect x="190" y="72" width="165" height="7" rx="3.5" fill="#e2e8f0" />
                        <rect x="190" y="86" width="130" height="6" rx="3" fill="#f1f5f9" />
                        <rect x="190" y="98" width="150" height="6" rx="3" fill="#f1f5f9" />
                        <rect x="190" y="110" width="115" height="6" rx="3" fill="#f1f5f9" />
                        <rect x="190" y="122" width="140" height="6" rx="3" fill="#f1f5f9" />
                    </g>

                    <!-- ================= ACCENT SECONDARY GEARS (RIGHT) ================= -->
                    <g transform="translate(365, 170) scale(0.65)">
                        <circle cx="20" cy="20" r="16" fill="#cbd5e1" />
                        <!-- Teeth -->
                        <path d="M 17 0 H 23 V 6 H 17 Z M 17 34 H 23 V 40 H 17 Z M 0 17 H 6 V 23 H 0 Z M 34 17 H 40 V 23 H 34 Z M 6 6 L 10 10 M 30 30 L 34 34 M 30 10 L 34 6 M 6 34 L 10 30" stroke="#cbd5e1" stroke-width="6" stroke-linecap="square" />
                        <circle cx="20" cy="20" r="7" fill="#ffffff" />
                    </g>
                    <g transform="translate(382, 195) scale(0.45)">
                        <circle cx="20" cy="20" r="16" fill="#94a3b8" />
                        <path d="M 17 0 H 23 V 6 H 17 Z M 17 34 H 23 V 40 H 17 Z M 0 17 H 6 V 23 H 0 Z M 34 17 H 40 V 23 H 34 Z" stroke="#94a3b8" stroke-width="6" />
                        <circle cx="20" cy="20" r="7" fill="#ffffff" />
                    </g>

                    <!-- ================= CENTRAL 3D GEAR WITH WRENCH ================= -->
                    <g filter="url(#gear-shadow)">
                        <!-- 3D Bevel Base -->
                        <circle cx="230" cy="132" r="42" fill="#94a3b8" />

                        <!-- Main Gear Body with 8 Teeth -->
                        <g>
                            <!-- Gear Core Outer -->
                            <circle cx="230" cy="130" r="42" fill="url(#gear-grad)" stroke="#ffffff" stroke-width="1.5" />
                            
                            <!-- 8 Outer Gear Teeth with 3D Depth -->
                            <!-- Top / Bottom -->
                            <rect x="221" y="80" width="18" height="15" rx="3" fill="url(#gear-grad)" />
                            <rect x="221" y="165" width="18" height="15" rx="3" fill="url(#gear-grad)" />
                            <!-- Left / Right -->
                            <rect x="180" y="121" width="15" height="18" rx="3" fill="url(#gear-grad)" />
                            <rect x="265" y="121" width="15" height="18" rx="3" fill="url(#gear-grad)" />
                            <!-- Diagonals -->
                            <g transform="rotate(45, 230, 130)">
                                <rect x="221" y="80" width="18" height="15" rx="3" fill="url(#gear-grad)" />
                                <rect x="221" y="165" width="18" height="15" rx="3" fill="url(#gear-grad)" />
                                <rect x="180" y="121" width="15" height="18" rx="3" fill="url(#gear-grad)" />
                                <rect x="265" y="121" width="15" height="18" rx="3" fill="url(#gear-grad)" />
                            </g>
                        </g>

                        <!-- Gear Center Recessed Ring -->
                        <circle cx="230" cy="130" r="26" fill="url(#gear-inner)" stroke="#cbd5e1" stroke-width="1.5" />
                        <circle cx="230" cy="130" r="22" fill="#f8fafc" />

                        <!-- 3D Red Wrench Inside Gear -->
                        <g transform="translate(230, 130) rotate(-35)">
                            <!-- Wrench Shadow -->
                            <path d="M -5 18 L 5 18 L 4 0 L -4 0 Z" fill="#991b1b" opacity="0.3" transform="translate(1, 2)" />
                            
                            <!-- Wrench Handle -->
                            <rect x="-4" y="-1" width="8" height="19" rx="3" fill="url(#wrench-grad)" stroke="#991b1b" stroke-width="1" />
                            <!-- Handle highlight -->
                            <line x1="-1.5" y1="2" x2="-1.5" y2="15" stroke="#fca5a5" stroke-width="1.2" stroke-linecap="round" />
                            
                            <!-- Wrench Head (Open-ended Jaw) -->
                            <path d="M -11 -7 C -11 -13 -6 -17 0 -17 C 6 -17 11 -13 11 -7 C 11 -2 8 2 4 4 L -4 4 C -8 2 -11 -2 -11 -7 Z" fill="url(#wrench-grad)" stroke="#991b1b" stroke-width="1" />
                            <!-- Jaw Cutout -->
                            <path d="M -4 -18 L 4 -18 L 3 -8 L -3 -8 Z" fill="#f8fafc" stroke="#991b1b" stroke-width="0.8" />
                            
                            <!-- Jaw Highlight -->
                            <path d="M -9 -7 C -9 -11 -5 -14 0 -14" stroke="#fca5a5" stroke-width="1.2" stroke-linecap="round" fill="none" />
                        </g>
                    </g>

                    <!-- ================= LEFT BARRICADE (SEDANG DIPERBAIKI) ================= -->
                    <g filter="url(#barrier-shadow)">
                        <!-- Wooden / Dark Support Legs -->
                        <path d="M 45 220 L 52 170 M 59 220 L 52 170" stroke="#334155" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M 85 220 L 92 170 M 99 220 L 92 170" stroke="#334155" stroke-width="2.5" stroke-linecap="round" />
                        <!-- Cross Tie -->
                        <line x1="48" y1="202" x2="57" y2="202" stroke="#334155" stroke-width="2" />
                        <line x1="88" y1="202" x2="97" y2="202" stroke="#334155" stroke-width="2" />

                        <!-- Barricade Top Hazard Plank (Diagonal Red & White Stripes) -->
                        <g>
                            <clipPath id="plank-clip">
                                <rect x="38" y="165" width="68" height="15" rx="3" />
                            </clipPath>
                            <g clip-path="url(#plank-clip)">
                                <rect x="38" y="165" width="68" height="15" fill="#ffffff" stroke="#e2e8f0" />
                                <path d="M 35 185 L 50 160 M 47 185 L 62 160 M 59 185 L 74 160 M 71 185 L 86 160 M 83 185 L 98 160 M 95 185 L 110 160" stroke="#dc2626" stroke-width="6" stroke-linecap="square" />
                            </g>
                        </g>

                        <!-- Barricade Sign Board ('SEDANG DIPERSIAPKAN') -->
                        <rect x="42" y="182" width="60" height="22" rx="3" fill="#f8fafc" stroke="#cbd5e1" stroke-width="1" />
                        <text x="72" y="192" text-anchor="middle" fill="#0f172a" font-size="5.5" font-weight="800" font-family="sans-serif">
                            SEDANG
                        </text>
                        <text x="72" y="199" text-anchor="middle" fill="#dc2626" font-size="5.5" font-weight="900" font-family="sans-serif">
                            DIPERBAIKI
                        </text>
                    </g>

                    <!-- ================= TRAFFIC CONE (IN FRONT OF BARRICADE) ================= -->
                    <g transform="translate(108, 192)">
                        <!-- Cone Base Plate -->
                        <path d="M 4 30 L 28 30 L 26 33 L 6 33 Z" fill="#1e293b" />
                        
                        <!-- Cone Body (Triangle) -->
                        <path d="M 7 30 L 14 6 L 18 6 L 25 30 Z" fill="url(#cone-grad)" stroke="#9a3412" stroke-width="0.8" />
                        
                        <!-- White Reflective Stripes -->
                        <path d="M 9.5 24 L 22.5 24 L 21 19 L 11 19 Z" fill="#ffffff" />
                        <path d="M 12 15 L 20 15 L 19 11 L 13 11 Z" fill="#ffffff" />
                    </g>

                    <!-- ================= SCREWDRIVER ON RIGHT ================= -->
                    <g transform="translate(285, 218) rotate(14)">
                        <!-- Metal Shaft -->
                        <rect x="0" y="2" width="22" height="2.5" rx="1" fill="#94a3b8" stroke="#475569" stroke-width="0.5" />
                        <path d="M -3 3.25 L 0 2 L 0 4.5 Z" fill="#64748b" />
                        <!-- Red & Black Rubber Handle -->
                        <rect x="22" y="0.5" width="16" height="5.5" rx="2" fill="#dc2626" stroke="#991b1b" stroke-width="0.8" />
                        <rect x="26" y="0.5" width="4" height="5.5" fill="#1e293b" />
                        <rect x="33" y="0.5" width="3" height="5.5" fill="#1e293b" />
                    </g>
                </svg>
            </div>

            <!-- Centered Action Buttons -->
            <div class="pt-1 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('dashboard') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs sm:text-sm font-semibold shadow-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Katalog</span>
                </a>

                <button @click="showDetails = !showDetails" 
                        type="button" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold shadow-2xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-[#1d68d8]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span x-text="showDetails ? 'Tutup Persyaratan' : 'Persyaratan Pengajuan Fisik'"></span>
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
