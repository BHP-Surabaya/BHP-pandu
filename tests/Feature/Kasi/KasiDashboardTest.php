<?php

namespace Tests\Feature\Kasi;

use App\Models\Permohonan;
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

    private function createPemohonUser(string $name = 'Fajar Nugroho'): User
    {
        return User::factory()->create([
            'name' => $name,
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
    }

    private function createPermohonan(User $pemohon, array $attributes = []): Permohonan
    {
        return Permohonan::create(array_merge([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.09-00006',
            'status' => 'menunggu_verifikasi',
        ], $attributes));
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
        $pemohon = $this->createPemohonUser('Fajar Nugroho');

        $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.09-00006',
            'status' => 'menunggu_verifikasi',
        ]);

        $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.09-00008',
            'status' => 'proses_muda',
            'created_at' => now()->subDays(12),
        ]);

        $response = $this->actingAs($kasi)->get(route('kasi.dashboard'));

        $response->assertOk();
        $response->assertSee('Disposisi Layanan');
        $response->assertSee('Layanan Baru');
        $response->assertSee('W15.AHU.AHU.1.AH.06.09-00006');
        $response->assertSee('Fajar Nugroho');
        $response->assertSee('Pemantauan SLA Layanan');
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
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon);

        $response = $this->actingAs($kasi)->post(route('kasi.disposisi', ['id' => $permohonan->id]), [
            'pic' => ['Kurator Keperdataan Pertama'],
            'prioritas' => 'mendesak',
            'catatan' => 'Segera verifikasi berkas',
        ]);

        $response->assertRedirect(route('kasi.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_kasi_can_tindak_lanjut_sla(): void
    {
        $kasi = $this->createKasiUser();
        $pemohon = $this->createPemohonUser();
        $permohonan = $this->createPermohonan($pemohon, [
            'created_at' => now()->subDays(10),
        ]);

        $response = $this->actingAs($kasi)->post(route('kasi.tindak-lanjut', ['id' => $permohonan->id]), [
            'alasan_keterlambatan' => 'Menunggu kelengkapan dokumen asli dari pemohon.',
            'komitmen_penyelesaian' => 'PIC akan menyelesaikan verifikasi dalam waktu 2 hari kerja.',
        ]);

        $response->assertRedirect(route('kasi.dashboard'));
        $response->assertSessionHas('success');
    }

    public function test_kasi_can_view_history_page(): void
    {
        $kasi = $this->createKasiUser();
        $pemohon = $this->createPemohonUser();
        $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.09-00003',
            'disposisi_pic' => 'Iman, S.H.',
            'tanggal_disposisi' => now(),
        ]);

        $response = $this->actingAs($kasi)->get(route('kasi.history'));

        $response->assertOk();
        $response->assertSee('History Layanan');
        $response->assertSee('W15.AHU.AHU.1.AH.06.09-00003');
    }

    public function test_kasi_sidebar_badge_shows_perlu_disposisi_count(): void
    {
        $kasi = $this->createKasiUser();
        $pemohon = $this->createPemohonUser();
        $this->createPermohonan($pemohon);

        $response = $this->actingAs($kasi)->get(route('kasi.dashboard'));

        $response->assertOk();
        $response->assertSee('Disposisi Layanan');
    }

    public function test_kasi_history_page_displays_date_range_filter_controls(): void
    {
        $kasi = $this->createKasiUser();

        $response = $this->actingAs($kasi)->get(route('kasi.history'));

        $response->assertOk();
        $response->assertSee('Mulai:');
        $response->assertSee('Sampai:');
    }

    public function test_kasi_history_page_filters_by_date_range(): void
    {
        $kasi = $this->createKasiUser();
        $pemohon = $this->createPemohonUser();

        $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.09-00018',
            'disposisi_pic' => 'Iman, S.H.',
            'tanggal_disposisi' => '2025-05-28 10:00:00',
            'created_at' => '2025-05-28 09:00:00',
        ]);

        $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.01-00002',
            'disposisi_pic' => 'Iman, S.H.',
            'tanggal_disposisi' => '2025-05-05 10:00:00',
            'created_at' => '2025-05-05 09:00:00',
        ]);

        $response = $this->actingAs($kasi)->get(route('kasi.history', [
            'start_date' => '2025-05-26',
            'end_date' => '2025-05-30',
        ]));

        $response->assertOk();
        $response->assertViewHas('historyLayanan', function ($items) {
            $nomors = collect($items)->pluck('nomor_layanan')->all();

            return in_array('W15.AHU.AHU.1.AH.06.09-00018', $nomors) &&
                   ! in_array('W15.AHU.AHU.1.AH.06.01-00002', $nomors);
        });
    }

    public function test_kasi_history_page_filters_by_tanggal_selesai(): void
    {
        $kasi = $this->createKasiUser();
        $pemohon = $this->createPemohonUser();

        $p1 = $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.09-00018',
            'status' => 'selesai',
            'disposisi_pic' => 'Iman, S.H.',
            'created_at' => '2025-05-20 09:00:00',
        ]);
        $p1->timestamps = false;
        $p1->updated_at = '2025-05-30 10:00:00';
        $p1->save();

        $p2 = $this->createPermohonan($pemohon, [
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.01-00002',
            'status' => 'selesai',
            'disposisi_pic' => 'Iman, S.H.',
            'created_at' => '2025-05-05 09:00:00',
        ]);
        $p2->timestamps = false;
        $p2->updated_at = '2025-05-12 10:00:00';
        $p2->save();

        $response = $this->actingAs($kasi)->get(route('kasi.history', [
            'date_field' => 'tanggal_selesai',
            'start_date' => '2025-05-28',
            'end_date' => '2025-05-30',
        ]));

        $response->assertOk();
        $response->assertViewHas('historyLayanan', function ($items) {
            $nomors = collect($items)->pluck('nomor_layanan')->all();

            return in_array('W15.AHU.AHU.1.AH.06.09-00018', $nomors) &&
                   ! in_array('W15.AHU.AHU.1.AH.06.01-00002', $nomors);
        });
    }
}
