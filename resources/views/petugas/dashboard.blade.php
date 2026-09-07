<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Petugas BHP') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Ringkasan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Total Permohonan</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900">0</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Menunggu Verifikasi</div>
                        <div class="mt-1 text-3xl font-bold text-yellow-600">0</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500">Menunggu Voucher</div>
                        <div class="mt-1 text-3xl font-bold text-indigo-600">0</div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">Daftar Permohonan Pembukaan Wasiat</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Modul permohonan belum dihubungkan ke dashboard ini. Tabel <code class="bg-gray-100 px-1 rounded">permohonans</code>, <code class="bg-gray-100 px-1 rounded">pewasiats</code>, <code class="bg-gray-100 px-1 rounded">pasangans</code>, <code class="bg-gray-100 px-1 rounded">ahli_waris</code>, <code class="bg-gray-100 px-1 rounded">dokumens</code>, dan <code class="bg-gray-100 px-1 rounded">vouchers</code> sudah siap melalui migration.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>