<?php

namespace Tests\Feature;

use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_petugas_is_redirected_to_petugas_dashboard(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
        ]);

        $response = $this->actingAs($petugas)->get('/dashboard');

        $response->assertRedirect(route('petugas.dashboard'));
    }

    public function test_pemohon_sees_empty_state_when_having_no_permohonan(): void
    {
        $user = User::factory()->create([
            'name' => 'Fernanda',
            'pekerjaan' => 'PPAT',
            'role' => 'pemohon',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Portal Pemohon');
        $response->assertSee('PPAT');
        $response->assertSee('Selamat Datang, Fernanda');
        $response->assertSee('TOTAL PERMOHONAN');
        $response->assertSee('Data Tidak Ditemukan');
        $response->assertSee('Panduan Alur Proses Permohonan Wasiat Tertutup');
        $response->assertDontSee('Jadwal Pembukaan Resmi');
        $response->assertDontSee('Ketentuan Berkas Permohonan');
    }

    public function test_pemohon_sees_real_permohonan_data_when_exists(): void
    {
        $user = User::factory()->create([
            'name' => 'Fernanda',
            'pekerjaan' => 'PPAT',
            'role' => 'pemohon',
        ]);

        $permohonan = Permohonan::create([
            'user_id' => $user->id,
            'nomor_permohonan' => 'WST-2026-999',
            'status' => 'menunggu_voucher',
        ]);

        Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Alm. Soetomo',
            'nik' => '3578011234567890',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1960-01-01',
            'tempat_tinggal_terakhir' => 'Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2026-01-01',
            'nomor_akta_kematian' => '123/2026',
            'tanggal_akta_kematian' => '2026-01-02',
            'pejabat_pembuat_akta_kematian' => 'Dispendukcapil',
            'nomor_surat_dpw' => 'AHU-123',
            'tanggal_surat_dpw' => '2026-01-03',
            'status_pencatatan' => 'Tercatat',
            'nomor_akta_penyimpanan' => 'WST-99',
            'tanggal_akta_penyimpanan' => '2020-01-01',
            'nama_notaris' => 'Notaris A',
            'kedudukan_notaris' => 'Surabaya',
            'status_kawin' => 'tidak_kawin',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('WST-2026-999');
        $response->assertSee('Alm. Soetomo');
        $response->assertSee('Input Voucher PNBP');
        $response->assertSee('Tindakan Diperlukan');
    }
}
