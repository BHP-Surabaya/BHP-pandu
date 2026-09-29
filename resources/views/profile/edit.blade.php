<x-portal-layout>
    <x-slot name="title">
        Profil Akun - Balai Harta Peninggalan
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6"
         x-data="{ 
             activeTab: 'profile',
             alamatKtp: @js(old('alamat_ktp', $user->alamat_ktp ?? '')),
             domisiliSamaKtp: @js($user->alamat_ktp && $user->alamat_ktp === $user->alamat_domisili ? true : false),
             alamatDomisili: @js(old('alamat_domisili', $user->alamat_domisili ?? '')),
             pekerjaan: @js(old('pekerjaan', $user->pekerjaan ?? '')),
             skFileName: '',
             syncDomisili() {
                 if (this.domisiliSamaKtp) {
                     this.alamatDomisili = this.alamatKtp;
                 }
             }
         }">
        
        <!-- ================= PAGE TITLE ================= -->
        <div>
            <h2 class="text-2xl font-bold text-[#0c2a55] tracking-tight">
                Pengaturan Profil Akun
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kelola informasi data diri, legalitas profesi, dan keamanan akses akun Balai Harta Peninggalan Anda.
            </p>
        </div>

        <!-- ================= STATUS NOTIFIKASI ================= -->
        @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-transition class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold">Profil Berhasil Diperbarui!</p>
                        <p class="text-xs text-emerald-600">Seluruh perubahan data identitas Anda telah berhasil disimpan ke sistem.</p>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-transition class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold">Kata Sandi Berhasil Diperbarui!</p>
                        <p class="text-xs text-emerald-600">Kata sandi baru Anda telah aktif. Gunakan sandi baru pada sesi login berikutnya.</p>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- ================= KARTU IDENTITAS HEADER PROFIL ================= -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-center gap-5 text-center sm:text-left w-full sm:w-auto">
                <!-- Avatar Initials -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#0c2a55] text-amber-300 font-extrabold text-2xl sm:text-3xl flex items-center justify-center shadow-md ring-4 ring-blue-50 shrink-0">
                    {{ $user->initials ?? 'US' }}
                </div>

                <div class="space-y-1.5 min-w-0">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <h1 class="text-xl sm:text-2xl font-bold text-[#0c2a55] tracking-tight">
                            {{ $user->name }}
                        </h1>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $user->pekerjaan === 'Notaris' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-100 text-[#0066d6] border border-blue-200' }}">
                            {{ $user->pekerjaan ?: 'Pemohon Layanan' }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Akun Aktif
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $user->email }}
                        </span>
                        @if ($user->phone)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $user->phone }}
                            </span>
                        @endif
                        <span class="hidden sm:inline text-gray-300">•</span>
                        <span>Terdaftar: {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= NAVIGASI TAB MODEREN ================= -->
        <div class="flex border-b border-gray-200 gap-6 text-sm font-semibold">
            <button type="button" 
                    @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ? 'border-[#0066d6] text-[#0066d6] border-b-2 pb-3' : 'text-gray-500 hover:text-gray-700 pb-3 border-b-2 border-transparent'"
                    class="transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Data Diri &amp; Profesi</span>
            </button>

            <button type="button" 
                    @click="activeTab = 'security'"
                    :class="activeTab === 'security' ? 'border-[#0066d6] text-[#0066d6] border-b-2 pb-3' : 'text-gray-500 hover:text-gray-700 pb-3 border-b-2 border-transparent'"
                    class="transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <span>Keamanan Sandi</span>
            </button>

            <button type="button" 
                    @click="activeTab = 'account'"
                    :class="activeTab === 'account' ? 'border-red-600 text-red-600 border-b-2 pb-3' : 'text-gray-500 hover:text-gray-700 pb-3 border-b-2 border-transparent'"
                    class="transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span>Pengaturan Akun</span>
            </button>
        </div>

        <!-- ================= TAB 1: DATA DIRI & PROFESI ================= -->
        <div x-show="activeTab === 'profile'" x-cloak class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-[#0c2a55]">Informasi Data Identitas &amp; Profesi</h3>
                        <p class="text-xs text-gray-500">Perbarui data yang dibutuhkan untuk proses administrasi hukum di BHP.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Grid Data Diri Pokok -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('name') border-red-500 @enderror" />
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('email') border-red-500 @enderror" />
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-gray-700 mb-1">
                                Nomor Induk Kependudukan (NIK)
                            </label>
                            <input id="nik" 
                                   name="nik" 
                                   type="text" 
                                   maxlength="16"
                                   placeholder="16 digit angka NIK"
                                   value="{{ old('nik', $user->nik) }}" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('nik') border-red-500 @enderror" />
                            @error('nik')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor WhatsApp / HP -->
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                Nomor WhatsApp / HP
                            </label>
                            <input id="phone" 
                                   name="phone" 
                                   type="text" 
                                   placeholder="Contoh: 081234567890"
                                   value="{{ old('phone', $user->phone) }}" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('phone') border-red-500 @enderror" />
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan / Profesi -->
                        <div class="sm:col-span-2">
                            <label for="pekerjaan" class="block text-xs font-semibold text-gray-700 mb-1">
                                Pekerjaan / Profesi
                            </label>
                            <input id="pekerjaan" 
                                   name="pekerjaan" 
                                   type="text" 
                                   x-model="pekerjaan"
                                   placeholder="Contoh: Notaris, Advokat, Wiraswasta, Pegawai Swasta, dll"
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('pekerjaan') border-red-500 @enderror" />
                            @error('pekerjaan')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Panel Khusus Notaris -->
                    <div x-show="pekerjaan === 'Notaris' || {{ $user->pekerjaan === 'Notaris' ? 'true' : 'false' }}" 
                         class="p-5 bg-blue-50/60 border border-blue-200/80 rounded-2xl space-y-4">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-blue-200">
                            <div class="w-7 h-7 rounded-lg bg-[#0066d6] text-white flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-[#0c2a55]">Kelengkapan Berkas &amp; Kantor Notaris</h4>
                                <p class="text-[11px] text-gray-500">Legalitas profesi Notaris untuk verifikasi penerbitan akta dan layanan wasiat.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Berkas SK Notaris -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    Berkas SK Notaris
                                </label>

                                @if ($user->sk_notaris)
                                    <div class="mb-3 p-3 bg-white rounded-xl border border-blue-200 flex items-center justify-between gap-3 shadow-xs">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-gray-800 truncate">SK Notaris Terverifikasi</p>
                                                <p class="text-[10px] text-gray-500">Berkas tersimpan aman</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $user->sk_notaris) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#0066d6] hover:bg-[#0055b8] text-white font-semibold text-xs transition shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            <span>Buka Berkas</span>
                                        </a>
                                    </div>
                                @endif

                                <div class="relative">
                                    <input id="sk_notaris" 
                                           name="sk_notaris" 
                                           type="file" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           @change="skFileName = $event.target.files[0] ? $event.target.files[0].name : ''"
                                           class="hidden" />
                                    <label for="sk_notaris" 
                                           class="flex flex-col items-center justify-center px-4 py-3.5 border-2 border-dashed border-blue-300 hover:border-[#0066d6] bg-white rounded-xl cursor-pointer transition text-center hover:bg-blue-50/50">
                                        <svg class="w-6 h-6 text-[#0066d6] mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span x-show="!skFileName" class="text-xs font-semibold text-gray-700">
                                            {{ $user->sk_notaris ? 'Unggah Berkas Baru Pengganti' : 'Pilih Berkas SK Notaris' }}
                                        </span>
                                        <span x-show="skFileName" x-text="skFileName" class="text-xs font-bold text-[#0066d6] break-all"></span>
                                        <span class="text-[10px] text-gray-400 mt-1">Format PDF, JPG, PNG (Maks. 25MB)</span>
                                    </label>
                                </div>
                                @error('sk_notaris')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Kantor Notaris -->
                            <div>
                                <label for="alamat_kantor" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Alamat Kantor Notaris
                                </label>
                                <textarea id="alamat_kantor" 
                                          name="alamat_kantor" 
                                          rows="4" 
                                          placeholder="Alamat lengkap kantor notaris (Jalan, Nomor, Kecamatan, Kota/Kabupaten)"
                                          class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition resize-y @error('alamat_kantor') border-red-500 @enderror">{{ old('alamat_kantor', $user->alamat_kantor) }}</textarea>
                                @error('alamat_kantor')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Alamat KTP & Domisili -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-3 border-t border-gray-100">
                        <!-- Alamat KTP -->
                        <div>
                            <label for="alamat_ktp" class="block text-xs font-semibold text-gray-700 mb-1">
                                Alamat Sesuai KTP
                            </label>
                            <textarea id="alamat_ktp" 
                                      name="alamat_ktp" 
                                      rows="3" 
                                      x-model="alamatKtp"
                                      @input="syncDomisili()"
                                      placeholder="Alamat lengkap sesuai identitas KTP"
                                      class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition resize-y @error('alamat_ktp') border-red-500 @enderror">{{ old('alamat_ktp', $user->alamat_ktp) }}</textarea>
                            @error('alamat_ktp')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Domisili -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="alamat_domisili" class="block text-xs font-semibold text-gray-700">
                                    Alamat Domisili Saat Ini
                                </label>
                                <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs text-gray-600 hover:text-gray-900">
                                    <input type="checkbox" 
                                           x-model="domisiliSamaKtp" 
                                           @change="syncDomisili()"
                                           class="rounded border-gray-300 text-[#0066d6] focus:ring-[#0066d6] w-3.5 h-3.5">
                                    <span class="text-[11px] font-medium text-gray-500">Sama dengan KTP</span>
                                </label>
                            </div>
                            <textarea id="alamat_domisili" 
                                      name="alamat_domisili" 
                                      rows="3" 
                                      x-model="alamatDomisili"
                                      :readonly="domisiliSamaKtp"
                                      :class="{ 'bg-gray-100 text-gray-500 cursor-not-allowed': domisiliSamaKtp }"
                                      placeholder="Alamat tempat tinggal saat ini"
                                      class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition resize-y @error('alamat_domisili') border-red-500 @enderror">{{ old('alamat_domisili', $user->alamat_domisili) }}</textarea>
                            @error('alamat_domisili')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Simpan Perubahan -->
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm transition hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Perubahan Data</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= TAB 2: KEAMANAN KATA SANDI ================= -->
        <div x-show="activeTab === 'security'" x-cloak class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden max-w-2xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-[#0c2a55]">Perbarui Kata Sandi</h3>
                    <p class="text-xs text-gray-500">Pastikan akun Anda menggunakan kata sandi yang aman dan tidak mudah ditebak.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-xs font-semibold text-gray-700 mb-1">
                            Kata Sandi Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <input id="current_password" 
                               name="current_password" 
                               type="password" 
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('current_password', 'updatePassword') border-red-500 @enderror" />
                        @error('current_password', 'updatePassword')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                            Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('password', 'updatePassword') border-red-500 @enderror" />
                        @error('password', 'updatePassword')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">
                            Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               autocomplete="new-password"
                               placeholder="Ulangi kata sandi baru"
                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6] focus:border-[#0066d6] transition @error('password_confirmation', 'updatePassword') border-red-500 @enderror" />
                        @error('password_confirmation', 'updatePassword')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= TAB 3: PENGATURAN & HAPUS AKUN ================= -->
        <div x-show="activeTab === 'account'" x-cloak class="space-y-6">
            <div class="bg-white rounded-2xl border border-red-200 shadow-xs overflow-hidden max-w-2xl">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50/50 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-red-900">Hapus Akun Pengguna</h3>
                        <p class="text-xs text-red-600">Tindakan ini permanen dan akan menghapus seluruh data permohonan Anda.</p>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Setelah akun Anda dihapus, semua data profil, histori berkas pengajuan wasiat, serta akses akun akan dibersihkan secara permanen. Pastikan Anda telah menyimpan dokumen atau arsip penting sebelum melanjutkan.
                    </p>

                    <div>
                        <button type="button" 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl shadow-xs transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus Akun Saya Secara Permanen</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900">
                        Konfirmasi Penghapusan Akun
                    </h2>
                    <p class="text-xs text-gray-500">
                        Ketik kata sandi Anda untuk memverifikasi bahwa Anda adalah pemilik sah akun ini.
                    </p>
                </div>
            </div>

            <div>
                <input id="password_delete"
                       name="password"
                       type="password"
                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                       placeholder="Masukkan kata sandi Anda..." />
                @error('password', 'userDeletion')
                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                <button type="button" 
                        x-on:click="$dispatch('close')" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition shadow-xs cursor-pointer">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>

</x-portal-layout>
