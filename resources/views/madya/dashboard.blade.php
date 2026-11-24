<x-portal-layout>
    <x-slot:title>
        Layanan Wasiat Tertutup - Kurator Keperdataan Madya BHP Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        selectedItem: null,
        modalOpen: false,
        activeWorkflowTab: 'ba',
        bukaModal(item) {
            this.selectedItem = item;
            this.modalOpen = true;
            this.activeWorkflowTab = 'ba';
        },
        tutupModal() {
            this.modalOpen = false;
            this.selectedItem = null;
        }
    }">

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Header Halaman Sesuai Mockup Dashboard Madya -->
        <div>
            <span class="text-xs font-bold tracking-wider text-[#1d68d8] uppercase block">
                DASHBOARD MADYA
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight mt-1">
                Layanan Wasiat Tertutup
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola berita acara, cetak dokumen 2 salinan, dan arsipkan berkas layanan.
            </p>
        </div>

        <!-- Kartu Utama: Daftar Layanan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-7">
            
            <!-- Judul & Subjudul Kartu Sesuai Mockup -->
            <div class="mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Daftar Layanan
                </h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    Layanan Wasiat Tertutup aktif — buat BA, cetak dokumen, unggah berkas.
                </p>
            </div>

            <!-- Tabel Data Layanan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[950px]">
                    <thead>
                        <tr class="bg-slate-50/70 border-y border-slate-100 text-xs font-bold text-slate-700">
                            <th scope="col" class="py-3.5 px-4 w-12 text-center">
                                No
                            </th>
                            <th scope="col" class="py-3.5 px-4">
                                No Layanan
                            </th>
                            <th scope="col" class="py-3.5 px-4">
                                Jenis Layanan
                            </th>
                            <th scope="col" class="py-3.5 px-4">
                                Pemohon
                            </th>
                            <th scope="col" class="py-3.5 px-4">
                                SLA Layanan
                            </th>
                            <th scope="col" class="py-3.5 px-4">
                                Jadwal Pembukaan
                            </th>
                            <th scope="col" class="py-3.5 px-4 text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($layananList as $index => $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <!-- NO -->
                                <td class="py-4 px-4 text-center font-medium text-slate-600">
                                    {{ sprintf('%02d', $index + 1) }}
                                </td>

                                <!-- NO LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="font-bold text-[#1d68d8]">
                                        {{ $item['nomor_layanan'] }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $item['nama_pewasiat'] ?? 'Pewasiat' }}
                                    </div>
                                </td>

                                <!-- JENIS LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-[#1d68d8] border border-blue-100">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                </td>

                                <!-- PEMOHON -->
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-slate-900">
                                        {{ $item['nama_pemohon'] }}
                                    </div>
                                    @if (!empty($item['telepon']))
                                        <div class="text-xs text-slate-400 font-normal mt-0.5">
                                            {{ $item['telepon'] }}
                                        </div>
                                    @endif
                                </td>

                                <!-- SLA LAYANAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="font-semibold text-slate-800 text-xs sm:text-sm">
                                        {{ $item['sla_tanggal'] ?? '-' }}
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-0.5">
                                        <span class="w-2 h-2 rounded-full shrink-0 {{ ($item['sla_badge'] ?? '') === 'red' ? 'bg-rose-500' : (($item['sla_badge'] ?? '') === 'yellow' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                        <span>{{ $item['sla_sisa'] ?? 'SLA Aktif' }}</span>
                                        @if (!empty($item['sla_progress']))
                                            <span class="text-slate-400 text-[11px]">({{ $item['sla_progress'] }})</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- JADWAL PEMBUKAAN -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="font-semibold text-slate-800 text-xs sm:text-sm">
                                        {{ $item['jadwal_pembukaan'] ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        {{ $item['waktu_pembukaan'] ?? '-' }}
                                    </div>
                                </td>

                                <!-- AKSI -->
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Tombol Detail / Verifikasi SOP -->
                                        <a href="{{ route('madya.verifikasi.show', $item['id']) }}" 
                                           title="Lihat Detail & Checklist SOP"
                                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-300 transition shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>Lihat</span>
                                        </a>

                                        <!-- Tombol Tindak Lanjut Modal -->
                                        <button type="button" 
                                                @click="bukaModal({{ json_encode($item) }})"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#1d68d8] hover:bg-[#1557b8] text-white text-xs font-semibold shadow-xs transition cursor-pointer">
                                            <span>Tindak lanjut</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center text-sm text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span>Belum ada layanan Wasiat Tertutup aktif saat ini.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total Layanan Footer Ringkas -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan {{ count($layananList) }} layanan aktif</span>
                <span class="text-slate-400">Balai Harta Peninggalan &bull; Fungsional Madya</span>
            </div>
        </div>

        <!-- ================= MODAL TINDAK LANJUT LAYANAN WASIAT TERTUTUP ================= -->
        <div x-show="modalOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" 
                 @click="tutupModal()"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-200"
                     @click.stop>
                    
                    <!-- Modal Header -->
                    <div class="bg-[#0c2a55] px-6 py-4 text-white flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-blue-200 tracking-wider uppercase block">TINDAK LANJUT LAYANAN WASIAT TERTUTUP</span>
                            <h3 class="text-base font-bold text-white mt-0.5" x-text="selectedItem ? selectedItem.nomor_layanan : ''"></h3>
                        </div>
                        <button type="button" @click="tutupModal()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Ringkasan Layanan -->
                    <div class="p-6 bg-slate-50/60 border-b border-slate-100 text-xs grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <span class="text-slate-400 block font-medium">Pemohon</span>
                            <span class="font-bold text-slate-800" x-text="selectedItem ? selectedItem.nama_pemohon : '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Pewasiat</span>
                            <span class="font-bold text-slate-800" x-text="selectedItem ? selectedItem.nama_pewasiat : '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Jadwal Pembukaan</span>
                            <span class="font-bold text-slate-800" x-text="selectedItem ? selectedItem.jadwal_pembukaan : '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Waktu</span>
                            <span class="font-bold text-[#1d68d8]" x-text="selectedItem ? selectedItem.waktu_pembukaan : '-'"></span>
                        </div>
                    </div>

                    <!-- Workflow Tabs Sesuai Subjudul Mockup -->
                    <div class="px-6 pt-4 border-b border-slate-200 flex gap-2">
                        <button type="button" 
                                @click="activeWorkflowTab = 'ba'"
                                :class="activeWorkflowTab === 'ba' ? 'border-[#1d68d8] text-[#1d68d8] font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                                class="pb-3 border-b-2 text-xs flex items-center gap-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span>1. Buat BA</span>
                        </button>
                        <button type="button" 
                                @click="activeWorkflowTab = 'cetak'"
                                :class="activeWorkflowTab === 'cetak' ? 'border-[#1d68d8] text-[#1d68d8] font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                                class="pb-3 border-b-2 text-xs flex items-center gap-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.672-2.13-1.27-3.086m0 0A10.02 10.02 0 0112 4.5c4.76 0 8.746 3.324 9.77 7.784M12 4.5v15m0 0l-3-3m3 3l3-3" />
                            </svg>
                            <span>2. Cetak Dokumen (2 Salinan)</span>
                        </button>
                        <button type="button" 
                                @click="activeWorkflowTab = 'arsip'"
                                :class="activeWorkflowTab === 'arsip' ? 'border-[#1d68d8] text-[#1d68d8] font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                                class="pb-3 border-b-2 text-xs flex items-center gap-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            <span>3. Arsipkan Berkas</span>
                        </button>
                    </div>

                    <!-- Modal Body Form -->
                    <div class="p-6">
                        
                        <!-- TAB 1: BUAT BERITA ACARA -->
                        <div x-show="activeWorkflowTab === 'ba'" class="space-y-4">
                            <form :action="'{{ url('/madya/layanan') }}/' + (selectedItem ? selectedItem.id : '') + '/buat-ba'" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Berita Acara (BA)</label>
                                    <input type="text" name="nomor_ba" 
                                           :value="selectedItem && selectedItem.nomor_ba ? selectedItem.nomor_ba : 'BA.01/WST/BHP.SBY/{{ date('m/Y') }}'" 
                                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-medium focus:ring-2 focus:ring-[#1d68d8]/20 focus:border-[#1d68d8]" />
                                    <span class="text-[11px] text-slate-400 mt-1 block">Format baku Berita Acara Pembukaan Akta Wasiat Tertutup Balai Harta Peninggalan.</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan Pelaksanaan BA</label>
                                    <textarea name="catatan" rows="3" placeholder="Keadaan sampul wasiat tersegel, disaksikan oleh notaris dan 2 orang saksi..." 
                                              class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-[#1d68d8]/20 focus:border-[#1d68d8]"></textarea>
                                </div>
                                <div class="flex items-center justify-between pt-2">
                                    <a :href="'{{ url('/madya/verifikasi') }}/' + (selectedItem ? selectedItem.id : '')" 
                                       class="text-xs font-semibold text-[#1d68d8] hover:underline flex items-center gap-1">
                                        <span>Buka Form Telaah SOP Lengkap</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                    </a>
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#1d68d8] hover:bg-[#1557b8] text-white text-xs font-bold shadow-xs transition">
                                        Simpan & Buat BA
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB 2: CETAK DOKUMEN 2 SALINAN -->
                        <div x-show="activeWorkflowTab === 'cetak'" class="space-y-4">
                            <form :action="'{{ url('/madya/layanan') }}/' + (selectedItem ? selectedItem.id : '') + '/cetak-dokumen'" method="POST" class="space-y-4">
                                @csrf
                                <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-100 flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.672-2.13-1.27-3.086m0 0A10.02 10.02 0 0112 4.5c4.76 0 8.746 3.324 9.77 7.784M12 4.5v15m0 0l-3-3m3 3l3-3" />
                                        </svg>
                                    </div>
                                    <div class="text-xs text-blue-900 leading-relaxed">
                                        <p class="font-bold">Ketentuan Cetak 2 Salinan Dokumen:</p>
                                        <ul class="list-disc list-inside mt-1 space-y-0.5 text-blue-800">
                                            <li><strong>Salinan I:</strong> Diserahkan secara resmi kepada Pemohon / Ahli Waris sah.</li>
                                            <li><strong>Salinan II:</strong> Disimpan dalam warkah arsip BHP Surabaya.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="pt-2 flex items-center justify-end gap-2">
                                    <button type="button" @click="window.print()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 text-xs font-semibold shadow-2xs transition">
                                        Pratinjau Cetak
                                    </button>
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#1d68d8] hover:bg-[#1557b8] text-white text-xs font-bold shadow-xs transition">
                                        Konfirmasi Cetak 2 Salinan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB 3: ARSIPKAN BERKAS LAYANAN -->
                        <div x-show="activeWorkflowTab === 'arsip'" class="space-y-4">
                            <form :action="'{{ url('/madya/layanan') }}/' + (selectedItem ? selectedItem.id : '') + '/arsipkan'" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Berita Acara Bertandatangan (PDF)</label>
                                    <input type="file" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#1d68d8] hover:file:bg-blue-100" />
                                    <span class="text-[11px] text-slate-400 mt-1 block">Scan warkah Berita Acara dan tanda terima salinan dokumen.</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Pengarsipan</label>
                                    <textarea name="catatan" rows="3" placeholder="Layanan telah selesai dilaksanakan, berkas fisik disimpan di lemari warkah wasiat..." 
                                              class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-[#1d68d8]/20 focus:border-[#1d68d8]"></textarea>
                                </div>
                                <div class="pt-2 flex items-center justify-end gap-2">
                                    <button type="button" @click="tutupModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition">
                                        Simpan & Arsipkan Layanan
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
