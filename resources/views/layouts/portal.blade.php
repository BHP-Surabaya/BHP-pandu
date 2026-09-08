<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Portal Pembukaan Wasiat Tertutup' }} - {{ config('app.name', 'BHP Surabaya') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f8fafc] text-gray-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden" 
             style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0b2e66] text-white flex flex-col justify-between transition-transform duration-200 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen lg:shrink-0 lg:self-start overflow-y-auto shadow-xl">
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <!-- Brand Header -->
                    <div class="px-5 py-5 border-b border-white/10 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/pengayoman.svg') }}" alt="Logo Pengayoman" class="w-10 h-11 object-contain drop-shadow-md shrink-0 rounded-lg" />
                            <div>
                                <h2 class="text-lg font-black text-white leading-tight tracking-tight">
                                    BHP
                                </h2>
                                <p class="text-[11px] text-blue-200/80 font-medium leading-snug">
                                    Balai Harta Peninggalan<br>Surabaya
                                </p>
                            </div>
                        </div>
                        <!-- Close button on mobile -->
                        <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="p-4 space-y-2">
                        <!-- Layanan (Replaces Dashboard) -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-[#1d68d8] text-white shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                            <!-- Home / Layanan icon -->
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span>Layanan</span>
                        </a>

                        <!-- Histori Permohonan (Combined Permohonan Saya & Riwayat) -->
                        <a href="{{ route('permohonan.index') }}" 
                           class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('permohonan.*') ? 'bg-[#1d68d8] text-white font-semibold shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                            <!-- Clock / History icon -->
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Histori Permohonan</span>
                            @php
                                $badgeCount = Auth::user()?->permohonans()->count() ?? 0;
                            @endphp
                            @if ($badgeCount > 0)
                                <span class="ms-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold rounded-full bg-white/20 text-white">
                                    {{ $badgeCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Profil Akun -->
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('profile.*') ? 'bg-[#1d68d8] text-white font-semibold shadow-md' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                            <!-- User icon -->
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>Profil Akun</span>
                        </a>
                    </nav>
                </div>

                <!-- Siluet Arsitektur di Pojokan Bawah Sidebar (Watermark Halus Tanpa Kotak/Teks) -->
                <div class="pointer-events-none px-4 pb-2 opacity-15 mt-auto">
                    <img src="{{ asset('images/siluet-gedung-bhp-white.png') }}" alt="Siluet Gedung BHP" class="w-full object-contain" />
                </div>
            </div>

            <!-- Sidebar Bottom: User Profile & Keluar Action (Matching Image 1) -->
            <div class="p-4 border-t border-white/10 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-white/15 border border-white/25 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-white truncate">
                                {{ Auth::user()->name ?? 'Pengguna' }}
                            </p>
                            <p class="text-[10px] text-blue-200/80 font-medium truncate">
                                {{ Auth::user()->pekerjaan ?: 'Pemohon Layanan' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-white/75 hover:text-white hover:bg-white/10 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Mobile Navigation Bar (Hidden on desktop) -->
            <div class="lg:hidden sticky top-0 z-30 bg-white border-b border-gray-200 h-14 flex items-center justify-between px-4">
                <div class="flex items-center gap-2.5">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-1.5 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none" aria-label="Buka Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/pengayoman.svg') }}" alt="Logo Pengayoman" class="w-6 h-7 object-contain rounded" />
                        <span class="text-xs font-bold text-[#0b2e66]">BHP Surabaya</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-700">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                </div>
            </div>

            <!-- Main Scrollable Content -->
            <main class="flex-1 bg-[#f8fafc] flex flex-col justify-between">
                <div>
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <footer class="mt-auto border-t border-gray-200/80 bg-white px-4 sm:px-8 py-5">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] sm:text-xs text-gray-500">
                        <div>
                            &copy; 2024 Balai Harta Peninggalan - Direktorat Jenderal Administrasi Hukum Umum, Kemenkumham RI
                        </div>
                        <div class="flex items-center gap-6 font-medium">
                            <a href="#" class="hover:text-gray-800 transition">Syarat &amp; Ketentuan</a>
                            <a href="#" class="hover:text-gray-800 transition">Kebijakan Privasi</a>
                            <a href="#" class="hover:text-gray-800 transition">Kontak Layanan</a>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
</body>
</html>
