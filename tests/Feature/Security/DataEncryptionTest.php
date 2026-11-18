<?php

namespace Tests\Feature\Security;

use App\Models\AhliWaris;
use App\Models\Pasangan;
use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DataEncryptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_pewasiat_nik_is_encrypted_at_rest_in_database(): void
    {
        $pemohon = User::factory()->create(['role' => 'pemohon']);
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-ENC-001',
            'status' => 'draft',
        ]);

        $plainNik = '3578011708520001';

        $pewasiat = Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Alm. Soetrisno Hardjono',
            'nik' => $plainNik,
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1952-08-17',
            'tempat_tinggal_terakhir' => 'Kota Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2025-01-12',
            'nomor_akta_kematian' => '3578-KM-2025-00891',
            'tanggal_akta_kematian' => '2025-01-15',
            'pejabat_pembuat_akta_kematian' => 'Disdukcapil Surabaya',
            'nomor_surat_dpw' => 'AHU.2.AH.04.01-14022025/DPW',
            'tanggal_surat_dpw' => '2025-02-14',
            'status_pencatatan' => 'Terdaftar',
            'nomor_akta_penyimpanan' => 'WST-12/NOT-SBY/2019',
            'tanggal_akta_penyimpanan' => '2019-11-05',
            'nama_notaris' => 'Bambang Sugiharto, S.H., M.Kn.',
            'kedudukan_notaris' => 'Surabaya',
            'status_kawin' => 'kawin',
        ]);

        // 1. Eloquent otomatis mendekripsi saat diakses
        $freshPewasiat = Pewasiat::find($pewasiat->id);
        $this->assertSame($plainNik, $freshPewasiat->nik);

        // 2. Data mentah di database harus terenkripsi (bukan plaintext)
        $rawNik = DB::table('pewasiats')->where('id', $pewasiat->id)->value('nik');
        $this->assertNotSame($plainNik, $rawNik);
        $this->assertTrue(strlen($rawNik) > 50, 'Ciphertext NIK di database harus berukuran lebih dari 50 karakter.');

        // 3. Dekripsi manual membuktikan validitas ciphertext AES-256
        $this->assertSame($plainNik, Crypt::decryptString($rawNik));
    }

    public function test_pasangan_nik_is_encrypted_at_rest_in_database(): void
    {
        $pemohon = User::factory()->create(['role' => 'pemohon']);
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-ENC-002',
            'status' => 'draft',
        ]);

        $pewasiat = Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Pewasiat Test',
            'nik' => '3578011708520002',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1952-08-17',
            'tempat_tinggal_terakhir' => 'Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2025-01-12',
            'nomor_akta_kematian' => '3578-KM-2025-00892',
            'tanggal_akta_kematian' => '2025-01-15',
            'pejabat_pembuat_akta_kematian' => 'Disdukcapil Surabaya',
            'nomor_surat_dpw' => 'AHU.2.AH.04.01-14022025/DPW',
            'tanggal_surat_dpw' => '2025-02-14',
            'status_pencatatan' => 'Terdaftar',
            'nomor_akta_penyimpanan' => 'WST-12/NOT-SBY/2019',
            'tanggal_akta_penyimpanan' => '2019-11-05',
            'nama_notaris' => 'Notaris Test',
            'kedudukan_notaris' => 'Surabaya',
            'status_kawin' => 'kawin',
        ]);

        $plainNikPasangan = '3578015509550002';
        $pasangan = Pasangan::create([
            'pewasiat_id' => $pewasiat->id,
            'nama_lengkap' => 'Hj. Siti Aminah',
            'nik' => $plainNikPasangan,
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1955-09-15',
            'alamat' => 'Surabaya',
            'tempat_kawin' => 'Surabaya',
            'tanggal_kawin' => '1980-05-10',
            'bukti_perkawinan' => 'Buku Nikah',
            'nomor_bukti_perkawinan' => 'BN-12345/1980',
            'tanggal_bukti_perkawinan' => '1980-05-10',
            'pejabat_pembuat_bukti' => 'KUA Tegalsari Surabaya',
        ]);

        $freshPasangan = Pasangan::find($pasangan->id);
        $this->assertSame($plainNikPasangan, $freshPasangan->nik);

        $rawNik = DB::table('pasangans')->where('id', $pasangan->id)->value('nik');
        $this->assertNotSame($plainNikPasangan, $rawNik);
        $this->assertSame($plainNikPasangan, Crypt::decryptString($rawNik));
    }

    public function test_ahli_waris_nik_is_encrypted_at_rest_in_database(): void
    {
        $pemohon = User::factory()->create(['role' => 'pemohon']);
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-ENC-003',
            'status' => 'draft',
        ]);

        $pewasiat = Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Pewasiat Test',
            'nik' => '3578011708520003',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1952-08-17',
            'tempat_tinggal_terakhir' => 'Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2025-01-12',
            'nomor_akta_kematian' => '3578-KM-2025-00893',
            'tanggal_akta_kematian' => '2025-01-15',
            'pejabat_pembuat_akta_kematian' => 'Disdukcapil Surabaya',
            'nomor_surat_dpw' => 'AHU.2.AH.04.01-14022025/DPW',
            'tanggal_surat_dpw' => '2025-02-14',
            'status_pencatatan' => 'Terdaftar',
            'nomor_akta_penyimpanan' => 'WST-12/NOT-SBY/2019',
            'tanggal_akta_penyimpanan' => '2019-11-05',
            'nama_notaris' => 'Notaris Test',
            'kedudukan_notaris' => 'Surabaya',
            'status_kawin' => 'kawin',
        ]);

        $plainNikAnak = '3578011203820003';
        $anak = AhliWaris::create([
            'pewasiat_id' => $pewasiat->id,
            'nama_lengkap' => 'Dimas Arya',
            'nik' => $plainNikAnak,
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1982-03-12',
            'alamat' => 'Surabaya',
        ]);

        $freshAnak = AhliWaris::find($anak->id);
        $this->assertSame($plainNikAnak, $freshAnak->nik);

        $rawNik = DB::table('ahli_waris')->where('id', $anak->id)->value('nik');
        $this->assertNotSame($plainNikAnak, $rawNik);
        $this->assertSame($plainNikAnak, Crypt::decryptString($rawNik));
    }

    public function test_user_nik_is_encrypted_at_rest_in_database(): void
    {
        $plainNik = '3578019908900005';
        $user = User::factory()->create([
            'role' => 'pemohon',
            'nik' => $plainNik,
        ]);

        $freshUser = User::find($user->id);
        $this->assertSame($plainNik, $freshUser->nik);

        $rawNik = DB::table('users')->where('id', $user->id)->value('nik');
        $this->assertNotSame($plainNik, $rawNik);
        $this->assertSame($plainNik, Crypt::decryptString($rawNik));
    }
}
