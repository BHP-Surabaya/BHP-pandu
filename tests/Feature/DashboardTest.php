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

    public function test_notaris_sees_wasiat_services_and_not_kepailitan(): void
    {
        $notaris = User::factory()->notaris()->create([
            'name' => 'Fernanda',
        ]);

        $response = $this->actingAs($notaris)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Fernanda');
        $response->assertSee('Pembukaan Wasiat');
        $response->assertSee('Pendaftaran Wasiat');
        $response->assertSee('Perwalian');
        $response->assertSee('Pengampuan');
        $response->assertSee('SKHW');
        $response->assertDontSee('Layanan Kepailitan');
    }

    public function test_pengacara_sees_kepailitan_and_not_wasiat(): void
    {
        $pengacara = User::factory()->pengacara()->create([
            'name' => 'Budi Advokat',
        ]);

        $response = $this->actingAs($pengacara)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Budi Advokat');
        $response->assertSee('Layanan Kepailitan');
        $response->assertSee('Perwalian');
        $response->assertDontSee('Pembukaan Wasiat');
        $response->assertDontSee('Pendaftaran Wasiat');
    }

    public function test_perorangan_does_not_see_wasiat_nor_kepailitan(): void
    {
        $perorangan = User::factory()->perorangan()->create([
            'name' => 'Warga Biasa',
        ]);

        $response = $this->actingAs($perorangan)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Warga Biasa');
        $response->assertSee('Perwalian');
        $response->assertSee('Pengampuan');
        $response->assertSee('SKHW');
        $response->assertDontSee('Pembukaan Wasiat');
        $response->assertDontSee('Pendaftaran Wasiat');
        $response->assertDontSee('Layanan Kepailitan');
    }
}
