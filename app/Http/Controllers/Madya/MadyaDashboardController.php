<?php

namespace App\Http\Controllers\Madya;

use App\Http\Controllers\Controller;
use App\Mail\MadyaApprovalOtpMail;
use App\Models\Dokumen;
use App\Models\Permohonan;
use App\Services\AuditLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MadyaDashboardController extends Controller
{
    /**
     * Hitung permohonan aktif untuk Kurator Madya.
     */
    public static function getLayananAktifCount(): int
    {
        return Permohonan::whereIn('status', ['proses_madya', 'proses_muda', 'disetujui_pertama'])->count();
    }

    /**
     * Alias method untuk badge sidebar portal layout.
     */
    public static function getPerluVerifikasiCount(): int
    {
        return self::getLayananAktifCount();
    }

    /**
     * Tampilkan halaman utama Layanan Wasiat Tertutup Kurator Madya.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $query = Permohonan::with(['user', 'pewasiat', 'dokumens'])
            ->whereIn('status', ['proses_madya', 'proses_muda', 'disetujui_pertama'])
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('pewasiat', fn ($p) => $p->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $permohonans = $query->get();

        $layananList = $permohonans->map(function (Permohonan $item) {
            $dokumenList = $this->mapDokumenList($item);
            $jadwal = $item->jadwal_pembukaan;
            $hariBerjalan = max(1, (int) ($item->created_at?->diffInDays(now()) ?? 0) + 1);
            $sisaHari = max(0, 14 - $hariBerjalan);
            $ba = $item->data_berita_acara ?? [];
            $hasBa = ! empty($item->nomor_berita_acara) || ! empty($ba['nomor_ba']);

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('WST-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat Tertutup',
                'detail_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nik' => $item->user?->nik ?? '-',
                'telepon' => $item->user?->phone ?? '-',
                'nomor_telepon' => $item->user?->phone ?? '-',
                'email' => $item->user?->email ?? '-',
                'alamat_domisili' => $item->user?->alamat_domisili ?? '-',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'tanggal_masuk' => $item->created_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                'waktu_masuk' => $item->created_at ? 'Pukul '.$item->created_at->format('H:i') : 'Pukul 10:00',
                'sla_tanggal' => $item->created_at?->addDays(14)->translatedFormat('d M Y') ?? now()->addDays(14)->translatedFormat('d M Y'),
                'sla_sisa' => "{$sisaHari} hari tersisa",
                'sla_progress' => "Hari ke-{$hariBerjalan} dari 14",
                'sla_badge' => $sisaHari <= 2 ? 'red' : ($sisaHari <= 5 ? 'yellow' : 'purple'),
                'jadwal_pembukaan' => $jadwal ? $jadwal->translatedFormat('l, d F Y') : 'Menunggu Penetapan',
                'waktu_pembukaan' => $jadwal ? $jadwal->format('H.i').' WIB' : '-',
                'status_layanan' => $item->status_label,
                'status_ba' => $hasBa ? 'BA Diterbitkan' : 'Draft BA Siap',
                'nomor_ba' => $item->nomor_berita_acara ?: ($ba['nomor_ba'] ?? '-'),
                'has_ba' => $hasBa,
                'dokumen_terkunci' => (bool) ($item->dokumen_terkunci ?? false),
                'dokumen_count' => $item->dokumens->count(),
                'salinan_count' => 2,
                'petugas_pertama' => $item->diverifikasi_oleh ?? 'Iman, S.H.',
                'petugas_muda' => 'Lutfy, S.H.',
                'catatan' => $item->disposisi_kasi ?? 'Sampul wasiat tertutup siap dibuka bersama notaris.',
                'dokumen_list' => $dokumenList,
            ];
        })->all();

        $stats = [
            'total_layanan_aktif' => count($layananList),
            'total_ba_siap' => collect($layananList)->where('nomor_ba', '!=', '-')->count(),
            'total_arsip' => Permohonan::where('status', 'selesai')->count(),
        ];

        return view('madya.dashboard', compact('layananList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman Histori Layanan Kurator Madya.
     */
    public function history(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $query = Permohonan::with(['user', 'pewasiat', 'dokumens'])
            ->where('status', 'selesai')
            ->latest('updated_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('pewasiat', fn ($p) => $p->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $permohonans = $query->get();

        $historyList = $permohonans->map(function (Permohonan $item) {
            $ba = $item->data_berita_acara ?? [];

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('WST-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'nomor_ba' => $item->nomor_berita_acara ?: ($ba['nomor_ba'] ?? ('BA-'.date('Ymd').'-'.str_pad((string) $item->id, 4, '0', STR_PAD_LEFT))),
                'tanggal_selesai' => $item->updated_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
                'status_hasil' => 'selesai',
                'status_label' => 'Selesai & Diarsipkan',
                'kurator_madya' => auth()->user()?->name ?? 'Inara, S.H., M.H.',
                'catatan' => $item->catatan_petugas ?? 'Berita Acara dan 2 salinan dokumen telah dicetak dan berkas diarsipkan.',
                'dokumen_terkunci' => (bool) ($item->dokumen_terkunci ?? false),
            ];
        })->all();

        $stats = [
            'total_riwayat' => count($historyList),
            'total_disetujui' => count($historyList),
            'total_wasiat_tertutup' => count($historyList),
            'total_salinan_cetak' => count($historyList) * 2,
        ];

        return view('madya.history', compact('historyList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman pembuatan dan reviu Berita Acara (BA) Kurator Madya.
     */
    public function buatBaPage(string|int $id): View|RedirectResponse
    {
        $permohonan = Permohonan::with(['user', 'pewasiat', 'dokumens'])->find($id);
        if (! $permohonan) {
            return redirect()->route('madya.dashboard')->with('error', 'Layanan tidak ditemukan.');
        }

        $existingBa = $permohonan->data_berita_acara ?? [];
        $hasUploadedSuratKuasa = $permohonan->dokumens->where('jenis_dokumen', 'surat_kuasa')->isNotEmpty();
        $adaSuratKuasa = isset($existingBa['ada_surat_kuasa']) ? (bool) $existingBa['ada_surat_kuasa'] : $hasUploadedSuratKuasa;

        $jadwal = $permohonan->jadwal_pembukaan ?? now();
        $tglStr = $existingBa['tanggal'] ?? $jadwal->format('Y-m-d');

        $defaultPihak1 = $adaSuratKuasa ? [
            'pihak_pertama_nama' => auth()->user()?->name ?? 'Ayu Rachmawati, S.H., M.Kn.',
            'pihak_pertama_nip' => '198405122010122001',
            'pihak_pertama_jabatan' => 'Kurator Keperdataan Ahli Madya',
        ] : [
            'pihak_pertama_nama' => 'Hendro Setyawan, S.H., M.H.',
            'pihak_pertama_nip' => '197503182001121001',
            'pihak_pertama_jabatan' => 'Kepala Balai Harta Peninggalan Surabaya',
        ];

        $noUrut = str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT);
        $defaultNomorBa = 'W15.BHP.02-'.$noUrut.'/BA-WT/'.date('m/Y');

        $baForm = [
            'nomor_ba' => $existingBa['nomor_ba'] ?? ($permohonan->nomor_berita_acara ?: $defaultNomorBa),
            'ada_surat_kuasa' => (bool) $adaSuratKuasa,
            'tanggal_surat_kuasa' => $existingBa['tanggal_surat_kuasa'] ?? $tglStr,
            'hari' => $existingBa['hari'] ?? $this->getIndonesianDayName($jadwal),
            'tanggal' => $tglStr,
            'tempat_dibuat' => $existingBa['tempat_dibuat'] ?? ($permohonan->tempat_pembukaan ?: 'Sidoarjo'),
            'pihak_pertama_nama' => $existingBa['pihak_pertama_nama'] ?? $defaultPihak1['pihak_pertama_nama'],
            'pihak_pertama_nip' => $existingBa['pihak_pertama_nip'] ?? $defaultPihak1['pihak_pertama_nip'],
            'pihak_pertama_jabatan' => $existingBa['pihak_pertama_jabatan'] ?? $defaultPihak1['pihak_pertama_jabatan'],
            'pihak_kedua_nama' => $existingBa['pihak_kedua_nama'] ?? ($permohonan->user?->name ?? 'Notaris Pemohon'),
            'pihak_kedua_jabatan' => $existingBa['pihak_kedua_jabatan'] ?? 'Notaris Kota Surabaya',
            'pihak_kedua_alamat' => $existingBa['pihak_kedua_alamat'] ?? ($permohonan->user?->alamat_kantor ?: ($permohonan->user?->alamat_domisili ?: 'Jl. Raya Surabaya')),
            'deskripsi_wasiat' => $existingBa['deskripsi_wasiat'] ?? '1 (satu) buah amplop coklat ukuran A4 dalam keadaan tertutup dan tersegel lak merah',
            'nama_pewasiat' => $existingBa['nama_pewasiat'] ?? ($permohonan->pewasiat?->nama_lengkap ?? 'Alm. Pewasiat'),
            'saksi_1' => $existingBa['saksi_1'] ?? 'Budi Santoso, S.H.',
            'saksi_2' => $existingBa['saksi_2'] ?? 'Rina Wulandari, S.H.',
        ];

        $registeredEmail = config('services.madya.approval_email') ?? env('MADYA_APPROVAL_EMAIL', 'yaffed@gmail.com');
        $maskedEmail = $this->maskEmail($registeredEmail);

        return view('madya.buat-ba', compact('permohonan', 'baForm', 'registeredEmail', 'maskedEmail'));
    }

    /**
     * Request kode persetujuan (OTP) Fungsional Madya via Email.
     */
    public function requestKodePersetujuan(Request $request, string|int $id): JsonResponse
    {
        $permohonan = Permohonan::with(['user'])->findOrFail($id);
        $code = (string) random_int(100000, 999999);
        $recipientEmail = config('services.madya.approval_email') ?? env('MADYA_APPROVAL_EMAIL', 'yaffed@gmail.com');

        $ttlSeconds = 600; // 10 menit
        Cache::put("madya_otp_{$permohonan->id}", [
            'code' => $code,
            'email' => $recipientEmail,
            'expires_at' => now()->addSeconds($ttlSeconds)->timestamp,
        ], $ttlSeconds);

        // Hapus flag verified sebelumnya jika meminta kode baru
        Cache::forget("madya_otp_verified_{$permohonan->id}");

        $deliveryMode = 'simulasi';
        try {
            Mail::to($recipientEmail)->send(new MadyaApprovalOtpMail(
                code: $code,
                nomorLayanan: $permohonan->nomor_permohonan ?: ('WST-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT)),
                namaPemohon: $permohonan->user?->name ?? 'Pemohon',
                expiresMinutes: 10,
            ));
            $deliveryMode = config('mail.default') === 'log' ? 'simulasi' : 'email';
        } catch (\Throwable $e) {
            Log::warning("Gagal mengirim email OTP Kurator Madya: {$e->getMessage()}");
        }

        return response()->json([
            'success' => true,
            'sent_to' => $recipientEmail,
            'masked_email' => $this->maskEmail($recipientEmail),
            'expires_in_seconds' => $ttlSeconds,
            'delivery_mode' => $deliveryMode,
            'preview_code' => $code,
        ]);
    }

    /**
     * Verifikasi kode persetujuan (OTP) yang dimasukkan Kurator Madya.
     */
    public function verifikasiKodePersetujuan(Request $request, string|int $id): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $cached = Cache::get("madya_otp_{$id}");
        if (! $cached || ! isset($cached['code'])) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode persetujuan belum diminta atau sudah kedaluwarsa. Silakan klik Minta Kode.',
            ], 422);
        }

        if (trim((string) $cached['code']) !== trim((string) $request->input('code'))) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode persetujuan 6 digit tidak sesuai.',
            ], 422);
        }

        Cache::put("madya_otp_verified_{$id}", true, now()->addMinutes(30));

        return response()->json([
            'valid' => true,
            'message' => 'Kode persetujuan terverifikasi.',
        ]);
    }

    /**
     * Buat dan simpan Berita Acara (BA) Pembukaan Wasiat Tertutup.
     */
    public function buatBa(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        $validated = $request->validate([
            'nomor_ba' => ['required', 'string', 'max:100'],
            'ada_surat_kuasa' => ['nullable', 'boolean'],
            'tanggal_surat_kuasa' => ['nullable', 'string', 'max:50'],
            'hari' => ['required', 'string', 'max:50'],
            'tanggal' => ['required', 'date'],
            'tempat_dibuat' => ['required', 'string', 'max:150'],
            'pihak_pertama_nama' => ['required', 'string', 'max:255'],
            'pihak_pertama_nip' => ['required', 'string', 'max:50'],
            'pihak_pertama_jabatan' => ['required', 'string', 'max:255'],
            'pihak_kedua_nama' => ['required', 'string', 'max:255'],
            'pihak_kedua_jabatan' => ['required', 'string', 'max:255'],
            'pihak_kedua_alamat' => ['required', 'string', 'max:500'],
            'deskripsi_wasiat' => ['required', 'string', 'max:1000'],
            'nama_pewasiat' => ['required', 'string', 'max:255'],
            'saksi_1' => ['required', 'string', 'max:255'],
            'saksi_2' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'approval_code' => ['nullable', 'string', 'max:10'],
            'submit_action' => ['nullable', 'string', 'in:save,save_print'],
        ]);

        $adaSuratKuasa = $request->boolean('ada_surat_kuasa');
        $validated['ada_surat_kuasa'] = $adaSuratKuasa;

        // Validasi OTP: cek apakah sudah terverifikasi di session/cache atau dari input
        $isVerified = Cache::get("madya_otp_verified_{$id}", false);
        $inputCode = trim((string) ($validated['approval_code'] ?? ''));
        $cachedOtp = Cache::get("madya_otp_{$id}");

        if (! $isVerified) {
            if ($cachedOtp && isset($cachedOtp['code']) && $inputCode === trim((string) $cachedOtp['code'])) {
                $isVerified = true;
            }
        }

        if (! $isVerified) {
            return back()->withInput()->with('error', 'Otorisasi Berita Acara gagal: Wajib meminta dan memverifikasi 6 digit Kode Persetujuan (OTP) yang dikirim ke email terlebih dahulu.');
        }

        // Simpan data Berita Acara
        $nomorBa = $validated['nomor_ba'];
        $permohonan->update([
            'nomor_berita_acara' => $nomorBa,
            'tanggal_berita_acara' => $validated['tanggal'],
            'data_berita_acara' => $validated,
            'status' => 'proses_madya',
            'catatan_petugas' => $validated['catatan'] ?? 'Berita Acara pembukaan dan pembacaan wasiat tertutup telah diterbitkan resmi.',
        ]);

        // Hapus kode OTP setelah berhasil dipakai
        Cache::forget("madya_otp_{$id}");
        Cache::forget("madya_otp_verified_{$id}");

        $user = auth()->user();
        AuditLogger::log(
            action: 'buat_ba_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} menerbitkan Berita Acara {$nomorBa} untuk permohonan {$permohonan->nomor_permohonan}.",
            resource: $permohonan,
            details: ['nomor_berita_acara' => $nomorBa, 'pihak_pertama' => $validated['pihak_pertama_nama']]
        );

        if (($validated['submit_action'] ?? '') === 'save_print') {
            return redirect()->route('madya.layanan.cetak.page', $permohonan->id)
                ->with('success', "Berita Acara {$nomorBa} berhasil diotorisasi & disimpan. Membuka lembar cetak 2 salinan.");
        }

        return redirect()->route('madya.layanan.buat-ba.page', $permohonan->id)
            ->with('success', "Berita Acara untuk layanan {$permohonan->nomor_permohonan} berhasil diotorisasi dan disimpan.");
    }

    /**
     * Tampilkan halaman cetak 2 salinan resmi Berita Acara.
     */
    public function cetakPage(string|int $id): View|RedirectResponse
    {
        $permohonan = Permohonan::with(['user', 'pewasiat'])->find($id);
        if (! $permohonan) {
            return redirect()->route('madya.dashboard')->with('error', 'Layanan tidak ditemukan.');
        }

        $existingBa = $permohonan->data_berita_acara;
        if (empty($existingBa)) {
            return redirect()->route('madya.layanan.buat-ba.page', $id)
                ->with('error', 'Silakan susun dan simpan Berita Acara terlebih dahulu sebelum mencetak dokumen 2 salinan.');
        }

        return view('madya.cetak', compact('permohonan', 'existingBa'));
    }

    /**
     * Konfirmasi cetak dokumen 2 salinan (salinan untuk BHP dan Notaris).
     */
    public function cetakDokumen(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        $user = auth()->user();
        AuditLogger::log(
            action: 'cetak_2_salinan_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} mencetak dokumen 2 salinan resmi Berita Acara untuk {$permohonan->nomor_permohonan}.",
            resource: $permohonan
        );

        return redirect()->route('madya.dashboard')
            ->with('success', "Dokumen 2 salinan resmi untuk layanan {$permohonan->nomor_permohonan} berhasil dicetak.");
    }

    /**
     * Tampilkan halaman pengelola berkas sidang (6 Slot Dokumen).
     */
    public function uploadPage(string|int $id): View|RedirectResponse
    {
        $permohonan = Permohonan::with(['user', 'pewasiat', 'dokumens'])->find($id);
        if (! $permohonan) {
            return redirect()->route('madya.dashboard')->with('error', 'Layanan tidak ditemukan.');
        }

        $dokumens = $permohonan->dokumens;
        $slots = $this->getDokumenSlots($permohonan);

        $uploadedSlotKeys = $dokumens->pluck('jenis_dokumen')->all();
        $requiredSlots = collect($slots)->where('required', true)->pluck('key')->all();
        $completedRequired = count(array_intersect($requiredSlots, $uploadedSlotKeys));
        $totalRequired = count($requiredSlots);

        return view('madya.upload', compact(
            'permohonan',
            'dokumens',
            'slots',
            'completedRequired',
            'totalRequired'
        ));
    }

    /**
     * Unggah berkas dokumen sidang untuk Kurator Madya.
     */
    public function uploadDokumen(Request $request, string|int $id): RedirectResponse|JsonResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->dokumen_terkunci) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Dokumen telah dikunci dan tidak dapat diubah.'], 403);
            }

            return back()->with('error', 'Dokumen layanan ini telah dikunci dan tidak dapat diubah.');
        }

        $request->validate([
            'jenis_dokumen' => ['required', 'string', 'in:persetujuan_jadwal,surat_kuasa,daftar_hadir,berita_acara,wasiat_tertutup,dokumentasi'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $jenis = $request->input('jenis_dokumen');
        $file = $request->file('file');
        $path = $file->store("dokumens/permohonan_{$permohonan->id}", 'local');

        // Jika jenis dokumen sama sudah ada, hapus file lama
        $existing = Dokumen::where('permohonan_id', $permohonan->id)
            ->where('jenis_dokumen', $jenis)
            ->first();

        if ($existing && $existing->file_path && Storage::disk('local')->exists($existing->file_path)) {
            Storage::disk('local')->delete($existing->file_path);
        }

        $dokumen = Dokumen::updateOrCreate(
            [
                'permohonan_id' => $permohonan->id,
                'jenis_dokumen' => $jenis,
            ],
            [
                'file_path' => $path,
                'status' => 'valid',
            ]
        );

        $user = auth()->user();
        AuditLogger::log(
            action: 'upload_dokumen_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} mengunggah berkas {$jenis} untuk layanan {$permohonan->nomor_permohonan}.",
            resource: $dokumen,
            details: ['jenis' => $jenis, 'path' => $path]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'dokumen' => $dokumen,
                'message' => 'Berkas berhasil diunggah.',
            ]);
        }

        return back()->with('success', "Berkas untuk kategori '{$jenis}' berhasil diunggah.");
    }

    /**
     * Hapus berkas dokumen yang terunggah.
     */
    public function deleteDokumen(Request $request, string|int $id): RedirectResponse|JsonResponse
    {
        $dokumen = Dokumen::with('permohonan')->findOrFail($id);

        if ($dokumen->permohonan?->dokumen_terkunci) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Dokumen telah dikunci dan tidak dapat dihapus.'], 403);
            }

            return back()->with('error', 'Dokumen layanan ini telah dikunci dan tidak dapat dihapus.');
        }

        if ($dokumen->file_path && Storage::disk('local')->exists($dokumen->file_path)) {
            Storage::disk('local')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Berkas berhasil dihapus.']);
        }

        return back()->with('success', 'Berkas berhasil dihapus.');
    }

    /**
     * Toggle kunci berkas dokumen.
     */
    public function toggleKunciDokumen(Request $request, string|int $id): RedirectResponse|JsonResponse
    {
        $permohonan = Permohonan::findOrFail($id);
        $newStatus = ! $permohonan->dokumen_terkunci;

        $permohonan->update([
            'dokumen_terkunci' => $newStatus,
            'dokumen_dikunci_at' => $newStatus ? now() : null,
        ]);

        $user = auth()->user();
        AuditLogger::log(
            action: $newStatus ? 'kunci_dokumen_madya' : 'buka_kunci_dokumen_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} ".($newStatus ? 'mengunci' : 'membuka kunci')." berkas dokumen layanan {$permohonan->nomor_permohonan}.",
            resource: $permohonan
        );

        $msg = $newStatus ? 'Seluruh berkas dokumen telah dikunci dan diamankan dari perubahan.' : 'Kunci dokumen berhasil dibuka.';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'dokumen_terkunci' => $newStatus,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Arsipkan berkas layanan setelah proses selesai.
     */
    public function arsipkan(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        $permohonan->update([
            'status' => 'selesai',
            'dokumen_terkunci' => true,
            'dokumen_dikunci_at' => now(),
            'catatan_petugas' => $request->input('catatan') ?: ($permohonan->catatan_petugas ?? 'Layanan selesai dan seluruh warkah berkas telah diarsipkan.'),
        ]);

        $user = auth()->user();
        AuditLogger::log(
            action: 'arsipkan_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} menyelesaikan layanan wasiat tertutup {$permohonan->nomor_permohonan} dan mengarsipkan seluruh berkas fisik.",
            resource: $permohonan
        );

        return redirect()->route('madya.dashboard')
            ->with('success', "Layanan {$permohonan->nomor_permohonan} berhasil diselesaikan dan berkas telah diarsipkan.");
    }

    /**
     * Aktifkan kembali layanan dari arsip / histori.
     */
    public function aktifkan(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        $permohonan->update([
            'status' => 'proses_madya',
            'dokumen_terkunci' => false,
            'dokumen_dikunci_at' => null,
        ]);

        $user = auth()->user();
        AuditLogger::log(
            action: 'aktifkan_kembali_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} mengaktifkan kembali layanan wasiat tertutup {$permohonan->nomor_permohonan} ke daftar aktif.",
            resource: $permohonan
        );

        return redirect()->route('madya.dashboard')
            ->with('success', "Layanan {$permohonan->nomor_permohonan} berhasil diaktifkan kembali ke Daftar Layanan Aktif.");
    }

    /**
     * Tampilkan detail verifikasi / berkas layanan untuk Kurator Madya.
     */
    public function show(string|int $id): View|RedirectResponse
    {
        $permohonan = Permohonan::with(['user', 'pewasiat.pasangans', 'pewasiat.ahliWaris', 'dokumens', 'voucher'])->find($id);

        if (! $permohonan) {
            return redirect()->route('madya.dashboard')->with('error', 'Layanan permohonan tidak ditemukan.');
        }

        $layanan = $this->formatLayananData($permohonan);

        return view('madya.verifikasi.show', compact('layanan'));
    }

    /**
     * Tindak lanjut Kurator Madya.
     */
    public function tindakLanjut(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:disetujui,revisi,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $permohonan = Permohonan::findOrFail($id);

        if ($validated['status'] === 'disetujui') {
            $permohonan->update([
                'status' => 'selesai',
                'catatan_petugas' => $validated['catatan'] ?? 'Proses pembukaan wasiat tertutup telah selesai dilaksanakan.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} berhasil diselesaikan.";
        } else {
            $permohonan->update([
                'status' => 'revisi',
                'catatan_revisi' => $validated['catatan'] ?? 'Perlu perbaikan berkas.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} dikembalikan untuk perbaikan berkas.";
        }

        return redirect()->route('madya.dashboard')->with('success', $pesan);
    }

    /**
     * Format data Permohonan ke array pratinjau.
     *
     * @return array<string, mixed>
     */
    protected function formatLayananData(Permohonan $permohonan): array
    {
        $dokumenList = $this->mapDokumenList($permohonan);

        $userNik = $permohonan->user?->nik;
        $maskedNik = $userNik ? (strlen($userNik) > 8 ? substr($userNik, 0, 4).'••••••••'.substr($userNik, -4) : $userNik) : '-';

        $userPhone = $permohonan->user?->phone;
        $maskedPhone = $userPhone ? (strlen($userPhone) > 8 ? substr($userPhone, 0, 4).' •••• '.substr($userPhone, -4) : $userPhone) : '-';

        return [
            'id' => $permohonan->id,
            'nomor_layanan' => $permohonan->nomor_permohonan ?: ('WST-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT)),
            'jenis_layanan' => $permohonan->jenis_layanan_label,
            'detail_layanan' => 'Pembukaan Wasiat Tertutup',
            'nama_pemohon' => $permohonan->user?->name ?? 'Pemohon',
            'nik' => $maskedNik,
            'email' => $permohonan->user?->email ?? '-',
            'nomor_telepon' => $maskedPhone,
            'alamat_domisili' => $permohonan->user?->alamat_domisili ?? '-',
            'nama_pewasiat' => $permohonan->pewasiat?->nama_lengkap ?? 'Pewasiat',
            'tanggal_masuk' => $permohonan->created_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
            'waktu_masuk' => $permohonan->created_at ? 'Pukul '.$permohonan->created_at->format('H:i') : 'Pukul 10:00',
            'status_verifikasi' => $permohonan->status,
            'status_label' => $permohonan->status_label,
            'dokumen_count' => count($dokumenList),
            'dokumen_total' => max(count($dokumenList), 4),
            'tipe_badge' => 'purple',
            'petugas_pertama' => $permohonan->diverifikasi_oleh ?? 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => $permohonan->catatan_petugas ?? 'Sampul wasiat tertutup siap dibuka.',
            'dokumen_list' => $dokumenList,
        ];
    }

    /**
     * Map dokumen list untuk viewer.
     *
     * @return array<int, array<string, string>>
     */
    protected function mapDokumenList(Permohonan $permohonan): array
    {
        $docLabels = [
            'persetujuan_jadwal' => 'Surat Persetujuan Jadwal.pdf',
            'surat_kuasa' => 'Surat Kuasa Notaris / Pejabat.pdf',
            'daftar_hadir' => 'Daftar Hadir Sidang.pdf',
            'berita_acara' => 'Berita Acara Pembukaan Wasiat.pdf',
            'wasiat_tertutup' => 'Akta Wasiat Tertutup.pdf',
            'dokumentasi' => 'Dokumentasi Foto Sidang.jpg',
            'akta_kematian' => 'Kutipan Akta Kematian Pewasiat.pdf',
            'surat_keterangan_wasiat' => 'Surat Keterangan Wasiat DPW.pdf',
            'akta_penyimpanan_wasiat' => 'Akta Penyimpanan Wasiat Notaris.pdf',
            'buku_nikah' => 'Buku Nikah / Akta Perkawinan.pdf',
            'akta_lahir_ktp_kk' => 'Kartu Keluarga & KTP Ahli Waris.pdf',
            'dokumen_lainnya' => 'Dokumen Tambahan.pdf',
        ];

        $list = [];
        foreach ($permohonan->dokumens as $dok) {
            $namaFile = $docLabels[$dok->jenis_dokumen] ?? (basename($dok->file_path) ?: 'Dokumen Persyaratan.pdf');
            $list[] = [
                'nama' => $namaFile,
                'ukuran' => '1,5 MB',
                'tipe' => strtoupper(pathinfo($dok->file_path, PATHINFO_EXTENSION) ?: 'PDF'),
                'url' => route('secure.dokumen.show', $dok->id),
                'download_url' => route('secure.dokumen.download', $dok->id),
            ];
        }

        if (empty($list)) {
            $list = [
                ['nama' => 'Kutipan Akta Kematian Pewasiat.pdf', 'ukuran' => '1,8 MB', 'tipe' => 'PDF', 'url' => '#'],
                ['nama' => 'Surat Keterangan Wasiat DPW.pdf', 'ukuran' => '2,1 MB', 'tipe' => 'PDF', 'url' => '#'],
                ['nama' => 'Akta Penyimpanan Wasiat Notaris.pdf', 'ukuran' => '2,5 MB', 'tipe' => 'PDF', 'url' => '#'],
                ['nama' => 'Kartu Keluarga & KTP Ahli Waris.pdf', 'ukuran' => '1,2 MB', 'tipe' => 'PDF', 'url' => '#'],
            ];
        }

        return $list;
    }

    /**
     * Dapatkan daftar slot berkas dokumen sidang untuk Kurator Madya.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getDokumenSlots(Permohonan $permohonan): array
    {
        $ba = $permohonan->data_berita_acara ?? [];
        $adaSuratKuasa = $ba['ada_surat_kuasa'] ?? false;

        return [
            [
                'key' => 'persetujuan_jadwal',
                'judul' => 'Surat / Form Persetujuan Jadwal',
                'deskripsi' => 'Persetujuan jadwal pembukaan wasiat tertutup bersama notaris penyimpan.',
                'required' => true,
            ],
            [
                'key' => 'surat_kuasa',
                'judul' => 'Surat Kuasa Khusus',
                'deskripsi' => 'Surat kuasa dari Kepala Balai kepada Kurator Madya (wajib jika pembukaan dikuasakan).',
                'required' => (bool) $adaSuratKuasa,
            ],
            [
                'key' => 'daftar_hadir',
                'judul' => 'Daftar Hadir Sidang',
                'deskripsi' => 'Daftar tanda tangan kehadiran pemohon, notaris, saksi-saksi, dan pejabat BHP.',
                'required' => true,
            ],
            [
                'key' => 'berita_acara',
                'judul' => 'Berita Acara Bertandatangan',
                'deskripsi' => 'Warkah fisik Berita Acara yang telah ditandatangani lengkap seluruh pihak.',
                'required' => true,
            ],
            [
                'key' => 'wasiat_tertutup',
                'judul' => 'Akta Wasiat Tertutup',
                'deskripsi' => 'Dokumen salinan akta wasiat tertutup yang telah dibuka.',
                'required' => true,
            ],
            [
                'key' => 'dokumentasi',
                'judul' => 'Dokumentasi Foto Sidang',
                'deskripsi' => 'Foto dokumentasi proses pembukaan sampul wasiat tersegel di ruang sidang.',
                'required' => false,
            ],
        ];
    }

    /**
     * Masking email untuk privasi (contoh: yaffed@gmail.com -> ya***@gmail.com).
     */
    protected function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $email;
        }

        $name = $parts[0];
        $domain = $parts[1];
        $len = strlen($name);

        if ($len <= 2) {
            $maskedName = substr($name, 0, 1).'*';
        } else {
            $maskedName = substr($name, 0, 2).str_repeat('*', min(4, $len - 2)).substr($name, -1);
        }

        return $maskedName.'@'.$domain;
    }

    /**
     * Konversi hari Inggris ke nama hari Indonesia.
     */
    protected function getIndonesianDayName(\DateTimeInterface $date): string
    {
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $english = $date->format('l');

        return $days[$english] ?? $english;
    }
}
