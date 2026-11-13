<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KasiDashboardController extends Controller
{
    /**
     * Hitung jumlah layanan baru yang perlu didisposisikan oleh KASI.
     */
    public static function getPerluDisposisiCount(): int
    {
        return Permohonan::whereIn('status', ['menunggu_verifikasi', 'disetujui_pertama', 'menunggu_disposisi'])
            ->whereNull('disposisi_pic')
            ->count();
    }

    /**
     * Tampilkan halaman utama dashboard KASI (Kepala Seksi).
     */
    public function index(Request $request): View
    {
        // 1. Layanan Baru (Belum Didisposisikan)
        $permohonanBaru = Permohonan::with(['user', 'pewasiat'])
            ->whereIn('status', ['menunggu_verifikasi', 'disetujui_pertama', 'menunggu_disposisi'])
            ->whereNull('disposisi_pic')
            ->latest()
            ->get();

        $layananBaru = $permohonanBaru->map(function (Permohonan $item) {
            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                'detail_layanan' => $item->jenis_layanan_label,
                'pemohon' => $item->user?->name ?? 'Pemohon',
                'tanggal_masuk' => $item->created_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                'waktu_masuk' => $item->created_at ? 'Pukul '.$item->created_at->format('H.i') : 'Pukul 10.00',
                'tipe_badge' => $item->jenis_layanan === 'skhw' ? 'sky' : 'purple',
                'status_verifikasi' => $item->status,
            ];
        })->all();

        // 2. Pemantauan SLA Aktif
        $permohonanSla = Permohonan::with(['user', 'pewasiat'])
            ->whereNotIn('status', ['draft', 'selesai', 'ditolak'])
            ->latest()
            ->get();

        $pemantauanSla = $permohonanSla->map(function (Permohonan $item) {
            $created = $item->created_at ?? now();
            $hariBerjalan = max(1, (int) $created->diffInDays(now()) + 1);
            $sisaHari = max(0, 14 - $hariBerjalan);

            $level = 'normal';
            $statusLabel = 'NORMAL';
            if ($hariBerjalan > 14) {
                $level = 'critical';
                $statusLabel = 'TERLAMBAT';
            } elseif ($hariBerjalan >= 10) {
                $level = 'warning';
                $statusLabel = 'PERINGATAN';
            }

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                'detail_layanan' => $item->jenis_layanan_label,
                'pemohon' => $item->user?->name ?? 'Pemohon',
                'tanggal_disposisi' => $item->tanggal_disposisi?->translatedFormat('d M Y') ?? $item->created_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                'status_layanan' => $item->status_label,
                'pic' => $item->disposisi_pic ? explode(', ', $item->disposisi_pic) : ['Kurator Keperdataan Pertama'],
                'sla_hari' => $hariBerjalan,
                'sla_label' => "Hari ke-{$hariBerjalan}",
                'sla_sisa' => $sisaHari,
                'sla_status' => $statusLabel,
                'sla_level' => $level,
                'batas_waktu' => $created->copy()->addDays(14)->translatedFormat('d M Y'),
                'tipe_badge' => $item->jenis_layanan === 'skhw' ? 'sky' : 'purple',
                'catatan' => $item->disposisi_kasi ?? $item->catatan_petugas ?? 'Dalam proses telaah berkas',
            ];
        })->all();

        // 3. Disposisi Selesai (sudah didisposisikan)
        $disposisiSelesai = Permohonan::with(['user', 'pewasiat'])
            ->whereNotNull('disposisi_pic')
            ->latest('tanggal_disposisi')
            ->take(15)
            ->get()
            ->map(function (Permohonan $item) {
                return [
                    'id' => $item->id,
                    'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                    'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                    'detail_layanan' => $item->jenis_layanan_label,
                    'pemohon' => $item->user?->name ?? 'Pemohon',
                    'tanggal_disposisi' => $item->tanggal_disposisi?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                    'pic' => $item->disposisi_pic ? explode(', ', $item->disposisi_pic) : ['Kurator Pertama'],
                    'prioritas' => ucfirst($item->disposisi_prioritas ?? 'Biasa'),
                    'tipe_badge' => $item->jenis_layanan === 'skhw' ? 'sky' : 'purple',
                    'status_layanan' => $item->status_label,
                ];
            })->all();

        // 4. Pemeriksaan Selesai (status: selesai)
        $pemeriksaanSelesai = Permohonan::with(['user', 'pewasiat'])
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->take(15)
            ->get()
            ->map(function (Permohonan $item) {
                return [
                    'id' => $item->id,
                    'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                    'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                    'detail_layanan' => $item->jenis_layanan_label,
                    'pemohon' => $item->user?->name ?? 'Pemohon',
                    'tanggal_selesai' => $item->updated_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                    'durasi_layanan' => max(1, (int) ($item->created_at?->diffInDays($item->updated_at) ?? 1)).' hari kerja',
                    'status' => 'Selesai',
                    'keterangan_hasil' => $item->nomor_berita_acara ? "BA: {$item->nomor_berita_acara}" : 'Layanan telah diselesaikan',
                    'tipe_badge' => $item->jenis_layanan === 'skhw' ? 'sky' : 'purple',
                ];
            })->all();

        // Filter pencarian jika ada
        $search = trim((string) $request->input('search', ''));
        if ($search !== '') {
            $layananBaru = array_values(array_filter($layananBaru, function ($item) use ($search) {
                return str_contains(strtolower($item['nomor_layanan']), strtolower($search))
                    || str_contains(strtolower($item['pemohon']), strtolower($search));
            }));
        }

        $totalLayananBaru = count($layananBaru);
        $totalSla = count($pemantauanSla);

        $kuratorList = [
            'Kurator Keperdataan Pertama' => ['Iman, S.H.', 'Rahmat, S.H.'],
            'Kurator Keperdataan Muda' => ['Lutfy, S.H.', 'Kemal, S.H.'],
            'Kurator Keperdataan Madya' => ['Inara, S.H., M.H.', 'Lisa, S.H.'],
        ];
        $petugasList = ['Iman, S.H.', 'Rahmat, S.H.', 'Lutfy, S.H.', 'Kemal, S.H.', 'Inara, S.H., M.H.', 'Lisa, S.H.'];

        $stats = [
            'perlu_disposisi' => $totalLayananBaru,
            'sla_berjalan' => $totalSla,
            'sla_mendesak' => collect($pemantauanSla)->where('sla_level', 'critical')->count(),
            'sla_perhatian' => collect($pemantauanSla)->where('sla_level', 'warning')->count(),
            'sla_normal' => collect($pemantauanSla)->where('sla_level', 'normal')->count(),
            'total_selesai' => count($pemeriksaanSelesai),
        ];

        return view('kasi.dashboard', compact(
            'layananBaru',
            'pemantauanSla',
            'disposisiSelesai',
            'pemeriksaanSelesai',
            'totalLayananBaru',
            'totalSla',
            'kuratorList',
            'petugasList',
            'stats',
            'search'
        ));
    }

    /**
     * Tampilkan halaman riwayat disposisi / history layanan.
     */
    public function history(Request $request): View
    {
        $query = Permohonan::with(['user', 'pewasiat'])
            ->whereNotNull('disposisi_pic')
            ->latest('tanggal_disposisi');

        if ($request->filled('q')) {
            $q = strtolower(trim((string) $request->query('q')));
            $query->where(function ($sub) use ($q) {
                $sub->where('nomor_permohonan', 'like', "%{$q}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
            });
        }

        $permohonans = $query->get();

        $historyLayanan = $permohonans->map(function (Permohonan $item) {
            $created = $item->created_at ?? now();
            $selesai = $item->status === 'selesai' ? ($item->updated_at ?? now()) : null;
            $durasi = $selesai ? max(1, (int) $created->diffInDays($selesai)) : max(1, (int) $created->diffInDays(now()));

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan === 'skhw' ? 'SKHW' : 'Wasiat',
                'detail_layanan' => $item->jenis_layanan_label,
                'pemohon' => $item->user?->name ?? 'Pemohon',
                'tanggal_masuk' => $created->translatedFormat('d M Y'),
                'tanggal_masuk_iso' => $created->format('Y-m-d'),
                'tanggal_disposisi' => $item->tanggal_disposisi?->translatedFormat('d M Y') ?? $created->translatedFormat('d M Y'),
                'tanggal_disposisi_iso' => $item->tanggal_disposisi?->format('Y-m-d') ?? $created->format('Y-m-d'),
                'tanggal_selesai' => $selesai?->translatedFormat('d M Y') ?? '-',
                'tanggal_selesai_iso' => $selesai?->format('Y-m-d') ?? '',
                'durasi_layanan' => "{$durasi} hari kerja",
                'status' => $item->status_label,
                'keterangan_hasil' => $item->disposisi_pic ? "Disposisi ke: {$item->disposisi_pic}" : 'Menunggu tindakan',
                'tipe_badge' => $item->jenis_layanan === 'skhw' ? 'sky' : 'purple',
            ];
        })->all();

        $rawHistoryLayanan = $historyLayanan;

        if ($request->filled('start_date')) {
            $startDate = (string) $request->query('start_date');
            $dateField = $request->query('date_field', 'tanggal_masuk') === 'tanggal_selesai' ? 'tanggal_selesai_iso' : 'tanggal_disposisi_iso';
            $historyLayanan = array_values(array_filter($historyLayanan, function ($item) use ($startDate, $dateField) {
                return ! empty($item[$dateField]) && $item[$dateField] >= $startDate;
            }));
        }

        if ($request->filled('end_date')) {
            $endDate = (string) $request->query('end_date');
            $dateField = $request->query('date_field', 'tanggal_masuk') === 'tanggal_selesai' ? 'tanggal_selesai_iso' : 'tanggal_disposisi_iso';
            $historyLayanan = array_values(array_filter($historyLayanan, function ($item) use ($endDate, $dateField) {
                return ! empty($item[$dateField]) && $item[$dateField] <= $endDate;
            }));
        }

        $statsHistory = [
            'layanan_masuk' => count($historyLayanan),
            'jenis_skhw' => collect($historyLayanan)->where('jenis_layanan', 'SKHW')->count(),
            'jenis_wasiat' => collect($historyLayanan)->where('jenis_layanan', 'Wasiat')->count(),
            'sla_merah' => 0,
            'sla_kuning' => 0,
            'sla_hijau' => count($historyLayanan),
            'layanan_selesai' => collect($historyLayanan)->where('status', 'Selesai')->count(),
        ];

        return view('kasi.history', compact('historyLayanan', 'rawHistoryLayanan', 'statsHistory'));
    }

    /**
     * Proses disposisi layanan oleh Kasi ke Petugas PIC.
     */
    public function disposisi(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'pic' => ['required', 'array', 'min:1'],
            'pic.*' => ['string'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'prioritas' => ['nullable', 'string', 'in:biasa,mendesak,sangat_mendesak'],
        ]);

        $permohonan = Permohonan::findOrFail($id);

        $picStr = implode(', ', $validated['pic']);
        $nextStatus = 'proses_muda';

        // Tentukan tahap berdasarkan PIC
        if (str_contains(strtolower($picStr), 'madya')) {
            $nextStatus = 'proses_madya';
        } elseif (str_contains(strtolower($picStr), 'muda')) {
            $nextStatus = 'proses_muda';
        }

        $permohonan->update([
            'disposisi_pic' => $picStr,
            'disposisi_kasi' => $validated['catatan'] ?? 'Telah didisposisikan oleh Kepala Seksi.',
            'disposisi_prioritas' => $validated['prioritas'] ?? 'biasa',
            'tanggal_disposisi' => now(),
            'status' => $nextStatus,
        ]);

        $user = auth()->user();
        AuditLogger::log(
            action: 'disposisi_kasi',
            permohonan: $permohonan,
            description: "Kasi {$user->name} melakukan disposisi permohonan {$permohonan->nomor_permohonan} kepada PIC {$picStr} dengan prioritas {$validated['prioritas']}.",
            resource: $permohonan,
            details: ['pic' => $validated['pic'], 'prioritas' => $validated['prioritas'] ?? 'biasa']
        );

        return redirect()->route('kasi.dashboard')
            ->with('success', "Layanan {$permohonan->nomor_permohonan} berhasil didisposisikan ke Petugas PIC: {$picStr}");
    }

    /**
     * Proses aksi konfirmasi tindak lanjut SLA.
     */
    public function tindakLanjut(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'alasan_keterlambatan' => ['required_without:aksi', 'nullable', 'string', 'max:1000'],
            'komitmen_penyelesaian' => ['required_without:aksi', 'nullable', 'string', 'max:1000'],
            'aksi' => ['nullable', 'string', 'in:kirim_pengingat,perpanjang_sla,tandai_selesai'],
            'pesan' => ['nullable', 'string', 'max:500'],
        ]);

        $permohonan = Permohonan::findOrFail($id);

        if (($validated['aksi'] ?? null) === 'tandai_selesai') {
            $permohonan->update(['status' => 'selesai']);

            return redirect()->route('kasi.dashboard')
                ->with('success', "Tindak lanjut {$permohonan->nomor_permohonan} berhasil: Status telah ditandai Selesai.");
        }

        if (! empty($validated['alasan_keterlambatan'])) {
            $permohonan->update([
                'disposisi_kasi' => "Alasan: {$validated['alasan_keterlambatan']}. Komitmen: {$validated['komitmen_penyelesaian']}",
            ]);
        }

        return redirect()->route('kasi.dashboard')
            ->with('success', "Konfirmasi tindak lanjut untuk {$permohonan->nomor_permohonan} berhasil disimpan.");
    }
}
