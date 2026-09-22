<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayananTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_when_accessing_layanan_pengembangan(): void
    {
        $response = $this->get(route('layanan.pengembangan', 'perwalian'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_layanan_pengembangan(): void
    {
        $user = User::factory()->create([
            'role' => 'pemohon',
        ]);

        $response = $this->actingAs($user)->get(route('layanan.pengembangan', 'perwalian'));

        $response->assertStatus(200);
        $response->assertSee('Perwalian');
        $response->assertSee('Layanan Sedang Tahap Pengembangan');
        $response->assertSee('Tahap Digitalisasi Sistem');
        $response->assertSee('Dokumen yang Diperlukan:');
        $response->assertSee('Loket PTSP BHP Surabaya:');
    }

    public function test_dashboard_contains_link_to_layanan_pengembangan(): void
    {
        $user = User::factory()->create([
            'role' => 'pemohon',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee(route('layanan.pengembangan', 'perwalian'));
        $response->assertSee(route('layanan.pengembangan', 'pendaftaran-wasiat'));
        $response->assertSee(route('layanan.pengembangan', 'skhw'));
    }
}
