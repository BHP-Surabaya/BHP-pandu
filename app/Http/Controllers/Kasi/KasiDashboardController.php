<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KasiDashboardController extends Controller
{
    /**
     * Default daftar layanan baru (belum didisposisikan) sesuai wireframe.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultLayananBaru = [
        [
            'id' => 1,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00006',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Fajar Nugroho',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 11.45',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00006',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat',
            'pemohon' => 'Ratna Kusumawati',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 11.20',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00005',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Hendra Gunawan',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 09.40',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 4,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00005',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Wasiat Terbuka',
            'pemohon' => 'Siska Melati',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 16.05',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 5,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00004',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Rudi Hermawan',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 14.15',
            'tipe_badge' => 'sky',
        ],
    ];

    /**
     * Default daftar pemantauan SLA (sudah didisposisikan) sesuai wireframe.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultPemantauanSla = [
        [
            'id' => 1,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00008',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Dian Puspitasari',
            'tanggal_disposisi' => '9 Mei 2025',
            'status_layanan' => 'Verifikasi Madya',
            'pic' => ['Januar', 'Indra'],
            'sla_hari' => 14,
            'sla_label' => 'Hari ke-14',
            'sla_status' => 'MENDESAK',
            'sla_level' => 'danger', // 13-14 hari
            'batas_waktu' => '23 Mei 2025',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00009',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Wasiat Terbuka',
            'pemohon' => 'Suhindra Wijaya',
            'tanggal_disposisi' => '12 Mei 2025',
            'status_layanan' => 'Verifikasi Muda',
            'pic' => ['Maya', 'Lisa'],
            'sla_hari' => 13,
            'sla_label' => 'Hari ke-13',
            'sla_status' => 'MENDESAK',
            'sla_level' => 'danger', // 13-14 hari
            'batas_waktu' => '26 Mei 2025',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00012',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat',
            'pemohon' => 'PT Adikara Sentosa',
            'tanggal_disposisi' => '16 Mei 2025',
            'status_layanan' => 'Verifikasi PNBP',
            'pic' => ['Rahmat', 'Kamal'],
            'sla_hari' => 9,
            'sla_label' => 'Hari ke-9',
            'sla_status' => 'PERHATIAN',
            'sla_level' => 'warning', // 8-12 hari
            'batas_waktu' => '5 Jun 2025',
            'tipe_badge' => 'purple',
        ],
    ];

    /**
     * Default riwayat layanan selesai sesuai wireframe.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultHistoryLayanan = [
        [
            'id' => 1,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00018',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Arif Setiawan',
            'tanggal_masuk' => '28 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-28',
            'tanggal_disposisi' => '28 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-28',
            'tanggal_selesai' => '30 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-30',
            'durasi_layanan' => '3 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00017',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat',
            'pemohon' => 'Dwi Lestari',
            'tanggal_masuk' => '27 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-27',
            'tanggal_disposisi' => '27 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-27',
            'tanggal_selesai' => '30 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-30',
            'durasi_layanan' => '4 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00016',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Bagus Permana',
            'tanggal_masuk' => '26 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-26',
            'tanggal_disposisi' => '26 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-26',
            'tanggal_selesai' => '29 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-29',
            'durasi_layanan' => '4 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 4,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00015',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Wasiat Terbuka',
            'pemohon' => 'Hesti Wulandari',
            'tanggal_masuk' => '23 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-23',
            'tanggal_disposisi' => '23 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-23',
            'tanggal_selesai' => '28 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-28',
            'durasi_layanan' => '4 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 5,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00013',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Irfan Maulana',
            'tanggal_masuk' => '22 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-22',
            'tanggal_disposisi' => '22 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-22',
            'tanggal_selesai' => '27 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-27',
            'durasi_layanan' => '4 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 6,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00011',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat',
            'pemohon' => 'Melati Purnama',
            'tanggal_masuk' => '20 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-20',
            'tanggal_disposisi' => '20 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-20',
            'tanggal_selesai' => '26 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-26',
            'durasi_layanan' => '5 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 7,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00010',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'PT Karya Utama',
            'tanggal_masuk' => '19 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-19',
            'tanggal_disposisi' => '19 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-19',
            'tanggal_selesai' => '23 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-23',
            'durasi_layanan' => '5 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 8,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00008',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Wasiat Terbuka',
            'pemohon' => 'Rangga Pratama',
            'tanggal_masuk' => '16 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-16',
            'tanggal_disposisi' => '16 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-16',
            'tanggal_selesai' => '22 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-22',
            'durasi_layanan' => '5 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 9,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00007',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'CV Berkah Abadi',
            'tanggal_masuk' => '14 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-14',
            'tanggal_disposisi' => '14 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-14',
            'tanggal_selesai' => '20 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-20',
            'durasi_layanan' => '5 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 10,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00005',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Wasiat Terbuka',
            'pemohon' => 'Siti Aminah',
            'tanggal_masuk' => '12 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-12',
            'tanggal_disposisi' => '12 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-12',
            'tanggal_selesai' => '19 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-19',
            'durasi_layanan' => '5 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 11,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00003',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Bambang Sudibyo',
            'tanggal_masuk' => '08 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-08',
            'tanggal_disposisi' => '08 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-08',
            'tanggal_selesai' => '15 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-15',
            'durasi_layanan' => '6 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'sky',
        ],
        [
            'id' => 12,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00002',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat',
            'pemohon' => 'H. Suryadi',
            'tanggal_masuk' => '05 Mei 2025',
            'tanggal_masuk_iso' => '2025-05-05',
            'tanggal_disposisi' => '05 Mei 2025',
            'tanggal_disposisi_iso' => '2025-05-05',
            'tanggal_selesai' => '12 Mei 2025',
            'tanggal_selesai_iso' => '2025-05-12',
            'durasi_layanan' => '6 hari kerja',
            'status' => 'Selesai',
            'keterangan_hasil' => 'Dikirim ke akun pemohon',
            'tipe_badge' => 'purple',
        ],
    ];

    /**
     * Tampilkan halaman utama dashboard KASI (Kepala Seksi).
     */
    public function index(Request $request): View
    {
        $layananBaru = session('kasi_layanan_baru', $this->defaultLayananBaru);
        $rawPemantauan = session('kasi_pemantauan_sla', $this->defaultPemantauanSla);
        $pemantauanSla = collect($rawPemantauan)
            ->reject(fn ($item) => ($item['sla_level'] ?? '') === 'normal' || (int) ($item['sla_hari'] ?? 0) <= 7)
            ->map(function ($item) {
                if (empty($item['status_layanan'])) {
                    $item['status_layanan'] = match ((int) ($item['id'] ?? 0)) {
                        1 => 'Verifikasi Madya',
                        2 => 'Verifikasi Muda',
                        3 => 'Verifikasi PNBP',
                        default => 'Verifikasi Pertama',
                    };
                }

                return $item;
            })
            ->values()
            ->all();
        session(['kasi_pemantauan_sla' => $pemantauanSla]);

        // Ambil permohonan dinamis dari database jika ada
        $dbPermohonans = Permohonan::with(['user', 'pewasiat'])
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();

        foreach ($dbPermohonans as $permohonan) {
            $nomor = $permohonan->nomor_permohonan ?: ('W15.AHU.AHU.1.AH.06.01-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT));

            // Cek agar tidak duplikat dengan list wireframe
            $exists = collect($layananBaru)->contains('nomor_layanan', $nomor);
            if (! $exists) {
                array_unshift($layananBaru, [
                    'id' => 'db_'.$permohonan->id,
                    'nomor_layanan' => $nomor,
                    'jenis_layanan' => 'Wasiat',
                    'detail_layanan' => 'Pembukaan Wasiat Tertutup',
                    'pemohon' => $permohonan->user?->name ?? 'Pemohon',
                    'tanggal_masuk' => $permohonan->created_at->translatedFormat('d F Y'),
                    'waktu_masuk' => 'Pukul '.$permohonan->created_at->format('H.i'),
                    'tipe_badge' => 'purple',
                ]);
            }
        }

        // Daftar Kurator Keperdataan (PIC) fungsional sesuai wireframe penugasan
        $kuratorList = [
            'pertama' => [
                ['name' => 'Iman', 'disposisi_aktif' => 6],
                ['name' => 'Rahmat', 'disposisi_aktif' => 10],
                ['name' => 'Januar', 'disposisi_aktif' => 8],
            ],
            'muda' => [
                ['name' => 'Lutfy', 'disposisi_aktif' => 9],
                ['name' => 'Kemal', 'disposisi_aktif' => 8],
                ['name' => 'Maya', 'disposisi_aktif' => 7],
            ],
            'madya' => [
                ['name' => 'Inara', 'disposisi_aktif' => 11],
                ['name' => 'Lisa', 'disposisi_aktif' => 13],
            ],
        ];

        $petugasList = ['Iman', 'Rahmat', 'Januar', 'Lutfy', 'Kemal', 'Maya', 'Inara', 'Lisa'];

        $totalLayananBaru = count($layananBaru);
        $totalSla = count($pemantauanSla);

        $stats = [
            'perlu_disposisi' => $totalLayananBaru,
            'sla_berjalan' => $totalSla,
            'sla_mendesak' => collect($pemantauanSla)->where('sla_level', 'danger')->count(),
            'sla_perhatian' => collect($pemantauanSla)->where('sla_level', 'warning')->count(),
            'sla_normal' => collect($pemantauanSla)->where('sla_level', 'normal')->count(),
            'total_selesai' => count(session('kasi_history_layanan', $this->defaultHistoryLayanan)),
        ];

        return view('kasi.dashboard', compact(
            'layananBaru',
            'pemantauanSla',
            'totalLayananBaru',
            'totalSla',
            'kuratorList',
            'petugasList',
            'stats'
        ));
    }

    /**
     * Tampilkan halaman riwayat disposisi / history layanan.
     */
    public function history(Request $request): View
    {
        $historyLayanan = session('kasi_history_layanan', $this->defaultHistoryLayanan);

        // Pastikan format ISO tersedia untuk filter range tanggal
        $historyLayanan = array_map(function ($item) {
            if (empty($item['tanggal_masuk_iso']) && ! empty($item['tanggal_masuk'])) {
                $item['tanggal_masuk_iso'] = $this->convertIndoDateToIso($item['tanggal_masuk']);
            }
            if (empty($item['tanggal_disposisi_iso']) && ! empty($item['tanggal_disposisi'])) {
                $item['tanggal_disposisi_iso'] = $this->convertIndoDateToIso($item['tanggal_disposisi']);
            }
            $selesai = $item['tanggal_selesai'] ?? $item['selesai_pada'] ?? null;
            if (empty($item['tanggal_selesai_iso']) && ! empty($selesai)) {
                $item['tanggal_selesai_iso'] = $this->convertIndoDateToIso($selesai);
            }

            return $item;
        }, $historyLayanan);

        $rawHistoryLayanan = $historyLayanan;

        if ($request->filled('start_date')) {
            $startDate = (string) $request->query('start_date');
            $dateField = $request->query('date_field', 'tanggal_masuk') === 'tanggal_selesai' ? 'tanggal_selesai_iso' : 'tanggal_masuk_iso';
            $historyLayanan = array_values(array_filter($historyLayanan, function ($item) use ($startDate, $dateField) {
                return ! empty($item[$dateField]) && $item[$dateField] >= $startDate;
            }));
        }

        if ($request->filled('end_date')) {
            $endDate = (string) $request->query('end_date');
            $dateField = $request->query('date_field', 'tanggal_masuk') === 'tanggal_selesai' ? 'tanggal_selesai_iso' : 'tanggal_masuk_iso';
            $historyLayanan = array_values(array_filter($historyLayanan, function ($item) use ($endDate, $dateField) {
                return ! empty($item[$dateField]) && $item[$dateField] <= $endDate;
            }));
        }

        if ($request->filled('jenis') && $request->query('jenis') !== 'all') {
            $jenis = (string) $request->query('jenis');
            $historyLayanan = array_values(array_filter($historyLayanan, function ($item) use ($jenis) {
                return ($item['jenis_layanan'] ?? '') === $jenis;
            }));
        }

        if ($request->filled('q')) {
            $q = strtolower((string) $request->query('q'));
            $historyLayanan = array_values(array_filter($historyLayanan, function ($item) use ($q) {
                $searchable = strtolower(($item['nomor_layanan'] ?? '').' '.($item['jenis_layanan'] ?? '').' '.($item['detail_layanan'] ?? '').' '.($item['pemohon'] ?? ''));

                return str_contains($searchable, $q);
            }));
        }

        $statsHistory = [
            'layanan_masuk' => count($historyLayanan),
            'jenis_skhw' => collect($historyLayanan)->where('jenis_layanan', 'SKHW')->count(),
            'jenis_wasiat' => collect($historyLayanan)->where('jenis_layanan', 'Wasiat')->count(),
            'sla_merah' => 2,
            'sla_kuning' => 1,
            'sla_hijau' => 1,
            'layanan_selesai' => count($historyLayanan),
        ];

        return view('kasi.history', compact('historyLayanan', 'rawHistoryLayanan', 'statsHistory'));
    }

    /**
     * Konversi format tanggal Indonesia (misal: "28 Mei 2025") ke ISO YYYY-MM-DD.
     */
    protected function convertIndoDateToIso(?string $dateStr): ?string
    {
        if (empty($dateStr)) {
            return null;
        }

        $bulanMap = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
            'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08',
            'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12',
        ];

        if (preg_match('/^(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})$/', trim($dateStr), $matches)) {
            $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $monthName = ucfirst(strtolower($matches[2]));
            $month = $bulanMap[$monthName] ?? '01';
            $year = $matches[3];

            return "{$year}-{$month}-{$day}";
        }

        return null;
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

        $layananBaru = session('kasi_layanan_baru', $this->defaultLayananBaru);
        $pemantauanSla = session('kasi_pemantauan_sla', $this->defaultPemantauanSla);

        // Cari item yang didisposisikan
        $targetItem = null;
        $filteredLayananBaru = [];

        foreach ($layananBaru as $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetItem = $item;
            } else {
                $filteredLayananBaru[] = $item;
            }
        }

        if ($targetItem) {
            // Tambahkan ke daftar pemantauan SLA
            $newItemSla = [
                'id' => time(),
                'nomor_layanan' => $targetItem['nomor_layanan'],
                'jenis_layanan' => $targetItem['jenis_layanan'],
                'detail_layanan' => $targetItem['detail_layanan'],
                'pemohon' => $targetItem['pemohon'],
                'tanggal_disposisi' => now()->translatedFormat('d F Y'),
                'status_layanan' => 'Verifikasi Pertama',
                'pic' => $validated['pic'],
                'sla_hari' => 1,
                'sla_label' => 'Hari ke-1',
                'sla_status' => 'NORMAL',
                'sla_level' => 'normal',
                'batas_waktu' => now()->addDays(14)->translatedFormat('d F Y'),
                'tipe_badge' => $targetItem['tipe_badge'] ?? 'sky',
                'catatan' => $validated['catatan'] ?? null,
            ];

            array_unshift($pemantauanSla, $newItemSla);

            session([
                'kasi_layanan_baru' => $filteredLayananBaru,
                'kasi_pemantauan_sla' => $pemantauanSla,
            ]);

            return redirect()->route('kasi.dashboard')
                ->with('success', "Layanan {$targetItem['nomor_layanan']} berhasil didisposisikan ke Petugas: ".implode(', ', $validated['pic']));
        }

        return redirect()->route('kasi.dashboard')
            ->with('info', 'Layanan berhasil diproses.');
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

        $pemantauanSla = session('kasi_pemantauan_sla', $this->defaultPemantauanSla);
        $itemNomor = 'Layanan';

        foreach ($pemantauanSla as $key => $item) {
            if ((string) $item['id'] === (string) $id) {
                $itemNomor = $item['nomor_layanan'];
                if (! empty($validated['alasan_keterlambatan'])) {
                    $pemantauanSla[$key]['alasan_keterlambatan'] = $validated['alasan_keterlambatan'];
                    $pemantauanSla[$key]['komitmen_penyelesaian'] = $validated['komitmen_penyelesaian'];
                }
                break;
            }
        }

        session(['kasi_pemantauan_sla' => $pemantauanSla]);

        if (($validated['aksi'] ?? null) === 'tandai_selesai') {
            $pemantauanSla = array_values(array_filter($pemantauanSla, fn ($i) => (string) $i['id'] !== (string) $id));
            session(['kasi_pemantauan_sla' => $pemantauanSla]);

            return redirect()->route('kasi.dashboard')
                ->with('success', "Tindak lanjut {$itemNomor} berhasil: Status telah ditandai Selesai.");
        }

        return redirect()->route('kasi.dashboard')
            ->with('success', "Konfirmasi tindak lanjut untuk {$itemNomor} berhasil disimpan.");
    }

    /**
     * Hitung jumlah layanan baru yang perlu didisposisikan oleh KASI.
     */
    public static function getPerluDisposisiCount(): int
    {
        $instance = new self;
        $layananBaru = session('kasi_layanan_baru', $instance->defaultLayananBaru);

        try {
            $dbPermohonans = Permohonan::where('status', 'menunggu_verifikasi')->get();
            foreach ($dbPermohonans as $permohonan) {
                $nomor = $permohonan->nomor_permohonan ?: ('W15.AHU.AHU.1.AH.06.01-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT));
                $exists = collect($layananBaru)->contains('nomor_layanan', $nomor);
                if (! $exists) {
                    $layananBaru[] = ['nomor_layanan' => $nomor];
                }
            }
        } catch (\Throwable) {
            // Abaikan jika tabel belum ada atau koneksi gagal
        }

        return count($layananBaru);
    }
}
