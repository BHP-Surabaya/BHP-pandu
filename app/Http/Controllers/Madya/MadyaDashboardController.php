<?php

namespace App\Http\Controllers\Madya;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MadyaDashboardController extends Controller
{
    /**
     * Default list Layanan Wasiat Tertutup aktif untuk Kurator Madya.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultLayananList = [
        [
            'id' => 1,
            'nomor_layanan' => 'WST-2025-04098',
            'jenis_layanan' => 'Wasiat Tertutup',
            'detail_layanan' => 'Pembukaan Wasiat Tertutup',
            'nama_pemohon' => 'Dimas Mahendra',
            'nik' => '3578••••••••0098',
            'telepon' => '0812 8876 2104',
            'nomor_telepon' => '0812 8876 2104',
            'email' => 'dimas.mahendra@email.com',
            'alamat_domisili' => 'Kec. Genteng, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Soetrisno Hardjono',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 14:32',
            'sla_tanggal' => '23 Mei 2025',
            'sla_sisa' => '2 hari tersisa',
            'sla_progress' => 'Hari ke-12 dari 14',
            'sla_badge' => 'red',
            'jadwal_pembukaan' => 'Selasa, 20 Mei 2025',
            'waktu_pembukaan' => '10.00 WIB',
            'status_layanan' => 'Disetujui',
            'status_ba' => 'Draft BA Siap',
            'nomor_ba' => 'BA.01/WST/BHP.SBY/V/2025',
            'salinan_count' => 2,
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Sampul wasiat tertutup telah diperiksa keutuhannya dan siap dibuka bersama notaris.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,2 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,8 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Penyimpanan Wasiat Notaris.pdf', 'ukuran' => '2,5 MB', 'tipe' => 'PDF'],
                ['nama' => 'Surat Keterangan Wasiat AHU.pdf', 'ukuran' => '1,9 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'WST-2025-04081',
            'jenis_layanan' => 'Wasiat Tertutup',
            'detail_layanan' => 'Pembukaan Wasiat Tertutup',
            'nama_pemohon' => 'Sari Wulandari',
            'nik' => '3578••••••••0045',
            'telepon' => '0813 9012 4765',
            'nomor_telepon' => '0813 9012 4765',
            'email' => 'sari.w@email.com',
            'alamat_domisili' => 'Kec. Rungkut, Kota Surabaya',
            'nama_pewasiat' => 'Almh. Siti Hartini',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 11:18',
            'sla_tanggal' => '27 Mei 2025',
            'sla_sisa' => '6 hari tersisa',
            'sla_progress' => 'Hari ke-8 dari 14',
            'sla_badge' => 'yellow',
            'jadwal_pembukaan' => 'Kamis, 22 Mei 2025',
            'waktu_pembukaan' => '13.30 WIB',
            'status_layanan' => 'Menunggu persetujuan',
            'status_ba' => 'Belum Dibuat',
            'nomor_ba' => null,
            'salinan_count' => 0,
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Menunggu verifikasi fisik sampul wasiat di hadapan fungsional madya.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,1 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,7 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Penitipan Wasiat.pdf', 'ukuran' => '2,2 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'WST-2025-04072',
            'jenis_layanan' => 'Wasiat Tertutup',
            'detail_layanan' => 'Pembukaan Wasiat Tertutup',
            'nama_pemohon' => 'Fajar Nugraha',
            'nik' => '3578••••••••0012',
            'telepon' => '0857 1120 8843',
            'nomor_telepon' => '0857 1120 8843',
            'email' => 'fajar.n@email.com',
            'alamat_domisili' => 'Kec. Wonokromo, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Johannes Tan',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 16:05',
            'sla_tanggal' => '29 Mei 2025',
            'sla_sisa' => '9 hari tersisa',
            'sla_progress' => 'Hari ke-5 dari 14',
            'sla_badge' => 'green',
            'jadwal_pembukaan' => 'Senin, 26 Mei 2025',
            'waktu_pembukaan' => '09.00 WIB',
            'status_layanan' => 'Menunggu persetujuan',
            'status_ba' => 'Belum Dibuat',
            'nomor_ba' => null,
            'salinan_count' => 0,
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Berkas pendaftaran wasiat lengkap, jadwal telah terkonfirmasi.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,3 MB', 'tipe' => 'PDF'],
                ['nama' => 'Buku Nikah Pewasiat.pdf', 'ukuran' => '2,0 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,6 MB', 'tipe' => 'PDF'],
            ],
        ],
    ];

    /**
     * Default list permohonan yang perlu diverifikasi / ditelaah tingkat lanjut oleh Kurator Madya.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultVerifikasiList = [
        [
            'id' => 1,
            'nomor_layanan' => 'WST-2025-04098',
            'jenis_layanan' => 'Wasiat Tertutup',
            'detail_layanan' => 'Permohonan Pembukaan Wasiat Tertutup',
            'nama_pemohon' => 'Dimas Mahendra',
            'nik' => '3578••••••••0098',
            'email' => 'dimas.mahendra@email.com',
            'nomor_telepon' => '0812 8876 2104',
            'alamat_domisili' => 'Kec. Genteng, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Soetrisno Hardjono',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 14:32',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Pemeriksaan silsilah waris dan berkas telah divalidasi oleh Pertama & Muda.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,2 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,8 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Penyimpanan Wasiat Notaris.pdf', 'ukuran' => '2,5 MB', 'tipe' => 'PDF'],
                ['nama' => 'Surat Keterangan Wasiat AHU.pdf', 'ukuran' => '1,9 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'WST-2025-04081',
            'jenis_layanan' => 'Wasiat Tertutup',
            'detail_layanan' => 'Permohonan Pembukaan Wasiat Tertutup',
            'nama_pemohon' => 'Sari Wulandari',
            'nik' => '3578••••••••0045',
            'email' => 'sari.w@email.com',
            'nomor_telepon' => '0813 9012 4765',
            'alamat_domisili' => 'Kec. Rungkut, Kota Surabaya',
            'nama_pewasiat' => 'Almh. Siti Hartini',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 11:18',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 3,
            'dokumen_total' => 3,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Salinan akta wasiat dan surat keterangan kematian terlampir absah.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,1 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,7 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Penitipan Wasiat.pdf', 'ukuran' => '2,2 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'WST-2025-04072',
            'jenis_layanan' => 'Wasiat Tertutup',
            'detail_layanan' => 'Permohonan Pembukaan Wasiat Tertutup',
            'nama_pemohon' => 'Fajar Nugraha',
            'nik' => '3578••••••••0012',
            'email' => 'fajar.n@email.com',
            'nomor_telepon' => '0857 1120 8843',
            'alamat_domisili' => 'Kec. Wonokromo, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Johannes Tan',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 16:05',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 3,
            'dokumen_total' => 3,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Berkas kepemilikan dan buku nikah lengkap.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,3 MB', 'tipe' => 'PDF'],
                ['nama' => 'Buku Nikah Pewasiat.pdf', 'ukuran' => '2,0 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,6 MB', 'tipe' => 'PDF'],
            ],
        ],
    ];

    /**
     * Default history riwayat permohonan yang telah selesai diverifikasi oleh Kurator Madya.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultHistoryList = [
        [
            'id' => 101,
            'nomor_layanan' => 'WST-2025-04050',
            'jenis_layanan' => 'Wasiat Tertutup',
            'nama_pemohon' => 'Farhan Saputra, S.H.',
            'nama_pewasiat' => 'Alm. H. Achmad Dahlan',
            'tanggal_selesai' => '28 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Selesai & Diarsipkan',
            'nomor_ba' => 'BA.08/WST/BHP.SBY/V/2025',
            'salinan_dicetak' => '2 Salinan Selesai',
            'petugas_verifikator' => 'Inara, S.H., M.H.',
            'catatan' => 'Berita Acara telah dibuat, 2 salinan dicetak dan diserahkan serta berkas telah diarsipkan.',
        ],
        [
            'id' => 102,
            'nomor_layanan' => 'WST-2025-04041',
            'jenis_layanan' => 'Wasiat Tertutup',
            'nama_pemohon' => 'Anisa Rahmawati',
            'nama_pewasiat' => 'Almh. Hj. Fatimah',
            'tanggal_selesai' => '27 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Selesai & Diarsipkan',
            'nomor_ba' => 'BA.07/WST/BHP.SBY/V/2025',
            'salinan_dicetak' => '2 Salinan Selesai',
            'petugas_verifikator' => 'Inara, S.H., M.H.',
            'catatan' => 'Dokumen pembukaan wasiat tertutup telah ditandatangani dan diarsipkan rapi.',
        ],
        [
            'id' => 103,
            'nomor_layanan' => 'WST-2025-04033',
            'jenis_layanan' => 'Wasiat Tertutup',
            'nama_pemohon' => 'Budi Santoso',
            'nama_pewasiat' => 'Alm. Soegeng Prawiro',
            'tanggal_selesai' => '26 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Selesai & Diarsipkan',
            'nomor_ba' => 'BA.06/WST/BHP.SBY/V/2025',
            'salinan_dicetak' => '2 Salinan Selesai',
            'petugas_verifikator' => 'Inara, S.H., M.H.',
            'catatan' => 'Keutuhan sampul wasiat tertutup terkonfirmasi sah, berkas layanan lengkap.',
        ],
    ];

    /**
     * Hitung jumlah permohonan yang perlu ditindaklanjuti oleh Kurator Madya.
     */
    public static function getPerluVerifikasiCount(): int
    {
        $instance = new self;
        $sessionList = session('madya_layanan_list', $instance->defaultLayananList);

        $dbCount = Permohonan::where('status', 'menunggu_verifikasi')->count();

        return max(count($sessionList), $dbCount);
    }

