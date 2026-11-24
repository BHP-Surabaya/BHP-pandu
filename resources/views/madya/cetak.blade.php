<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Berita Acara 2 Salinan — {{ $permohonan->nomor_permohonan ?: $existingBa['nomor_ba'] }}</title>
    
    <!-- Tailwind & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600;0,8..60,700;1,8..60,400&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .page-break {
                page-break-after: always;
                break-after: page;
            }
            .print-sheet {
                border: none !important;
                box-shadow: none !important;
                padding: 1.5cm 1.5cm !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
        }
        @page {
            size: A4 portrait;
            margin: 1.5cm 1.5cm;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased font-sans" x-data="{ copyMode: 'both' }">

    <!-- ================= STICKY ACTION TOOLBAR (NO-PRINT) ================= -->
    <header class="no-print sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-md px-4 py-3 shadow-xs">
        <div class="max-w-5xl mx-auto flex flex-wrap items-center justify-between gap-3">
            
            <div class="flex items-center gap-3">
                <a href="{{ route('madya.layanan.buat-ba.page', $permohonan->id) }}"
                   title="Kembali ke formulir BA"
                   class="flex size-9 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-sm sm:text-base font-extrabold text-[#0c2a55]">
                        Cetak Berita Acara — 2 Salinan Resmi
                    </h1>
                    <p class="text-xs text-slate-500 font-mono">
                        {{ $permohonan->nomor_permohonan }} &bull; {{ $existingBa['nomor_ba'] ?? 'BA Resmi' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Mode Filter Salinan -->
                <div class="inline-flex rounded-xl border border-slate-200 bg-slate-100 p-1 text-xs font-semibold text-slate-600">
                    <button type="button" 
                            @click="copyMode = 'both'"
                            :class="copyMode === 'both' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'"
                            class="px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                        2 Salinan
                    </button>
                    <button type="button" 
                            @click="copyMode = '1'"
                            :class="copyMode === '1' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'"
                            class="px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                        Salinan 1 (BHP)
                    </button>
                    <button type="button" 
                            @click="copyMode = '2'"
                            :class="copyMode === '2' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-900'"
                            class="px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                        Salinan 2 (Pemohon)
                    </button>
                </div>

                <a href="{{ route('madya.layanan.buat-ba.page', $permohonan->id) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <span>Edit Data BA</span>
                </a>

                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.672-2.13-1.27-3.086m0 0A10.02 10.02 0 0112 4.5c4.76 0 8.746 3.324 9.77 7.784M12 4.5v15m0 0l-3-3m3 3l3-3" />
                    </svg>
                    <span>Cetak Sekarang (Print)</span>
                </button>
            </div>

        </div>
    </header>

    <!-- Container Cetak Dokumen -->
    <main class="max-w-4xl mx-auto p-4 sm:p-8 print:p-0 print:max-w-none space-y-8 print:space-y-0">
        
        <!-- ================= SALINAN I : ARSIP BHP SURABAYA ================= -->
        <section x-show="copyMode === 'both' || copyMode === '1'"
                 class="print-sheet bg-white border border-slate-200 rounded-2xl shadow-xl p-8 sm:p-14 text-slate-900 leading-[1.6] text-[12.5px] font-serif"
                 :class="{ 'page-break': copyMode === 'both' }">
            
            <p class="text-right font-sans text-[10px] font-bold uppercase tracking-[0.2em] text-blue-900 border-b border-blue-100 pb-1 mb-5">
                SALINAN I — ARSIP BALAI HARTA PENINGGALAN SURABAYA (PIHAK PERTAMA)
            </p>

            @include('madya.partials.naskah-ba', ['ba' => $existingBa, 'salinan' => 1])
        </section>

        <!-- ================= SALINAN II : NOTARIS / PEMOHON ================= -->
        <section x-show="copyMode === 'both' || copyMode === '2'"
                 class="print-sheet bg-white border border-slate-200 rounded-2xl shadow-xl p-8 sm:p-14 text-slate-900 leading-[1.6] text-[12.5px] font-serif">
            
            <p class="text-right font-sans text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-900 border-b border-emerald-100 pb-1 mb-5">
                SALINAN II — PEMOHON / NOTARIS PENYIMPAN (PIHAK KEDUA)
            </p>

            @include('madya.partials.naskah-ba', ['ba' => $existingBa, 'salinan' => 2])
        </section>

    </main>

</body>
</html>
