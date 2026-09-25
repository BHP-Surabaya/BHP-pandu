<x-portal-layout>
    <x-slot name="title">
        Form Pengajuan Wasiat Tertutup
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
        statusKawin: '{{ old('status_kawin', 'tidak_kawin') }}',
        jenisDokumenPerkawinan: '{{ old('jenis_dokumen_perkawinan', '') }}',
        nomorDokumenPerkawinan: '{{ old('nomor_dokumen_perkawinan', '') }}',
        tanggalPerkawinan: '{{ old('tanggal_perkawinan', '') }}',
        tempatPerkawinan: '{{ old('tempat_perkawinan', '') }}',
        instansiPenerbitPerkawinan: '{{ old('instansi_penerbit_perkawinan', '') }}',
        memilikiAnak: '{{ old('memiliki_anak', 'tidak_ada') }}',
        pasangans: {{ json_encode(old('pasangans', [['nama_lengkap' => '', 'nik' => '', 'jenis_kelamin' => '']])) }},
        anakList: {{ json_encode(old('anak', [['nama_lengkap' => '', 'nik' => '', 'jenis_kelamin' => '', 'tempat_tanggal_lahir' => '', 'alamat' => '']])) }},
        tambahPasangan() {
            this.pasangans.push({ nama_lengkap: '', nik: '', jenis_kelamin: '' });
        },
        hapusPasangan(index) {
            if (this.pasangans.length > 1) {
                this.pasangans.splice(index, 1);
            }
        },
        tambahAnak() {
            this.anakList.push({ nama_lengkap: '', nik: '', jenis_kelamin: '', tempat_tanggal_lahir: '', alamat: '' });
        },
        hapusAnak(index) {
            if (this.anakList.length > 1) {
                this.anakList.splice(index, 1);
            }
        },
        isiDataDummy() {
            document.getElementById('nama_lengkap').value = 'Prof. Dr. Ir. Raden Soeprapto Mangoenkoesoemo';
            if (document.getElementById('dahulu_bernama')) document.getElementById('dahulu_bernama').value = 'Soeprapto';
            if (document.getElementById('alias')) document.getElementById('alias').value = 'Opa Prapto';
            document.getElementById('nik').value = '3578011708520001';
            document.getElementById('jenis_kelamin').value = 'L';
            document.getElementById('tempat_lahir').value = 'Surabaya';
            document.getElementById('tanggal_lahir').value = '1952-08-17';
            document.getElementById('tempat_tinggal_terakhir').value = 'Jl. Raya Darmo No. 45, RT 003 / RW 002, Kel. Keputran, Kec. Tegalsari, Kota Surabaya, Jawa Timur';

            document.getElementById('tempat_kematian').value = 'RSUD Dr. Soetomo, Kota Surabaya';
            document.getElementById('tanggal_kematian').value = '2026-02-10';
            document.getElementById('nomor_akta_kematian').value = '3578-KM-10022026-0015';
            document.getElementById('tanggal_akta_kematian').value = '2026-02-14';
            document.getElementById('pejabat_pembuat_akta_kematian').value = 'Dinas Kependudukan dan Pencatatan Sipil Kota Surabaya';

            document.getElementById('nomor_surat_dpw').value = 'AHU.2.AH.04.01-14022026/DPW';
            document.getElementById('tanggal_surat_dpw').value = '2026-02-20';
            document.getElementById('status_pencatatan').value = 'Terdaftar';

            document.getElementById('nomor_akta_penyimpanan').value = 'WST-12/NOT-SBY/2019';
            document.getElementById('tanggal_akta_penyimpanan').value = '2019-11-05';
            document.getElementById('nama_notaris').value = 'Bambang Sugiharto, S.H., M.Kn.';
            document.getElementById('kedudukan_notaris').value = 'Kota Surabaya';

            this.statusKawin = 'kawin';
            this.jenisDokumenPerkawinan = 'Buku Nikah';
            this.nomorDokumenPerkawinan = 'KUA.13.05/PW.01/1978';
            this.tanggalPerkawinan = '1978-09-15';
            this.tempatPerkawinan = 'Kota Surabaya';
            this.instansiPenerbitPerkawinan = 'KUA Kecamatan Tegalsari, Kota Surabaya';

            this.pasangans = [
                { nama_lengkap: 'Hj. Siti Aminah Soeprapto', nik: '3578015509550002', jenis_kelamin: 'P' }
            ];

            this.memilikiAnak = 'ada';
            this.anakList = [
                { nama_lengkap: 'dr. Dimas Arya Mangoenkoesoemo, Sp.PD', nik: '3578011203820003', jenis_kelamin: 'L', tempat_tanggal_lahir: 'Surabaya, 12 Maret 1982', alamat: 'Jl. Manyar Kertoarjo IV No. 18, Surabaya' },
                { nama_lengkap: 'Dian Anggraini Mangoenkoesoemo, S.E., M.B.A.', nik: '3578015807860004', jenis_kelamin: 'P', tempat_tanggal_lahir: 'Surabaya, 18 Juli 1986', alamat: 'Jl. Kertajaya Indah Timur No. 22, Surabaya' }
            ];

            this.$nextTick(() => {
                const setVal = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = val;
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                };
                setVal('jenis_dokumen_perkawinan', 'Buku Nikah');
                setVal('nomor_dokumen_perkawinan', 'KUA.13.05/PW.01/1978');
                setVal('tanggal_perkawinan', '1978-09-15');
                setVal('tempat_perkawinan', 'Kota Surabaya');
                setVal('instansi_penerbit_perkawinan', 'KUA Kecamatan Tegalsari, Kota Surabaya');
            });
        }
    }">
        <!-- Breadcrumb / Back button -->
        <div class="mb-3">
            <a href="{{ route('permohonan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-900 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Header Title -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-[28px] font-bold text-[#0f172a] tracking-tight">
                    Form Pengajuan Wasiat Tertutup
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Lengkapi data di bawah ini untuk memulai proses pengajuan wasiat tertutup.
                </p>
            </div>
            <div>
                <button type="button" 
                        @click="isiDataDummy()" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold rounded-lg border border-purple-200 bg-purple-50 hover:bg-purple-100 text-[#4a1d84] shadow-xs transition cursor-pointer">
                    <svg class="w-4 h-4 text-[#4a1d84]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>Isi Otomatis Data Dummy</span>
                </button>
            </div>
        </div>

        <!-- Stepper Progress Bar (Tahap 1, 2, 3, 4) -->
        <div class="bg-white rounded-xl border border-gray-200/80 p-4 sm:p-5 mb-8 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
            <div class="flex items-center justify-between gap-2" style="display: flex; flex-direction: row; width: 100%;">
                <!-- Tahap 1 (Active) -->
                <div class="flex-1 flex items-center gap-3" style="flex: 1;">
                    <div class="w-8 h-8 rounded-full bg-[#1e1b4b] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm">
                        1
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#1e1b4b] leading-tight">Tahap 1</div>
                        <div class="text-[11px] text-gray-500 hidden sm:block">Data Pewasiat</div>
                    </div>
                </div>

                <!-- Tahap 2 (Inactive) -->
                <div class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        2
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 leading-tight">Tahap 2</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Upload Berkas</div>
                    </div>
                </div>

                <!-- Tahap 3 (Inactive) -->
                <div class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        3
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 leading-tight">Tahap 3</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Voucher PNBP</div>
                    </div>
                </div>

                <!-- Tahap 4 (Inactive) -->
                <div class="flex-1 flex items-center gap-3 border-l border-gray-100 pl-3 sm:pl-6" style="flex: 1; border-left: 1px solid #f3f4f6; padding-left: 1rem;">
                    <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 text-gray-400 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        4
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-400 leading-tight">Tahap 4</div>
                        <div class="text-[11px] text-gray-400 hidden sm:block">Preview Data</div>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Terdapat kolom yang belum terisi dengan benar:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('permohonan.store') }}" class="space-y-6">
            @csrf

            <!-- ================= SEKSI I: INFORMASI PEWASIAT ================= -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                        I
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Informasi Pewasiat
                    </h3>
                </div>

                <div class="p-6 sm:p-7 space-y-4">
                    <!-- Nama Lengkap Pewasiat -->
                    <div>
                        <label for="nama_lengkap" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap Pewasiat <span class="text-red-500">*</span>
                        </label>
                        <input id="nama_lengkap" 
                               name="nama_lengkap" 
                               type="text" 
                               value="{{ old('nama_lengkap') }}" 
                               required 
                               placeholder="Masukkan nama lengkap" 
                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('nama_lengkap') border-red-500 @enderror" />
                        @error('nama_lengkap')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dahulu Bernama & Alias -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                        <div>
                            <label for="dahulu_bernama" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Dahulu Bernama
                            </label>
                            <input id="dahulu_bernama" 
                                   name="dahulu_bernama" 
                                   type="text" 
                                   value="{{ old('dahulu_bernama') }}" 
                                   placeholder="Nama terdahulu (opsional)" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                            <p class="mt-1.5 text-[11px] text-gray-400 leading-relaxed italic">
                                Apabila terdapat perbedaan nama, wajib disertai Penetapan Akta Ganti Nama atau penetapan Beda Nama.
                            </p>
                        </div>
                        <div>
                            <label for="alias" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Alias
                            </label>
                            <input id="alias" 
                                   name="alias" 
                                   type="text" 
                                   value="{{ old('alias') }}" 
                                   placeholder="Nama alias (opsional)" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                        </div>
                    </div>

                    <!-- NIK Pewasiat & Jenis Kelamin Pewasiat -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                NIK Pewasiat <span class="text-red-500">*</span>
                            </label>
                            <input id="nik" 
                                   name="nik" 
                                   type="text" 
                                   maxlength="16" 
                                   value="{{ old('nik') }}" 
                                   required 
                                   placeholder="16 digit NIK" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('nik') border-red-500 @enderror" />
                            @error('nik')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Jenis Kelamin Pewasiat <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="jenis_kelamin" 
                                        name="jenis_kelamin" 
                                        required 
                                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition appearance-none cursor-pointer @error('jenis_kelamin') border-red-500 @enderror">
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tempat Lahir & Tanggal Lahir -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input id="tempat_lahir" 
                                   name="tempat_lahir" 
                                   type="text" 
                                   value="{{ old('tempat_lahir') }}" 
                                   required 
                                   placeholder="Tempat lahir" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tempat_lahir') border-red-500 @enderror" />
                            @error('tempat_lahir')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_lahir" 
                                   name="tanggal_lahir" 
                                   type="date" 
                                   value="{{ old('tanggal_lahir') }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tanggal_lahir') border-red-500 @enderror" />
                            @error('tanggal_lahir')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bertempat Tinggal Terakhir -->
                    <div>
                        <label for="tempat_tinggal_terakhir" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Bertempat Tinggal Terakhir <span class="text-red-500">*</span>
                        </label>
                        <textarea id="tempat_tinggal_terakhir" 
                                  name="tempat_tinggal_terakhir" 
                                  rows="3" 
                                  required 
                                  placeholder="Alamat lengkap tempat tinggal terakhir" 
                                  class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition resize-y @error('tempat_tinggal_terakhir') border-red-500 @enderror">{{ old('tempat_tinggal_terakhir') }}</textarea>
                        @error('tempat_tinggal_terakhir')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ================= SEKSI II: INFORMASI KEMATIAN PEWASIAT ================= -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                        II
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Informasi Kematian Pewasiat
                    </h3>
                </div>

                <div class="p-6 sm:p-7 space-y-4">
                    <!-- Tempat & Tanggal Kematian -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tempat_kematian" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tempat Kematian <span class="text-red-500">*</span>
                            </label>
                            <input id="tempat_kematian" 
                                   name="tempat_kematian" 
                                   type="text" 
                                   value="{{ old('tempat_kematian') }}" 
                                   required 
                                   placeholder="Tempat Kematian" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tempat_kematian') border-red-500 @enderror" />
                            @error('tempat_kematian')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_kematian" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tanggal Kematian <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_kematian" 
                                   name="tanggal_kematian" 
                                   type="date" 
                                   value="{{ old('tanggal_kematian') }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tanggal_kematian') border-red-500 @enderror" />
                            @error('tanggal_kematian')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor & Tanggal Akta Kematian -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nomor_akta_kematian" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Nomor Akta Kematian <span class="text-red-500">*</span>
                            </label>
                            <input id="nomor_akta_kematian" 
                                   name="nomor_akta_kematian" 
                                   type="text" 
                                   value="{{ old('nomor_akta_kematian') }}" 
                                   required 
                                   placeholder="Nomor akta" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('nomor_akta_kematian') border-red-500 @enderror" />
                            @error('nomor_akta_kematian')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_akta_kematian" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tanggal Akta Kematian <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_akta_kematian" 
                                   name="tanggal_akta_kematian" 
                                   type="date" 
                                   value="{{ old('tanggal_akta_kematian') }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tanggal_akta_kematian') border-red-500 @enderror" />
                            @error('tanggal_akta_kematian')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kota/Kabupaten Penerbit Akta Kematian -->
                    <div>
                        <label for="pejabat_pembuat_akta_kematian" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Kota/Kabupaten Penerbit Akta Kematian <span class="text-red-500">*</span>
                        </label>
                        <input id="pejabat_pembuat_akta_kematian" 
                               name="pejabat_pembuat_akta_kematian" 
                               type="text" 
                               value="{{ old('pejabat_pembuat_akta_kematian') }}" 
                               required 
                               placeholder="Kota Surabaya / Kabupaten Sidoarjo" 
                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('pejabat_pembuat_akta_kematian') border-red-500 @enderror" />
                        @error('pejabat_pembuat_akta_kematian')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ================= SEKSI III: INFORMASI PENCATATAN WASIAT ================= -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                        III
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Informasi Pencatatan Wasiat
                    </h3>
                </div>

                <div class="p-6 sm:p-7 space-y-4">
                    <!-- Nomor & Tanggal Surat dari DPW Ditjen AHU -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nomor_surat_dpw" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Nomor Surat dari DPW Ditjen AHU <span class="text-red-500">*</span>
                            </label>
                            <input id="nomor_surat_dpw" 
                                   name="nomor_surat_dpw" 
                                   type="text" 
                                   value="{{ old('nomor_surat_dpw') }}" 
                                   required 
                                   placeholder="Nomor surat" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('nomor_surat_dpw') border-red-500 @enderror" />
                            @error('nomor_surat_dpw')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_surat_dpw" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tanggal Surat dari DPW Ditjen AHU <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_surat_dpw" 
                                   name="tanggal_surat_dpw" 
                                   type="date" 
                                   value="{{ old('tanggal_surat_dpw') }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tanggal_surat_dpw') border-red-500 @enderror" />
                            @error('tanggal_surat_dpw')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status Pencatatan dari DPW Ditjen AHU -->
                    <div>
                        <label for="status_pencatatan" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Status Pencatatan dari DPW Ditjen AHU <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="status_pencatatan" 
                                    name="status_pencatatan" 
                                    required 
                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition appearance-none cursor-pointer @error('status_pencatatan') border-red-500 @enderror">
                                <option value="" disabled {{ old('status_pencatatan') ? '' : 'selected' }}>Pilih Status</option>
                                <option value="Terdaftar" {{ old('status_pencatatan') === 'Terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                                <option value="Tercatat" {{ old('status_pencatatan') === 'Tercatat' ? 'selected' : '' }}>Tercatat</option>
                                <option value="Tidak Tercatat" {{ old('status_pencatatan') === 'Tidak Tercatat' ? 'selected' : '' }}>Tidak Tercatat</option>
                                <option value="Dalam Proses" {{ old('status_pencatatan') === 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('status_pencatatan')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ================= SEKSI IV: INFORMASI AKTA PENYIMPANAN WASIAT ================= -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                        IV
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Informasi Akta Penyimpanan Wasiat
                    </h3>
                </div>

                <div class="p-6 sm:p-7 space-y-4">
                    <!-- Nomor & Tanggal Akta Penyimpanan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nomor_akta_penyimpanan" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Nomor Akta Penyimpanan <span class="text-red-500">*</span>
                            </label>
                            <input id="nomor_akta_penyimpanan" 
                                   name="nomor_akta_penyimpanan" 
                                   type="text" 
                                   value="{{ old('nomor_akta_penyimpanan') }}" 
                                   required 
                                   placeholder="Nomor akta" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('nomor_akta_penyimpanan') border-red-500 @enderror" />
                            @error('nomor_akta_penyimpanan')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_akta_penyimpanan" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tanggal Akta Penyimpanan <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_akta_penyimpanan" 
                                   name="tanggal_akta_penyimpanan" 
                                   type="date" 
                                   value="{{ old('tanggal_akta_penyimpanan') }}" 
                                   required 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('tanggal_akta_penyimpanan') border-red-500 @enderror" />
                            @error('tanggal_akta_penyimpanan')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama Notaris & Kedudukan Notaris -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_notaris" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Nama Notaris Pembuat Akta <span class="text-red-500">*</span>
                            </label>
                            <input id="nama_notaris" 
                                   name="nama_notaris" 
                                   type="text" 
                                   value="{{ old('nama_notaris') }}" 
                                   required 
                                   placeholder="Nama Notaris" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('nama_notaris') border-red-500 @enderror" />
                            @error('nama_notaris')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kedudukan_notaris" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Kedudukan Notaris Pembuat Akta <span class="text-red-500">*</span>
                            </label>
                            <input id="kedudukan_notaris" 
                                   name="kedudukan_notaris" 
                                   type="text" 
                                   value="{{ old('kedudukan_notaris') }}" 
                                   required 
                                   placeholder="Kota/Kabupaten Kedudukan" 
                                   class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition @error('kedudukan_notaris') border-red-500 @enderror" />
                            @error('kedudukan_notaris')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SEKSI V: INFORMASI PERKAWINAN MENDIANG ================= -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                        V
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Informasi Perkawinan Mendiang
                    </h3>
                </div>

                <div class="p-6 sm:p-7 space-y-5">
                    <!-- Pertanyaan Kawin -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                            Apakah Pewasiat Kawin? <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" 
                                       name="status_kawin" 
                                       value="tidak_kawin" 
                                       x-model="statusKawin"
                                       class="w-4 h-4 text-[#4a1d84] border-gray-300 focus:ring-[#4a1d84]/20 cursor-pointer" />
                                <span class="text-sm font-medium text-gray-700">Tidak Kawin</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" 
                                       name="status_kawin" 
                                       value="kawin" 
                                       x-model="statusKawin"
                                       class="w-4 h-4 text-[#4a1d84] border-gray-300 focus:ring-[#4a1d84]/20 cursor-pointer" />
                                <span class="text-sm font-medium text-gray-700">Kawin</span>
                            </label>
                        </div>
                    </div>

                    <!-- Konten Jika Kawin -->
                    <div x-show="statusKawin === 'kawin'" x-cloak class="space-y-4 pt-2">
                        <!-- Blok Data Perkawinan -->
                        <div class="bg-gray-50/70 border border-gray-200/90 rounded-xl p-5 space-y-4">
                            <h4 class="text-xs font-bold text-gray-800">
                                Data Perkawinan
                            </h4>

                            <!-- Row 1: Jenis Dokumen & Nomor Dokumen -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Jenis Dokumen Perkawinan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="jenis_dokumen_perkawinan" 
                                                name="jenis_dokumen_perkawinan" 
                                                x-model="jenisDokumenPerkawinan"
                                                :required="statusKawin === 'kawin'"
                                                class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition appearance-none cursor-pointer">
                                            <option value="" disabled>Pilih Jenis Dokumen</option>
                                            <option value="Buku Nikah">Buku Nikah</option>
                                            <option value="Akta Perkawinan">Akta Perkawinan</option>
                                            <option value="Dokumen Perkawinan Lainnya">Dokumen Perkawinan Lainnya</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('jenis_dokumen_perkawinan')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Nomor Dokumen Perkawinan <span class="text-red-500">*</span>
                                    </label>
                                    <input id="nomor_dokumen_perkawinan" 
                                           type="text" 
                                           name="nomor_dokumen_perkawinan" 
                                           x-model="nomorDokumenPerkawinan"
                                           :required="statusKawin === 'kawin'"
                                           placeholder="Masukkan nomor dokumen perkawinan" 
                                           class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    @error('nomor_dokumen_perkawinan')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 2: Tanggal Perkawinan & Tempat Perkawinan -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Tanggal Perkawinan <span class="text-red-500">*</span>
                                    </label>
                                    <input id="tanggal_perkawinan" 
                                           type="date" 
                                           name="tanggal_perkawinan" 
                                           x-model="tanggalPerkawinan"
                                           :required="statusKawin === 'kawin'"
                                           placeholder="mm/dd/yyyy"
                                           class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    @error('tanggal_perkawinan')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Tempat Perkawinan
                                    </label>
                                    <input id="tempat_perkawinan" 
                                           type="text" 
                                           name="tempat_perkawinan" 
                                           x-model="tempatPerkawinan"
                                           placeholder="Masukkan kota/kabupaten perkawinan" 
                                           class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    @error('tempat_perkawinan')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 3: Instansi Penerbit Dokumen -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Instansi Penerbit Dokumen
                                </label>
                                <input id="instansi_penerbit_perkawinan" 
                                       type="text" 
                                       name="instansi_penerbit_perkawinan" 
                                       x-model="instansiPenerbitPerkawinan"
                                       placeholder="Contoh: Kantor Urusan Agama (KUA) / Disdukcapil" 
                                       class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                @error('instansi_penerbit_perkawinan')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Repeater Form Pasangan -->
                        <template x-for="(pasangan, index) in pasangans" :key="index">
                            <div class="bg-gray-50/70 border border-gray-200/90 rounded-xl p-5 space-y-4 relative">
                                <div x-show="pasangans.length > 1" class="flex items-center justify-between border-b border-gray-200/60 pb-2">
                                    <span class="text-xs font-bold text-gray-700" x-text="'Informasi Pasangan Pewasiat ' + (index + 1)"></span>
                                    <button type="button" 
                                            @click="hapusPasangan(index)" 
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>

                                <!-- Nama Lengkap Pasangan -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Nama Lengkap Pasangan Pewasiat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           :name="'pasangans[' + index + '][nama_lengkap]'" 
                                           x-model="pasangan.nama_lengkap" 
                                           :required="statusKawin === 'kawin'"
                                           placeholder="Masukkan nama lengkap" 
                                           class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    <p class="mt-1 text-[11px] text-gray-400 italic">
                                        Isi jika terdapat perbedaan nama dengan dokumen identitas
                                    </p>
                                </div>

                                <!-- NIK & Jenis Kelamin Pasangan -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                            NIK Pasangan Pewasiat <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               maxlength="16" 
                                               :name="'pasangans[' + index + '][nik]'" 
                                               x-model="pasangan.nik" 
                                               placeholder="16 digit NIK" 
                                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                            Jenis Kelamin <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select :name="'pasangans[' + index + '][jenis_kelamin]'" 
                                                    x-model="pasangan.jenis_kelamin" 
                                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition appearance-none cursor-pointer">
                                                <option value="" disabled>Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Tombol Tambah Pasangan -->
                        <button type="button" 
                                @click="tambahPasangan()" 
                                class="w-full py-2.5 px-4 rounded-xl border-2 border-dashed border-purple-300 hover:border-purple-500 bg-purple-50/40 hover:bg-purple-50 text-purple-700 text-xs font-bold flex items-center justify-center gap-1.5 transition duration-150 cursor-pointer">
                            <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Tambah Pasangan</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ================= SEKSI VI: INFORMASI ANAK PEWASIAT ================= -->
            <div class="bg-white rounded-xl border border-purple-100/90 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="bg-[#faf7fd] px-6 py-4 border-b border-purple-100/80 flex items-center gap-3">
                    <div class="w-7 h-7 rounded-full bg-[#4a1d84] text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                        VI
                    </div>
                    <h3 class="text-base font-bold text-[#2e1065]">
                        Informasi Anak Pewasiat
                    </h3>
                </div>

                <div class="p-6 sm:p-7 space-y-5">
                    <!-- Pertanyaan Anak Kandung -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                            Apakah Pewasiat memiliki anak kandung? <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" 
                                       name="memiliki_anak" 
                                       value="tidak_ada" 
                                       x-model="memilikiAnak"
                                       class="w-4 h-4 text-[#4a1d84] border-gray-300 focus:ring-[#4a1d84]/20 cursor-pointer" />
                                <span class="text-sm font-medium text-gray-700">Tidak Ada</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" 
                                       name="memiliki_anak" 
                                       value="ada" 
                                       x-model="memilikiAnak"
                                       class="w-4 h-4 text-[#4a1d84] border-gray-300 focus:ring-[#4a1d84]/20 cursor-pointer" />
                                <span class="text-sm font-medium text-gray-700">Ada</span>
                            </label>
                        </div>
                    </div>

                    <!-- Repeater Form Anak (Jika Ada) -->
                    <div x-show="memilikiAnak === 'ada'" x-cloak class="space-y-4 pt-2">
                        <template x-for="(anak, index) in anakList" :key="index">
                            <div class="bg-gray-50/70 border border-gray-200/90 rounded-xl p-5 space-y-4 relative">
                                <div class="flex items-center justify-between border-b border-gray-200/60 pb-2">
                                    <span class="text-xs font-bold text-gray-700" x-text="'Informasi Anak Pewasiat ' + (anakList.length > 1 ? (index + 1) : '')"></span>
                                    <button type="button" 
                                            x-show="anakList.length > 1" 
                                            @click="hapusAnak(index)" 
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>

                                <!-- Nama Lengkap Anak Pewasiat -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Nama Lengkap Anak Pewasiat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           :name="'anak[' + index + '][nama_lengkap]'" 
                                           x-model="anak.nama_lengkap" 
                                           :required="memilikiAnak === 'ada'"
                                           placeholder="Masukkan nama lengkap" 
                                           class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    <p class="mt-1 text-[11px] text-gray-400 italic">
                                        Apabila terdapat perbedaan nama, wajib disertai Penetapan Akta Ganti Nama atau penetapan Beda Nama.
                                    </p>
                                </div>

                                <!-- NIK & Jenis Kelamin Anak -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                            NIK Anak Waris Pewasiat <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               maxlength="16" 
                                               :name="'anak[' + index + '][nik]'" 
                                               x-model="anak.nik" 
                                               placeholder="16 digit NIK" 
                                               class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                            Jenis Kelamin Anak Waris Pewasiat <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select :name="'anak[' + index + '][jenis_kelamin]'" 
                                                    x-model="anak.jenis_kelamin" 
                                                    class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition appearance-none cursor-pointer">
                                                <option value="" disabled>Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tempat/Tanggal Lahir Anak -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Tempat/Tanggal Lahir Anak Waris Pewasiat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           :name="'anak[' + index + '][tempat_tanggal_lahir]'" 
                                           x-model="anak.tempat_tanggal_lahir" 
                                           placeholder="Contoh: Surabaya, 12-05-1995" 
                                           class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition" />
                                </div>

                                <!-- Alamat Anak -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Alamat Anak Waris Pewasiat <span class="text-red-500">*</span>
                                    </label>
                                    <textarea :name="'anak[' + index + '][alamat]'" 
                                              x-model="anak.alamat" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap" 
                                              class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4a1d84]/20 focus:border-[#4a1d84] transition resize-y"></textarea>
                                </div>
                            </div>
                        </template>

                        <!-- Tombol Tambah Anak -->
                        <div>
                            <button type="button" 
                                    @click="tambahAnak()" 
                                    class="w-full py-2.5 px-4 rounded-xl border-2 border-dashed border-purple-300 hover:border-purple-500 bg-purple-50/40 hover:bg-purple-50 text-purple-700 text-xs font-bold flex items-center justify-center gap-1.5 transition duration-150 cursor-pointer">
                                <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Tambah Anak</span>
                            </button>
                            <p class="mt-1.5 text-[11px] text-gray-400 text-center">
                                apabila anak Pewasiat lebih dari satu, klik tombol
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= TOMBOL AKSI BAWAH ================= -->
            <div class="flex items-center justify-end gap-3 pt-4 pb-12">
                <a href="{{ route('permohonan.index') }}" 
                   class="px-6 py-2.5 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                    Batal
                </a>

                <button type="submit" 
                        class="px-6 py-2.5 bg-[#eab308] hover:bg-[#d99b04] active:bg-[#b88002] text-[#1e1b4b] font-bold text-sm rounded-lg shadow-sm hover:shadow flex items-center gap-2 transition duration-150 cursor-pointer">
                    <span>Simpan & Lanjut</span>
                    <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-portal-layout>
