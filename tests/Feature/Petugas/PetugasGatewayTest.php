<?php

namespace Tests\Feature\Petugas;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasGatewayTest extends TestCase
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
            'name' => 'Pemohon Biasa',
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('petugas.gateway.index'));
        $response->assertRedirect(route('login'));

        $responseRiwayat = $this->get(route('petugas.gateway.riwayat'));
        $responseRiwayat->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_gateway_pages(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('petugas.gateway.index'));
        $response->assertForbidden();

        $responseRiwayat = $this->actingAs($pemohon)->get(route('petugas.gateway.riwayat'));
        $responseRiwayat->assertForbidden();
    }

    public function test_petugas_can_view_gateway_proses_barcode_dan_ttd(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->get(route('petugas.gateway.index'));

        $response->assertOk();
        $response->assertSee('Gateway Layanan');
        $response->assertSee('Proses Barcode');
        $response->assertSee('W15.AHU.BHP.04.01-1104');
        $response->assertSee('Ir. Bambang Hermanto');
        $response->assertSee('Dokumen Siap');
        $response->assertSee('Menunggu Dokumen');
        $response->assertSee('Download Dokumen');
        $response->assertSee('Upload &amp; Kirim Dokumen', false);
    }

    public function test_petugas_can_view_gateway_riwayat_pengiriman(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->get(route('petugas.gateway.riwayat'));

        $response->assertOk();
        $response->assertSee('Riwayat Upload dan Pengiriman Dokumen');
        $response->assertSee('W15.AHU.BHP.04.01-0850');
        $response->assertSee('Raden Ahmad Fauzan');
        $response->assertSee('Terkirim ke Pemohon');
    }

    public function test_petugas_can_download_draft_dokumen(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->get(route('petugas.gateway.download', 1));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
    }

    public function test_petugas_can_upload_and_kirim_dokumen(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->post(route('petugas.gateway.upload-kirim', 1), [
            'konfirmasi' => '1',
            'catatan' => 'Selesai disematkan barcode & e-TTD resmi.',
        ]);

        $response->assertRedirect(route('petugas.gateway.index'));
        $response->assertSessionHas('success');

        // Pastikan item id 1 pindah ke riwayat pengiriman
        $responseRiwayat = $this->actingAs($petugas)->get(route('petugas.gateway.riwayat'));
        $responseRiwayat->assertOk();
        $responseRiwayat->assertSee('W15.AHU.BHP.04.01-1104');
        $responseRiwayat->assertSee('Ir. Bambang Hermanto');
    }

    public function test_petugas_can_reset_gateway_data(): void
    {
        $petugas = $this->createPetugasUser();

        $response = $this->actingAs($petugas)->post(route('petugas.gateway.reset'));

        $response->assertRedirect(route('petugas.gateway.index'));
        $response->assertSessionHas('success');
    }
}
