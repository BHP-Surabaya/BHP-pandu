<x-portal-layout>
    <x-slot name="title">
        Layanan Terpadu - Balai Harta Peninggalan
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8" 
         x-data="{ 
             search: '', 
             activeTab: 'all',
             infoModal: false, 
             modalTitle: '', 
             modalBadge: '',
             modalDesc: '',
             modalSyarat: [],
             openModal(title, badge, desc, syarat) {
                 this.modalTitle = title;
                 this.modalBadge = badge;
                 this.modalDesc = desc;
                 this.modalSyarat = syarat;
                 this.infoModal = true;
             },
             matches(keywords, category) {
                 const query = this.search.trim().toLowerCase();
                 const matchesSearch = !query || keywords.toLowerCase().includes(query);
                 const matchesCategory = this.activeTab === 'all' || this.activeTab === category;
                 return matchesSearch && matchesCategory;
             }
         }">
        
        <!-- ================= HERO BANNER EKSEKUTIF ================= -->
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-r from-[#071d40] via-[#0b2e66] to-[#0a234c] p-6 sm:p-9 text-white shadow-xl border border-blue-800/40">
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <!-- Brand Pill -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 border border-white/15 text-xs font-semibold backdrop-blur-md shadow-xs">
                        <img src="{{ asset('images/pengayoman.svg') }}" alt="Pengayoman" class="w-4 h-4 object-contain rounded-xs" />
                        <span>Balai Harta Peninggalan (BHP) Kemenkumham RI</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight">
                        Selamat Datang, {{ Auth::user()->name ?? 'Pemohon' }}
                    </h1>
                    
                    <p class="text-xs sm:text-sm text-blue-100/90 leading-relaxed font-normal">
                        Portal pelayanan hukum terpadu Balai Harta Peninggalan Surabaya. Silakan pilih layanan yang ingin Anda ajukan di bawah ini atau pantau seluruh status permohonan melalui menu Histori Permohonan.
                    </p>
                </div>

                <!-- Shortcut Actions -->
                <div class="shrink-0 flex flex-col sm:flex-row lg:flex-col gap-3">
                    <a href="{{ route('permohonan.index') }}" 
                       class="inline-flex items-center justify-center gap-2.5 px-5 py-3 bg-[#1d68d8] hover:bg-[#2575ea] text-white font-bold text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-900/30 transition-all hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Histori Permohonan</span>
                        @php
                            $userCount = Auth::user()?->permohonans()->count() ?? 0;
                        @endphp
                        @if ($userCount > 0)
                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-extrabold">
                                {{ $userCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Subtle Skyline Silhouette Watermark -->
            <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none translate-x-4 translate-y-4">
                <svg class="w-80 h-36 text-white" fill="currentColor" viewBox="0 0 300 120">
                    <path d="M10 110 H290 V120 H10 Z" />
                    <path d="M20 100 H280 V110 H20 Z" />
                    <path d="M30 40 L150 10 L270 40 V50 H30 Z" />
                    <rect x="50" y="50" width="16" height="50" rx="2" />
                    <rect x="80" y="50" width="16" height="50" rx="2" />
                    <rect x="110" y="50" width="16" height="50" rx="2" />
                    <rect x="142" y="50" width="16" height="50" rx="2" />
                    <rect x="174" y="50" width="16" height="50" rx="2" />
                    <rect x="204" y="50" width="16" height="50" rx="2" />
                    <rect x="234" y="50" width="16" height="50" rx="2" />
                </svg>
            </div>
        </div>

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

            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold no-scrollbar">
                <button type="button" 
                        @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'bg-[#0b2e66] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-lg transition shrink-0">
                    Semua Layanan (9)
                </button>
                <button type="button" 
                        @click="activeTab = 'wasiat'" 
                        :class="activeTab === 'wasiat' ? 'bg-[#0b2e66] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3.5 py-1.5 rounded-lg transition shrink-0">
                    Wasiat &amp; Waris (3)
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
                    Pengurusan Harta &amp; Kepailitan (4)
                </button>
            </div>
        </div>

        <!-- ================= KATALOG 9 LAYANAN (GRID 3x3 SIMETRIS SEMPURNA) ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- 1. Pembukaan Wasiat (LAYANAN UTAMA - AKTIF ONLINE) -->
            <div x-show="matches('Pembukaan Wasiat akta wasiat tertutup terbuka ahli waris notaris', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border-2 border-[#1d68d8]/30 hover:border-[#1d68d8] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between relative overflow-hidden bg-gradient-to-b from-white via-white to-blue-50/20">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-bl-full pointer-events-none"></div>
                
                <div>
                    <!-- Header Kartu: Ikon & Badge -->
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
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Tersedia Online
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-[#1d68d8] transition-colors leading-snug">
                        Pembukaan Wasiat
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Permohonan pembukaan akta wasiat tertutup (geheim) atau terbuka dan penyerahan Berita Acara pembukaan wasiat kepada ahli waris sah.
                    </p>
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

            <!-- 2. Pendaftaran Wasiat -->
            <div x-show="matches('Pendaftaran Wasiat register akta notaris lapor', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-sky-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                            Registrasi Notaris
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-sky-700 transition-colors leading-snug">
                        Pendaftaran Wasiat
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pencatatan dan pelaporan daftar akta wasiat yang dibuat di hadapan Notaris ke Pusat Pendaftaran Wasiat Balai Harta Peninggalan.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Pendaftaran Wasiat', 'Registrasi Notaris', 'Layanan pendaftaran daftar akta wasiat yang dibuat di hadapan Notaris untuk dicatat ke dalam buku register resmi BHP Surabaya.', ['Surat Pengantar dari Notaris Pembuat Akta', 'Salinan Akta Wasiat Notariil', 'Identitas Pemberi Wasiat (KTP/KK)', 'Bukti Pembayaran PNBP (bila ada)'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 3. Perwalian -->
            <div x-show="matches('Perwalian anak belum dewasa harta waris wali', 'perlindungan')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Perlindungan Anak
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-emerald-700 transition-colors leading-snug">
                        Perwalian
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pengurusan, pemeliharaan, serta pengawasan atas harta kekayaan anak yang belum dewasa yang berada di bawah perwalian Balai Harta Peninggalan.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Layanan Perwalian', 'Perlindungan Anak', 'Pengawasan dan pengelolaan harta kekayaan anak di bawah umur yang orang tuanya telah meninggal dunia atau dicabut hak asuhnya.', ['Penetapan Pengadilan Negeri / Agama tentang Perwalian', 'Akta Kematian Orang Tua', 'Akta Kelahiran Anak', 'Daftar Harta Peninggalan (Boedel)', 'KTP & KK Wali yang Ditunjuk'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 4. Pengampuan -->
            <div x-show="matches('Pengampuan curatele kurator perlindungan dewasa gangguan', 'perlindungan')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-teal-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                            Curatele
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-teal-700 transition-colors leading-snug">
                        Pengampuan
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pengurusan dan perlindungan harta kekayaan bagi orang dewasa yang berada di bawah pengampuan karena kondisi kesehatan mental atau fisik.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Layanan Pengampuan', 'Curatele', 'Pelayanan kepengurusan harta dan pengawasan bagi individu dewasa yang ditetapkan di bawah pengampuan oleh Pengadilan.', ['Penetapan Pengadilan Negeri tentang Pengampuan', 'Surat Keterangan Dokter/Medis yang Relevan', 'KTP & KK Orang yang Diampu dan Pengampu', 'Daftar Rincian Aset/Harta Kekayaan'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 5. SKHW (Surat Keterangan Hak Waris) -->
            <div x-show="matches('SKHW Surat Keterangan Hak Waris warisan eropa timur asing', 'wasiat')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-amber-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            Hak Waris
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-amber-700 transition-colors leading-snug">
                        SKHW
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Penerbitan Surat Keterangan Hak Waris resmi untuk WNI keturunan Timur Asing dan Eropa berdasarkan ketentuan hukum perdata barat.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Surat Keterangan Hak Waris (SKHW)', 'Hak Waris', 'Penerbitan dokumen legalitas hak waris bagi subjek hukum yang menjadi kewenangan Balai Harta Peninggalan.', ['Surat Kematian Pewaris dari Dispendukcapil', 'Akta Perkawinan / Buku Nikah Pewaris', 'Akta Kelahiran Seluruh Ahli Waris', 'KTP & Kartu Keluarga Seluruh Ahli Waris', 'Surat Keterangan Wasiat dari Ditjen AHU'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 6. Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir -->
            <div x-show="matches('Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir afwezigheid ghaib hilang aset', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-indigo-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                            Afwezigheid
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-indigo-700 transition-colors leading-snug">
                        Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Penatausahaan dan pengelolaan harta kekayaan milik orang yang tidak hadir atau meninggalkan tempat tinggalnya tanpa menunjuk kuasa.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir', 'Afwezigheid', 'Pelayanan pengurusan harta milik orang yang hilang / tidak diketahui keberadaannya berdasarkan putusan pengadilan.', ['Penetapan Pengadilan tentang Ketidakhadiran (Afwezigheid)', 'Surat Keterangan Hilang dari Kepolisian', 'Bukti Kepemilikan Aset / Properti', 'Identitas Pihak Pemohon / Keluarga'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 7. Layanan Harta Peninggalan Yang Tidak Terurus -->
            <div x-show="matches('Layanan Harta Peninggalan Yang Tidak Terurus onbeheerde boedel warisan terlantar', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-blue-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                            <!-- House on Caring Hands -->
                            <svg class="w-8 h-8" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 18l8-7 8 7v10H16V18z" fill="#eff6ff" stroke="#1d4ed8" />
                                <path d="M10 32c4 4 10 5 14 5s10-1 14-5M12 36l12 3 12-3" stroke="#1e3a8a" stroke-width="2.2" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                            Onbeheerde Boedel
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-blue-800 transition-colors leading-snug">
                        Layanan Harta Peninggalan Yang Tidak Terurus
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pengurusan, pendaftaran, dan pemberesan boedel harta peninggalan yang tidak ada ahli warisnya atau seluruh ahli waris menolak warisan.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Layanan Harta Peninggalan Yang Tidak Terurus', 'Onbeheerde Boedel', 'Pengelolaan dan penyelesaian harta peninggalan orang yang meninggal dunia tanpa ahli waris sah yang menerima.', ['Surat Kematian Pewaris', 'Keterangan Penolakan Waris dari Pengadilan (bila ada)', 'Daftar Aset / Harta Benda yang Ditinggalkan', 'Laporan dari Pihak Ketiga / Lingkungan Terkait'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 8. Layanan Uang Pihak Ketiga -->
            <div x-show="matches('Layanan Uang Pihak Ketiga konsinyasi penitipan ganti rugi kas', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-cyan-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-cyan-50 text-cyan-800 border border-cyan-200">
                            Konsinyasi
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-cyan-800 transition-colors leading-snug">
                        Layanan Uang Pihak Ketiga
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Penerimaan, penyimpanan, dan penyaluran uang titipan milik pihak ketiga (konsinyasi pembebasan lahan, eksekusi, dll) pada kas BHP.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Layanan Uang Pihak Ketiga', 'Konsinyasi Kas BHP', 'Penyimpanan dan penyaluran dana titipan pihak ketiga berdasarkan perintah pengadilan atau penetapan hukum.', ['Penetapan Konsinyasi dari Pengadilan Negeri', 'Berita Acara Penitipan Uang Ganti Rugi', 'Identitas Pihak Penerima / Termohon Konsinyasi', 'Nomor Rekening Bank yang Sah'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 9. Layanan Kepailitan -->
            <div x-show="matches('Layanan Kepailitan kurator negara pengadilan niaga pailit insolvensi', 'harta')" 
                 x-transition
                 class="group bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-purple-300 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between">
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                            Kurator Negara
                        </span>
                    </div>

                    <h3 class="text-base font-extrabold text-[#071d40] group-hover:text-purple-700 transition-colors leading-snug">
                        Layanan Kepailitan
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pelaksanaan tugas BHP sebagai Kurator Negara dalam kepengurusan dan pemberesan boedel harta debitur pailit berdasarkan putusan Pengadilan Niaga.
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <button type="button" 
                            @click="openModal('Layanan Kepailitan', 'Kurator Negara', 'Pelaksanaan kewenangan kurator negara untuk mengamankan dan membagikan harta debitur pailit kepada para kreditur.', ['Salinan Putusan Pailit dari Pengadilan Niaga', 'Daftar Kreditur & Debitur Pailit', 'Laporan Harta Kekayaan Debitur Pailit', 'Identitas Kuasa Hukum / Pemohon'])" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#0b2e66] hover:bg-[#1d68d8] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <span>Ajukan Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- ================= MODAL INFORMASI & PERSYARATAN ================= -->
        <div x-show="infoModal" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs" 
             style="display: none;">
            <div @click.away="infoModal = false" 
                 class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5 animate-in fade-in zoom-in duration-150">
                
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1d68d8] flex items-center justify-center shrink-0">
                            <img src="{{ asset('images/pengayoman.svg') }}" alt="Pengayoman" class="w-7 h-7 object-contain" />
                        </div>
                        <div>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 mb-1" x-text="modalBadge"></span>
                            <h3 class="text-base font-extrabold text-[#071d40]" x-text="modalTitle"></h3>
                        </div>
                    </div>
                    <button type="button" @click="infoModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <h4 class="font-bold text-slate-900 mb-1">Deskripsi Layanan</h4>
                        <p class="text-slate-600 leading-relaxed" x-text="modalDesc"></p>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Persyaratan Dokumen Umum:</h4>
                        <ul class="space-y-1.5 pl-1">
                            <template x-for="(syarat, idx) in modalSyarat" :key="idx">
                                <li class="flex items-start gap-2 text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span x-text="syarat"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200/80 text-amber-800 text-[11px] leading-relaxed flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Untuk konsultasi berkas fisik atau pengajuan tatap muka, Anda dapat langsung mengunjungi loket pelayanan Balai Harta Peninggalan Surabaya.</span>
                    </div>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="button" @click="infoModal = false" class="w-full py-2.5 px-4 bg-[#071d40] hover:bg-[#0b2e66] text-white font-bold text-xs rounded-xl transition cursor-pointer">
                        Mengerti &amp; Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Siluet Panorama Memanjang Surabaya & BHP (Jembatan Suramadu, Tugu Pahlawan, Skyline & Gedung BHP) -->
        <div class="pointer-events-none select-none -mx-4 sm:-mx-6 lg:-mx-8 -mb-6 sm:-mb-8 pt-4 overflow-hidden">
            <img src="{{ asset('images/panorama-skyline-surabaya-bhp.svg') }}" 
                 alt="Panorama Skyline Surabaya &amp; Balai Harta Peninggalan" 
                 class="w-full h-auto max-h-36 sm:max-h-48 object-cover object-bottom" />
        </div>

    </div>
</x-portal-layout>
