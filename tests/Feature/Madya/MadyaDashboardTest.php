<?php

namespace Tests\Feature\Madya;

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
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
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

    public function test_madya_dashboard_renders_with_menu_utama_and_verifikasi_persyaratan(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->get(route('madya.dashboard'));

        $response->assertOk();
        $response->assertSee('DASHBOARD FUNGSIONAL MADYA');
        $response->assertSee('Verifikasi Persyaratan');
        $response->assertSee('History Verifikasi');
        $response->assertSee('Daftar Layanan');
    }

    public function test_madya_history_page_renders_successfully(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->get(route('madya.history'));

        $response->assertOk();
        $response->assertSee('History Verifikasi');
        $response->assertSee('DASHBOARD FUNGSIONAL MADYA');
        $response->assertSee('Inara, S.H., M.H.');
    }

    public function test_madya_can_view_verifikasi_detail_page(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->get(route('madya.verifikasi.show', ['id' => 1]));

        $response->assertOk();
        $response->assertSee('Data Input Pemohon');
        $response->assertSee('Dokumen Persyaratan');
        $response->assertSee('Verifikasi Data Input dan Persyaratan');
        $response->assertSee('Nadia Prameswari');
        $response->assertSee('KTP Pemohon.pdf');
        $response->assertSee('Permohonan Pembukaan/Pembacaan Wasiat Tertutup Oleh Fungsional Madya');
        $response->assertSee('Permohonan diajukan oleh Notaris');
        $response->assertSee('Verifikasi Data Pewasiat');
        $response->assertSee('Daftar Pusat Wasiat, Ditjen AHU');
        $response->assertSee('Verifikasi data dan informasi para Ahli Waris');
    }

    public function test_pemohon_cannot_view_madya_verifikasi_detail_page(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('madya.verifikasi.show', ['id' => 1]));

        $response->assertForbidden();
    }

    public function test_madya_can_process_tindak_lanjut_verifikasi(): void
    {
        $madya = $this->createKuratorMadyaUser();

        $response = $this->actingAs($madya)->post(route('madya.tindak-lanjut', ['id' => 1]), [
            'status' => 'disetujui',
            'catatan' => 'Berkas persyaratan lengkap diverifikasi Kurator Madya.',
        ]);

        $response->assertRedirect(route('madya.dashboard'));
        $response->assertSessionHas('success');
    }
}
