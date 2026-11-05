<?php

namespace Tests\Feature\Petugas;

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
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
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

        $response = $this->actingAs($petugas)->get(route('petugas.verifikasi.show', ['id' => 1]));

        $response->assertOk();
        $response->assertSee('Data Input Pemohon');
        $response->assertSee('Dokumen Persyaratan');
        $response->assertSee('Verifikasi Data Input dan Persyaratan');
        $response->assertSee('Nadia Prameswari');
        $response->assertSee('KTP Pemohon.pdf');
        $response->assertSee('Permohonan diajukan oleh Notaris');
        $response->assertSee('Verifikasi Data Pewasiat');
        $response->assertSee('Daftar Pusat Wasiat, Ditjen AHU');
        $response->assertSee('Verifikasi data dan informasi para Ahli Waris');
    }

    public function test_pemohon_cannot_view_verifikasi_detail_page(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('petugas.verifikasi.show', ['id' => 1]));

        $response->assertForbidden();
    }

    public function test_petugas_can_process_tindak_lanjut_verifikasi(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->post(route('petugas.tindak-lanjut', ['id' => 1]), [
            'status' => 'disetujui',
            'catatan' => 'Berkas persyaratan lengkap.',
        ]);

        $response->assertRedirect(route('petugas.dashboard'));
        $response->assertSessionHas('success');
    }
}
