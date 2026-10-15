<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Pemulihan Akun');
        $response->assertSee('Alamat Email atau NIK (16 Digit)');
    }

    public function test_reset_password_link_can_be_requested_with_email(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_account_recovery_can_be_requested_with_registered_nik(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'budi.santoso@example.com',
            'nik' => '3578012345678901',
        ]);

        $response = $this->post('/forgot-password', ['email' => '3578012345678901']);

        $response->assertSessionHas('status');
        $this->assertStringContainsString('bu', session('status'));
        $this->assertStringContainsString('example.com', session('status'));
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_account_recovery_fails_with_unregistered_nik(): void
    {
        Notification::fake();

        $response = $this->post('/forgot-password', ['email' => '9999999999999999']);

        $response->assertSessionHasErrors(['email']);
        Notification::assertNothingSent();
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);
            $response->assertSee('Atur Ulang Kata Sandi');

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect(route('login'));

            return true;
        });
    }

    public function test_password_cannot_be_reset_with_invalid_token(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/reset-password', [
            'token' => 'invalid-token-12345',
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
