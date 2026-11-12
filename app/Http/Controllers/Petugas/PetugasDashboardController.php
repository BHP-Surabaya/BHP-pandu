<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PetugasDashboardController extends Controller
{
    /**
     * Hitung jumlah permohonan yang perlu diverifikasi persyaratannya.
     */
    public static function getPerluVerifikasiCount(): int
    {
        return Permohonan::where('status', 'menunggu_verifikasi')->count();
    }

    /**
     * Tampilkan halaman utama Verifikasi Persyaratan.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $query = Permohonan::with(['user', 'pewasiat', 'dokumens', 'voucher'])
            ->whereIn('status', ['menunggu_verifikasi', 'revisi'])
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('pewasiat', fn ($p) => $p->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $permohonans = $query->get();

        $verifikasiList = $permohonans->map(function (Permohonan $permohonan) {
            return $this->formatLayananData($permohonan);
        })->all();

        $stats = [
            'total_perlu_verifikasi' => Permohonan::where('status', 'menunggu_verifikasi')->count(),
            'total_selesai' => Permohonan::whereNotIn('status', ['draft', 'menunggu_verifikasi', 'revisi'])->count(),
        ];

        return view('petugas.dashboard', compact('verifikasiList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman History Verifikasi.
     */
    public function history(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $query = Permohonan::with(['user', 'pewasiat', 'dokumens'])
            ->whereNotIn('status', ['draft', 'menunggu_verifikasi'])
            ->latest('updated_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('pewasiat', fn ($p) => $p->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $permohonans = $query->get();

        $historyList = $permohonans->map(function (Permohonan $permohonan) {
            $statusHasil = match ($permohonan->status) {
                'revisi' => 'revisi',
                'ditolak' => 'ditolak',
                default => 'disetujui',
            };

            return [
                'id' => $permohonan->id,
                'nomor_layanan' => $permohonan->nomor_permohonan ?: ('WST-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $permohonan->jenis_layanan_label,
                'nama_pemohon' => $permohonan->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $permohonan->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'tanggal_selesai' => $permohonan->tanggal_diverifikasi?->translatedFormat('d F Y') ?? $permohonan->updated_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
                'status_hasil' => $statusHasil,
                'status_label' => $permohonan->status_label,
                'petugas_verifikator' => $permohonan->diverifikasi_oleh ?? 'Petugas Verifikator',
                'catatan' => $permohonan->catatan_petugas ?? $permohonan->catatan_revisi ?? 'Verifikasi persyaratan telah diproses.',
            ];
        })->all();

        $stats = [
            'total_riwayat' => count($historyList),
            'total_disetujui' => collect($historyList)->where('status_hasil', 'disetujui')->count(),
            'total_revisi' => collect($historyList)->where('status_hasil', 'revisi')->count(),
        ];

        return view('petugas.history', compact('historyList', 'stats', 'search'));
    }

    /**
     * Tampilkan detail verifikasi persyaratan sesuai ID permohonan.
     */
    public function show(string|int $id): View|RedirectResponse
    {
        $permohonan = Permohonan::with(['user', 'pewasiat.pasangans', 'pewasiat.ahliWaris', 'dokumens', 'voucher'])->find($id);

        if (! $permohonan) {
            return redirect()->route('petugas.dashboard')->with('error', 'Permohonan layanan tidak ditemukan.');
        }

        $layanan = $this->formatLayananData($permohonan);

        return view('petugas.verifikasi.show', compact('layanan'));
    }

    /**
     * Proses telaah/verifikasi persyaratan (setujui / revisi / tolak).
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
                'status' => 'disetujui_pertama',
                'diverifikasi_oleh' => auth()->user()?->name ?? 'Kurator Pertama',
                'tanggal_diverifikasi' => now(),
                'catatan_petugas' => $validated['catatan'] ?? 'Dokumen persyaratan lengkap dan absah.',
                'catatan_revisi' => null,
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} berhasil diverifikasi dan disetujui. Berkas diteruskan ke tahap disposisi Kasi.";
        } elseif ($validated['status'] === 'revisi') {
            $permohonan->update([
                'status' => 'revisi',
                'diverifikasi_oleh' => auth()->user()?->name ?? 'Kurator Pertama',
                'tanggal_diverifikasi' => now(),
                'catatan_revisi' => $validated['catatan'] ?? 'Terdapat kekurangan berkas persyaratan. Silakan periksa kembali dan unggah ulang.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} dikembalikan kepada pemohon untuk perbaikan berkas.";
        } else {
            $permohonan->update([
                'status' => 'ditolak',
                'diverifikasi_oleh' => auth()->user()?->name ?? 'Kurator Pertama',
                'tanggal_diverifikasi' => now(),
                'catatan_revisi' => $validated['catatan'] ?? 'Permohonan ditolak karena berkas tidak memenuhi syarat hukum.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} telah ditolak.";
        }

        return redirect()->route('petugas.dashboard')->with('success', $pesan);
    }

    /**
     * Format model Permohonan ke array representation untuk view.
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
            'alamat_domisili' => $permohonan->user?->alamat_domisili ?? $permohonan->user?->alamat_ktp ?? '-',
            'nama_pewasiat' => $permohonan->pewasiat?->nama_lengkap ?? 'Pewasiat',
            'tanggal_masuk' => $permohonan->created_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
            'waktu_masuk' => $permohonan->created_at ? 'Pukul '.$permohonan->created_at->format('H:i') : 'Pukul 10:00',
            'status_verifikasi' => $permohonan->status,
            'status_label' => $permohonan->status_label,
            'dokumen_count' => count($dokumenList),
            'dokumen_total' => max(count($dokumenList), 4),
            'tipe_badge' => 'purple',
            'catatan' => $permohonan->catatan_petugas ?? $permohonan->catatan_revisi ?? 'Permohonan masuk dari portal pemohon.',
            'dokumen_list' => $dokumenList,
        ];
    }

    /**
     * Map dokumen relation ke format pratinjau split viewer.
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
                'url' => Storage::url($dok->file_path),
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
