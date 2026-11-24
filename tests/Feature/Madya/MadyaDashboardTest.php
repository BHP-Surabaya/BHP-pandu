<?php

namespace Tests\Feature\Madya;

use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MadyaDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createKuratorMadyaUser(): User
    {
        return User::factory()->jfkkMadya()->create();
    }

    private function createPemohonUser(): User
    {
        return User::factory()->create([
            'name' => 'Dimas Mahendra',
            'role' => 'pemohon',
            'phone' => '0812 8876 2104',
            'email_verified_at' => now(),
        ]);
    }

    private function createPermohonan(User $pemohon, array $attributes = []): Permohonan
    {
        $permohonan = Permohonan::create(array_merge([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-2025-04098',
            'status' => 'proses_madya',
        ], $attributes));

        Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Alm. Soetrisno Hardjono',
            'nik' => '3578011708520001',
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

        return $permohonan;
    }

    public function test_madya_dashboard_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get(route('madya.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_madya_dashboard(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('madya.dashboard'));

        $response->assertForbidden();
    }

    public function test_kurator_madya_is_redirected_to_madya_dashboard_from_root_dashboard(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->get(route('dashboard'));

        $response->assertRedirect(route('madya.dashboard'));
    }

    public function test_madya_dashboard_renders_with_menu_utama_and_layanan_wasiat_tertutup(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->get(route('madya.dashboard'));

        $response->assertOk();
        $response->assertSee('DASHBOARD MADYA');
        $response->assertSee('Layanan Wasiat Tertutup');
        $response->assertSee('Daftar Layanan');
        $response->assertSee('SLA Layanan');
        $response->assertSee('Jadwal Pembukaan');
    }

    public function test_madya_history_page_renders_successfully(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->get(route('madya.history'));

        $response->assertOk();
        $response->assertSee('Histori Layanan');
        $response->assertSee('DASHBOARD MADYA');
    }

    public function test_madya_can_request_and_verify_approval_otp_code(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        // 1. Request OTP
        $response = $this->actingAs($madya)->postJson(route('madya.layanan.kode-persetujuan', ['id' => $permohonan->id]));
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'sent_to',
            'masked_email',
            'expires_in_seconds',
            'delivery_mode',
            'preview_code',
        ]);

        $otp = $response->json('preview_code');
        $this->assertNotEmpty($otp);

        // 2. Verify Wrong OTP
        $wrongResponse = $this->actingAs($madya)->postJson(route('madya.layanan.verifikasi-kode', ['id' => $permohonan->id]), [
            'code' => '000000',
        ]);
        $wrongResponse->assertStatus(422);
        $wrongResponse->assertJson(['valid' => false]);

        // 3. Verify Correct OTP
        $verifyResponse = $this->actingAs($madya)->postJson(route('madya.layanan.verifikasi-kode', ['id' => $permohonan->id]), [
            'code' => $otp,
        ]);
        $verifyResponse->assertOk();
        $verifyResponse->assertJson(['valid' => true]);
    }

    public function test_madya_can_view_buat_ba_page_and_save_ba_with_verified_otp(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        // View Buat BA page
        $pageResponse = $this->actingAs($madya)->get(route('madya.layanan.buat-ba.page', ['id' => $permohonan->id]));
        $pageResponse->assertOk();
        $pageResponse->assertSee('Berita Acara Pembukaan Wasiat Tertutup');
        $pageResponse->assertSee('Otorisasi Kurator Madya');

        // Set verified OTP in cache
        Cache::put("madya_otp_verified_{$permohonan->id}", true, now()->addMinutes(10));

        $baData = [
            'nomor_ba' => 'W15.BHP.02-00099/BA-WT/XI/2026',
            'ada_surat_kuasa' => 1,
            'tanggal_surat_kuasa' => '2026-11-24',
            'hari' => 'Selasa',
            'tanggal' => '2026-11-24',
            'tempat_dibuat' => 'Sidoarjo',
            'pihak_pertama_nama' => 'Ayu Rachmawati, S.H., M.Kn.',
            'pihak_pertama_nip' => '198405122010122001',
            'pihak_pertama_jabatan' => 'Kurator Keperdataan Ahli Madya',
            'pihak_kedua_nama' => 'Dimas Mahendra',
            'pihak_kedua_jabatan' => 'Notaris Kota Surabaya',
            'pihak_kedua_alamat' => 'Jl. Pemuda No. 10 Surabaya',
            'deskripsi_wasiat' => '1 (satu) buah amplop coklat ukuran A4 dalam keadaan tertutup dan tersegel lak merah',
            'nama_pewasiat' => 'Alm. Soetrisno Hardjono',
            'saksi_1' => 'Budi Santoso, S.H.',
            'saksi_2' => 'Rina Wulandari, S.H.',
            'catatan' => 'Sidang pembukaan wasiat berlangsung tertib.',
            'submit_action' => 'save_print',
        ];

        $response = $this->actingAs($madya)->post(route('madya.layanan.buat-ba', ['id' => $permohonan->id]), $baData);

        $response->assertRedirect(route('madya.layanan.cetak.page', ['id' => $permohonan->id]));
        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'nomor_berita_acara' => 'W15.BHP.02-00099/BA-WT/XI/2026',
        ]);
    }

    public function test_madya_can_view_cetak_2_salinan_page(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon, [
            'nomor_berita_acara' => 'W15.BHP.02-00099/BA-WT/XI/2026',
            'data_berita_acara' => [
                'nomor_ba' => 'W15.BHP.02-00099/BA-WT/XI/2026',
                'ada_surat_kuasa' => true,
                'tanggal_surat_kuasa' => '2026-11-24',
                'hari' => 'Selasa',
                'tanggal' => '2026-11-24',
                'tempat_dibuat' => 'Sidoarjo',
                'pihak_pertama_nama' => 'Ayu Rachmawati, S.H., M.Kn.',
                'pihak_pertama_nip' => '198405122010122001',
                'pihak_pertama_jabatan' => 'Kurator Keperdataan Ahli Madya',
                'pihak_kedua_nama' => 'Dimas Mahendra',
                'pihak_kedua_jabatan' => 'Notaris Kota Surabaya',
                'pihak_kedua_alamat' => 'Jl. Pemuda No. 10 Surabaya',
                'deskripsi_wasiat' => '1 buah amplop coklat',
                'nama_pewasiat' => 'Alm. Soetrisno Hardjono',
                'saksi_1' => 'Budi Santoso, S.H.',
                'saksi_2' => 'Rina Wulandari, S.H.',
            ],
        ]);

        $response = $this->actingAs($madya)->get(route('madya.layanan.cetak.page', ['id' => $permohonan->id]));

        $response->assertOk();
        $response->assertSee('Cetak Berita Acara — 2 Salinan Resmi');
        $response->assertSee('SALINAN I — ARSIP BALAI HARTA PENINGGALAN SURABAYA');
        $response->assertSee('SALINAN II — PEMOHON / NOTARIS PENYIMPAN');
    }

    public function test_madya_can_manage_6_slot_documents_and_toggle_lock(): void
    {
        Storage::fake('local');

        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        // 1. View upload page
        $viewResponse = $this->actingAs($madya)->get(route('madya.layanan.upload.page', ['id' => $permohonan->id]));
        $viewResponse->assertOk();
        $viewResponse->assertSee('Unggah dan Kelola Berkas Sidang Wasiat');
        $viewResponse->assertSee('Surat / Form Persetujuan Jadwal');

        // 2. Upload file
        $file = UploadedFile::fake()->create('jadwal_sidang.pdf', 200, 'application/pdf');
        $uploadResponse = $this->actingAs($madya)->post(route('madya.layanan.upload-dokumen', ['id' => $permohonan->id]), [
            'jenis_dokumen' => 'persetujuan_jadwal',
            'file' => $file,
        ]);
        $uploadResponse->assertRedirect();
        $this->assertDatabaseHas('dokumens', [
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen' => 'persetujuan_jadwal',
        ]);

        // 3. Toggle Lock Documents
        $lockResponse = $this->actingAs($madya)->post(route('madya.layanan.toggle-kunci', ['id' => $permohonan->id]));
        $lockResponse->assertRedirect();
        $this->assertTrue($permohonan->fresh()->dokumen_terkunci);

        // 4. Try upload when locked -> forbidden/error
        $tryUploadResponse = $this->actingAs($madya)->post(route('madya.layanan.upload-dokumen', ['id' => $permohonan->id]), [
            'jenis_dokumen' => 'daftar_hadir',
            'file' => UploadedFile::fake()->create('daftar_hadir.pdf', 100, 'application/pdf'),
        ]);
        $tryUploadResponse->assertSessionHas('error');
    }

    public function test_madya_can_archive_and_reopen_layanan(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        // Archive
        $archiveResponse = $this->actingAs($madya)->post(route('madya.layanan.arsipkan', ['id' => $permohonan->id]), [
            'catatan' => 'Layanan telah selesai dan diarsipkan.',
        ]);
        $archiveResponse->assertRedirect(route('madya.dashboard'));
        $this->assertEquals('selesai', $permohonan->fresh()->status);
        $this->assertTrue($permohonan->fresh()->dokumen_terkunci);

        // Reopen (aktifkan kembali)
        $reopenResponse = $this->actingAs($madya)->post(route('madya.layanan.aktifkan', ['id' => $permohonan->id]));
        $reopenResponse->assertRedirect(route('madya.dashboard'));
        $this->assertEquals('proses_madya', $permohonan->fresh()->status);
        $this->assertFalse($permohonan->fresh()->dokumen_terkunci);
    }

    public function test_madya_can_record_cetak_dokumen(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($madya)->post(route('madya.layanan.cetak-dokumen', ['id' => $permohonan->id]));

        $response->assertRedirect(route('madya.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_madya_can_view_verifikasi_detail_page(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($madya)->get(route('madya.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertOk();
        $response->assertSee('Data Input Pemohon');
        $response->assertSee('Dokumen Persyaratan');
        $response->assertSee('Verifikasi Data Input dan Persyaratan');
        $response->assertSee('Dimas Mahendra');
        $response->assertSee('Permohonan Pembukaan/Pembacaan Wasiat Tertutup Oleh Fungsional Madya');
        $response->assertSee('Permohonan diajukan oleh Notaris');
        $response->assertSee('Verifikasi Data Pewasiat');
        $response->assertSee('Daftar Pusat Wasiat, Ditjen AHU');
        $response->assertSee('Verifikasi data dan informasi para Ahli Waris');
    }

    public function test_pemohon_cannot_view_madya_verifikasi_detail_page(): void
    {
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($pemohon)->get(route('madya.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertForbidden();
    }

    public function test_madya_can_submit_tindak_lanjut_verifikasi(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($madya)->post(route('madya.tindak-lanjut', ['id' => $permohonan->id]), [
            'status' => 'disetujui',
            'catatan' => 'Semua berkas persyaratan lengkap dan sah.',
        ]);

        $response->assertRedirect(route('madya.dashboard'));
        $response->assertSessionHas('success');
    }
}
