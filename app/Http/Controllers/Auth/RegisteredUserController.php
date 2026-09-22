<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $isNotaris = $request->pekerjaan_select === 'Notaris' || $request->pekerjaan === 'Notaris';

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nik' => ['nullable', 'string', 'max:16'],
            'phone' => ['nullable', 'string', 'max:20'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'pekerjaan_select' => ['nullable', 'string', 'max:100'],
            'pekerjaan_custom' => ['nullable', 'required_if:pekerjaan_select,Lainnya', 'string', 'max:255'],
            'sk_notaris' => [Rule::requiredIf($isNotaris), 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'alamat_kantor' => [Rule::requiredIf($isNotaris), 'nullable', 'string', 'max:1000'],
            'alamat_ktp' => ['nullable', 'string'],
            'alamat_domisili' => ['nullable', 'string'],
            'domisili_sama_ktp' => ['nullable'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['nullable'],
        ], [
            'sk_notaris.required' => 'Berkas SK Notaris wajib diunggah untuk pendaftar Notaris.',
            'sk_notaris.file' => 'Berkas SK Notaris harus berupa file dokumen valid.',
            'sk_notaris.mimes' => 'Format berkas SK Notaris harus berformat PDF, JPG, JPEG, atau PNG.',
            'sk_notaris.max' => 'Ukuran berkas SK Notaris maksimal 10MB.',
            'alamat_kantor.required' => 'Alamat kantor notaris wajib diisi untuk pendaftar Notaris.',
        ]);

        $pekerjaan = $request->pekerjaan;
        if (blank($pekerjaan)) {
            $pekerjaan = $request->pekerjaan_select === 'Lainnya'
                ? $request->pekerjaan_custom
                : $request->pekerjaan_select;
        }

        $alamatKtp = $request->alamat_ktp;
        $alamatDomisili = $request->alamat_domisili;
        if ($request->boolean('domisili_sama_ktp') || ($request->has('domisili_sama_ktp') && blank($alamatDomisili))) {
            $alamatDomisili = $alamatKtp;
        }

        $skNotarisPath = null;
        if ($request->hasFile('sk_notaris')) {
            $skNotarisPath = $request->file('sk_notaris')->store('sk_notaris', 'public');
        }

        $alamatKantor = $isNotaris ? $request->alamat_kantor : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'pekerjaan' => $pekerjaan,
            'alamat_ktp' => $alamatKtp,
            'alamat_domisili' => $alamatDomisili,
            'sk_notaris' => $skNotarisPath,
            'alamat_kantor' => $alamatKantor,
            'password' => Hash::make($request->password),
            'role' => 'pemohon',
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan masuk ke akun Anda.');
    }
}