    /**
     * Tampilkan halaman utama Daftar Layanan Wasiat Tertutup Kurator Madya.
     */
    public function index(Request $request): View
    {
        $layananList = session('madya_layanan_list', $this->defaultLayananList);

        // Gabungkan permohonan riil dari database bila ada
        $dbPermohonans = Permohonan::with(['user', 'pewasiat'])
            ->where('status', 'menunggu_verifikasi')
            ->get();

        foreach ($dbPermohonans as $permohonan) {
            $existing = collect($layananList)->firstWhere('nomor_layanan', $permohonan->nomor_permohonan ?? $permohonan->id);
            if (! $existing) {
                array_unshift($layananList, [
                    'id' => $permohonan->id,
                    'nomor_layanan' => $permohonan->nomor_permohonan ?? 'WST-2025-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT),
                    'jenis_layanan' => 'Wasiat Tertutup',
                    'nama_pemohon' => $permohonan->user?->name ?? 'Pemohon',
                    'nik' => $permohonan->user?->nik ?? '3578••••••••0000',
                    'telepon' => $permohonan->user?->phone ?? '0812 •••• 0000',
                    'email' => $permohonan->user?->email ?? 'pemohon@email.com',
                    'nama_pewasiat' => $permohonan->pewasiat?->nama ?? 'Pewasiat',
                    'sla_tanggal' => now()->addDays(7)->translatedFormat('d F Y'),
                    'sla_sisa' => '7 hari tersisa',
                    'sla_progress' => 'Hari ke-7 dari 14',
                    'sla_badge' => 'yellow',
                    'jadwal_pembukaan' => now()->addDays(3)->translatedFormat('l, d F Y'),
                    'waktu_pembukaan' => '10.00 WIB',
                    'status_layanan' => 'Menunggu Tindak Lanjut',
                    'status_ba' => 'Belum Dibuat',
                    'nomor_ba' => null,
                    'salinan_count' => 0,
                    'petugas_pertama' => 'Iman, S.H.',
                    'petugas_muda' => 'Lutfy, S.H.',
                    'catatan' => 'Permohonan masuk dari portal pemohon.',
                ]);
            }
        }

        $search = $request->input('search');
        if ($search) {
            $layananList = array_values(array_filter($layananList, function ($item) use ($search) {
                return str_contains(strtolower($item['nomor_layanan']), strtolower($search))
                    || str_contains(strtolower($item['nama_pemohon']), strtolower($search))
                    || str_contains(strtolower($item['jenis_layanan']), strtolower($search));
            }));
        }

        // Variabel untuk kompatibilitas tampilan
        $verifikasiList = $layananList;

        $stats = [
            'total_layanan' => count($layananList),
            'total_selesai' => count(session('madya_history_list', $this->defaultHistoryList)),
        ];

        return view('madya.dashboard', compact('layananList', 'verifikasiList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman Histori Layanan Kurator Madya.
     */
    public function history(Request $request): View
    {
        $historyList = session('madya_history_list', $this->defaultHistoryList);

        $search = $request->input('search');
        if ($search) {
            $historyList = array_values(array_filter($historyList, function ($item) use ($search) {
                return str_contains(strtolower($item['nomor_layanan']), strtolower($search))
                    || str_contains(strtolower($item['nama_pemohon']), strtolower($search))
                    || str_contains(strtolower($item['jenis_layanan']), strtolower($search));
            }));
        }

        $stats = [
            'total_riwayat' => count($historyList),
            'total_disetujui' => collect($historyList)->where('status_hasil', 'disetujui')->count(),
            'total_revisi' => collect($historyList)->where('status_hasil', 'revisi')->count(),
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
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $layananList = session('madya_layanan_list', $this->defaultLayananList);
        $nomorBa = $validated['nomor_ba'] ?: 'BA.'.str_pad((string) random_int(1, 99), 2, '0', STR_PAD_LEFT).'/WST/BHP.SBY/'.now()->format('m').'/'.now()->format('Y');

        foreach ($layananList as &$item) {
            if ((string) $item['id'] === (string) $id) {
                $item['nomor_ba'] = $nomorBa;
                $item['status_ba'] = 'BA Dibuat';
                $item['catatan'] = $validated['catatan'] ?? $item['catatan'];
                break;
            }
        }
        unset($item);

        session(['madya_layanan_list' => $layananList]);

        return redirect()->route('madya.dashboard')->with('success', "Berita Acara {$nomorBa} berhasil dibuat!");
    }

    /**
     * Catat cetak dokumen 2 salinan.
     */
    public function cetakDokumen(Request $request, string|int $id): RedirectResponse
    {
        $layananList = session('madya_layanan_list', $this->defaultLayananList);

        foreach ($layananList as &$item) {
            if ((string) $item['id'] === (string) $id) {
                $item['salinan_count'] = 2;
                $item['salinan_dicetak'] = '2 Salinan Selesai';
                break;
            }
        }
        unset($item);

        session(['madya_layanan_list' => $layananList]);

        return redirect()->route('madya.dashboard')->with('success', 'Dokumen Berita Acara berhasil dicetak sebanyak 2 salinan (1 untuk Pemohon, 1 untuk Arsip BHP).');
    }

    /**
     * Arsipkan berkas layanan dan pindahkan ke Histori Layanan.
     */
    public function arsipkan(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $layananList = session('madya_layanan_list', $this->defaultLayananList);
        $historyList = session('madya_history_list', $this->defaultHistoryList);

        $targetItem = null;
        $newLayananList = [];

        foreach ($layananList as $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetItem = $item;
            } else {
                $newLayananList[] = $item;
            }
        }

        if ($targetItem) {
            $nomorBa = $targetItem['nomor_ba'] ?? ('BA.'.str_pad((string) random_int(1, 99), 2, '0', STR_PAD_LEFT).'/WST/BHP.SBY/'.now()->format('m').'/'.now()->format('Y'));
            $newHistoryItem = [
                'id' => time(),
                'nomor_layanan' => $targetItem['nomor_layanan'],
                'jenis_layanan' => $targetItem['jenis_layanan'],
                'nama_pemohon' => $targetItem['nama_pemohon'],
                'nama_pewasiat' => $targetItem['nama_pewasiat'],
                'tanggal_selesai' => now()->translatedFormat('d F Y'),
                'status_hasil' => 'disetujui',
                'status_label' => 'Selesai & Diarsipkan',
                'nomor_ba' => $nomorBa,
                'salinan_dicetak' => '2 Salinan Selesai',
                'petugas_verifikator' => auth()->user()?->name ?? 'Inara, S.H., M.H.',
                'catatan' => $validated['catatan'] ?? 'Berita Acara telah dibuat, 2 salinan dicetak dan berkas resmi diarsipkan.',
            ];

            array_unshift($historyList, $newHistoryItem);

            session([
                'madya_layanan_list' => $newLayananList,
                'madya_history_list' => $historyList,
            ]);

            return redirect()->route('madya.dashboard')->with('success', "Layanan {$targetItem['nomor_layanan']} berhasil diarsipkan dan masuk ke Histori Layanan.");
        }

        return redirect()->route('madya.dashboard');
    }

    /**
     * Tampilkan detail verifikasi persyaratan sesuai ID layanan.
     */
    public function show(string|int $id): View|RedirectResponse
    {
        $layananList = session('madya_layanan_list', $this->defaultLayananList);
        $layanan = collect($layananList)->firstWhere('id', (int) $id)
            ?? collect($layananList)->firstWhere('id', (string) $id);

        if (! $layanan) {
            $verifikasiList = session('madya_verifikasi_list', $this->defaultVerifikasiList);
            $layanan = collect($verifikasiList)->firstWhere('id', (int) $id)
                ?? collect($verifikasiList)->firstWhere('id', (string) $id);
        }

        if (! $layanan) {
            $permohonan = Permohonan::with(['user', 'pewasiat', 'dokumens', 'voucher'])->find($id);
            if ($permohonan) {
                $dokumenList = [];
                $docLabels = [
                    'ktp' => 'KTP Pemohon.pdf',
                    'surat_kuasa' => 'Surat Kuasa.pdf',
                    'akta_kematian' => 'Akta Kematian Pewaris.pdf',
                    'surat_keterangan_wasiat' => 'Surat Keterangan Wasiat DPW.pdf',
                    'akta_penyimpanan_wasiat' => 'Akta Penyimpanan Wasiat Notaris.pdf',
                    'buku_nikah' => 'Buku Nikah Pewasiat.pdf',
                    'akta_lahir_ktp_kk' => 'Kartu Keluarga & Akta Lahir.pdf',
                    'dokumen_lainnya' => 'Dokumen Tambahan.pdf',
                ];

                foreach ($permohonan->dokumens as $dok) {
                    $namaFile = $docLabels[$dok->jenis_dokumen] ?? (basename($dok->file_path) ?: 'Dokumen Persyaratan.pdf');
                    $dokumenList[] = [
                        'nama' => $namaFile,
                        'ukuran' => '1,5 MB',
                        'tipe' => 'PDF',
                        'url' => Storage::url($dok->file_path),
                    ];
                }

                if (empty($dokumenList)) {
                    $dokumenList = [
                        ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,2 MB', 'tipe' => 'PDF'],
                        ['nama' => 'Akta Kematian Pewaris.pdf', 'ukuran' => '1,8 MB', 'tipe' => 'PDF'],
                        ['nama' => 'Surat Keterangan Wasiat DPW.pdf', 'ukuran' => '2,1 MB', 'tipe' => 'PDF'],
                        ['nama' => 'Akta Penyimpanan Wasiat.pdf', 'ukuran' => '2,5 MB', 'tipe' => 'PDF'],
                    ];
                }

                $userNik = $permohonan->user?->nik;
                $maskedNik = $userNik ? (strlen($userNik) > 8 ? substr($userNik, 0, 4).'••••••••'.substr($userNik, -4) : $userNik) : '3578••••••••0006';

                $userPhone = $permohonan->user?->phone;
                $maskedPhone = $userPhone ? (strlen($userPhone) > 8 ? substr($userPhone, 0, 4).' •••• '.substr($userPhone, -4) : $userPhone) : '0812 •••• 8841';

                $layanan = [
                    'id' => $permohonan->id,
                    'nomor_layanan' => $permohonan->nomor_permohonan ?? 'WST-2025-'.str_pad((string) $permohonan->id, 5, '0', STR_PAD_LEFT),
                    'jenis_layanan' => 'Wasiat Tertutup',
                    'detail_layanan' => 'Pembukaan Wasiat Tertutup',
                    'nama_pemohon' => $permohonan->user?->name ?? 'Pemohon',
                    'nik' => $maskedNik,
                    'email' => $permohonan->user?->email ?? 'pemohon@email.com',
                    'nomor_telepon' => $maskedPhone,
                    'alamat_domisili' => $permohonan->user?->alamat_domisili ?? 'Kec. Genteng, Kota Surabaya',
                    'nama_pewasiat' => $permohonan->pewasiat?->nama_lengkap ?? 'Pewasiat',
                    'tanggal_masuk' => $permohonan->created_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
                    'waktu_masuk' => $permohonan->created_at?->format('H:i') ? 'Pukul '.$permohonan->created_at->format('H:i') : 'Pukul 10:00',
                    'status_verifikasi' => 'menunggu_telaah',
                    'status_label' => 'Menunggu Telaah Madya',
                    'dokumen_count' => count($dokumenList),
                    'dokumen_total' => count($dokumenList),
                    'tipe_badge' => 'purple',
                    'catatan' => 'Permohonan masuk dari portal pemohon.',
                    'dokumen_list' => $dokumenList,
                ];
            }
        }

        if (! $layanan) {
            $layanan = $this->defaultLayananList[0] ?? null;
        }

        if (! $layanan) {
            return redirect()->route('madya.dashboard')->with('error', 'Layanan tidak ditemukan.');
        }

        return view('madya.verifikasi.show', compact('layanan'));
    }

    /**
     * Proses telaah/verifikasi persyaratan (setujui / revisi) oleh Kurator Madya.
     */
    public function tindakLanjut(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:disetujui,revisi,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $layananList = session('madya_layanan_list', $this->defaultLayananList);
        $historyList = session('madya_history_list', $this->defaultHistoryList);

        $targetItem = null;
        $newLayananList = [];

        foreach ($layananList as $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetItem = $item;
            } else {
                $newLayananList[] = $item;
            }
        }

        if ($targetItem) {
            $nomorBa = $targetItem['nomor_ba'] ?? ('BA.'.str_pad((string) random_int(1, 99), 2, '0', STR_PAD_LEFT).'/WST/BHP.SBY/'.now()->format('m').'/'.now()->format('Y'));
            $newHistoryItem = [
                'id' => time(),
                'nomor_layanan' => $targetItem['nomor_layanan'],
                'jenis_layanan' => $targetItem['jenis_layanan'],
                'nama_pemohon' => $targetItem['nama_pemohon'],
                'nama_pewasiat' => $targetItem['nama_pewasiat'],
                'tanggal_selesai' => now()->translatedFormat('d F Y'),
                'status_hasil' => $validated['status'],
                'status_label' => $validated['status'] === 'disetujui' ? 'Disetujui Madya' : 'Perlu Revisi Pemohon',
                'nomor_ba' => $nomorBa,
                'salinan_dicetak' => '2 Salinan',
                'petugas_verifikator' => auth()->user()?->name ?? 'Inara, S.H., M.H.',
                'catatan' => $validated['catatan'] ?? ($validated['status'] === 'disetujui' ? 'Dokumen persyaratan lengkap, absah, dan disetujui Kurator Madya.' : 'Terdapat kekurangan berkas persyaratan.'),
            ];

            array_unshift($historyList, $newHistoryItem);

            session([
                'madya_layanan_list' => $newLayananList,
                'madya_history_list' => $historyList,
            ]);

            // Sinkronkan status permohonan di DB jika ada
            $permohonan = Permohonan::find($id);
            if ($permohonan) {
                $permohonan->update([
                    'status' => $validated['status'] === 'disetujui' ? 'selesai' : 'revisi',
                    'catatan_revisi' => $validated['catatan'] ?? null,
                ]);
            }

            $pesan = $validated['status'] === 'disetujui'
                ? "Permohonan {$targetItem['nomor_layanan']} berhasil diverifikasi dan disetujui Kurator Madya."
                : "Permohonan {$targetItem['nomor_layanan']} telah dikembalikan untuk perbaikan berkas.";

            return redirect()->route('madya.dashboard')->with('success', $pesan);
        }

        return redirect()->route('madya.dashboard');
    }
}
