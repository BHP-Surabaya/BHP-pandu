<x-portal-layout>
    <x-slot:title>
        Manajemen &amp; Verifikasi Akun Pengguna - Master Admin BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        switchModalOpen: false,
        deleteModalOpen: false,
        selectedUser: null,
        targetStatus: 'perorangan',
        actionUrl: '',
        deleteActionUrl: '',
        openSwitchModal(user) {
            this.selectedUser = user;
            this.targetStatus = user.status_akun || 'perorangan';
            this.actionUrl = '/admin/verifikasi/' + user.id + '/ubah-status';
            this.switchModalOpen = true;
        },
        openDeleteModal(user) {
            this.selectedUser = user;
            this.deleteActionUrl = '/admin/verifikasi/' + user.id;
            this.deleteModalOpen = true;
        }
    }">
        <!-- Header Page -->
        <div class="pb-4 border-b border-gray-200">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                Manajemen &amp; Verifikasi Akun
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Pantau seluruh akun pengguna yang aktif di sistem. Master Admin dapat memindahkan status akun (Notaris, Pengacara, Perorangan) secara langsung.
            </p>
        </div>

        <!-- Flash Message Notification -->
        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('status') }}
                </div>
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-900 text-sm flex items-start gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('error') }}
                </div>
                <button type="button" @click="show = false" class="text-red-700 hover:text-red-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <!-- Summary Metric Cards (5 Cards Aktif) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
            <!-- Card 1: Total Semua Akun -->
            <a href="{{ route('admin.verifikasi.index', ['status' => 'all']) }}" 
               class="bg-white p-4 rounded-2xl border transition shadow-sm hover:shadow-md {{ $status === 'all' ? 'border-[#0066d6] ring-2 ring-[#0066d6]/10' : 'border-gray-100' }}">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Semua Akun</p>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mt-2">{{ $stats['total_user'] }}</h3>
                <p class="text-[10px] text-gray-400 mt-1 font-medium">Terdaftar di sistem</p>
            </a>

            <!-- Card 2: Akun Notaris Aktif -->
            <a href="{{ route('admin.verifikasi.index', ['status' => 'notaris']) }}" 
               class="bg-white p-4 rounded-2xl border transition shadow-sm hover:shadow-md {{ $status === 'notaris' ? 'border-blue-500 ring-2 ring-blue-500/10' : 'border-gray-100' }}">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Akun Notaris</p>
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0066d6] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#0066d6] mt-2">{{ $stats['total_notaris'] }}</h3>
                <p class="text-[10px] text-blue-400 mt-1 font-medium">Status Notaris aktif</p>
            </a>

            <!-- Card 3: Akun Pengacara Aktif -->
            <a href="{{ route('admin.verifikasi.index', ['status' => 'pengacara']) }}" 
               class="bg-white p-4 rounded-2xl border transition shadow-sm hover:shadow-md {{ $status === 'pengacara' ? 'border-indigo-500 ring-2 ring-indigo-500/10' : 'border-gray-100' }}">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider">Akun Pengacara</p>
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-indigo-600 mt-2">{{ $stats['total_pengacara'] }}</h3>
                <p class="text-[10px] text-indigo-400 mt-1 font-medium">Status Pengacara aktif</p>
            </a>

            <!-- Card 4: Akun Perorangan Aktif -->
            <a href="{{ route('admin.verifikasi.index', ['status' => 'perorangan']) }}" 
               class="bg-white p-4 rounded-2xl border transition shadow-sm hover:shadow-md {{ $status === 'perorangan' ? 'border-emerald-500 ring-2 ring-emerald-500/10' : 'border-gray-100' }}">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Akun Perorangan</p>
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-emerald-600 mt-2">{{ $stats['total_perorangan'] }}</h3>
                <p class="text-[10px] text-emerald-400 mt-1 font-medium">Status Perorangan aktif</p>
            </a>

            <!-- Card 5: Antrean Menunggu Verifikasi -->
            <a href="{{ route('admin.verifikasi.index', ['status' => 'menunggu_verifikasi']) }}" 
               class="bg-white p-4 rounded-2xl border transition shadow-sm hover:shadow-md col-span-2 sm:col-span-1 {{ $status === 'menunggu_verifikasi' ? 'border-amber-500 ring-2 ring-amber-500/10' : 'border-gray-100' }}">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Antrean Verifikasi</p>
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-amber-600 mt-2">{{ $stats['total_pending'] }}</h3>
                <p class="text-[10px] text-amber-500 mt-1 font-medium">Perlu ditinjau</p>
            </a>
        </div>

        <!-- Filter & Search Controls -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <!-- Status Filter Tabs -->
                <div class="flex items-center gap-1.5 p-1 bg-gray-100/80 rounded-xl overflow-x-auto text-xs font-semibold">
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'all', 'search' => $search]) }}"
                       class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ $status === 'all' ? 'bg-white text-[#0c2a55] shadow-sm font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                        Semua Akun ({{ $stats['total_user'] }})
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'notaris', 'search' => $search]) }}"
                       class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ $status === 'notaris' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                        Notaris ({{ $stats['total_notaris'] }})
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'pengacara', 'search' => $search]) }}"
                       class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ $status === 'pengacara' ? 'bg-white text-indigo-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                        Pengacara ({{ $stats['total_pengacara'] }})
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'perorangan', 'search' => $search]) }}"
                       class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ $status === 'perorangan' ? 'bg-white text-emerald-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                        Perorangan ({{ $stats['total_perorangan'] }})
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'menunggu_verifikasi', 'search' => $search]) }}"
                       class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ $status === 'menunggu_verifikasi' ? 'bg-white text-amber-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                        Menunggu Verifikasi ({{ $stats['total_pending'] }})
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'ditolak', 'search' => $search]) }}"
                       class="px-3.5 py-2 rounded-lg transition whitespace-nowrap {{ $status === 'ditolak' ? 'bg-white text-red-700 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                        Ditolak
                    </a>
                </div>

                <!-- Right Side: Search Input -->
                <div class="flex items-center gap-2.5">
                    <input type="hidden" name="status" value="{{ $status }}">

                    <div class="relative min-w-[240px]">
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               placeholder="Cari nama, email, NIK..."
                               class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-[#0c2a55] hover:bg-[#103873] text-white text-xs font-bold rounded-xl shadow-sm transition">
                        Cari
                    </button>
                    @if ($search)
                        <a href="{{ route('admin.verifikasi.index', ['status' => $status]) }}" class="px-2.5 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 border-collapse">
                    <thead class="bg-slate-50/90 border-b border-gray-200 text-[11px] font-bold text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-5 border-r border-gray-200/80">Pengguna</th>
                            <th class="py-3.5 px-3 text-center border-r border-gray-200/80">Status Akun Aktif</th>
                            <th class="py-3.5 px-3 text-center border-r border-gray-200/80">Aktivasi Email</th>
                            <th class="py-3.5 px-3 text-center border-r border-gray-200/80">Pengajuan Awal</th>
                            <th class="py-3.5 px-3 text-center border-r border-gray-200/80">Dokumen Terlampir</th>
                            <th class="py-3.5 px-3 text-center border-r border-gray-200/80">Verifikasi Berkas</th>
                            <th class="py-3.5 px-4 text-center">Tindakan Master Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $userItem)
                            <tr class="hover:bg-blue-50/30 transition">
                                <!-- User Info -->
                                <td class="py-3.5 px-4 sm:px-5 border-r border-gray-100/90 align-middle">
                                    <div class="flex items-center gap-3">
                                        @if ($userItem->foto_profil_url)
                                            <img src="{{ $userItem->foto_profil_url }}" alt="{{ $userItem->name }}" class="w-9 h-9 rounded-full object-cover shrink-0 shadow-inner" />
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-blue-100 text-[#0066d6] font-bold text-xs flex items-center justify-center shrink-0 shadow-inner">
                                                {{ $userItem->initials }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 truncate">{{ $userItem->name }}</p>
                                            <p class="text-xs text-gray-500 truncate mt-0.5">{{ $userItem->email }}</p>
                                            @if ($userItem->nik)
                                                <p class="text-[10px] text-gray-400 font-mono mt-0.5">NIK: {{ $userItem->nik }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Status Akun Aktif Saat Ini -->
                                <td class="py-3.5 px-3 text-center border-r border-gray-100/90 align-middle">
                                    @if ($userItem->status_akun === 'notaris')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-blue-800 border border-blue-200 text-xs font-bold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                            Akun Notaris
                                        </span>
                                    @elseif ($userItem->status_akun === 'pengacara')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-800 border border-indigo-200 text-xs font-bold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                            Akun Pengacara
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            Akun Perorangan
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Aktivasi Email (Kolom Khusus) -->
                                <td class="py-3.5 px-3 text-center border-r border-gray-100/90 align-middle">
                                    @if ($userItem->hasVerifiedEmail())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold shadow-2xs" title="Email terverifikasi pada {{ $userItem->email_verified_at->format('d/m/Y H:i') }}">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Teraktivasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-900 border border-amber-300 text-xs font-bold shadow-2xs" title="Pengguna belum mengklik tautan aktivasi email">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Belum Aktivasi
                                        </span>
                                    @endif
                                </td>

                                <!-- Pengajuan Awal -->
                                <td class="py-3.5 px-3 text-center border-r border-gray-100/90 align-middle">
                                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-gray-100 text-gray-700 text-xs font-semibold capitalize">
                                        {{ $userItem->jenis_akun ?: 'Perorangan' }}
                                    </span>
                                    @if ($userItem->pekerjaan && !in_array(strtolower($userItem->pekerjaan), [strtolower($userItem->jenis_akun), 'perorangan', 'notaris', 'pengacara']))
                                        <span class="block text-[11px] text-gray-400 font-normal mt-0.5">({{ $userItem->pekerjaan }})</span>
                                    @endif
                                </td>

                                <!-- Dokumen Berkas -->
                                <td class="py-3.5 px-3 text-center border-r border-gray-100/90 align-middle">
                                    @if ($userItem->isNotaris())
                                        <div class="inline-flex flex-wrap justify-center gap-1 text-[11px]">
                                            <span class="px-2 py-0.5 rounded-md {{ $userItem->sk_notaris ? 'bg-blue-50 text-blue-700 font-semibold border border-blue-200' : 'bg-gray-100 text-gray-400' }}">
                                                {{ $userItem->sk_notaris ? '✓ SK Notaris' : '✗ SK Notaris' }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-md {{ $userItem->sk_ppat ? 'bg-blue-50 text-blue-700 font-semibold border border-blue-200' : 'bg-gray-100 text-gray-400' }}">
                                                {{ $userItem->sk_ppat ? '✓ SK PPAT' : '✗ SK PPAT' }}
                                            </span>
                                        </div>
                                    @elseif ($userItem->isPengacara())
                                        <div class="inline-flex flex-wrap justify-center gap-1 text-[11px]">
                                            <span class="px-2 py-0.5 rounded-md {{ $userItem->berita_acara_sumpah ? 'bg-indigo-50 text-indigo-700 font-semibold border border-indigo-200' : 'bg-gray-100 text-gray-400' }}">
                                                {{ $userItem->berita_acara_sumpah ? '✓ BA Sumpah' : '✗ BA Sumpah' }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-md {{ $userItem->id_card_pengacara ? 'bg-indigo-50 text-indigo-700 font-semibold border border-indigo-200' : 'bg-gray-100 text-gray-400' }}">
                                                {{ $userItem->id_card_pengacara ? '✓ ID Card' : '✗ ID Card' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tanpa berkas khusus</span>
                                    @endif
                                </td>

                                <!-- Verifikasi Berkas -->
                                <td class="py-3.5 px-3 text-center border-r border-gray-100/90 align-middle">
                                    @if ($userItem->isNotaris() || $userItem->isPengacara())
                                        @if ($userItem->isVerifikasiPending())
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-200 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Berkas
                                            </span>
                                        @elseif ($userItem->isTerverifikasi())
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-200 text-xs font-bold">
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                                Berkas Disetujui
                                            </span>
                                        @elseif ($userItem->status_verifikasi === 'ditolak')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-100 text-red-900 border border-red-200 text-xs font-bold">
                                                <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                                Ditolak
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                                            Tanpa Berkas
                                        </span>
                                    @endif
                                </td>

                                <!-- Tindakan Master Admin (Toolbar Ringkas & Rapi) -->
                                <td class="py-3.5 px-4 text-center align-middle">
                                    <div class="inline-flex items-center justify-center gap-1.5 whitespace-nowrap">
                                        <!-- Tombol Pindah Status (Modal) -->
                                        <button type="button" 
                                                @click="openSwitchModal({{ json_encode([
                                                    'id' => $userItem->id,
                                                    'name' => $userItem->name,
                                                    'email' => $userItem->email,
                                                    'status_akun' => $userItem->status_akun ?: 'perorangan',
                                                    'status_akun_label' => $userItem->status_akun_label,
                                                ]) }})"
                                                class="inline-flex items-center gap-1 px-2.5 h-8 rounded-lg border border-amber-300 bg-amber-50 hover:bg-amber-100 active:bg-amber-200/80 text-amber-800 text-xs font-bold transition cursor-pointer shadow-2xs whitespace-nowrap"
                                                title="Ubah Status Akun Pengguna">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                                            <span>Ubah Status</span>
                                        </button>

                                        <!-- Tombol Tinjau Detail -->
                                        <a href="{{ route('admin.verifikasi.show', $userItem) }}" 
                                           class="inline-flex items-center gap-1 px-3 h-8 rounded-lg bg-[#0066d6] hover:bg-[#0055b8] active:bg-[#00479e] text-white text-xs font-semibold shadow-xs transition"
                                           title="Tinjau Detail Berkas Pengguna">
                                            <span>Tinjau</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                        </a>

                                        <!-- Tombol Hapus Akun -->
                                        <button type="button" 
                                                @click="openDeleteModal({{ json_encode([
                                                    'id' => $userItem->id,
                                                    'name' => $userItem->name,
                                                    'email' => $userItem->email,
                                                    'status_akun_label' => $userItem->status_akun_label,
                                                ]) }})"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-200 bg-red-50 hover:bg-red-100 active:bg-red-200 text-red-600 transition cursor-pointer shadow-2xs"
                                                title="Hapus Akun Pengguna">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-4 text-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-700">Tidak ada akun ditemukan</h4>
                                    <p class="text-xs text-gray-400 mt-1">Tidak ditemukan akun yang sesuai dengan filter atau kata kunci pencarian Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- ================= MODAL PINDAH STATUS AKUN ================= -->
        <div x-show="switchModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 space-y-4" 
                 @click.outside="switchModalOpen = false">
                
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-gray-900">Pindahkan Status Akun</h3>
                        <p class="text-xs text-gray-500 truncate" x-text="selectedUser ? selectedUser.name + ' (' + selectedUser.email + ')' : ''"></p>
                    </div>
                </div>

                <form method="POST" :action="actionUrl" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Pilih Status Akun Baru:
                        </label>
                        <div class="grid grid-cols-1 gap-2">
                            <!-- Opsi 1: Akun Notaris -->
                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="targetStatus === 'notaris' ? 'bg-blue-50/80 border-blue-500 ring-1 ring-blue-500' : 'bg-gray-50/60 border-gray-200 hover:bg-gray-100/70'">
                                <input type="radio" name="status_akun" value="notaris" x-model="targetStatus" class="w-4 h-4 text-[#0066d6] focus:ring-[#0066d6]">
                                <div>
                                    <p class="text-xs font-bold text-blue-950">Akun Notaris</p>
                                    <p class="text-[11px] text-gray-500">Mendapatkan akses penuh modul registrasi &amp; pelaporan wasiat Notaris.</p>
                                </div>
                            </label>

                            <!-- Opsi 2: Akun Pengacara -->
                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="targetStatus === 'pengacara' ? 'bg-indigo-50/80 border-indigo-500 ring-1 ring-indigo-500' : 'bg-gray-50/60 border-gray-200 hover:bg-gray-100/70'">
                                <input type="radio" name="status_akun" value="pengacara" x-model="targetStatus" class="w-4 h-4 text-indigo-600 focus:ring-indigo-600">
                                <div>
                                    <p class="text-xs font-bold text-indigo-950">Akun Pengacara</p>
                                    <p class="text-[11px] text-gray-500">Mendapatkan akses permohonan dengan kuasa hukum resmi.</p>
                                </div>
                            </label>

                            <!-- Opsi 3: Akun Perorangan -->
                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="targetStatus === 'perorangan' ? 'bg-emerald-50/80 border-emerald-500 ring-1 ring-emerald-500' : 'bg-gray-50/60 border-gray-200 hover:bg-gray-100/70'">
                                <input type="radio" name="status_akun" value="perorangan" x-model="targetStatus" class="w-4 h-4 text-emerald-600 focus:ring-emerald-600">
                                <div>
                                    <p class="text-xs font-bold text-emerald-950">Akun Perorangan</p>
                                    <p class="text-[11px] text-gray-500">Akun reguler pemohon perorangan (tanpa hak profesi khusus).</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="catatan_verifikasi_modal" class="block text-xs font-semibold text-gray-700 mb-1">
                            Catatan Pemindahan (Opsional)
                        </label>
                        <input id="catatan_verifikasi_modal" 
                               name="catatan_verifikasi" 
                               type="text" 
                               placeholder="Contoh: Dipindahkan atas persetujuan manual Master Admin."
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" 
                                @click="switchModalOpen = false"
                                class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex-1 py-2.5 px-4 rounded-xl bg-[#0c2a55] hover:bg-[#103873] text-white text-xs font-bold shadow-md transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL HAPUS AKUN ================= -->
        <div x-show="deleteModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 space-y-4" 
                 @click.outside="deleteModalOpen = false">
                
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-gray-900">Hapus Akun Pengguna</h3>
                        <p class="text-xs text-red-600 font-medium">Tindakan ini permanen dan tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="bg-red-50/70 border border-red-200/80 rounded-xl p-3.5 space-y-1.5">
                    <p class="text-xs text-gray-700">
                        Apakah Anda yakin ingin menghapus akun pengguna berikut?
                    </p>
                    <p class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
                        <span x-text="selectedUser ? selectedUser.name : ''"></span>
                    </p>
                    <p class="text-[11px] text-gray-500 font-mono" x-text="selectedUser ? selectedUser.email : ''"></p>
                    <p class="text-[11px] text-gray-500 mt-2 pt-2 border-t border-red-100">
                        Seluruh data permohonan, riwayat, dan berkas yang terhubung dengan akun ini akan ikut terhapus dari sistem.
                    </p>
                </div>

                <form method="POST" :action="deleteActionUrl" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" 
                                @click="deleteModalOpen = false"
                                class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex-1 py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-md shadow-red-500/20 transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            <span>Ya, Hapus Akun</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-portal-layout>
