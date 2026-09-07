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
               class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200/80 flex flex-col justify-between transition-transform duration-200 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen lg:shrink-0 lg:self-start overflow-y-auto">
            <div>
                <!-- Brand Header -->
                <div class="px-5 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/pengayoman.svg') }}" alt="Logo BHP" class="w-10 h-10 object-contain shrink-0 drop-shadow-sm" />
                        <div>
                            <h2 class="text-[15px] font-extrabold text-[#0f172a] leading-tight tracking-tight">
                                Balai Harta<br>Peninggalan
                            </h2>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                Surabaya
                            </p>
                        </div>
                    </div>
                    <!-- Close button on mobile -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-[#f59e0b] text-gray-950 shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                        <!-- Grid / Dashboard icon -->
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Permohonan Saya -->
                    <a href="{{ route('permohonan.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('permohonan.*') ? 'bg-[#f59e0b] text-gray-950 font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                        <!-- Document folder / files icon -->
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span>Permohonan Saya</span>
                        @php
                            $badgeCount = Auth::user()?->permohonans()->count() ?? 0;
                        @endphp
                        @if ($badgeCount > 0)
                            <span class="ms-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold rounded-full bg-purple-100 text-purple-700">
                                {{ $badgeCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Riwayat -->
                    <a href="{{ route('permohonan.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100/80 transition">
                        <!-- Clock / History icon -->
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Riwayat</span>
                    </a>

                    <!-- Profil -->
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('profile.*') ? 'bg-[#f59e0b] text-gray-950 font-semibold shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100/80' }}">
                        <!-- User icon -->
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Bottom Info -->
            <div class="p-4 border-t border-gray-100 text-center">
                <div class="inline-flex items-center gap-2 text-[11px] text-gray-400">
                    <img src="{{ asset('images/pengayoman.svg') }}" alt="Logo" class="w-4 h-4 object-contain opacity-70" />
                    <span>BHP Kemenkumham RI</span>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navigation Bar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-sm border-b border-gray-200/80 h-16 flex items-center justify-between px-4 sm:px-8">
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Top title / Portal Pemohon badge -->
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-purple-100/80 text-purple-700 border border-purple-200/50">
                        Portal Pemohon
                    </span>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition focus:outline-none" aria-label="Notifikasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-amber-400 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- Settings -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition focus:outline-none" aria-label="Pengaturan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative flex items-center gap-3" x-data="{ open: false }">
                        <div class="hidden sm:flex flex-col text-right">
                            <span class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">
                                {{ Auth::user()->name ?? 'Budi Santoso' }}
                            </span>
                            <span class="text-[11px] font-semibold text-emerald-600 leading-tight">
                                {{ Auth::user()->pekerjaan ?: 'PPAT' }}
                            </span>
                        </div>

                        <button @click="open = !open" 
                                class="flex items-center gap-2 p-0.5 rounded-full hover:ring-2 hover:ring-purple-200 transition focus:outline-none cursor-pointer"
                                aria-label="User menu">
                            <div class="w-9 h-9 rounded-full bg-[#2e1065] text-[#fbbf24] flex items-center justify-center text-xs font-bold shadow-sm border border-purple-300/30">
                                {{ Auth::user()->initials ?? 'BS' }}
                            </div>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute right-0 top-12 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-1.5 z-50 ring-1 ring-black/5" 
                             style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 font-medium">
                                Pengaturan Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 hover:text-red-700 font-semibold cursor-pointer flex items-center gap-2 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

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
