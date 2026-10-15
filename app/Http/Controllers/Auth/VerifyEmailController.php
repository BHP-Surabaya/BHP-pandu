<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     *
     * @throws AuthorizationException
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user() ?? User::find($request->route('id'));

        if (! $user) {
            throw new AuthorizationException('Pengguna tidak ditemukan.');
        }

        if (! hash_equals((string) $user->getKey(), (string) $request->route('id'))) {
            throw new AuthorizationException('ID pengguna tidak valid.');
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            throw new AuthorizationException('Hash email tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            if (Auth::check()) {
                return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
            }

            return redirect()->route('login')->with('status', 'Email Anda sudah terverifikasi sebelumnya. Silakan masuk ke akun Anda.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if (Auth::check()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        return redirect()->route('login')->with('status', 'Aktivasi akun berhasil! Email Anda telah terverifikasi. Silakan masuk ke akun Anda.');
    }
}
