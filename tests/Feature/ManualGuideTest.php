<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManualGuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_manual_guide(): void
    {
        $response = $this->get(route('manual-guide'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_manual_guide(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('manual-guide'));

        $response->assertOk()
            ->assertSee('Panduan Penggunaan Aplikasi')
            ->assertSee('Manual Guide')
            ->assertSee('Tahap 1')
            ->assertSee('Histori Permohonan');
    }
}
