<?php

namespace App\Http\Controllers;

use App\Models\AhliWaris;
use App\Models\Pasangan;
use App\Models\Permohonan;
use App\Models\Pewasiat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PermohonanWasiatController extends Controller
{
    /**
     * Display a listing of user's permohonan.
     */
    public function index(): View
    {
        $permohonans = Permohonan::with(['pewasiat'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('permohonan.index', compact('permohonans'));
    }

    /**
     * Show the form for creating a new permohonan (Tahap 1: Data Pewasiat).
     */
    public function create(): View
    {
        return view('permohonan.create');
    }

    /**
     * Store a newly created permohonan (Tahap 1) in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Seksi I: Informasi Pewasiat
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'dahulu_bernama' => ['nullable', 'string', 'max:255'],
            'alias' => ['nullable', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'tempat_tinggal_terakhir' => ['required', 'string'],

            // Seksi II: Informasi Kematian Pewasiat
            'tempat_kematian' => ['required', 'string', 'max:255'],
            'tanggal_kematian' => ['required', 'date'],
            'nomor_akta_kematian' => ['required', 'string', 'max:255'],
            'tanggal_akta_kematian' => ['required', 'date'],
            'pejabat_pembuat_akta_kematian' => ['required', 'string', 'max:255'],

            // Seksi III: Informasi Pencatatan Wasiat
            'nomor_surat_dpw' => ['required', 'string', 'max:255'],
            'tanggal_surat_dpw' => ['required', 'date'],
            'status_pencatatan' => ['required', 'string', 'max:255'],

            // Seksi IV: Informasi Akta Penyimpanan Wasiat
            'nomor_akta_penyimpanan' => ['required', 'string', 'max:255'],
            'tanggal_akta_penyimpanan' => ['required', 'date'],
            'nama_notaris' => ['required', 'string', 'max:255'],
            'kedudukan_notaris' => ['required', 'string', 'max:255'],

            // Seksi V: Informasi Perkawinan Mendiang
            'status_kawin' => ['required', 'in:tidak_kawin,kawin'],
            'jenis_dokumen_perkawinan' => ['required_if:status_kawin,kawin', 'nullable', 'string', 'max:255'],
            'nomor_dokumen_perkawinan' => ['required_if:status_kawin,kawin', 'nullable', 'string', 'max:255'],
            'tanggal_perkawinan' => ['required_if:status_kawin,kawin', 'nullable', 'date'],
            'tempat_perkawinan' => ['nullable', 'string', 'max:255'],
            'instansi_penerbit_perkawinan' => ['nullable', 'string', 'max:255'],
            'pasangans' => ['nullable', 'array'],
            'pasangans.*.nama_lengkap' => ['nullable', 'string', 'max:255'],
            'pasangans.*.nik' => ['nullable', 'string', 'max:16'],
            'pasangans.*.jenis_kelamin' => ['nullable', 'in:L,P'],

            // Seksi VI: Informasi Anak Pewasiat
            'memiliki_anak' => ['required', 'in:tidak_ada,ada'],
            'anak' => ['nullable', 'array'],
            'anak.*.nama_lengkap' => ['nullable', 'string', 'max:255'],
            'anak.*.nik' => ['nullable', 'string', 'max:16'],
            'anak.*.jenis_kelamin' => ['nullable', 'in:L,P'],
            'anak.*.tempat_tanggal_lahir' => ['nullable', 'string', 'max:255'],
            'anak.*.alamat' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, &$permohonan) {
            // Generate Nomor Permohonan unik
            $nomorPermohonan = 'WST-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(3)));

            $permohonan = Permohonan::create([
                'user_id' => auth()->id(),
                'nomor_permohonan' => $nomorPermohonan,
                'status' => 'draft',
            ]);

            $pewasiat = Pewasiat::create([
                'permohonan_id' => $permohonan->id,
                'nama_lengkap' => $validated['nama_lengkap'],
                'dahulu_bernama' => $validated['dahulu_bernama'] ?? null,
                'alias' => $validated['alias'] ?? null,
                'nik' => $validated['nik'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'tempat_tinggal_terakhir' => $validated['tempat_tinggal_terakhir'],
                'tempat_kematian' => $validated['tempat_kematian'],
                'tanggal_kematian' => $validated['tanggal_kematian'],
                'nomor_akta_kematian' => $validated['nomor_akta_kematian'],
                'tanggal_akta_kematian' => $validated['tanggal_akta_kematian'],
                'pejabat_pembuat_akta_kematian' => $validated['pejabat_pembuat_akta_kematian'],
                'nomor_surat_dpw' => $validated['nomor_surat_dpw'],
                'tanggal_surat_dpw' => $validated['tanggal_surat_dpw'],
                'status_pencatatan' => $validated['status_pencatatan'],
                'nomor_akta_penyimpanan' => $validated['nomor_akta_penyimpanan'],
                'tanggal_akta_penyimpanan' => $validated['tanggal_akta_penyimpanan'],
                'nama_notaris' => $validated['nama_notaris'],
                'kedudukan_notaris' => $validated['kedudukan_notaris'],
                'status_kawin' => $validated['status_kawin'],
            ]);

            // Simpan Data Pasangan jika status Kawin
            if ($validated['status_kawin'] === 'kawin' && ! empty($validated['pasangans'])) {
                foreach ($validated['pasangans'] as $pasanganData) {
                    if (! empty($pasanganData['nama_lengkap'])) {
                        Pasangan::create([
                            'pewasiat_id' => $pewasiat->id,
                            'nama_lengkap' => $pasanganData['nama_lengkap'],
                            'nik' => $pasanganData['nik'] ?? '',
                            'jenis_kelamin' => $pasanganData['jenis_kelamin'] ?? 'P',
                            'bukti_perkawinan' => $validated['jenis_dokumen_perkawinan'] ?? null,
                            'nomor_bukti_perkawinan' => $validated['nomor_dokumen_perkawinan'] ?? null,
                            'tanggal_kawin' => $validated['tanggal_perkawinan'] ?? null,
                            'tempat_kawin' => $validated['tempat_perkawinan'] ?? null,
                            'pejabat_pembuat_bukti' => $validated['instansi_penerbit_perkawinan'] ?? null,
                        ]);
                    }
                }
            }

            // Simpan Data Anak jika memiliki anak kandung
            if ($validated['memiliki_anak'] === 'ada' && ! empty($validated['anak'])) {
                foreach ($validated['anak'] as $anakData) {
                    if (! empty($anakData['nama_lengkap'])) {
                        AhliWaris::create([
                            'pewasiat_id' => $pewasiat->id,
                            'nama_lengkap' => $anakData['nama_lengkap'],
                            'nik' => $anakData['nik'] ?? null,
                            'jenis_kelamin' => $anakData['jenis_kelamin'] ?? 'L',
                            'tempat_lahir' => $anakData['tempat_tanggal_lahir'] ?? null,
                            'alamat' => $anakData['alamat'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('permohonan.tahap2', $permohonan->id)->with('status', 'Data Pewasiat (Tahap 1) berhasil disimpan. Silakan lanjutkan ke Tahap 2 (Upload Berkas).');
    }

    /**
     * Show the form for Tahap 2: Upload Berkas.
     */
    public function tahap2(Permohonan $permohonan): View
    {
        abort_unless($permohonan->user_id === auth()->id(), 403);

        $permohonan->load(['dokumens', 'pewasiat']);
        $dokumens = $permohonan->dokumens->keyBy('jenis_dokumen');

        return view('permohonan.tahap2', compact('permohonan', 'dokumens'));
    }

    /**
     * Store uploaded files for Tahap 2.
     */
    public function storeTahap2(Request $request, Permohonan $permohonan): RedirectResponse
    {
        abort_unless($permohonan->user_id === auth()->id(), 403);

        $request->validate([
            'surat_kuasa' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'akta_kematian' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'surat_keterangan_wasiat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'akta_penyimpanan_wasiat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'buku_nikah' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'akta_lahir_ktp_kk' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'dokumen_lainnya' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $documentKeys = [
            'surat_kuasa',
            'akta_kematian',
            'surat_keterangan_wasiat',
            'akta_penyimpanan_wasiat',
            'buku_nikah',
            'akta_lahir_ktp_kk',
            'dokumen_lainnya',
        ];

        foreach ($documentKeys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store("dokumens/{$permohonan->id}", 'public');

                $permohonan->dokumens()->updateOrCreate(
                    ['jenis_dokumen' => $key],
                    [
                        'file_path' => $path,
                        'status' => 'diunggah',
                    ]
                );
            }
        }

        return redirect()->route('permohonan.tahap3', $permohonan->id)->with('status', 'Berkas berhasil disimpan. Silakan ikuti panduan pemesanan voucher pada Tahap 3.');
    }

    /**
     * Show the form for Tahap 3: Panduan Pemesanan di SIMPADHU AHU.
     */
    public function tahap3(Permohonan $permohonan): View
    {
        abort_unless($permohonan->user_id === auth()->id(), 403);

        $user = auth()->user();

        return view('permohonan.tahap3', compact('permohonan', 'user'));
    }

    /**
     * Complete Tahap 3 and update status to menunggu_verifikasi.
     */
    public function storeTahap3(Request $request, Permohonan $permohonan): RedirectResponse
    {
        abort_unless($permohonan->user_id === auth()->id(), 403);

        $request->validate([
            'nomor_voucher' => ['nullable', 'string', 'max:100'],
        ]);

        if ($request->filled('nomor_voucher')) {
            $permohonan->voucher()->updateOrCreate(
                ['permohonan_id' => $permohonan->id],
                [
                    'nomor_voucher' => trim($request->nomor_voucher),
                    'status_pembayaran' => 'belum_bayar',
                    'tanggal_input' => now(),
                ]
            );
        }

        if ($permohonan->status === 'draft') {
            $permohonan->update([
                'status' => 'menunggu_verifikasi',
            ]);
        }

        return redirect()->route('permohonan.index')->with('status', 'Pengajuan Wasiat Tertutup berhasil dikirim! Silakan pantau status verifikasi berkas Anda.');
    }
}
