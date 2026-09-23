<?php

namespace Tests\Feature;

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

    public function test_pemohon_sees_layanan_katalog_and_greeting(): void
    {
        $user = User::factory()->create([
            'name' => 'Fernanda',
            'pekerjaan' => 'Notaris',
            'role' => 'pemohon',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Notaris');
        $response->assertSee('Selamat Datang, Fernanda');
        $response->assertSee('Pilih Layanan Yang Ingin Anda Ajukan');
        $response->assertSee('Pembukaan Wasiat');
        $response->assertSee('Pendaftaran Wasiat');
        $response->assertSee('Perwalian');
        $response->assertSee('Pengampuan');
        $response->assertSee('SKHW');
        $response->assertSee('Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir');
        $response->assertSee('Layanan Harta Peninggalan Yang Tidak Terurus');
        $response->assertSee('Layanan Uang Pihak Ketiga');
        $response->assertSee('Layanan Kepailitan');
        $response->assertDontSee('TOTAL PERMOHONAN');
        $response->assertDontSee('Daftar Permohonan Aktif');
    }
}
