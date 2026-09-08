<x-portal-layout>
    <x-slot name="title">
        Histori Permohonan - Balai Harta Peninggalan
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#0c2a55] tracking-tight">
                    Histori Permohonan
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Daftar riwayat dan status pengajuan permohonan Anda di Balai Harta Peninggalan Surabaya.
                </p>
            </div>

            <a href="{{ route('permohonan.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Ajukan Permohonan Baru</span>
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-800 flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Card List Table -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-[0_2px_8px_rgba(0,0,0,0.02)] overflow-hidden">
            @if ($permohonans->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-blue-50 text-[#0066d6] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Belum ada permohonan</h3>
                    <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1 mb-6">
                        Anda belum pernah membuat pengajuan permohonan pembukaan wasiat tertutup. Klik tombol di bawah untuk mulai.
                    </p>
                    <a href="{{ route('permohonan.create') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0066d6] hover:bg-[#0055b8] text-white font-bold text-xs rounded-xl shadow-sm transition">
                        <svg class="w-4 h-4 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Mulai Pengajuan Baru</span>
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-700">
                        <thead class="bg-[#f0f4f9] text-[#0c2a55] uppercase text-[11px] font-bold border-b border-blue-100">
                            <tr>
                                <th class="px-6 py-3.5">No. Permohonan</th>
                                <th class="px-6 py-3.5">Nama Pewasiat</th>
                                <th class="px-6 py-3.5">Status</th>
                                <th class="px-6 py-3.5">Tanggal Dibuat</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($permohonans as $p)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="px-6 py-4 font-mono font-semibold text-gray-900">
                                        {{ $p->nomor_permohonan }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $p->pewasiat?->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($p->status === 'draft')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                Draft
                                            </span>
                                        @elseif ($p->status === 'menunggu_verifikasi')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif ($p->status === 'selesai')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $p->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('permohonan.tahap2', $p->id) }}" 
                                               class="px-2.5 py-1 text-[11px] font-bold rounded-md bg-[#edf4fb] text-[#0066cc] hover:bg-[#d8e9f8] transition">
                                                Tahap 2
                                            </a>
                                            <a href="{{ route('permohonan.tahap3', $p->id) }}" 
                                               class="px-2.5 py-1 text-[11px] font-bold rounded-md bg-purple-50 text-[#4a1d84] hover:bg-purple-100 transition">
                                                Tahap 3
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100">
                    {{ $permohonans->links() }}
                </div>
            @endif
        </div>
    </div>
</x-portal-layout>
