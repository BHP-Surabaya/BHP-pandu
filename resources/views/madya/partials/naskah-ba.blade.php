<article class="font-serif text-[12.5px] leading-[1.6] text-slate-950">
    <!-- Kop Surat Resmi Kementerian Hukum RI / BHP Surabaya -->
    <header class="flex items-center gap-4 pb-2 border-b-2 border-blue-950">
        <img src="{{ asset('images/pengayoman.svg') }}" 
             alt="Logo Resmi Kementerian Hukum RI" 
             class="w-16 h-16 shrink-0 object-contain" />
        
        <div class="flex-1 text-center font-sans leading-[1.2]">
            <p class="text-[11.5px] font-medium uppercase tracking-[0.03em] text-slate-900">
                Kementerian Hukum Republik Indonesia
            </p>
            <p class="text-[13.5px] font-bold uppercase tracking-[0.02em] text-slate-950">
                Balai Harta Peninggalan Surabaya
            </p>
            <p class="text-[9.5px] text-slate-700 mt-0.5">
                Jalan Jenderal S. Parman No. 58, Waru, Sidoarjo
            </p>
            <p class="text-[9.5px] text-slate-700">
                Telepon (031) 8531785
            </p>
            <p class="text-[9.5px] text-slate-700">
                Laman: <span class="text-blue-800 underline">http://bhpsurabaya.kemenkum.go.id</span>, 
                Pos-el: <span class="text-blue-800 underline">bhp.surabaya@kemenkum.go.id</span>
            </p>
        </div>
    </header>

    <div class="border-b border-blue-950 mt-[2px]"></div>

    <!-- Judul Berita Acara -->
    <div class="mt-5 text-center font-sans leading-snug">
        <h2 class="text-[14px] font-bold uppercase tracking-wide text-slate-950">Berita Acara</h2>
        <p class="text-[13px] font-bold uppercase tracking-wide text-slate-950">
            Pembukaan dan Pembacaan Wasiat Tertutup/Rahasia
        </p>
        <p class="text-[12px] font-bold text-slate-950 mt-0.5">
            NOMOR: <span class="font-mono text-blue-950 font-bold">{{ $ba['nomor_ba'] ?? 'W15.BHP.02-……' }}</span>
        </p>
    </div>

    <!-- Paragraf Pembuka -->
    @php
        $tglFormatted = !empty($ba['tanggal']) ? \Carbon\Carbon::parse($ba['tanggal'])->translatedFormat('d F Y') : '……';
        $tglKuasaFormatted = !empty($ba['tanggal_surat_kuasa']) ? \Carbon\Carbon::parse($ba['tanggal_surat_kuasa'])->translatedFormat('d F Y') : '……';
    @endphp
    <p class="mt-4 text-justify indent-8 leading-relaxed">
        Sesuai dengan Pasal 942 Kitab Undang-Undang Hukum Perdata <em>jo.</em> Pasal 14 Huruf d Peraturan Menteri Hukum Nomor 16 Tahun 2026 Tentang Organisasi dan Tata Kerja di Lingkungan Kementerian Hukum
        @if(!empty($ba['ada_surat_kuasa']))
            dan surat kuasa tgl <strong>{{ $tglKuasaFormatted }}</strong>
        @endif
        . Pada hari ini, <strong>{{ $ba['hari'] ?? '……' }}</strong>, tanggal <strong>{{ $tglFormatted }}</strong>, Kami masing-masing:
    </p>

    <!-- PIHAK PERTAMA -->
    <div class="mt-3 pl-4">
        <table class="w-full border-collapse text-left text-[12px]">
            <tbody>
                <tr>
                    <td class="w-28 py-0.5 text-slate-600">Nama Pejabat</td>
                    <td class="w-3 py-0.5">:</td>
                    <td class="py-0.5 font-bold text-slate-900">{{ $ba['pihak_pertama_nama'] ?? '……' }}</td>
                </tr>
                <tr>
                    <td class="py-0.5 text-slate-600">NIP</td>
                    <td class="w-3 py-0.5">:</td>
                    <td class="py-0.5 font-mono text-[11.5px] tabular-nums">{{ $ba['pihak_pertama_nip'] ?? '……' }}</td>
                </tr>
                <tr>
                    <td class="py-0.5 text-slate-600">Jabatan</td>
                    <td class="w-3 py-0.5">:</td>
                    <td class="py-0.5">{{ $ba['pihak_pertama_jabatan'] ?? '……' }}</td>
                </tr>
            </tbody>
        </table>
        <p class="mt-0.5 text-[11.5px]">
            selanjutnya disebut <strong class="text-slate-900">PIHAK PERTAMA</strong>
        </p>
    </div>

    <p class="my-2 text-center font-medium italic text-[11.5px]">Dan</p>

    <!-- PIHAK KEDUA -->
    <div class="pl-4">
        <table class="w-full border-collapse text-left text-[12px]">
            <tbody>
                <tr>
                    <td class="w-28 py-0.5 text-slate-600">Nama Pemohon</td>
                    <td class="w-3 py-0.5">:</td>
                    <td class="py-0.5 font-bold text-slate-900">{{ $ba['pihak_kedua_nama'] ?? '……' }}</td>
                </tr>
                <tr>
                    <td class="py-0.5 text-slate-600">Jabatan Pemohon</td>
                    <td class="w-3 py-0.5">:</td>
                    <td class="py-0.5">{{ $ba['pihak_kedua_jabatan'] ?? '……' }}</td>
                </tr>
                <tr class="align-top">
                    <td class="py-0.5 text-slate-600">Alamat Pemohon</td>
                    <td class="w-3 py-0.5">:</td>
                    <td class="py-0.5">{{ $ba['pihak_kedua_alamat'] ?? '……' }}</td>
                </tr>
            </tbody>
        </table>
        <p class="mt-0.5 text-[11.5px]">
            selanjutnya disebut <strong class="text-slate-900">PIHAK KEDUA</strong>
        </p>
    </div>

    <!-- Isi Poin 1 - 3 -->
    <p class="mt-3 font-sans text-[12px] font-semibold text-slate-900">
        Telah melaksanakan hal-hal sebagai berikut:
    </p>

    <ol class="mt-1 list-decimal space-y-1.5 pl-6 text-justify text-[12px]">
        <li>
            PIHAK KEDUA telah menyerahkan kepada PIHAK PERTAMA, berupa <strong>{{ $ba['deskripsi_wasiat'] ?? '(deskripsi tampilan akta wasiat tertutup/rahasia)' }}</strong> yang berisi akta wasiat tertutup/rahasia yang dibuat dan diserahkan untuk disimpan Notaris penyimpan oleh <strong>{{ $ba['nama_pewasiat'] ?? '(nama Pewasiat)' }}</strong>;
        </li>
        <li>
            PIHAK PERTAMA membuka penyimpanan akta wasiat tertutup/rahasia tersebut dan telah membacakan isi akta wasiat tertutup/rahasia tersebut di hadapan PIHAK KEDUA, para ahli waris Pewasiat, dan para saksi (akta wasiat tertutup/rahasia terlampir); dan
        </li>
        <li>
            PIHAK PERTAMA telah mengembalikan akta wasiat tertutup/rahasia tersebut kepada PIHAK KEDUA untuk kemudian dilakukan pendaftaran wasiat tercatat ke Balai Harta Peninggalan Surabaya sebelum pelaksanaan isi wasiat tersebut.
        </li>
    </ol>

    <p class="mt-4 text-justify indent-8 text-[12px]">
        Berita acara ini dibuat dengan sesungguhnya dalam 2 (dua) rangkap yang sama dan ditandatangani oleh kedua pihak pada hari tanggal tersebut di atas untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    <!-- Blok Tanda Tangan Para Pihak -->
    <div class="mt-7 grid grid-cols-2 gap-8 text-center text-[12px]">
        <div>
            <p class="font-bold">&nbsp;</p>
            <p class="font-bold">PIHAK KEDUA,</p>
            <div class="h-16"></div>
            <p class="font-bold underline underline-offset-4">{{ $ba['pihak_kedua_nama'] ?? '……………' }}</p>
        </div>

        <div>
            <p>Dibuat di <strong>{{ $ba['tempat_dibuat'] ?? 'Sidoarjo' }}</strong></p>
            <p class="font-bold">PIHAK PERTAMA,</p>
            <div class="h-16"></div>
            <p class="font-bold underline underline-offset-4">{{ $ba['pihak_pertama_nama'] ?? '……………' }}</p>
        </div>
    </div>

    <!-- Saksi-Saksi -->
    <div class="mt-6 text-[12px]">
        <p class="font-bold">Saksi-saksi:</p>
        <div class="mt-2 space-y-3">
            <div class="grid grid-cols-2 items-end gap-8">
                <div class="flex items-baseline gap-2">
                    <span class="w-4 tabular-nums">1.</span>
                    <span class="flex-1 border-b border-dotted border-slate-600 pb-0.5 font-medium">{{ $ba['saksi_1'] ?? '……………' }}</span>
                </div>
                <div class="border-b border-dotted border-slate-600 pb-0.5 text-right text-[11px] text-slate-400">
                    (Tanda Tangan Saksi I)
                </div>
            </div>
            <div class="grid grid-cols-2 items-end gap-8">
                <div class="flex items-baseline gap-2">
                    <span class="w-4 tabular-nums">2.</span>
                    <span class="flex-1 border-b border-dotted border-slate-600 pb-0.5 font-medium">{{ $ba['saksi_2'] ?? '……………' }}</span>
                </div>
                <div class="border-b border-dotted border-slate-600 pb-0.5 text-right text-[11px] text-slate-400">
                    (Tanda Tangan Saksi II)
                </div>
            </div>
        </div>
    </div>
</article>
