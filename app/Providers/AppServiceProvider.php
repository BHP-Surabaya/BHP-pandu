<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Aktivasi Akun PanduBHP - Balai Harta Peninggalan Surabaya')
                ->greeting('Halo, '.$notifiable->name.'!')
                ->line('Terima kasih telah mendaftar di Sistem Pendukung Administrasi Terpadu (PanduBHP) Balai Harta Peninggalan Surabaya.')
                ->line('Untuk mengaktifkan akun dan memastikan keamanan akses layanan Anda, silakan klik tautan verifikasi di bawah ini:')
                ->action('Aktivasi Akun Saya', $url)
                ->line('Tautan aktivasi ini berlaku selama 60 menit.')
                ->line('Jika Anda tidak merasa melakukan pendaftaran akun di PanduBHP, silakan abaikan email ini.')
                ->salutation("Hormat kami,\nBalai Harta Peninggalan Surabaya");
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $resetUrl = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);

            return (new MailMessage)
                ->subject('Permintaan Pemulihan Akun / Reset Kata Sandi - PanduBHP')
                ->greeting('Halo, '.$notifiable->name.'!')
                ->line('Kami menerima permintaan pemulihan akun dan pengaturan ulang kata sandi (reset password) untuk akun PanduBHP Anda.')
                ->line('Silakan klik tombol di bawah ini untuk mengatur kata sandi baru Anda:')
                ->action('Atur Ulang Kata Sandi', $resetUrl)
                ->line('Tautan pemulihan ini berlaku selama '.config('auth.passwords.users.expire', 60).' menit.')
                ->line('Jika Anda tidak meminta pengaturan ulang kata sandi, mohon abaikan email ini atau pastikan keamanan akun Anda.')
                ->salutation("Hormat kami,\nBalai Harta Peninggalan Surabaya");
        });
    }
}
