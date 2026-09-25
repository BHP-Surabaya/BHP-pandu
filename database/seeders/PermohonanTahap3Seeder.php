<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class PermohonanTahap3Seeder extends Seeder
{
    /**
     * Run the database seeds for Tahap 3 (Nomor Voucher PNBP).
     */
    public function run(): void
    {
        $permohonans = Permohonan::all();

        if ($permohonans->isEmpty()) {
            $this->call([
                PermohonanTahap1Seeder::class,
                PermohonanTahap2Seeder::class,
            ]);
            $permohonans = Permohonan::all();
        }

        $dummyVouchers = [
            ['nomor' => 'AHU-001008002-83921045', 'status' => 'belum_bayar'],
            ['nomor' => 'AHU-001008002-94812304', 'status' => 'lunas'],
            ['nomor' => 'AHU-001008002-71048293', 'status' => 'belum_bayar'],
            ['nomor' => 'AHU-001008002-55291048', 'status' => 'lunas'],
        ];

        foreach ($permohonans as $index => $permohonan) {
            $data = $dummyVouchers[$index % count($dummyVouchers)];
            $nomor = $index < count($dummyVouchers)
                ? $data['nomor']
                : 'AHU-001008002-'.str_pad((string) mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);

            Voucher::updateOrCreate(
                ['permohonan_id' => $permohonan->id],
                [
                    'nomor_voucher' => $nomor,
                    'status_pembayaran' => $data['status'],
                    'tanggal_input' => now()->subHours(mt_rand(1, 24)),
                ]
            );
        }
    }
}
