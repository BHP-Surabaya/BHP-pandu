<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BendaharaPnbpController extends Controller
{
    /**
     * Default list permohonan PNBP untuk verifikasi (simulasi dan default wireframe).
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultPnbpList = [
        [
            'id' => 1,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00015',
            'jenis_layanan' => 'Pendaftaran Wasiat',
            'nama_pemohon' => 'Bambang Sudarsono',
            'nama_pewasiat' => 'Alm. Soetrisno',
            'tanggal_masuk' => '21 Okt 2026',
            'tanggal_masuk_iso' => '2026-10-21',
            'status_pnbp' => 'sudah_bayar',
            'nominal_tagihan' => 200000,
            'sla_hari_berjalan' => 2,
            'sla_hari_sisa' => 12,
            'sla_status' => 'normal',
            'is_expired' => false,
            'keterangan_sla' => 'Telah dibayar. Menunggu input NTPN & Upload Voucher.',
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00016',
            'jenis_layanan' => 'Pelaporan Wasiat Tertutup',
            'nama_pemohon' => 'Sri Rahayu Ningsih',
            'nama_pewasiat' => 'Almh. Siti Hartini',
            'tanggal_masuk' => '20 Okt 2026',
            'tanggal_masuk_iso' => '2026-10-20',
            'status_pnbp' => 'sudah_bayar',
            'nominal_tagihan' => 200000,
            'sla_hari_berjalan' => 3,
            'sla_hari_sisa' => 11,
            'sla_status' => 'normal',
            'is_expired' => false,
            'keterangan_sla' => 'Telah dibayar via Teller BNI. Menunggu verifikasi berkas voucher.',
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00012',
            'jenis_layanan' => 'Surat Keterangan Hak Waris (SKHW)',
            'nama_pemohon' => 'Dewi Lestari, S.H.',
            'nama_pewasiat' => 'Alm. Johannes Tan',
            'tanggal_masuk' => '17 Okt 2026',
            'tanggal_masuk_iso' => '2026-10-17',
            'status_pnbp' => 'belum_bayar',
            'nominal_tagihan' => 250000,
            'sla_hari_berjalan' => 6,
            'sla_hari_sisa' => 8,
            'sla_status' => 'normal',
            'is_expired' => false,
            'keterangan_sla' => 'Kode billing Simponi aktif. Sisa waktu 8 hari untuk pelunasan.',
        ],
        [
            'id' => 4,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00017',
            'jenis_layanan' => 'Wasiat Terbuka',
            'nama_pemohon' => 'Hadi Kurniawan',
            'nama_pewasiat' => 'Alm. Raden Mas Wardoyo',
            'tanggal_masuk' => '11 Okt 2026',
            'tanggal_masuk_iso' => '2026-10-11',
            'status_pnbp' => 'belum_bayar',
            'nominal_tagihan' => 200000,
            'sla_hari_berjalan' => 12,
            'sla_hari_sisa' => 2,
            'sla_status' => 'warning',
            'is_expired' => false,
            'keterangan_sla' => 'PERINGATAN SLA: Sisa 2 hari sebelum kode billing kadaluarsa!',
        ],
        [
            'id' => 5,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00018',
            'jenis_layanan' => 'Pendaftaran Wasiat',
            'nama_pemohon' => 'Fajar Pratama',
            'nama_pewasiat' => 'Almh. Maria Ulfah',
            'tanggal_masuk' => '05 Okt 2026',
            'tanggal_masuk_iso' => '2026-10-05',
            'status_pnbp' => 'belum_bayar',
            'nominal_tagihan' => 200000,
            'sla_hari_berjalan' => 18,
            'sla_hari_sisa' => 0,
            'sla_status' => 'expired',
            'is_expired' => true,
            'keterangan_sla' => 'SLA 14 Hari Terlampaui. Billing kadaluarsa dan pemohon harus mendaftar ulang.',
        ],
    ];

    /**
     * Default riwayat verifikasi PNBP yang telah lunas.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultHistoryList = [
        [
            'id' => 101,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00010',
            'jenis_layanan' => 'Pendaftaran Wasiat',
            'nama_pemohon' => 'Ahmad Dahlan',
            'nama_pewasiat' => 'Alm. H. Ridwan',
            'tanggal_masuk' => '14 Okt 2026',
            'ntpn' => '261015B789456123',
            'nominal' => 200000,
            'tanggal_bayar' => '15 Okt 2026',
            'tanggal_bayar_iso' => '2026-10-15',
            'tanggal_verifikasi' => '15 Okt 2026, 14.30 WIB',
            'file_voucher_url' => null,
            'file_voucher_nama' => 'VOUCHER-PNBP-W15-00010.pdf',
            'diverifikasi_oleh' => 'Bendahara Penerimaan BHP',
            'status' => 'Lunas',
        ],
        [
            'id' => 102,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00009',
            'jenis_layanan' => 'Surat Keterangan Hak Waris (SKHW)',
            'nama_pemohon' => 'Megawati Susanto',
            'nama_pewasiat' => 'Alm. Susanto Widjaja',
            'tanggal_masuk' => '13 Okt 2026',
            'ntpn' => '261014C123987456',
            'nominal' => 250000,
            'tanggal_bayar' => '14 Okt 2026',
            'tanggal_bayar_iso' => '2026-10-14',
            'tanggal_verifikasi' => '14 Okt 2026, 11.15 WIB',
            'file_voucher_url' => null,
            'file_voucher_nama' => 'BUKTI-BAYAR-SKHW-00009.pdf',
            'diverifikasi_oleh' => 'Bendahara Penerimaan BHP',
            'status' => 'Lunas',
        ],
        [
            'id' => 103,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00008',
            'jenis_layanan' => 'Pelaporan Wasiat Tertutup',
            'nama_pemohon' => 'Indra Wijaya',
            'nama_pewasiat' => 'Almh. Ny. Hendrawati',
            'tanggal_masuk' => '10 Okt 2026',
            'ntpn' => '261011A654321987',
            'nominal' => 200000,
            'tanggal_bayar' => '11 Okt 2026',
            'tanggal_bayar_iso' => '2026-10-11',
            'tanggal_verifikasi' => '11 Okt 2026, 16.00 WIB',
            'file_voucher_url' => null,
            'file_voucher_nama' => 'VOUCHER-SIMPONI-00008.jpg',
            'diverifikasi_oleh' => 'Bendahara Penerimaan BHP',
            'status' => 'Lunas',
        ],
    ];

    /**
     * Tampilkan halaman utama Verifikasi PNBP.
     */
    public function index(Request $request): View
    {
        $pnbpList = session('bendahara_pnbp_list', $this->defaultPnbpList);

        // Ambil data dari database dan gabungkan secara dinamis
        $pnbpList = $this->mergeWithDatabaseRecords($pnbpList);
        session(['bendahara_pnbp_list' => $pnbpList]);

        // Filter status
        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('q', ''));

        $filteredList = collect($pnbpList)->filter(function ($item) use ($statusFilter, $search) {
            // Filter status
            if ($statusFilter === 'sudah_bayar' && ($item['status_pnbp'] ?? '') !== 'sudah_bayar') {
                return false;
            }
            if ($statusFilter === 'belum_bayar' && (($item['status_pnbp'] ?? '') !== 'belum_bayar' || ($item['is_expired'] ?? false))) {
                return false;
            }
            if ($statusFilter === 'kadaluarsa' && ! ($item['is_expired'] ?? false)) {
                return false;
            }

            // Filter pencarian
            if ($search !== '') {
                $needle = mb_strtolower($search);
                $haystack = mb_strtolower(
                    ($item['nomor_layanan'] ?? '').' '.
                    ($item['jenis_layanan'] ?? '').' '.
                    ($item['nama_pemohon'] ?? '').' '.
                    ($item['nama_pewasiat'] ?? '')
                );

                return str_contains($haystack, $needle);
            }

            return true;
        })->values()->all();

        // Statistik ringkasan untuk header dashboard
        $stats = [
            'total_verifikasi' => count($pnbpList),
            'sudah_bayar' => collect($pnbpList)->where('status_pnbp', 'sudah_bayar')->count(),
            'belum_bayar' => collect($pnbpList)->where('status_pnbp', 'belum_bayar')->where('is_expired', false)->count(),
            'kadaluarsa' => collect($pnbpList)->where('is_expired', true)->count(),
            'total_terverifikasi' => count(session('bendahara_history_list', $this->defaultHistoryList)),
        ];

        return view('bendahara.verifikasi', [
            'pnbpList' => $filteredList,
            'stats' => $stats,
            'statusFilter' => $statusFilter,
            'search' => $search,
        ]);
    }

    /**
     * Proses tindak lanjut untuk permohonan yang sudah bayar:
     * Mengisi NTPN, Nominal, Tanggal Bayar, dan Upload Voucher.
     */
    public function tindakLanjut(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'ntpn' => ['required', 'string', 'min:8', 'max:50'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'tanggal_bayar' => ['required', 'date'],
            'file_voucher' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ], [
            'ntpn.required' => 'Nomor Transaksi Penerimaan Negara (NTPN) wajib diisi.',
            'nominal.required' => 'Nominal pembayaran PNBP wajib diisi.',
            'tanggal_bayar.required' => 'Tanggal pembayaran wajib dipilih.',
            'file_voucher.mimes' => 'File voucher harus berformat PDF, JPG, JPEG, atau PNG.',
            'file_voucher.max' => 'Ukuran file voucher maksimal 5MB.',
        ]);

        $fileUrl = null;
        $fileNama = null;

        if ($request->hasFile('file_voucher')) {
            $file = $request->file('file_voucher');
            $fileNama = 'VOUCHER_'.time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('vouchers', $fileNama, 'public');
            $fileUrl = Storage::url($path);
        }

        $pnbpList = session('bendahara_pnbp_list', $this->defaultPnbpList);
        $pnbpList = $this->mergeWithDatabaseRecords($pnbpList);

        $targetItem = null;
        $remainingList = [];

        foreach ($pnbpList as $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetItem = $item;
            } else {
                $remainingList[] = $item;
            }
        }

        if (! $targetItem) {
            return redirect()->route('bendahara.verifikasi.index')
                ->with('error', 'Data layanan PNBP tidak ditemukan.');
        }

        // Simpan ke database jika item berasal dari database
        if (str_starts_with((string) $id, 'db_')) {
            $dbId = (int) str_replace('db_', '', $id);
            $permohonan = Permohonan::find($dbId);

            if ($permohonan) {
                $voucher = $permohonan->voucher ?: new Voucher(['permohonan_id' => $permohonan->id]);
                $voucher->nomor_voucher = $voucher->nomor_voucher ?: 'VCH-'.date('Ymd').'-'.str_pad((string) $permohonan->id, 4, '0', STR_PAD_LEFT);
                $voucher->ntpn = $validated['ntpn'];
                $voucher->nominal = (int) $validated['nominal'];
                $voucher->tanggal_bayar = $validated['tanggal_bayar'];
                $voucher->status_pembayaran = 'lunas';
                if ($fileUrl) {
                    $voucher->file_voucher = $fileUrl;
                }
                $voucher->catatan = $validated['catatan'] ?? null;
                $voucher->save();
            }
        }

        // Pindahkan item ke riwayat verifikasi
        $historyList = session('bendahara_history_list', $this->defaultHistoryList);

        $newHistoryItem = [
            'id' => time(),
            'nomor_layanan' => $targetItem['nomor_layanan'],
            'jenis_layanan' => $targetItem['jenis_layanan'],
            'nama_pemohon' => $targetItem['nama_pemohon'],
            'nama_pewasiat' => $targetItem['nama_pewasiat'],
            'tanggal_masuk' => $targetItem['tanggal_masuk'],
            'ntpn' => strtoupper(trim($validated['ntpn'])),
            'nominal' => (int) $validated['nominal'],
            'tanggal_bayar' => Carbon::parse($validated['tanggal_bayar'])->translatedFormat('d M Y'),
            'tanggal_bayar_iso' => $validated['tanggal_bayar'],
            'tanggal_verifikasi' => now()->translatedFormat('d M Y, H.i').' WIB',
            'file_voucher_url' => $fileUrl,
            'file_voucher_nama' => $fileNama ?: 'Voucher-'.strtoupper(trim($validated['ntpn'])).'.pdf',
            'diverifikasi_oleh' => auth()->user()->name ?? 'Bendahara Penerimaan',
            'status' => 'Lunas',
        ];

        array_unshift($historyList, $newHistoryItem);

        session([
            'bendahara_pnbp_list' => $remainingList,
            'bendahara_history_list' => $historyList,
        ]);

        return redirect()->route('bendahara.verifikasi.index')
            ->with('success', "Verifikasi PNBP layanan {$targetItem['nomor_layanan']} berhasil disimpan! NTPN: {$validated['ntpn']}.");
    }

    /**
     * Tampilkan halaman Riwayat / History Verifikasi PNBP.
     */
    public function history(Request $request): View
    {
        $historyList = session('bendahara_history_list', $this->defaultHistoryList);

        $search = trim((string) $request->query('q', ''));
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

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

        $totalNominal = collect($filteredHistory)->sum('nominal');

        return view('bendahara.history', [
            'historyList' => $filteredHistory,
            'totalNominal' => $totalNominal,
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Export data riwayat PNBP ke CSV / Excel format.
     */
    public function export(Request $request): StreamedResponse
    {
        $historyList = session('bendahara_history_list', $this->defaultHistoryList);

        $filename = 'Laporan-Verifikasi-PNBP-'.date('Ymd-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($historyList) {
            $handle = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Excel dapat membuka karakter dengan benar
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No',
                'Nomor Layanan',
                'Jenis Layanan',
                'Nama Pemohon',
                'Nama Pewasiat',
                'NTPN',
                'Nominal (Rp)',
                'Tanggal Bayar',
                'Tanggal Verifikasi',
                'Petugas Verifikator',
                'Status',
            ], ';');

            $no = 1;
            foreach ($historyList as $row) {
                fputcsv($handle, [
                    $no++,
                    $row['nomor_layanan'] ?? '',
                    $row['jenis_layanan'] ?? '',
                    $row['nama_pemohon'] ?? '',
                    $row['nama_pewasiat'] ?? '',
                    $row['ntpn'] ?? '',
                    $row['nominal'] ?? 0,
                    $row['tanggal_bayar'] ?? '',
                    $row['tanggal_verifikasi'] ?? '',
                    $row['diverifikasi_oleh'] ?? '',
                    $row['status'] ?? '',
                ], ';');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Hitung jumlah antrean PNBP yang belum bayar untuk badge sidebar.
     */
    public static function getPendingCount(): int
    {
        $instance = new self;
        $list = session('bendahara_pnbp_list', $instance->defaultPnbpList);

        try {
            $list = $instance->mergeWithDatabaseRecords($list);
        } catch (\Throwable) {
            // fallback
        }

        return collect($list)->where('status_pnbp', 'belum_bayar')->count();
    }

    /**
     * Sinkronkan dengan entri permohonan yang ada di database.
     *
     * @param  array<int, array<string, mixed>>  $currentList
     * @return array<int, array<string, mixed>>
     */
    protected function mergeWithDatabaseRecords(array $currentList): array
    {
        try {
            $dbPermohonans = Permohonan::with(['user', 'pewasiat', 'voucher'])
                ->latest()
                ->get();

            foreach ($dbPermohonans as $permohonan) {
                $nomor = $permohonan->nomor_permohonan ?: ('W15.AHU.AHU.1.AH.06.01-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT));

                $exists = collect($currentList)->contains('nomor_layanan', $nomor);
                if (! $exists) {
                    $voucher = $permohonan->voucher;
                    $isLunas = $voucher?->isLunas() ?? false;
                    $statusPnbp = $isLunas ? 'sudah_bayar' : 'belum_bayar';

                    // Hitung SLA 14 Hari
                    $createdAt = $permohonan->created_at ?? now();
                    $daysRunning = (int) $createdAt->diffInDays(now());
                    $daysRemaining = max(0, 14 - $daysRunning);
                    $isExpired = (! $isLunas && $daysRunning > 14);

                    $slaStatus = 'normal';
                    if ($isExpired) {
                        $slaStatus = 'expired';
                    } elseif ($daysRemaining <= 3) {
                        $slaStatus = 'warning';
                    }

                    array_unshift($currentList, [
                        'id' => 'db_'.$permohonan->id,
                        'nomor_layanan' => $nomor,
                        'jenis_layanan' => 'Pendaftaran Wasiat Tertutup',
                        'nama_pemohon' => $permohonan->user?->name ?? 'Pemohon',
                        'nama_pewasiat' => $permohonan->pewasiat?->nama_lengkap ?? $permohonan->pewasiat?->nama_pewasiat ?? 'Pewasiat',
                        'tanggal_masuk' => $createdAt->translatedFormat('d M Y'),
                        'tanggal_masuk_iso' => $createdAt->format('Y-m-d'),
                        'status_pnbp' => $statusPnbp,
                        'nominal_tagihan' => $voucher?->nominal ?: 200000,
                        'sla_hari_berjalan' => $daysRunning,
                        'sla_hari_sisa' => $daysRemaining,
                        'sla_status' => $slaStatus,
                        'is_expired' => $isExpired,
                        'keterangan_sla' => $isExpired
                            ? 'SLA 14 Hari Terlampaui. Pemohon harus mendaftar ulang.'
                            : ($isLunas
                                ? 'Telah dibayar. Menunggu input NTPN & Bukti Voucher.'
                                : "Sisa waktu {$daysRemaining} hari dalam SLA 14 hari."),
                    ]);
                }
            }
        } catch (\Throwable) {
            // Ignored if DB table not available
        }

        return $currentList;
    }
}
