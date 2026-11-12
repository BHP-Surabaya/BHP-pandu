<?php

namespace Tests\Feature\Muda;

use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MudaDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createKuratorMudaUser(): User
    {
        return User::factory()->jfkkMuda()->create();
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
            'status' => 'disetujui_pertama',
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

    public function test_muda_dashboard_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get(route('muda.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_muda_dashboard(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('muda.dashboard'));

        $response->assertForbidden();
    }

    public function test_kurator_muda_is_redirected_to_muda_dashboard_from_root_dashboard(): void
    {
        $muda = $this->createKuratorMudaUser();

        $response = $this->actingAs($muda)->get(route('dashboard'));

        $response->assertRedirect(route('muda.dashboard'));
    }

    public function test_muda_dashboard_renders_with_tabs_and_jadwal_pembukaan(): void
    {
        $muda = $this->createKuratorMudaUser();
        $pemohon = $this->createPemohonUser();
        $this->createPermohonan($pemohon);

        $response = $this->actingAs($muda)->get(route('muda.dashboard'));

        $response->assertOk();
        $response->assertSee('RUANG KERJA');
        $response->assertSee('Verifikasi Lanjutan');
        $response->assertSee('Hasil Verifikasi Pertama');
        $response->assertSee('Penjadwalan Pembukaan');
        $response->assertSee('Penerbitan Dokumen');
        $response->assertSee('Jadwal Pembukaan Wasiat');
        $response->assertSee('WST-2025-04098');
        $response->assertSee('Dimas Mahendra');
        $response->assertSee('Tindak lanjut');
        $response->assertSee('Lihat');
    }

    public function test_muda_history_page_renders_successfully(): void
    {
        $muda = $this->createKuratorMudaUser();

        $response = $this->actingAs($muda)->get(route('muda.history'));

        $response->assertOk();
        $response->assertSee('History Verifikasi');
        $response->assertSee('DASHBOARD KURATOR MUDA');
        $response->assertSee('Lutfy, S.H.');
    }

    public function test_muda_can_view_verifikasi_detail_page(): void
    {
        $muda = $this->createKuratorMudaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($muda)->get(route('muda.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertOk();
        $response->assertSee('Data Input Pemohon');
        $response->assertSee('Dokumen Persyaratan');
        $response->assertSee('Verifikasi Data Input dan Persyaratan');
        $response->assertSee('Dimas Mahendra');
        $response->assertSee('Permohonan Pembukaan/Pembacaan Wasiat Tertutup Oleh Fungsional Muda');
        $response->assertSee('Permohonan diajukan oleh Notaris');
        $response->assertSee('Verifikasi Data Pewasiat');
        $response->assertSee('Daftar Pusat Wasiat, Ditjen AHU');
        $response->assertSee('Verifikasi data dan informasi para Ahli Waris');
    }

    public function test_pemohon_cannot_view_muda_verifikasi_detail_page(): void
    {
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($pemohon)->get(route('muda.verifikasi.show', ['id' => $permohonan->id]));

        $response->assertForbidden();
    }

    public function test_muda_can_process_tindak_lanjut_verifikasi(): void
    {
        $muda = $this->createKuratorMudaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($muda)->post(route('muda.tindak-lanjut', ['id' => $permohonan->id]), [
            'status' => 'disetujui',
            'catatan' => 'Berkas persyaratan lengkap diverifikasi Kurator Muda.',
        ]);

        $response->assertRedirect(route('muda.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_muda_can_process_tindak_lanjut_jadwal(): void
    {
        $muda = $this->createKuratorMudaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($muda)->post(route('muda.jadwal.tindak-lanjut', ['id' => $permohonan->id]), [
            'status' => 'disetujui',
            'lokasi' => 'Ruang Sidang Utama BHP Surabaya',
            'catatan' => 'Jadwal pembukaan wasiat disetujui.',
        ]);

        $response->assertRedirect(route('muda.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_muda_can_terbitkan_dokumen(): void
    {
        $muda = $this->createKuratorMudaUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($muda)->post(route('muda.dokumen.terbitkan', ['id' => $permohonan->id]), [
            'status_dokumen' => 'Selesai & Terdistribusi',
            'catatan' => 'Berita acara telah diunggah resmi.',
        ]);

        $response->assertRedirect(route('muda.dashboard'));
        $response->assertSessionHas('success');
    }
}
