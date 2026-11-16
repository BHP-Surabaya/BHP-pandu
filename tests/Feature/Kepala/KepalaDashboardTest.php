<?php

namespace Tests\Feature\Kepala;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KepalaDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createKepalaBhpUser(): User
    {
        return User::factory()->kepalaBhp()->create([
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

    public function test_kepala_bhp_dashboard_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get(route('kepala.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_kepala_bhp_dashboard(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('kepala.dashboard'));

        $response->assertForbidden();
    }

    public function test_authenticated_kepala_bhp_redirected_from_generic_dashboard(): void
    {
        $kepala = $this->createKepalaBhpUser();

        $response = $this->actingAs($kepala)->get(route('dashboard'));

        $response->assertRedirect(route('kepala.dashboard'));
    }

    public function test_kepala_bhp_can_view_dashboard_and_rekapitulasi(): void
    {
        $kepala = $this->createKepalaBhpUser();
        $pemohon = $this->createPemohonUser();

        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'W15.AHU.BHP.04.04-9999',
            'jenis_layanan' => 'skhw',
            'status' => 'proses_muda',
        ]);

        $response = $this->actingAs($kepala)->get(route('kepala.dashboard'));

        $response->assertOk();
        $response->assertSee('Dashboard Layanan');
        $response->assertSee('Atensi SLA');
        $response->assertSee('Dr. H. Prasetyo Wibowo');
        $response->assertSee('Kepala BHP Surabaya');
        $response->assertSee('W15.AHU.BHP.04.04-9999');
    }

    public function test_kepala_bhp_can_view_tindak_lanjut_page(): void
    {
        $kepala = $this->createKepalaBhpUser();

        $response = $this->actingAs($kepala)->get(route('kepala.tindak-lanjut'));

        $response->assertOk();
        $response->assertSee('Tindak Lanjut Dokumen Hukum');
        $response->assertSee('Perlu Persetujuan');
        $response->assertSee('Perwalian');
    }

    public function test_kepala_bhp_can_approve_dokumen_hukum(): void
    {
        $kepala = $this->createKepalaBhpUser();
        $pemohon = $this->createPemohonUser();

        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'W15.AHU.BHP.04.04-8888',
            'jenis_layanan' => 'skhw',
            'status' => 'proses_madya',
        ]);

        $response = $this->actingAs($kepala)->post(route('kepala.tindak-lanjut.setujui', $permohonan->id), [
            'catatan' => 'Segera sematkan Barcode & TTE prioritas hari ini.',
        ]);

        $response->assertRedirect(route('kepala.tindak-lanjut'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'status' => 'disetujui_pertama',
        ]);
    }

    public function test_kepala_bhp_can_view_history_page(): void
    {
        $kepala = $this->createKepalaBhpUser();

        $response = $this->actingAs($kepala)->get(route('kepala.history'));

        $response->assertOk();
        $response->assertSee('History Layanan');
        $response->assertSee('Rekapitulasi Layanan Selesai');
    }
}
