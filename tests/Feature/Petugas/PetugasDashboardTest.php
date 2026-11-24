<?php

namespace Tests\Feature\Petugas;

use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createPetugasUser(): User
    {
        return User::factory()->create([
            'name' => 'Iman, S.H.',
            'email' => 'jfkk.pertama@pandubhp.go.id',
            'role' => 'petugas',
            'pekerjaan' => 'Kurator Keperdataan Pertama',
            'status_akun' => 'petugas',
            'status_verifikasi' => 'terverifikasi',
            'email_verified_at' => now(),
        ]);
    }

    private function createPemohonUser(): User
    {
        return User::factory()->create([
            'name' => 'Nadia Prameswari',
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
    }

    private function createPermohonan(User $pemohon): Permohonan
    {
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'W15.AHU.AH.06.09-00024',
            'status' => 'menunggu_verifikasi',
        ]);

        Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Alm. Soetrisno',
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

    public function test_petugas_dashboard_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get(route('petugas.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_petugas_dashboard(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('petugas.dashboard'));

        $response->assertForbidden();
    }

    public function test_petugas_is_redirected_to_petugas_dashboard_from_root_dashboard(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->get(route('dashboard'));

        $response->assertRedirect(route('petugas.dashboard'));
    }

    public function test_petugas_dashboard_renders_with_menu_utama_and_verifikasi_persyaratan(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->get(route('petugas.dashboard'));

        $response->assertOk();
        $response->assertSee('MENU UTAMA');
        $response->assertSee('Verifikasi Persyaratan');
        $response->assertSee('History Verifikasi');
    }

    public function test_petugas_history_page_renders_successfully(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->get(route('petugas.history'));

        $response->assertOk();
        $response->assertSee('History Verifikasi');
        $response->assertSee('MENU UTAMA');
    }

    public function test_petugas_can_view_verifikasi_detail_page(): void
    {
        $petugas = $this->createPetugasUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($petugas)->get(route('petugas.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertOk();
        $response->assertSee('Data Input Pemohon');
        $response->assertSee('Dokumen Persyaratan');
        $response->assertSee('Verifikasi Data Input dan Persyaratan');
        $response->assertSee('Nadia Prameswari');
        $response->assertSee('Kutipan Akta Kematian Pewasiat.pdf');
        $response->assertSee('Permohonan diajukan oleh Notaris');
        $response->assertSee('Verifikasi Data Pewasiat');
        $response->assertSee('Daftar Pusat Wasiat, Ditjen AHU');
        $response->assertSee('Verifikasi data dan informasi para Ahli Waris');
    }

    public function test_pemohon_cannot_view_verifikasi_detail_page(): void
    {
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($pemohon)->get(route('petugas.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertForbidden();
    }

    public function test_petugas_can_process_tindak_lanjut_verifikasi(): void
    {
        $petugas = $this->createPetugasUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($petugas)->post(route('petugas.tindak-lanjut', ['id' => $permohonan->id]), [
            'status' => 'disetujui',
            'catatan' => 'Berkas persyaratan lengkap.',
        ]);

        $response->assertRedirect(route('petugas.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_petugas_can_view_in_page_qr_scanner_elements_for_akta_kematian(): void
    {
        $petugas = $this->createPetugasUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($petugas)->get(route('petugas.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertOk();
        $response->assertSee('Pindai QR Akta Kematian (Web Scan)');
        $response->assertSee('Verifikasi Barcode Surat Kematian');
        $response->assertSee('Pindai Berkas Digital (Auto-Decode)');
        $response->assertSee('TTE DUKCAPIL VALID');
        $response->assertSee('Terapkan & Setujui Poin 2.a', false);
    }
}
