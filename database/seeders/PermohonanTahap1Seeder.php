<?php

namespace Database\Seeders;

use App\Models\AhliWaris;
use App\Models\Pasangan;
use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermohonanTahap1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user pemohon (misal fernanda atau pemohon pertama yang ada)
        $users = User::where('role', 'pemohon')->get();

        if ($users->isEmpty()) {
            $user = User::first() ?? User::factory()->create([
                'name' => 'Pemohon Contoh',
                'email' => 'pemohon@bhp.test',
                'role' => 'pemohon',
            ]);
            $users = collect([$user]);
        }

        foreach ($users as $user) {
            $nomorPermohonan = 'WST-'.date('Ymd').'-'.strtoupper(substr(md5(uniqid((string) $user->id, true)), 0, 6));

            $permohonan = Permohonan::create([
                'user_id' => $user->id,
                'nomor_permohonan' => $nomorPermohonan,
                'status' => 'draft',
            ]);

            $pewasiat = Pewasiat::create([
                'permohonan_id' => $permohonan->id,
                'nama_lengkap' => 'Prof. Dr. Ir. Raden Soeprapto Mangoenkoesoemo',
                'dahulu_bernama' => 'Soeprapto',
                'alias' => 'Opa Prapto',
                'nik' => '3578011708520001',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1952-08-17',
                'tempat_tinggal_terakhir' => 'Jl. Raya Darmo No. 45, RT 003 / RW 002, Kel. Keputran, Kec. Tegalsari, Kota Surabaya, Jawa Timur',
                'tempat_kematian' => 'RSUD Dr. Soetomo, Kota Surabaya',
                'tanggal_kematian' => '2026-02-10',
                'nomor_akta_kematian' => '3578-KM-10022026-0015',
                'tanggal_akta_kematian' => '2026-02-14',
                'pejabat_pembuat_akta_kematian' => 'Dinas Kependudukan dan Pencatatan Sipil Kota Surabaya',
                'nomor_surat_dpw' => 'AHU.2.AH.04.01-14022026/DPW',
                'tanggal_surat_dpw' => '2026-02-20',
                'status_pencatatan' => 'Terdaftar pada Daftar Pusat Wasiat',
                'nomor_akta_penyimpanan' => 'WST-12/NOT-SBY/2019',
                'tanggal_akta_penyimpanan' => '2019-11-05',
                'nama_notaris' => 'Bambang Sugiharto, S.H., M.Kn.',
                'kedudukan_notaris' => 'Kota Surabaya',
                'status_kawin' => 'kawin',
            ]);

            Pasangan::create([
                'pewasiat_id' => $pewasiat->id,
                'nama_lengkap' => 'Hj. Siti Aminah Soeprapto',
                'nik' => '3578015509550002',
                'jenis_kelamin' => 'P',
                'bukti_perkawinan' => 'Buku Nikah',
                'nomor_bukti_perkawinan' => 'KUA.13.05/PW.01/1978',
                'tanggal_kawin' => '1978-09-15',
                'tempat_kawin' => 'Kota Surabaya',
                'pejabat_pembuat_bukti' => 'KUA Kecamatan Tegalsari, Kota Surabaya',
            ]);

            AhliWaris::create([
                'pewasiat_id' => $pewasiat->id,
                'nama_lengkap' => 'dr. Dimas Arya Mangoenkoesoemo, Sp.PD',
                'nik' => '3578011203820003',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya, 12 Maret 1982',
                'alamat' => 'Jl. Manyar Kertoarjo IV No. 18, Surabaya',
            ]);

            AhliWaris::create([
                'pewasiat_id' => $pewasiat->id,
                'nama_lengkap' => 'Dian Anggraini Mangoenkoesoemo, S.E., M.B.A.',
                'nik' => '3578015807860004',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Surabaya, 18 Juli 1986',
                'alamat' => 'Jl. Kertajaya Indah Timur No. 22, Surabaya',
            ]);
        }
    }
}
