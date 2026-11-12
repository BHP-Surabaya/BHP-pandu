<?php

namespace Tests\Feature\Muda;

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
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
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
        $response->assertSee('23 Mei 2025');
        $response->assertSee('2 hari tersisa');
        $response->assertSee('0812 8876 2104');
        $response->assertSee('Sari Wulandari');
        $response->assertSee('Fajar Nugraha');
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

        $response = $this->actingAs($muda)->get(route('muda.verifikasi.show', ['id' => 1]));

        $response->assertOk();
        $response->assertSee('Data Input Pemohon');
        $response->assertSee('Dokumen Persyaratan');
        $response->assertSee('Verifikasi Data Input dan Persyaratan');
        $response->assertSee('Nadia Prameswari');
        $response->assertSee('KTP Pemohon.pdf');
        $response->assertSee('Permohonan Pembukaan/Pembacaan Wasiat Tertutup Oleh Fungsional Muda');
        $response->assertSee('Permohonan diajukan oleh Notaris');
        $response->assertSee('Verifikasi Data Pewasiat');
        $response->assertSee('Daftar Pusat Wasiat, Ditjen AHU');
        $response->assertSee('Verifikasi data dan informasi para Ahli Waris');
    }

    public function test_pemohon_cannot_view_muda_verifikasi_detail_page(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('muda.verifikasi.show', ['id' => 1]));

        $response->assertForbidden();
    }

    public function test_muda_can_process_tindak_lanjut_verifikasi(): void
    {
        $muda = $this->createKuratorMudaUser();

        $response = $this->actingAs($muda)->post(route('muda.tindak-lanjut', ['id' => 1]), [
            'status' => 'disetujui',
            'catatan' => 'Berkas persyaratan lengkap diverifikasi Kurator Muda.',
        ]);

        $response->assertRedirect(route('muda.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_muda_can_process_tindak_lanjut_jadwal(): void
    {
        $muda = $this->createKuratorMudaUser();

        $response = $this->actingAs($muda)->post(route('muda.jadwal.tindak-lanjut', ['id' => 2]), [
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

        $response = $this->actingAs($muda)->post(route('muda.dokumen.terbitkan', ['id' => 1]), [
            'status_dokumen' => 'Selesai & Terdistribusi',
            'catatan' => 'Berita acara telah diunggah resmi.',
        ]);

        $response->assertRedirect(route('muda.dashboard'));
        $response->assertSessionHas('success');
    }
}
