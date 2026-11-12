<?php

namespace Tests\Feature\Madya;

use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response->assertSee('Histori Layanan');
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
        $response->assertSee('Daftar Layanan');
    }

    public function test_madya_can_create_ba_for_layanan(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($madya)->post(route('madya.layanan.buat-ba', ['id' => $permohonan->id]), [
            'nomor_ba' => 'BA.01/WST/BHP.SBY/05/2025',
            'catatan' => 'Pemeriksaan fisik telah selesai.',
        ]);

        $response->assertRedirect(route('madya.dashboard'));
        $response->assertSessionHas('success');
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

    public function test_madya_can_archive_layanan(): void
    {
        $madya = $this->createKuratorMadyaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($madya)->post(route('madya.layanan.arsipkan', ['id' => $permohonan->id]), [
            'catatan' => 'Layanan telah selesai dan diarsipkan.',
        ]);

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
