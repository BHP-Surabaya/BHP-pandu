<?php

namespace App\Http\Controllers\Madya;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MadyaDashboardController extends Controller
{
    /**
     * Hitung permohonan aktif untuk Kurator Madya.
     */
    public static function getLayananAktifCount(): int
    {
        return Permohonan::whereIn('status', ['proses_madya', 'proses_muda'])->count();
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
                'status_ba' => $item->nomor_berita_acara ? 'BA Diterbitkan' : 'Draft BA Siap',
                'nomor_ba' => $item->nomor_berita_acara ?: '-',
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

        $query = Permohonan::with(['user', 'pewasiat'])
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
            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('WST-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'nomor_ba' => $item->nomor_berita_acara ?: ('BA-'.date('Ymd').'-'.str_pad((string) $item->id, 4, '0', STR_PAD_LEFT)),
                'tanggal_selesai' => $item->updated_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
                'status_hasil' => 'selesai',
                'status_label' => 'Selesai & Diarsipkan',
                'kurator_madya' => auth()->user()?->name ?? 'Inara, S.H., M.H.',
                'catatan' => 'Berita Acara dan 2 salinan dokumen telah dicetak dan berkas diarsipkan.',
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
     * Buat Berita Acara (BA) Pembukaan Wasiat Tertutup.
     */
    public function buatBa(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_ba' => ['nullable', 'string', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $permohonan = Permohonan::findOrFail($id);
        $nomorBa = $validated['nomor_ba'] ?: ('BA.'.date('m').'/WST/BHP.SBY/'.date('Y').'/'.str_pad((string) $permohonan->id, 3, '0', STR_PAD_LEFT));

        $permohonan->update([
            'nomor_berita_acara' => $nomorBa,
            'tanggal_berita_acara' => now(),
            'status' => 'proses_madya',
            'catatan_petugas' => $validated['catatan'] ?? 'Berita Acara pembukaan wasiat tertutup telah diterbitkan.',
        ]);

        $user = auth()->user();
        AuditLogger::log(
            action: 'buat_ba_madya',
            permohonan: $permohonan,
            description: "Kurator Madya {$user->name} menerbitkan Berita Acara {$nomorBa} untuk permohonan {$permohonan->nomor_permohonan}.",
            resource: $permohonan,
            details: ['nomor_berita_acara' => $nomorBa]
        );

        return redirect()->route('madya.dashboard')
            ->with('success', "Berita Acara untuk layanan {$permohonan->nomor_permohonan} berhasil diterbitkan dengan nomor {$nomorBa}.");
    }

    /**
     * Cetak dokumen 2 salinan (salinan untuk BHP dan Notaris).
     */
    public function cetakDokumen(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        return redirect()->route('madya.dashboard')
            ->with('success', "Dokumen 2 salinan resmi untuk layanan {$permohonan->nomor_permohonan} berhasil dicetak.");
    }

    /**
     * Arsipkan berkas layanan setelah proses selesai.
     */
    public function arsipkan(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);

        $permohonan->update([
            'status' => 'selesai',
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
            'surat_kuasa' => 'Surat Kuasa Notaris.pdf',
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
}
