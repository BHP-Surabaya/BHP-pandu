<?php

namespace App\Http\Controllers\Muda;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MudaDashboardController extends Controller
{
    /**
     * Hitung permohonan aktif untuk Kurator Muda.
     */
    public static function getPerluVerifikasiCount(): int
    {
        return Permohonan::whereIn('status', ['disetujui_pertama', 'proses_muda'])->count();
    }

    /**
     * Tampilkan halaman utama Verifikasi Lanjutan Kurator Muda.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        // 1. Verifikasi Lanjutan
        $queryVerifikasi = Permohonan::with(['user', 'pewasiat', 'dokumens', 'voucher'])
            ->whereIn('status', ['disetujui_pertama', 'proses_muda'])
            ->latest();

        if ($search !== '') {
            $queryVerifikasi->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('pewasiat', fn ($p) => $p->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $permohonanVerifikasi = $queryVerifikasi->get();
        $verifikasiList = $permohonanVerifikasi->map(fn ($p) => $this->formatLayananData($p))->all();

        // 2. Penjadwalan Pembukaan Wasiat Tertutup
        $queryJadwal = Permohonan::with(['user', 'pewasiat'])
            ->whereIn('status', ['disetujui_pertama', 'proses_muda', 'proses_madya'])
            ->latest();

        $jadwalList = $queryJadwal->get()->map(function (Permohonan $item) {
            $jadwal = $item->jadwal_pembukaan;
            $statusJadwal = $jadwal ? 'disetujui' : 'menunggu_persetujuan';

            $userPhone = $item->user?->phone;
            $maskedPhone = $userPhone ? (strlen($userPhone) > 8 ? substr($userPhone, 0, 4).' •••• '.substr($userPhone, -4) : $userPhone) : '-';

            $slaTotalHari = 14;
            $created = $item->created_at ?? now();
            $slaHariKe = min(max(1, (int) $created->diffInDays(now()) + 1), $slaTotalHari);
            $slaHariTersisa = max(0, $slaTotalHari - $slaHariKe);
            $slaLevel = $slaHariTersisa <= 2 ? 'danger' : ($slaHariTersisa <= 6 ? 'warning' : 'safe');
            $batasSla = $created->copy()->addDays($slaTotalHari)->translatedFormat('d M Y');

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('WST-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                'detail_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'tanggal_masuk' => $item->created_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                'jadwal_pemohon_tanggal' => $jadwal ? $jadwal->translatedFormat('d F Y') : 'Menunggu Penetapan',
                'jadwal_pemohon_waktu' => $jadwal ? $jadwal->format('H.i').' WIB' : '-',
                'nomor_telepon' => $maskedPhone,
                'batas_sla' => $batasSla,
                'sla_total_hari' => $slaTotalHari,
                'sla_hari_ke' => $slaHariKe,
                'sla_hari_tersisa' => $slaHariTersisa,
                'sla_level' => $slaLevel,
                'lokasi' => $item->tempat_pembukaan ?: 'Ruang Sidang Balai Harta Peninggalan Surabaya',
                'status' => $statusJadwal,
                'status_label' => $jadwal ? 'Jadwal Ditetapkan' : 'Belum Dijadwalkan',
                'status_level' => $jadwal ? 'success' : 'warning',
                'tipe_badge' => 'purple',
                'catatan' => $item->disposisi_kasi ?? 'Diagendakan pembukaan sampul wasiat tertutup.',
            ];
        })->all();

        // 3. Penerbitan Dokumen
        $penerbitanList = Permohonan::with(['user', 'pewasiat'])
            ->whereIn('status', ['proses_madya', 'selesai'])
            ->latest()
            ->get()
            ->map(function (Permohonan $item) {
                return [
                    'id' => $item->id,
                    'nomor_layanan' => $item->nomor_permohonan ?: ('WST-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                    'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                    'detail_layanan' => $item->jenis_layanan_label,
                    'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                    'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                    'tanggal_pembukaan' => $item->jadwal_pembukaan?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                    'dokumen_terbit' => $item->nomor_berita_acara ? "BA Pembukaan No: {$item->nomor_berita_acara}" : 'Draft Berita Acara Siap',
                    'status_terbit' => $item->status === 'selesai' ? 'Telah Diterbitkan' : 'Siap Terbit',
                    'tipe_badge' => 'purple',
                ];
            })->all();

        $stats = [
            'total_verifikasi' => count($verifikasiList),
            'total_jadwal' => count($jadwalList),
            'total_penerbitan' => count($penerbitanList),
            'total_selesai' => Permohonan::where('status', 'selesai')->count(),
        ];

        return view('muda.dashboard', compact('verifikasiList', 'jadwalList', 'penerbitanList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman History Verifikasi Kurator Muda.
     */
    public function history(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $query = Permohonan::with(['user', 'pewasiat'])
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

        $historyList = $permohonans->map(function (Permohonan $item) {
            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('WST-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'tanggal_selesai' => $item->updated_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
                'status_hasil' => $item->status === 'revisi' ? 'revisi' : 'disetujui',
                'status_label' => $item->status_label,
                'petugas_verifikator' => auth()->user()?->name ?? 'Lutfy, S.H.',
                'catatan' => $item->catatan_petugas ?? 'Verifikasi lanjutan substantif telah diselesaikan.',
            ];
        })->all();

        $stats = [
            'total_riwayat' => count($historyList),
            'total_disetujui' => collect($historyList)->where('status_hasil', 'disetujui')->count(),
            'total_revisi' => collect($historyList)->where('status_hasil', 'revisi')->count(),
        ];

        return view('muda.history', compact('historyList', 'stats', 'search'));
    }

