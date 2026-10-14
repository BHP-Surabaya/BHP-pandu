<x-portal-layout>
    <x-slot:title>
        Tinjau Verifikasi: {{ $user->name }} - Master Admin BHP
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ 
        approveModalOpen: false, 
        rejectModalOpen: false,
        switchModalOpen: false,
        deleteModalOpen: false,
        targetStatus: '{{ $user->status_akun ?: 'perorangan' }}',
        catatanTolak: '',
        previewModalOpen: false,
        previewUrl: '',
        previewTitle: ''
    }">
        <!-- Breadcrumb & Back -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.verifikasi.index') }}" 
               class="inline-flex items-center gap-2 text-xs font-semibold text-gray-500 hover:text-[#0066d6] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                <span>Kembali ke Daftar Verifikasi &amp; Akun</span>
            </a>

            <!-- Quick Status Badge -->
            <div>
                @if ($user->status_akun === 'notaris')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-900 border border-blue-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Akun Notaris Aktif
                    </span>
                @elseif ($user->status_akun === 'pengacara')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-900 border border-indigo-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                        Akun Pengacara Aktif
                    </span>
                @elseif ($user->isVerifikasiPending())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Verifikasi
                    </span>
                @elseif ($user->status_verifikasi === 'ditolak')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-900 border border-red-200 text-xs font-bold">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        Pengajuan Ditolak
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-200 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Akun Perorangan Aktif
                    </span>
                @endif
            </div>
        </div>

        <!-- User Identity Header Banner -->
        <div class="bg-gradient-to-r from-[#0c2a55] via-[#103873] to-[#0a1e3d] rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white font-extrabold text-xl flex items-center justify-center shadow-inner shrink-0">
                    {{ $user->initials }}
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">{{ $user->name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/20 text-white text-xs font-bold">
                            Saat ini: {{ $user->status_akun_label }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-blue-200/80 mt-1">
                        Terdaftar sejak {{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }} WIB
                    </p>
                </div>
            </div>

            <!-- Action Buttons in Header -->
            <div class="flex items-center gap-2.5 relative z-10 flex-wrap">
                <!-- Pindah Status Button -->
                <button type="button" 
                        @click="switchModalOpen = true"
                        class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    <span>Pindah Status</span>
                </button>

                <button type="button" 
                        @click="rejectModalOpen = true"
                        class="px-3.5 py-2.5 rounded-xl bg-red-600/90 hover:bg-red-600 active:bg-red-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    <span>Tolak</span>
                </button>

                <button type="button" 
                        @click="approveModalOpen = true"
                        class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    <span>Setujui Profesi</span>
                </button>

                <!-- Tombol Hapus Akun -->
                <button type="button" 
                        @click="deleteModalOpen = true"
                        class="px-3.5 py-2.5 rounded-xl bg-red-700 hover:bg-red-800 active:bg-red-900 text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition cursor-pointer"
                        title="Hapus Akun Pengguna">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    <span>Hapus Akun</span>
                </button>
            </div>
        </div>

        <!-- Alert Catatan Verifikasi Jika Pernah Ditolak / Ada Catatan -->
        @if ($user->catatan_verifikasi)
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950 text-xs sm:text-sm flex items-start gap-3 shadow-sm">
                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="space-y-1">
                    <h4 class="font-bold text-amber-950">Catatan Verifikasi Terakhir:</h4>
                    <p class="leading-relaxed text-amber-900">{{ $user->catatan_verifikasi }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Data Profil & Identitas -->
            <div class="space-y-6">
                <!-- Identitas Diri Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-[#0066d6] flex items-center justify-center font-bold text-xs">
                            1
                        </div>
                        <h3 class="text-sm font-bold text-gray-800">Identitas Pemohon</h3>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div>
                            <p class="text-gray-400 font-medium">Nama Lengkap</p>
                            <p class="font-bold text-gray-800 mt-0.5 text-sm">{{ $user->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">Alamat Email</p>
                            <p class="font-bold text-gray-800 mt-0.5">{{ $user->email }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">NIK (KTP)</p>
                            <p class="font-mono font-bold text-gray-800 mt-0.5">{{ $user->nik ?: '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">Nomor WhatsApp / HP</p>
                            <p class="font-bold text-gray-800 mt-0.5">{{ $user->phone ?: '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">Pekerjaan Saat Daftar</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $user->pekerjaan ?: '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">Status Akun Saat Ini</p>
                            <p class="font-bold text-[#0066d6] mt-0.5 uppercase tracking-wider text-[11px]">{{ $user->status_akun_label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Alamat Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-[#0066d6] flex items-center justify-center font-bold text-xs">
                            2
                        </div>
                        <h3 class="text-sm font-bold text-gray-800">Data Alamat</h3>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <div>
                            <p class="text-gray-400 font-medium">Alamat KTP</p>
                            <p class="font-medium text-gray-800 mt-0.5 leading-relaxed bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                                {{ $user->alamat_ktp ?: 'Belum diisi' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">Alamat Domisili</p>
                            <p class="font-medium text-gray-800 mt-0.5 leading-relaxed bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                                {{ $user->alamat_domisili ?: 'Belum diisi' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400 font-medium">Alamat Kantor Profesi</p>
                            <p class="font-medium text-gray-800 mt-0.5 leading-relaxed bg-blue-50/60 p-2.5 rounded-xl border border-blue-100 text-blue-950 font-semibold">
                                {{ $user->alamat_kantor ?: 'Belum dilampirkan' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Dokumen Legalitas Khusus Profesi (2 Kolom di Desktop) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6 shadow-sm space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-[#0066d6] flex items-center justify-center font-bold text-xs">
                                3
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800">Berkas Legalitas Profesi</h3>
                                <p class="text-[11px] text-gray-400">Periksa kesesuaian dokumen resmi sebelum memberikan persetujuan role.</p>
                            </div>
                        </div>
                    </div>

                    @if ($user->isNotaris())
                        <!-- Berkas Notaris Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Dokumen 1: SK Notaris -->
                            <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/40 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-[#0066d6] text-white flex items-center justify-center font-bold text-xs">
                                            SK
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-900">SK Notaris</h4>
                                            <p class="text-[10px] text-gray-500">Surat Keputusan Pengangkatan</p>
                                        </div>
                                    </div>
                                    @if ($user->sk_notaris)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Terlampir</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800">Kosong</span>
                                    @endif
                                </div>

                                @if ($user->sk_notaris)
                                    <div class="pt-2">
                                        <a href="{{ asset('storage/' . $user->sk_notaris) }}" 
                                           target="_blank" 
                                           class="w-full py-2.5 px-3 rounded-lg bg-white border border-blue-200 hover:bg-blue-50 text-[#0066d6] font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            <span>Buka &amp; Periksa Dokumen SK</span>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">Pendaftar belum mengunggah file SK Notaris.</p>
                                @endif
                            </div>

                            <!-- Dokumen 2: SK PPAT -->
                            <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/40 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-[#0066d6] text-white flex items-center justify-center font-bold text-xs">
                                            PPAT
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-900">SK PPAT</h4>
                                            <p class="text-[10px] text-gray-500">SK Pejabat Pembuat Akta Tanah</p>
                                        </div>
                                    </div>
                                    @if ($user->sk_ppat)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Terlampir</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800">Kosong</span>
                                    @endif
                                </div>

                                @if ($user->sk_ppat)
                                    <div class="pt-2">
                                        <a href="{{ asset('storage/' . $user->sk_ppat) }}" 
                                           target="_blank" 
                                           class="w-full py-2.5 px-3 rounded-lg bg-white border border-blue-200 hover:bg-blue-50 text-[#0066d6] font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            <span>Buka &amp; Periksa Dokumen PPAT</span>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">Pendaftar belum mengunggah file SK PPAT.</p>
                                @endif
                            </div>
                        </div>

                    @elseif ($user->isPengacara())
                        <!-- Berkas Pengacara Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Dokumen 1: BA Sumpah PT -->
                            <div class="p-4 rounded-xl border border-indigo-100 bg-indigo-50/40 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                                            BA
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-900">BA Sumpah PT</h4>
                                            <p class="text-[10px] text-gray-500">Berita Acara Pengadilan Tinggi</p>
                                        </div>
                                    </div>
                                    @if ($user->berita_acara_sumpah)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Terlampir</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800">Kosong</span>
                                    @endif
                                </div>

                                @if ($user->berita_acara_sumpah)
                                    <div class="pt-2">
                                        <a href="{{ asset('storage/' . $user->berita_acara_sumpah) }}" 
                                           target="_blank" 
                                           class="w-full py-2.5 px-3 rounded-lg bg-white border border-indigo-200 hover:bg-indigo-50 text-indigo-700 font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            <span>Buka &amp; Periksa BA Sumpah</span>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">Pendaftar belum mengunggah file BA Sumpah.</p>
                                @endif
                            </div>

                            <!-- Dokumen 2: ID Card Pengacara -->
                            <div class="p-4 rounded-xl border border-indigo-100 bg-indigo-50/40 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                                            KTA
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-900">ID Card Pengacara</h4>
                                            <p class="text-[10px] text-gray-500">Kartu Tanda Advokat / Organisasi</p>
                                        </div>
                                    </div>
                                    @if ($user->id_card_pengacara)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Terlampir</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800">Kosong</span>
                                    @endif
                                </div>

                                @if ($user->id_card_pengacara)
                                    <div class="pt-2">
                                        <a href="{{ asset('storage/' . $user->id_card_pengacara) }}" 
                                           target="_blank" 
                                           class="w-full py-2.5 px-3 rounded-lg bg-white border border-indigo-200 hover:bg-indigo-50 text-indigo-700 font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            <span>Buka &amp; Periksa ID Card</span>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">Pendaftar belum mengunggah file ID Card Pengacara.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-400 italic bg-gray-50 rounded-xl">
                            Pendaftar mendaftar sebagai Akun Perorangan reguler dan tidak memerlukan berkas verifikasi profesi.
                        </div>
                    @endif
                </div>

                <!-- Panel Pindahkan Status Akun Langsung -->
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                        <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Pindahkan Status Akun Pengguna</h3>
                            <p class="text-[11px] text-gray-400">Master Admin dapat memindahkan atau menetapkan status akun ini ke profesi lain kapan saja.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.verifikasi.update-status', $user) }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Opsi Notaris -->
                            <label class="flex flex-col p-3.5 rounded-xl border cursor-pointer transition select-none"
                                   :class="targetStatus === 'notaris' ? 'bg-blue-50/90 border-blue-500 ring-2 ring-blue-500/20' : 'bg-gray-50/70 border-gray-200 hover:bg-gray-100/70'">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-blue-950">Akun Notaris</span>
                                    <input type="radio" name="status_akun" value="notaris" x-model="targetStatus" class="w-4 h-4 text-[#0066d6] focus:ring-[#0066d6]">
                                </div>
                                <span class="text-[10.5px] text-gray-500 leading-snug">Hak akses pelaporan dan pendaftaran akta wasiat notaris.</span>
                            </label>

                            <!-- Opsi Pengacara -->
                            <label class="flex flex-col p-3.5 rounded-xl border cursor-pointer transition select-none"
                                   :class="targetStatus === 'pengacara' ? 'bg-indigo-50/90 border-indigo-500 ring-2 ring-indigo-500/20' : 'bg-gray-50/70 border-gray-200 hover:bg-gray-100/70'">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-indigo-950">Akun Pengacara</span>
                                    <input type="radio" name="status_akun" value="pengacara" x-model="targetStatus" class="w-4 h-4 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <span class="text-[10.5px] text-gray-500 leading-snug">Hak akses permohonan wasiat selaku kuasa hukum resmi.</span>
                            </label>

                            <!-- Opsi Perorangan -->
                            <label class="flex flex-col p-3.5 rounded-xl border cursor-pointer transition select-none"
                                   :class="targetStatus === 'perorangan' ? 'bg-emerald-50/90 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-gray-50/70 border-gray-200 hover:bg-gray-100/70'">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-emerald-950">Akun Perorangan</span>
                                    <input type="radio" name="status_akun" value="perorangan" x-model="targetStatus" class="w-4 h-4 text-emerald-600 focus:ring-emerald-600">
                                </div>
                                <span class="text-[10.5px] text-gray-500 leading-snug">Akun pemohon umum perseorangan (tanpa hak profesi).</span>
                            </label>
                        </div>

                        <div>
                            <label for="catatan_verifikasi_panel" class="block text-xs font-semibold text-gray-700 mb-1">
                                Catatan Pemindahan Status (Opsional)
                            </label>
                            <input id="catatan_verifikasi_panel" 
                                   name="catatan_verifikasi" 
                                   type="text" 
                                   placeholder="Contoh: Disetujui manual oleh Master Admin setelah verifikasi langsung."
                                   class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="py-2.5 px-5 bg-[#0c2a55] hover:bg-[#103873] active:bg-[#081d3b] text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>Simpan Perubahan Status Akun</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Petunjuk & SOP Verifikasi -->
                <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-5 text-xs text-blue-950 space-y-2">
                    <h4 class="font-bold flex items-center gap-2 text-sm text-[#0c2a55]">
                        <svg class="w-4 h-4 text-[#0066d6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Standar Verifikasi &amp; Pemindahan Akun Profesi BHP:
                    </h4>
                    <ul class="list-disc pl-5 space-y-1 text-blue-900/90 leading-relaxed">
                        <li>Master Admin berhak memindahkan status akun kapan saja sesuai bukti keabsahan dokumen.</li>
                        <li>Pastikan nama lengkap pada SK / Berita Acara Sumpah sesuai dengan nama akun pemohon.</li>
                        <li>Ketika status akun dipindahkan ke Notaris atau Pengacara, akun tersebut otomatis aktif dan terverifikasi.</li>
                        <li>Jika terdapat berkas yang buram atau tidak valid, Anda dapat menolak pengajuan dengan mencantumkan alasan spesifik.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ================= MODAL PINDAH STATUS ================= -->
        <div x-show="switchModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 space-y-4" @click.outside="switchModalOpen = false">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                </div>

                <div class="text-center space-y-1">
                    <h3 class="text-lg font-bold text-gray-900">Pindahkan Status Akun</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pilih status akun baru untuk <strong>{{ $user->name }}</strong>. Hak akses sistem akan diperbarui otomatis.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.verifikasi.update-status', $user) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Status Akun:</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="targetStatus === 'notaris' ? 'bg-blue-50 border-blue-500 ring-1 ring-blue-500' : 'bg-gray-50/70 border-gray-200 hover:bg-gray-100/60'">
                                <input type="radio" name="status_akun" value="notaris" x-model="targetStatus" class="w-4 h-4 text-[#0066d6] focus:ring-[#0066d6]">
                                <div>
                                    <p class="text-xs font-bold text-blue-950">Akun Notaris</p>
                                    <p class="text-[11px] text-gray-500">Mendapatkan akses penuh registrasi &amp; pelaporan wasiat Notaris.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="targetStatus === 'pengacara' ? 'bg-indigo-50 border-indigo-500 ring-1 ring-indigo-500' : 'bg-gray-50/70 border-gray-200 hover:bg-gray-100/60'">
                                <input type="radio" name="status_akun" value="pengacara" x-model="targetStatus" class="w-4 h-4 text-indigo-600 focus:ring-indigo-600">
                                <div>
                                    <p class="text-xs font-bold text-indigo-950">Akun Pengacara</p>
                                    <p class="text-[11px] text-gray-500">Mendapatkan akses permohonan dengan kuasa hukum resmi.</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition"
                                   :class="targetStatus === 'perorangan' ? 'bg-emerald-50 border-emerald-500 ring-1 ring-emerald-500' : 'bg-gray-50/70 border-gray-200 hover:bg-gray-100/60'">
                                <input type="radio" name="status_akun" value="perorangan" x-model="targetStatus" class="w-4 h-4 text-emerald-600 focus:ring-emerald-600">
                                <div>
                                    <p class="text-xs font-bold text-emerald-950">Akun Perorangan</p>
                                    <p class="text-[11px] text-gray-500">Akun reguler pemohon perorangan umum.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="catatan_switch" class="block text-xs font-semibold text-gray-700 mb-1">
                            Catatan Pemindahan Status (Opsional)
                        </label>
                        <input id="catatan_switch" 
                               name="catatan_verifikasi" 
                               type="text" 
                               placeholder="Contoh: Dipindahkan secara manual oleh Master Admin."
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
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

        <!-- ================= MODAL PERSETUJUAN (APPROVE) ================= -->
        <div x-show="approveModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 space-y-4" @click.outside="approveModalOpen = false">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>

                <div class="text-center space-y-1">
                    <h3 class="text-lg font-bold text-gray-900">Setujui Akun Profesi?</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Anda akan menyetujui akun <strong>{{ $user->name }}</strong> sebagai <strong>{{ ucfirst($user->jenis_akun) }}</strong>. Hak akses pendaftaran dan pelaporan profesi akan diaktifkan secara otomatis.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.verifikasi.approve', $user) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="catatan_approve" class="block text-xs font-semibold text-gray-700 mb-1">
                            Catatan Persetujuan (Opsional)
                        </label>
                        <input id="catatan_approve" 
                               name="catatan_verifikasi" 
                               type="text" 
                               placeholder="Contoh: Berkas legalitas lengkap dan terverifikasi."
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" 
                                @click="approveModalOpen = false"
                                class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex-1 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-900/10 transition">
                            Ya, Setujui Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL PENOLAKAN (REJECT) ================= -->
        <div x-show="rejectModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 space-y-4" @click.outside="rejectModalOpen = false">
                <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>

                <div class="text-center space-y-1">
                    <h3 class="text-lg font-bold text-gray-900">Tolak Pengajuan Akun?</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pengajuan profesi untuk <strong>{{ $user->name }}</strong> akan ditolak. Akun tetap berstatus sebagai Akun Perorangan dan alasan penolakan akan ditampilkan kepada pengguna.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.verifikasi.reject', $user) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="catatan_verifikasi" class="block text-xs font-semibold text-gray-700 mb-1">
                            Alasan Penolakan / Kekurangan Berkas <span class="text-red-500">*</span>
                        </label>
                        <textarea id="catatan_verifikasi" 
                                  name="catatan_verifikasi" 
                                  rows="3" 
                                  required
                                  placeholder="Contoh: Berkas SK Notaris tidak terbaca / buram. Mohon unggah ulang salinan yang lebih jelas."
                                  class="w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition resize-y"></textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" 
                                @click="rejectModalOpen = false"
                                class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 text-gray-700 text-xs font-semibold hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex-1 py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-md shadow-red-900/10 transition">
                            Tolak Berkas
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL HAPUS AKUN ================= -->
        <div x-show="deleteModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 space-y-4" @click.outside="deleteModalOpen = false">
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
                        Apakah Anda yakin ingin menghapus akun <strong>{{ $user->name }}</strong> ({{ $user->email }})?
                    </p>
                    <p class="text-[11px] text-gray-500 mt-2 pt-2 border-t border-red-100">
                        Seluruh data permohonan, riwayat, dan dokumen berkas terkait akun ini akan dihapus secara permanen dari sistem.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.verifikasi.destroy', $user) }}" class="space-y-4">
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
