<x-portal-layout>
    <x-slot:title>
        Tindak Lanjut &amp; Persetujuan Dokumen - Kepala Balai Harta Peninggalan Surabaya
    </x-slot:title>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6" x-data="{
        selectedItem: null,
        modalOpen: false,
        arahanText: '',

        openActionModal(item) {
            this.selectedItem = item;
            this.arahanText = item.arahan_kepala || '';
            this.modalOpen = true;
        }
    }">

        <!-- Header Page -->
        <div class="pb-3 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0c2a55] tracking-tight">
                    Tindak Lanjut &amp; Atensi Layanan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Daftar permohonan layanan yang memerlukan atensi percepatan batas waktu SLA dan pengesahan dokumen.
                </p>
            </div>
            <a href="{{ route('kepala.dashboard') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-2xs transition self-start sm:self-auto">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- Flash Message Notification -->
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3 shadow-xs" x-data="{ show: true }" x-show="show">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 font-medium leading-relaxed">
                    {{ session('success') }}
                </div>
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <!-- Alert Bar Ringkasan Atensi -->
        <div class="bg-rose-50 border border-rose-200/90 rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-rose-900">
                        {{ count($layananList) }} Layanan Memerlukan Atensi Khusus Kepala BHP
                    </h3>
                    <p class="text-xs text-rose-700 mt-0.5">
                        Permohonan telah melampaui batas standar SLA 14 Hari Kerja dan memerlukan instruksi penyelesaian ke tim kurator.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Atensi Layanan -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50">
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                NOMOR LAYANAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                JENIS &amp; PEMOHON
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                WAKTU &amp; KETERLAMBATAN
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                KENDALA PROGRES
                            </th>
                            <th scope="col" class="py-3 px-5 text-[10px] font-bold uppercase tracking-wider text-gray-400 text-center w-36">
                                AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($layananList as $item)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-5">
                                    <span class="font-extrabold text-[#0c2a55] block leading-tight">
                                        {{ $item['nomor_layanan'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-400 block mt-0.5">
                                        {{ $item['tanggal_masuk'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-bold text-gray-800 block">
                                        {{ $item['jenis_layanan'] }}
                                    </span>
                                    <span class="text-[11px] text-gray-500 block mt-0.5">
                                        Pemohon: {{ $item['pemohon'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-100 text-rose-700 border border-rose-200">
                                        +{{ $item['keterlambatan'] }} Hari
                                    </span>
                                    <span class="text-[10px] text-gray-400 block mt-1">
                                        Berjalan {{ $item['hari_berjalan'] }} hari
                                    </span>
                                </td>
                                <td class="py-4 px-5 max-w-sm">
                                    <p class="text-gray-600 text-[11px] line-clamp-2">
                                        {{ $item['catatan_progres'] }}
                                    </p>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <button type="button" 
                                            @click="openActionModal({{ Js::from($item) }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#0066d6] hover:bg-[#0055b8] text-white text-xs font-bold transition shadow-xs cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Beri Arahan</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">
                                    Tidak ada layanan yang mengalami keterlambatan SLA saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Beri Arahan Tindak Lanjut -->
        <div x-show="modalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="modalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div class="relative w-full max-w-lg transform rounded-2xl bg-white text-left shadow-2xl transition-all p-6 border border-gray-100" @click.stop>
                    <div class="flex items-start justify-between pb-3 border-b border-gray-100">
                        <div>
                            <h3 class="text-base font-bold text-[#0c2a55]">
                                Beri Arahan Atensi Kepala BHP
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5" x-text="selectedItem?.nomor_layanan"></p>
                        </div>
                        <button type="button" @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form :action="'/kepala/tindak-lanjut/' + (selectedItem?.id || 0)" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Instruksi / Arahan Percepatan
                            </label>
                            <textarea name="arahan" 
                                      rows="4" 
                                      x-model="arahanText" 
                                      required 
                                      placeholder="Tuliskan arahan percepatan penyelesaian untuk KASI dan Tim Kurator..." 
                                      class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0066d6]/20 focus:border-[#0066d6] transition"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2.5 pt-2">
                            <button type="button" @click="modalOpen = false" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-[#0066d6] hover:bg-[#0055b8] text-white text-xs font-bold transition shadow-xs">
                                Kirim Arahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-portal-layout>