    /**
     * Tampilkan detail verifikasi persyaratan sesuai ID layanan.
     */
    public function show(string|int $id): View|RedirectResponse
    {
        $permohonan = Permohonan::with(['user', 'pewasiat.pasangans', 'pewasiat.ahliWaris', 'dokumens', 'voucher'])->find($id);

        if (! $permohonan) {
            return redirect()->route('muda.dashboard')->with('error', 'Layanan permohonan tidak ditemukan.');
        }

        $layanan = $this->formatLayananData($permohonan);

        return view('muda.verifikasi.show', compact('layanan'));
    }

    /**
     * Proses telaah/verifikasi persyaratan (setujui / revisi) oleh Kurator Muda.
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
                'status' => 'proses_muda',
                'catatan_petugas' => $validated['catatan'] ?? 'Telaah substantif Kurator Muda disetujui. Siap dijadwalkan pembukaan wasiat.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} berhasil diverifikasi lanjutan oleh Kurator Muda.";
        } elseif ($validated['status'] === 'revisi') {
            $permohonan->update([
                'status' => 'revisi',
                'catatan_revisi' => $validated['catatan'] ?? 'Diperlukan perbaikan berkas untuk telaah substantif.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} dikembalikan untuk revisi.";
        } else {
            $permohonan->update([
                'status' => 'ditolak',
                'catatan_revisi' => $validated['catatan'] ?? 'Permohonan ditolak pada tahap Kurator Muda.',
            ]);

            $pesan = "Permohonan {$permohonan->nomor_permohonan} ditolak.";
        }

        return redirect()->route('muda.dashboard')->with('success', $pesan);
    }

    /**
     * Proses tindak lanjut jadwal pembukaan wasiat (setujui / reschedule / terbitkan).
     */
    public function tindakLanjutJadwal(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:disetujui,reschedule,terbitkan'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'jadwal_tanggal' => ['nullable', 'string', 'max:100'],
            'jadwal_waktu' => ['nullable', 'string', 'max:50'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $permohonan = Permohonan::findOrFail($id);

        if ($validated['status'] === 'disetujui' || $validated['status'] === 'terbitkan') {
            $tanggal = ($validated['jadwal_tanggal'] ?? null) ?: now()->addDays(3)->format('Y-m-d');
            $waktu = ($validated['jadwal_waktu'] ?? null) ?: '10:00';

            try {
                $jadwalDt = Carbon::parse("{$tanggal} {$waktu}");
            } catch (\Throwable) {
                $jadwalDt = now()->addDays(3)->setTime(10, 0);
            }

            $permohonan->update([
                'jadwal_pembukaan' => $jadwalDt,
                'tempat_pembukaan' => $validated['lokasi'] ?: 'Ruang Sidang Balai Harta Peninggalan Surabaya',
                'status' => 'proses_madya',
                'disposisi_kasi' => $validated['catatan'] ?? 'Jadwal pembukaan wasiat tertutup telah ditetapkan.',
            ]);

            $pesan = "Jadwal pembukaan wasiat {$permohonan->nomor_permohonan} berhasil ditetapkan untuk tanggal {$jadwalDt->translatedFormat('d F Y, H:i')} WIB. Berkas diteruskan ke Kurator Madya.";
        } else {
            $permohonan->update([
                'disposisi_kasi' => $validated['catatan'] ?? 'Jadwal perlu disesuaikan kembali dengan pihak Notaris/Pemohon.',
            ]);

            $pesan = "Penyesuaian jadwal untuk {$permohonan->nomor_permohonan} berhasil disimpan.";
        }

        return redirect()->route('muda.dashboard')->with('success', $pesan);
    }

    /**
     * Terbitkan dokumen Berita Acara / Surat Keterangan.
     */
    public function terbitkanDokumen(Request $request, string|int $id): RedirectResponse
    {
        $permohonan = Permohonan::findOrFail($id);
        $permohonan->update(['status' => 'proses_madya']);

        return redirect()->route('muda.dashboard')
            ->with('success', "Dokumen pengantar untuk layanan {$permohonan->nomor_permohonan} berhasil diterbitkan dan siap diproses oleh Kurator Madya.");
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

        $slaTotalHari = 14;
        $created = $permohonan->created_at ?? now();
        $slaHariKe = min(max(1, (int) $created->diffInDays(now()) + 1), $slaTotalHari);
        $slaHariTersisa = max(0, $slaTotalHari - $slaHariKe);
        $slaLevel = $slaHariTersisa <= 2 ? 'danger' : ($slaHariTersisa <= 6 ? 'warning' : 'safe');
        $batasSla = $created->copy()->addDays($slaTotalHari)->translatedFormat('d M Y');

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
            'catatan' => $permohonan->catatan_petugas ?? 'Verifikasi persyaratan pertama telah disetujui.',
            'dokumen_list' => $dokumenList,
            'batas_sla' => $batasSla,
            'sla_total_hari' => $slaTotalHari,
            'sla_hari_ke' => $slaHariKe,
            'sla_hari_tersisa' => $slaHariTersisa,
            'sla_level' => $slaLevel,
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
