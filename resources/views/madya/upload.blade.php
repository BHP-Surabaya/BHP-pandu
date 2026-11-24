<x-portal-layout>
    <x-slot:title>
        Kelengkapan Berkas Sidang — Kurator Keperdataan Madya BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{ uploadModalOpen: false, activeSlot: null, activeSlotTitle: '' }">
        
        <!-- Header & Navigasi -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('madya.dashboard') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        <span>Daftar Layanan</span>
                    </a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Kelengkapan Berkas Sidang</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    Unggah dan Kelola Berkas Sidang Wasiat
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    No. Layanan: <span class="font-mono font-bold text-blue-700">{{ $permohonan->nomor_permohonan ?: ('WST-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT)) }}</span> &bull; 
                    Pemohon: <span class="font-semibold text-slate-800">{{ $permohonan->user?->name ?? 'Pemohon' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('madya.layanan.buat-ba.page', $permohonan->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 shadow-2xs transition">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <span>Form Berita Acara</span>
                </a>

                <!-- Form Toggle Kunci Dokumen -->
                <form action="{{ route('madya.layanan.toggle-kunci', $permohonan->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            title="{{ $permohonan->dokumen_terkunci ? 'Buka kunci berkas' : 'Kunci seluruh berkas dari perubahan' }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-xs cursor-pointer {{ $permohonan->dokumen_terkunci ? 'bg-amber-100 text-amber-900 border border-amber-300 hover:bg-amber-200' : 'bg-slate-900 text-white hover:bg-slate-800' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            @if($permohonan->dokumen_terkunci)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            @endif
                        </svg>
                        <span>{{ $permohonan->dokumen_terkunci ? 'Terkunci (Buka Kunci)' : 'Kunci Berkas' }}</span>
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Banner Status Kunci & Progres Kelengkapan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Card 1: Kelengkapan Berkas Wajib -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $completedRequired >= $totalRequired ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center font-bold text-lg shrink-0">
                    {{ $completedRequired }}/{{ $totalRequired }}
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Kelengkapan Berkas Wajib</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ $completedRequired >= $totalRequired ? 'Seluruh berkas wajib telah lengkap.' : 'Menunggu unggahan berkas yang tersisa.' }}
                    </p>
                </div>
            </div>

            <!-- Card 2: Status Gembok Keamanan -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $permohonan->dokumen_terkunci ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Status Dokumen</h3>
                    <p class="text-xs {{ $permohonan->dokumen_terkunci ? 'text-amber-700 font-semibold' : 'text-slate-500' }} mt-0.5">
                        {{ $permohonan->dokumen_terkunci ? 'Dokumen Terkunci & Diamankan' : 'Mode Terbuka (Bisa Unggah)' }}
                    </p>
                </div>
            </div>

            <!-- Card 3: Opsi Selesaikan & Arsipkan -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Arsip Layanan</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">
                        Selesaikan sidang dan arsipkan warkah digital.
                    </p>
                </div>
                <form action="{{ route('madya.layanan.arsipkan', $permohonan->id) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Apakah Anda yakin ingin menyelesaikan dan mengarsipkan layanan ini? Seluruh berkas akan otomatis dikunci.')"
                            class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition shrink-0 cursor-pointer">
                        Selesaikan & Arsipkan
                    </button>
                </form>
            </div>

        </div>

        <!-- ================= 6 SLOT GRID DOKUMEN SIDANG ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($slots as $slot)
                @php
                    $uploadedDoc = $dokumens->where('jenis_dokumen', $slot['key'])->first();
                @endphp
                <div class="bg-white rounded-2xl border {{ $uploadedDoc ? 'border-emerald-200/80 shadow-xs' : 'border-slate-200/80' }} p-5 flex flex-col justify-between transition hover:border-slate-300">
                    
                    <div>
                        <!-- Header Slot -->
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $slot['required'] ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $slot['required'] ? 'Wajib' : 'Opsional' }}
                            </span>
                            
                            @if ($uploadedDoc)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Terunggah
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-400">
                                    Belum Diunggah
                                </span>
                            @endif
                        </div>

                        <!-- Judul & Deskripsi Slot -->
                        <h3 class="text-sm font-bold text-slate-900">
                            {{ $slot['judul'] }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            {{ $slot['deskripsi'] }}
                        </p>
                    </div>

                    <!-- Area File / Upload Action -->
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        @if ($uploadedDoc)
                            <div class="flex items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                                <div class="flex items-center gap-2 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 font-bold text-[10px]">
                                        PDF
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate">
                                            {{ basename($uploadedDoc->file_path) }}
                                        </p>
                                        <p class="text-[10px] text-slate-400">
                                            {{ $uploadedDoc->created_at?->translatedFormat('d M Y, H:i') ?? 'Tersimpan' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1 shrink-0">
                                    <a href="{{ route('secure.dokumen.show', $uploadedDoc->id) }}" 
                                       target="_blank"
                                       title="Buka / Pratinjau Dokumen"
                                       class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-slate-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    @if (!$permohonan->dokumen_terkunci)
                                        <form action="{{ route('madya.dokumen.delete', $uploadedDoc->id) }}" method="POST" onsubmit="return confirm('Hapus berkas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    title="Hapus Dokumen"
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @else
                            @if ($permohonan->dokumen_terkunci)
                                <div class="p-3 text-center rounded-xl bg-slate-50 text-xs text-slate-400 border border-slate-200/60">
                                    Dokumen terkunci &mdash; tidak dapat mengunggah berkas baru.
                                </div>
                            @else
                                <form action="{{ route('madya.layanan.upload-dokumen', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="jenis_dokumen" value="{{ $slot['key'] }}">
                                    <div class="relative">
                                        <input type="file" 
                                               name="file" 
                                               required 
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               onchange="this.form.submit()"
                                               class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
                                    </div>
                                    <span class="text-[10px] text-slate-400 block">Format PDF / JPG / PNG (Maks 10 MB).</span>
                                </form>
                            @endif
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</x-portal-layout>
