<?php

namespace Tests\Feature\Kasi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasiDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createKasiUser(): User
    {
        return User::factory()->create([
            'name' => 'Ahmad Rizki, S.T.',
            'email' => 'kasi@pandubhp.go.id',
            'role' => 'kasi',
            'pekerjaan' => 'Kepala Seksi',
            'status_akun' => 'kasi',
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

    public function test_kasi_dashboard_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get(route('kasi.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_kasi_dashboard(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('kasi.dashboard'));

        $response->assertForbidden();
    }

    public function test_kasi_is_redirected_to_kasi_dashboard_from_root_dashboard(): void
    {
        $kasi = $this->createKasiUser();

        $response = $this->actingAs($kasi)->get(route('dashboard'));

        $response->assertRedirect(route('kasi.dashboard'));
    }

    public function test_kasi_can_view_dashboard_with_layanan_baru_and_sla_monitoring(): void
    {
        $kasi = $this->createKasiUser();

        $response = $this->actingAs($kasi)->get(route('kasi.dashboard'));

        $response->assertOk();
        $response->assertSee('Disposisi Layanan');
        $response->assertSee('Layanan Baru');
        $response->assertSee('W15.AHU.AHU.1.AH.06.09-00006');
        $response->assertSee('Fajar Nugroho');
        $response->assertSee('Pemantauan SLA Layanan');
        $response->assertSee('W15.AHU.AHU.1.AH.06.09-00008');
        $response->assertSee('MENDESAK');
        $response->assertSee('Ahmad Rizki, S.T.');
        $response->assertSee('Kepala Seksi');
        $response->assertSee('PENUGASAN LAYANAN');
        $response->assertSee('Pilih PIC / Fungsional');
        $response->assertSee('KURATOR KEPERDATAAN PERTAMA');
        $response->assertSee('KURATOR KEPERDATAAN MUDA');
        $response->assertSee('KURATOR KEPERDATAAN MADYA');
        $response->assertSee('Simpan Disposisi');
        $response->assertSee('Konfirmasi Penyelesaian Layanan');
        $response->assertSee('Alasan keterlambatan');
        $response->assertSee('Komitmen penyelesaian oleh PIC');
        $response->assertSee('Simpan Tindak Lanjut');
    }

    public function test_kasi_can_disposisi_layanan_to_petugas(): void
    {
        $kasi = $this->createKasiUser();

        $response = $this->actingAs($kasi)->post(route('kasi.disposisi', ['id' => 1]), [
            'pic' => ['Januar', 'Indra'],
            'prioritas' => 'mendesak',
            'catatan' => 'Segera verifikasi berkas',
        ]);

        $response->assertRedirect(route('kasi.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_kasi_can_tindak_lanjut_sla(): void
    {
        $kasi = $this->createKasiUser();

        $response = $this->actingAs($kasi)->post(route('kasi.tindak-lanjut', ['id' => 1]), [
            'alasan_keterlambatan' => 'Menunggu kelengkapan dokumen asli dari pemohon.',
            'komitmen_penyelesaian' => 'PIC akan menyelesaikan verifikasi dalam waktu 2 hari kerja.',
        ]);

        $response->assertRedirect(route('kasi.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_kasi_can_view_history_page(): void
    {
        $kasi = $this->createKasiUser();

        $response = $this->actingAs($kasi)->get(route('kasi.history'));

        $response->assertOk();
        $response->assertSee('History Layanan');
        $response->assertSee('W15.AHU.AHU.1.AH.06.09-00003');
    }
}
