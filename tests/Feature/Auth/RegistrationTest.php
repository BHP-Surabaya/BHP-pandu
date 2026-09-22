<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertDontSee('<option value="PPAT">', false);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');
    }

    public function test_new_users_can_register_with_nik_and_phone(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Pemohon',
            'email' => 'pemohon@example.com',
            'nik' => '3578012345678901',
            'phone' => '081234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'pemohon@example.com',
            'nik' => '3578012345678901',
            'phone' => '081234567890',
            'role' => 'pemohon',
        ]);
    }

    public function test_new_users_can_register_with_pekerjaan_notaris(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('sk_notaris.pdf', 500, 'application/pdf');

        $response = $this->post('/register', [
            'name' => 'Notaris User',
            'email' => 'notaris@example.com',
            'pekerjaan_select' => 'Notaris',
            'sk_notaris' => $file,
            'alamat_kantor' => 'Jl. Dharmahusada Indah No. 12, Surabaya',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));

        $user = User::where('email', 'notaris@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('Notaris', $user->pekerjaan);
        $this->assertSame('Jl. Dharmahusada Indah No. 12, Surabaya', $user->alamat_kantor);
        $this->assertNotNull($user->sk_notaris);

        Storage::disk('public')->assertExists($user->sk_notaris);
    }

    public function test_sk_notaris_and_alamat_kantor_are_required_when_pekerjaan_is_notaris(): void
    {
        $response = $this->post('/register', [
            'name' => 'Notaris Tanpa SK',
            'email' => 'notaris2@example.com',
            'pekerjaan_select' => 'Notaris',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['sk_notaris', 'alamat_kantor']);
    }

    public function test_new_users_can_register_with_pekerjaan_lainnya(): void
    {
        $response = $this->post('/register', [
            'name' => 'Advokat User',
            'email' => 'advokat@example.com',
            'pekerjaan_select' => 'Lainnya',
            'pekerjaan_custom' => 'Advokat / Pengacara',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'advokat@example.com',
            'pekerjaan' => 'Advokat / Pengacara',
        ]);
    }

    public function test_custom_pekerjaan_is_required_when_lainnya_is_selected(): void
    {
        $response = $this->post('/register', [
            'name' => 'Custom User',
            'email' => 'custom@example.com',
            'pekerjaan_select' => 'Lainnya',
            'pekerjaan_custom' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('pekerjaan_custom');
        $this->assertGuest();
    }

    public function test_new_users_can_register_with_alamat_ktp_and_different_domisili(): void
    {
        $response = $this->post('/register', [
            'name' => 'User Alamat',
            'email' => 'alamat@example.com',
            'alamat_ktp' => 'Jl. Kertajaya Indah No. 12, Surabaya',
            'alamat_domisili' => 'Jl. Diponegoro No. 45, Sidoarjo',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'alamat@example.com',
            'alamat_ktp' => 'Jl. Kertajaya Indah No. 12, Surabaya',
            'alamat_domisili' => 'Jl. Diponegoro No. 45, Sidoarjo',
        ]);
    }

    public function test_alamat_domisili_mirrors_alamat_ktp_when_checkbox_is_checked(): void
    {
        $response = $this->post('/register', [
            'name' => 'User Sama KTP',
            'email' => 'samaktp@example.com',
            'alamat_ktp' => 'Jl. Pemuda No. 1, Surabaya',
            'domisili_sama_ktp' => '1',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'samaktp@example.com',
            'alamat_ktp' => 'Jl. Pemuda No. 1, Surabaya',
            'alamat_domisili' => 'Jl. Pemuda No. 1, Surabaya',
        ]);
    }
}
