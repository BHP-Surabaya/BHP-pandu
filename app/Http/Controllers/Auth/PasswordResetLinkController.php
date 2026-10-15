<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string'],
        ], [
            'email.required' => 'Email atau NIK terdaftar wajib diisi.',
        ]);

        $input = trim((string) $request->input('email'));
        $lowerInput = Str::lower($input);

        // Cari user berdasarkan email, NIK, atau username
        $user = User::where(function ($query) use ($input, $lowerInput) {
            $query->whereRaw('LOWER(email) = ?', [$lowerInput])
                ->orWhere('nik', $input)
                ->orWhereRaw('LOWER(name) = ?', [$lowerInput]);
        })->first();

        if (! $user) {
            $isNik = preg_match('/^[0-9]{16}$/', $input);
            $errorMessage = $isNik
                ? 'Akun dengan NIK tersebut tidak ditemukan dalam sistem.'
                : 'Kami tidak dapat menemukan akun dengan email atau identitas tersebut.';

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => $errorMessage]);
        }

        // Kirim tautan pemulihan kata sandi ke email user yang terdaftar
        $status = Password::sendResetLink(['email' => $user->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $isNikOrName = $input !== $user->email && Str::lower($input) !== Str::lower($user->email);
            $maskedEmail = $this->maskEmail($user->email);

            $successMessage = $isNikOrName
                ? 'Akun ditemukan! Tautan pemulihan kata sandi telah dikirimkan ke email terdaftar Anda ('.$maskedEmail.'). Silakan periksa kotak masuk atau spam email Anda.'
                : 'Tautan pengaturan ulang kata sandi telah dikirimkan ke email Anda. Silakan periksa kotak masuk atau spam email Anda.';

            return back()->with('status', $successMessage);
        }

        $errorMessage = match ($status) {
            Password::RESET_THROTTLED => 'Harap tunggu beberapa saat sebelum meminta tautan pemulihan kembali.',
            default => 'Gagal mengirimkan tautan pemulihan. Silakan coba beberapa saat lagi.',
        };

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => $errorMessage]);
    }

    /**
     * Mask email address for user privacy while giving recognizable hint.
     */
    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1] ?? '';

        $length = strlen($name);
        if ($length <= 2) {
            $maskedName = substr($name, 0, 1).'*';
        } elseif ($length <= 4) {
            $maskedName = substr($name, 0, 1).str_repeat('*', $length - 2).substr($name, -1);
        } else {
            $maskedName = substr($name, 0, 2).str_repeat('*', max(3, $length - 4)).substr($name, -2);
        }

        return $maskedName.'@'.$domain;
    }
}
