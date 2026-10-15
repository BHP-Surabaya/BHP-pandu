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
        $isPengacara = in_array($request->pekerjaan_select, ['Pengacara', 'Advokat']) || in_array($request->pekerjaan, ['Pengacara', 'Advokat']);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nik' => ['nullable', 'string', 'max:16'],
            'phone' => ['nullable', 'string', 'max:20'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'pekerjaan_select' => ['nullable', 'string', 'max:100'],
            'pekerjaan_custom' => ['nullable', 'required_if:pekerjaan_select,Lainnya', 'string', 'max:255'],
            'sk_notaris' => [Rule::requiredIf($isNotaris), 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
            'sk_ppat' => [Rule::requiredIf($isNotaris), 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
            'berita_acara_sumpah' => [Rule::requiredIf($isPengacara), 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
            'id_card_pengacara' => [Rule::requiredIf($isPengacara), 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:25600'],
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
            'sk_notaris.max' => 'Ukuran berkas SK Notaris maksimal 25MB.',
            'sk_notaris.uploaded' => 'Berkas SK Notaris gagal diunggah. Pastikan ukuran berkas di bawah 25MB dan file tidak rusak.',
            'sk_ppat.required' => 'Berkas SK PPAT wajib diunggah untuk pendaftar Notaris.',
            'sk_ppat.file' => 'Berkas SK PPAT harus berupa file dokumen valid.',
            'sk_ppat.mimes' => 'Format berkas SK PPAT harus berformat PDF, JPG, JPEG, atau PNG.',
            'sk_ppat.max' => 'Ukuran berkas SK PPAT maksimal 25MB.',
            'sk_ppat.uploaded' => 'Berkas SK PPAT gagal diunggah. Pastikan ukuran berkas di bawah 25MB dan file tidak rusak.',
            'berita_acara_sumpah.required' => 'Berkas Berita Acara Sumpah dari Pengadilan Tinggi wajib diunggah untuk pendaftar Pengacara.',
            'berita_acara_sumpah.file' => 'Berkas Berita Acara Sumpah harus berupa file dokumen valid.',
            'berita_acara_sumpah.mimes' => 'Format berkas Berita Acara Sumpah harus berformat PDF, JPG, JPEG, atau PNG.',
            'berita_acara_sumpah.max' => 'Ukuran berkas Berita Acara Sumpah maksimal 25MB.',
            'berita_acara_sumpah.uploaded' => 'Berkas Berita Acara Sumpah gagal diunggah. Pastikan ukuran berkas di bawah 25MB dan file tidak rusak.',
            'id_card_pengacara.required' => 'Berkas ID Card Pengacara wajib diunggah untuk pendaftar Pengacara.',
            'id_card_pengacara.file' => 'Berkas ID Card Pengacara harus berupa file dokumen valid.',
            'id_card_pengacara.mimes' => 'Format berkas ID Card Pengacara harus berformat PDF, JPG, JPEG, atau PNG.',
            'id_card_pengacara.max' => 'Ukuran berkas ID Card Pengacara maksimal 25MB.',
            'id_card_pengacara.uploaded' => 'Berkas ID Card Pengacara gagal diunggah. Pastikan ukuran berkas di bawah 25MB dan file tidak rusak.',
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

        $skPpatPath = null;
        if ($request->hasFile('sk_ppat')) {
            $skPpatPath = $request->file('sk_ppat')->store('sk_ppat', 'public');
        }

        $baSumpahPath = null;
        if ($request->hasFile('berita_acara_sumpah')) {
            $baSumpahPath = $request->file('berita_acara_sumpah')->store('berita_acara_sumpah', 'public');
        }

        $idCardPengacaraPath = null;
        if ($request->hasFile('id_card_pengacara')) {
            $idCardPengacaraPath = $request->file('id_card_pengacara')->store('id_card_pengacara', 'public');
        }

        $alamatKantor = ($isNotaris || $isPengacara) ? $request->alamat_kantor : null;

        $jenisAkun = 'perorangan';
        $statusVerifikasi = 'terverifikasi';
        $statusAkun = 'perorangan';

        if ($isNotaris) {
            $jenisAkun = 'notaris';
            $statusVerifikasi = 'menunggu_verifikasi';
            $statusAkun = 'perorangan';
        } elseif ($isPengacara) {
            $jenisAkun = 'pengacara';
            $statusVerifikasi = 'menunggu_verifikasi';
            $statusAkun = 'perorangan';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'pekerjaan' => $pekerjaan,
            'jenis_akun' => $jenisAkun,
            'status_akun' => $statusAkun,
            'status_verifikasi' => $statusVerifikasi,
            'alamat_ktp' => $alamatKtp,
            'alamat_domisili' => $alamatDomisili,
            'sk_notaris' => $skNotarisPath,
            'sk_ppat' => $skPpatPath,
            'berita_acara_sumpah' => $baSumpahPath,
            'id_card_pengacara' => $idCardPengacaraPath,
            'alamat_kantor' => $alamatKantor,
            'password' => Hash::make($request->password),
            'role' => 'pemohon',
        ]);

        event(new Registered($user));

        $statusMsg = ($isNotaris || $isPengacara)
            ? 'Registrasi berhasil! Tautan aktivasi akun telah dikirimkan ke email '.$user->email.'. Silakan aktifkan email Anda. Pengajuan verifikasi profesi '.ucfirst($jenisAkun).' akan ditinjau oleh Master Admin.'
            : 'Registrasi berhasil! Tautan aktivasi akun telah dikirimkan ke email '.$user->email.'. Silakan periksa kotak masuk atau spam email Anda untuk mengaktifkan akun.';

        return redirect()->route('login')->with('status', $statusMsg);
    }
}
