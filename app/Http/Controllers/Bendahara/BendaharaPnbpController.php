<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BendaharaPnbpController extends Controller
{
    /**
     * Hitung permohonan yang perlu diverifikasi pembayaran PNBP-nya.
     */
    public static function getPerluVerifikasiCount(): int
    {
        return Permohonan::whereHas('voucher', function ($q) {
            $q->where('status_pembayaran', '!=', 'lunas');
        })->count();
    }

    /**
     * Alias method for badge count in sidebar.
     */
    public static function getPendingCount(): int
    {
        return self::getPerluVerifikasiCount();
    }

    /**
     * Tampilkan halaman utama Verifikasi PNBP.
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('q', ''));

        $query = Permohonan::with(['user', 'pewasiat', 'voucher'])
            ->whereHas('voucher')
            ->latest();

        $permohonans = $query->get();

        $pnbpList = $permohonans->map(function (Permohonan $item) {
            $voucher = $item->voucher;
            $created = $item->created_at ?? now();
            $hariBerjalan = max(1, (int) $created->diffInDays(now()) + 1);
            $sisaHari = max(0, 14 - $hariBerjalan);
            $isExpired = $hariBerjalan > 14;

            $slaStatus = 'normal';
            if ($isExpired) {
                $slaStatus = 'expired';
            } elseif ($hariBerjalan >= 10) {
                $slaStatus = 'warning';
            }

            $statusPnbp = $voucher?->status_pembayaran ?? 'belum_bayar';
            if ($statusPnbp === 'lunas') {
                $statusPnbp = 'sudah_bayar';
            }

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'tanggal_masuk' => $created->translatedFormat('d M Y'),
                'tanggal_masuk_iso' => $created->format('Y-m-d'),
                'status_pnbp' => $statusPnbp,
                'nominal_tagihan' => (int) ($voucher?->nominal ?: 200000),
                'nomor_voucher' => $voucher?->nomor_voucher ?? '-',
                'ntpn' => $voucher?->ntpn,
                'sla_hari_berjalan' => $hariBerjalan,
                'sla_hari_sisa' => $sisaHari,
                'sla_status' => $slaStatus,
                'is_expired' => $isExpired,
                'keterangan_sla' => $isExpired ? 'SLA 14 Hari Terlampaui.' : ($statusPnbp === 'sudah_bayar' ? 'Telah diverifikasi lunas.' : "Sisa waktu {$sisaHari} hari untuk pelunasan billing Simponi."),
            ];
        })->all();

        $filteredList = collect($pnbpList)->filter(function ($item) use ($statusFilter, $search) {
            if ($statusFilter === 'sudah_bayar' && ($item['status_pnbp'] ?? '') !== 'sudah_bayar') {
                return false;
            }
            if ($statusFilter === 'belum_bayar' && (($item['status_pnbp'] ?? '') !== 'belum_bayar' || ($item['is_expired'] ?? false))) {
                return false;
            }
            if ($statusFilter === 'kadaluarsa' && ! ($item['is_expired'] ?? false)) {
                return false;
            }

            if ($search !== '') {
                $needle = mb_strtolower($search);
                $haystack = mb_strtolower(
                    ($item['nomor_layanan'] ?? '').' '.
                    ($item['jenis_layanan'] ?? '').' '.
                    ($item['nama_pemohon'] ?? '').' '.
                    ($item['nama_pewasiat'] ?? '').' '.
                    ($item['nomor_voucher'] ?? '')
                );

                if (! str_contains($haystack, $needle)) {
                    return false;
                }
            }

            return true;
        })->values()->all();

        $stats = [
            'total_semua' => count($pnbpList),
            'sudah_bayar' => collect($pnbpList)->where('status_pnbp', 'sudah_bayar')->count(),
            'belum_bayar' => collect($pnbpList)->where('status_pnbp', 'belum_bayar')->where('is_expired', false)->count(),
            'kadaluarsa' => collect($pnbpList)->where('is_expired', true)->count(),
            'total_nominal_sudah_bayar' => collect($pnbpList)->where('status_pnbp', 'sudah_bayar')->sum('nominal_tagihan'),
        ];

        return view('bendahara.verifikasi', [
            'pnbpList' => $filteredList,
            'stats' => $stats,
            'currentFilter' => $statusFilter,
            'search' => $search,
        ]);
    }

    /**
     * Proses tindak lanjut verifikasi PNBP (input NTPN dan berkas bukti setor).
     */
    public function tindakLanjut(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'ntpn' => ['required', 'string', 'min:8', 'max:50'],
            'nominal' => ['required', 'numeric', 'min:1000'],
            'tanggal_bayar' => ['required', 'date'],
            'catatan' => ['nullable', 'string', 'max:500'],
            'file_voucher' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $cleanId = (int) str_replace('db_', '', (string) $id);
        $permohonan = Permohonan::with('voucher')->findOrFail($cleanId);
        $voucher = $permohonan->voucher;

        $filePath = null;
        if ($request->hasFile('file_voucher')) {
            $filePath = $request->file('file_voucher')->store("vouchers/{$permohonan->id}", 'local');
        }

        if (! $voucher) {
            $voucher = new Voucher([
                'permohonan_id' => $permohonan->id,
                'nomor_voucher' => 'VCH-'.date('Ymd').'-'.str_pad((string) $permohonan->id, 4, '0', STR_PAD_LEFT),
            ]);
        }

        $voucher->ntpn = strtoupper(trim($validated['ntpn']));
        $voucher->nominal = (int) $validated['nominal'];
        $voucher->tanggal_bayar = $validated['tanggal_bayar'];
        $voucher->status_pembayaran = 'lunas';
        if ($filePath) {
            $voucher->file_voucher = $filePath;
        }
        $voucher->catatan = $validated['catatan'] ?? null;
        $voucher->save();

        return redirect()->route('bendahara.verifikasi.index')
            ->with('success', "Verifikasi PNBP layanan {$permohonan->nomor_permohonan} berhasil disimpan! NTPN: {$validated['ntpn']}.");
    }

    /**
     * Tampilkan halaman Riwayat / History Verifikasi PNBP.
     */
    public function history(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = Permohonan::with(['user', 'pewasiat', 'voucher'])
            ->whereHas('voucher', fn ($q) => $q->where('status_pembayaran', 'lunas'))
            ->latest();

        $permohonans = $query->get();

        $historyList = $permohonans->map(function (Permohonan $item) {
            $voucher = $item->voucher;
            $tanggalBayarIso = $voucher?->tanggal_bayar ? Carbon::parse($voucher->tanggal_bayar)->format('Y-m-d') : null;

            return [
                'id' => $item->id,
                'nomor_layanan' => $item->nomor_permohonan ?: ('W15.AHU-'.str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'jenis_layanan' => $item->jenis_layanan_label,
                'nama_pemohon' => $item->user?->name ?? 'Pemohon',
                'nama_pewasiat' => $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                'tanggal_masuk' => $item->created_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y'),
                'ntpn' => $voucher?->ntpn ?? '-',
                'nominal' => (int) ($voucher?->nominal ?: 200000),
                'tanggal_bayar' => $voucher?->tanggal_bayar ? Carbon::parse($voucher->tanggal_bayar)->translatedFormat('d M Y') : '-',
                'tanggal_bayar_iso' => $tanggalBayarIso,
                'tanggal_verifikasi' => $voucher?->updated_at?->translatedFormat('d M Y, H.i').' WIB' ?? '-',
                'file_voucher_url' => $voucher?->file_voucher ? route('secure.voucher.show', $voucher->id) : null,
                'file_voucher_nama' => $voucher?->file_voucher ? basename($voucher->file_voucher) : null,
                'diverifikasi_oleh' => 'Bendahara Penerimaan BHP',
                'status' => 'Lunas',
            ];
        })->all();

        $filteredHistory = collect($historyList)->filter(function ($item) use ($search, $dateFrom, $dateTo) {
            if ($search !== '') {
                $needle = mb_strtolower($search);
                $haystack = mb_strtolower(
                    ($item['nomor_layanan'] ?? '').' '.
                    ($item['jenis_layanan'] ?? '').' '.
                    ($item['nama_pemohon'] ?? '').' '.
                    ($item['nama_pewasiat'] ?? '').' '.
                    ($item['ntpn'] ?? '')
                );

                if (! str_contains($haystack, $needle)) {
                    return false;
                }
            }

            if (! empty($dateFrom) && ! empty($item['tanggal_bayar_iso'])) {
                if ($item['tanggal_bayar_iso'] < $dateFrom) {
                    return false;
                }
            }

            if (! empty($dateTo) && ! empty($item['tanggal_bayar_iso'])) {
                if ($item['tanggal_bayar_iso'] > $dateTo) {
                    return false;
                }
            }

            return true;
        })->values()->all();

        $stats = [
            'total_transaksi' => count($filteredHistory),
            'total_nominal' => collect($filteredHistory)->sum('nominal'),
        ];

        return view('bendahara.history', [
            'historyList' => $filteredHistory,
            'stats' => $stats,
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Ekspor riwayat verifikasi PNBP ke CSV format.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Permohonan::with(['user', 'pewasiat', 'voucher'])
            ->whereHas('voucher', fn ($q) => $q->where('status_pembayaran', 'lunas'))
            ->latest();

        $permohonans = $query->get();

        $fileName = 'Riwayat-PNBP-'.date('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($permohonans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No', 'Nomor Layanan', 'Jenis Layanan', 'Pemohon', 'Pewasiat', 'NTPN', 'Nominal (Rp)', 'Tanggal Bayar', 'Status']);

            $no = 1;
            foreach ($permohonans as $item) {
                fputcsv($handle, [
                    $no++,
                    $item->nomor_permohonan,
                    $item->jenis_layanan_label,
                    $item->user?->name ?? 'Pemohon',
                    $item->pewasiat?->nama_lengkap ?? 'Pewasiat',
                    $item->voucher?->ntpn ?? '-',
                    $item->voucher?->nominal ?? 200000,
                    $item->voucher?->tanggal_bayar ?? '-',
                    'Lunas',
                ]);
            }
            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}
