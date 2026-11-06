<?php

namespace App\Http\Controllers\Muda;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MudaDashboardController extends Controller
{
    /**
     * Default list permohonan yang perlu diverifikasi persyaratannya oleh Kurator Pertama.
     * Ditampilkan di Tab 1: Hasil Verifikasi Pertama.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultVerifikasiList = [
        [
            'id' => 1,
            'nomor_layanan' => 'W15.AHU.AH.06.09-00024',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan Surat Keterangan Hak Waris',
            'nama_pemohon' => 'Nadia Prameswari',
            'nik' => '3578••••••••0006',
            'email' => 'nadia.p@email.com',
            'nomor_telepon' => '0812 •••• 8841',
            'alamat_domisili' => 'Kec. Genteng, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Soetrisno',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 14:32',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Disetujui Pertama',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'sky',
            'petugas_pertama' => 'Iman, S.H.',
            'catatan' => 'Pemeriksaan silsilah ahli waris dan KTP pemohon telah lengkap.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,2 MB', 'tipe' => 'PDF'],
                ['nama' => 'Kartu Keluarga.pdf', 'ukuran' => '2,4 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewaris.pdf', 'ukuran' => '1,8 MB', 'tipe' => 'PDF'],
                ['nama' => 'Surat Pernyataan Ahli Waris.pdf', 'ukuran' => '3,1 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'W15.AHU.AH.06.01-00023',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat Terbuka',
            'nama_pemohon' => 'Ahmad Fadli',
            'nik' => '3578••••••••0012',
            'email' => 'ahmad.fadli@email.com',
            'nomor_telepon' => '0813 •••• 9921',
            'alamat_domisili' => 'Kec. Rungkut, Kota Surabaya',
            'nama_pewasiat' => 'Almh. Siti Hartini',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 11:18',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Disetujui Pertama',
            'dokumen_count' => 5,
            'dokumen_total' => 5,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'catatan' => 'Salinan akta wasiat terbuka dan surat kematian terlampir absah.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,1 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,9 MB', 'tipe' => 'PDF'],
                ['nama' => 'Surat Keterangan Wasiat AHU.pdf', 'ukuran' => '2,5 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Penyimpanan Wasiat.pdf', 'ukuran' => '2,1 MB', 'tipe' => 'PDF'],
                ['nama' => 'Kartu Keluarga Ahli Waris.pdf', 'ukuran' => '1,6 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.AH.06.09-00022',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan Surat Keterangan Hak Waris',
            'nama_pemohon' => 'Rizka Amelia',
            'nik' => '3578••••••••0045',
            'email' => 'rizka.amelia@email.com',
            'nomor_telepon' => '0857 •••• 1234',
            'alamat_domisili' => 'Kec. Wonokromo, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Johannes Tan',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 16:05',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Disetujui Pertama',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'sky',
            'petugas_pertama' => 'Iman, S.H.',
            'catatan' => 'Berkas kepemilikan dan buku nikah lengkap.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,3 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewaris.pdf', 'ukuran' => '1,7 MB', 'tipe' => 'PDF'],
                ['nama' => 'Buku Nikah Pewaris.pdf', 'ukuran' => '2,2 MB', 'tipe' => 'PDF'],
                ['nama' => 'Kartu Keluarga.pdf', 'ukuran' => '1,5 MB', 'tipe' => 'PDF'],
            ],
        ],
        [
            'id' => 4,
            'nomor_layanan' => 'W15.AHU.AH.06.01-00021',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pelaporan Wasiat',
            'nama_pemohon' => 'Bambang Suryono',
            'nik' => '3578••••••••0098',
            'email' => 'bambang.suryono@email.com',
            'nomor_telepon' => '0811 •••• 5678',
            'alamat_domisili' => 'Kec. Gubeng, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Raden Mas Wardoyo',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 10:40',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Disetujui Pertama',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'catatan' => 'Pemeriksaan sampul dan laporan akta wasiat telah diverifikasi.',
            'dokumen_list' => [
                ['nama' => 'KTP Pemohon.pdf', 'ukuran' => '1,0 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Kematian Pewasiat.pdf', 'ukuran' => '1,8 MB', 'tipe' => 'PDF'],
                ['nama' => 'Surat Keterangan Wasiat AHU.pdf', 'ukuran' => '2,0 MB', 'tipe' => 'PDF'],
                ['nama' => 'Akta Penyimpanan Wasiat Notaris.pdf', 'ukuran' => '2,8 MB', 'tipe' => 'PDF'],
            ],
        ],
    ];

    /**
     * Default list jadwal pembukaan wasiat sesuai wireframe pengguna.
     * Ditampilkan di Tab 2: Penjadwalan Pembukaan.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultJadwalList = [
        [
            'id' => 1,
            'no' => '01',
            'nomor_layanan' => 'WST-2025-04098',
            'jenis_layanan' => 'Wasiat Terbuka',
            'detail_layanan' => 'Permohonan Pembukaan Wasiat Terbuka',
            'nama_pemohon' => 'Dimas Mahendra',
            'nik' => '3578••••••••0015',
            'email' => 'dimas.m@email.com',
            'nomor_telepon' => '0812 8876 2104',
            'alamat_domisili' => 'Kec. Tegalsari, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Hendra Mahendra',
            'batas_sla' => '23 Mei 2025',
            'sla_hari_tersisa' => 2,
            'sla_hari_ke' => 12,
            'sla_total_hari' => 14,
            'sla_level' => 'danger', // red dot
            'jadwal_pemohon_tanggal' => 'Selasa, 20 Mei 2025',
            'jadwal_pemohon_waktu' => '10.00 WIB',
            'lokasi' => 'Ruang Sidang Balai Harta Peninggalan Surabaya',
            'link_zoom' => 'https://zoom.us/j/bhp-surabaya-wst04098',
            'status' => 'disetujui',
            'status_label' => 'Disetujui',
            'status_level' => 'success',
            'catatan' => 'Semua saksi, ahli waris, dan notaris telah dikonfirmasi kehadirannya.',
        ],
        [
            'id' => 2,
            'no' => '02',
            'nomor_layanan' => 'WST-2025-04081',
            'jenis_layanan' => 'Wasiat Terbuka',
            'detail_layanan' => 'Permohonan Pembukaan Wasiat Terbuka',
            'nama_pemohon' => 'Sari Wulandari',
            'nik' => '3578••••••••0029',
            'email' => 'sari.w@email.com',
            'nomor_telepon' => '0813 9012 4765',
            'alamat_domisili' => 'Kec. Sukolilo, Kota Surabaya',
            'nama_pewasiat' => 'Almh. Ny. Wulandari',
            'batas_sla' => '27 Mei 2025',
            'sla_hari_tersisa' => 6,
            'sla_hari_ke' => 8,
            'sla_total_hari' => 14,
            'sla_level' => 'warning', // yellow dot
            'jadwal_pemohon_tanggal' => 'Kamis, 22 Mei 2025',
            'jadwal_pemohon_waktu' => '13.30 WIB',
            'lokasi' => 'Ruang Rapat Utama BHP Surabaya / Hybrid Zoom',
            'link_zoom' => null,
            'status' => 'menunggu_persetujuan',
            'status_label' => 'Menunggu persetujuan',
            'status_level' => 'warning',
            'catatan' => 'Pemohon meminta sesi hybrid bersama kuasa hukum keluarga.',
        ],
        [
            'id' => 3,
            'no' => '03',
            'nomor_layanan' => 'WST-2025-04072',
            'jenis_layanan' => 'Wasiat Terbuka',
            'detail_layanan' => 'Permohonan Pembukaan Wasiat Terbuka',
            'nama_pemohon' => 'Fajar Nugraha',
            'nik' => '3578••••••••0074',
            'email' => 'fajar.n@email.com',
            'nomor_telepon' => '0857 1120 8843',
            'alamat_domisili' => 'Kec. Gubeng, Kota Surabaya',
            'nama_pewasiat' => 'Alm. Nugraha Prawira',
            'batas_sla' => '29 Mei 2025',
            'sla_hari_tersisa' => 9,
            'sla_hari_ke' => 5,
            'sla_total_hari' => 14,
            'sla_level' => 'normal', // green dot
            'jadwal_pemohon_tanggal' => 'Senin, 26 Mei 2025',
            'jadwal_pemohon_waktu' => '09.00 WIB',
            'lokasi' => 'Ruang Sidang Balai Harta Peninggalan Surabaya',
            'link_zoom' => null,
            'status' => 'menunggu_persetujuan',
            'status_label' => 'Menunggu persetujuan',
            'status_level' => 'warning',
            'catatan' => 'Menunggu konfirmasi kehadiran notaris penyimpan wasiat tertutup.',
        ],
    ];

    /**
     * Default list penerbitan dokumen sesuai Tab 3.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultPenerbitanList = [
        [
            'id' => 1,
            'nomor_layanan' => 'WST-2025-04065',
            'jenis_layanan' => 'Wasiat Terbuka',
            'nama_pemohon' => 'Hendra Gunawan',
            'nomor_telepon' => '0812 7765 4321',
            'dokumen_terbit' => 'Berita Acara Pembukaan Wasiat',
            'tanggal_pembukaan' => '15 Mei 2025',
            'status_dokumen' => 'Draft Siap Diterbitkan',
            'status_level' => 'info',
            'nomor_akta' => 'BA-WST/V/2025/BHP.SBY-04065',
            'catatan' => 'Pembukaan selesai dihadiri 2 saksi dan notaris pembuat akta.',
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'WST-2025-04052',
            'jenis_layanan' => 'Wasiat Tertutup',
            'nama_pemohon' => 'Siska Melati',
            'nomor_telepon' => '0813 3344 5566',
            'dokumen_terbit' => 'Akta Pembukaan & Penyerahan Wasiat',
            'tanggal_pembukaan' => '12 Mei 2025',
            'status_dokumen' => 'Menunggu Tanda Tangan Kasi',
            'status_level' => 'warning',
            'nomor_akta' => 'BA-WST/V/2025/BHP.SBY-04052',
            'catatan' => 'Draft berita acara telah diparaf oleh Kurator Muda.',
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.06.01-00019',
            'jenis_layanan' => 'SKHW',
            'nama_pemohon' => 'Ratna Kusumawati',
            'nomor_telepon' => '0856 9988 7766',
            'dokumen_terbit' => 'Surat Keterangan Hak Waris (SKHW)',
            'tanggal_pembukaan' => '10 Mei 2025',
            'status_dokumen' => 'Selesai & Terdistribusi',
            'status_level' => 'success',
            'nomor_akta' => 'SKHW/V/2025/BHP.SBY-00019',
            'catatan' => 'Salinan resmi telah diunggah dan terkirim ke pemohon.',
        ],
    ];

    /**
     * Default history riwayat permohonan yang telah selesai diverifikasi oleh Kurator Muda.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $defaultHistoryList = [
        [
            'id' => 101,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00004',
            'jenis_layanan' => 'Pendaftaran Wasiat',
            'nama_pemohon' => 'Farhan Saputra, S.H.',
            'nama_pewasiat' => 'Alm. H. Achmad Dahlan',
            'tanggal_selesai' => '28 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Berkas Terverifikasi',
            'petugas_verifikator' => 'Lutfy, S.H.',
            'catatan' => 'Semua dokumen sah dan sesuai aslinya.',
        ],
        [
            'id' => 102,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00003',
            'jenis_layanan' => 'Permohonan SKHW',
            'nama_pemohon' => 'Anisa Rahmawati',
            'nama_pewasiat' => 'Almh. Hj. Fatimah',
            'tanggal_selesai' => '27 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Berkas Terverifikasi',
            'petugas_verifikator' => 'Lutfy, S.H.',
            'catatan' => 'Silsilah waris telah divalidasi dengan data Disdukcapil.',
        ],
        [
            'id' => 103,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00003',
            'jenis_layanan' => 'Wasiat Tertutup',
            'nama_pemohon' => 'Budi Santoso',
            'nama_pewasiat' => 'Alm. Soegeng Prawiro',
            'tanggal_selesai' => '26 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Berkas Terverifikasi',
            'petugas_verifikator' => 'Lutfy, S.H.',
            'catatan' => 'Sampul wasiat tertutup utuh dan tersegel resmi.',
        ],
    ];

    /**
     * Hitung jumlah permohonan yang perlu diverifikasi persyaratannya.
     */
    public static function getPerluVerifikasiCount(): int
    {
        $instance = new self;
        $sessionList = session('muda_jadwal_list', $instance->defaultJadwalList);

        return count($sessionList);
    }

    /**
     * Tampilkan halaman utama Verifikasi Lanjutan Kurator Muda.
     */
    public function index(Request $request): View
    {
        $verifikasiList = session('muda_verifikasi_list', $this->defaultVerifikasiList);
        $jadwalList = session('muda_jadwal_list', $this->defaultJadwalList);
        $penerbitanList = session('muda_penerbitan_list', $this->defaultPenerbitanList);

        // Gabungkan permohonan riil dari database bila ada ke daftar verifikasi
        $dbPermohonans = Permohonan::with(['user', 'pewasiat'])
            ->where('status', 'menunggu_verifikasi')
            ->get();

        foreach ($dbPermohonans as $permohonan) {
            $existing = collect($verifikasiList)->firstWhere('nomor_layanan', $permohonan->nomor_permohonan ?? $permohonan->id);
            if (! $existing) {
                array_unshift($verifikasiList, [
                    'id' => $permohonan->id,
                    'nomor_layanan' => $permohonan->nomor_permohonan ?? 'W15.AHU-'.str_pad($permohonan->id, 5, '0', STR_PAD_LEFT),
                    'jenis_layanan' => 'Pendaftaran Wasiat',
                    'nama_pemohon' => $permohonan->user?->name ?? 'Pemohon',
                    'nama_pewasiat' => $permohonan->pewasiat?->nama ?? 'Pewasiat',
                    'tanggal_masuk' => $permohonan->created_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y'),
                    'status_verifikasi' => 'menunggu_telaah',
                    'status_label' => 'Disetujui Pertama',
                    'dokumen_count' => 4,
                    'dokumen_total' => 4,
                    'tipe_badge' => 'purple',
                    'petugas_pertama' => 'Iman, S.H.',
                    'catatan' => 'Permohonan masuk dari portal pemohon.',
                ]);
            }
        }

        $search = $request->input('search');
        if ($search) {
            $searchLower = strtolower($search);
            $jadwalList = array_values(array_filter($jadwalList, function ($item) use ($searchLower) {
                return str_contains(strtolower($item['nomor_layanan'] ?? ''), $searchLower)
                    || str_contains(strtolower($item['nama_pemohon'] ?? ''), $searchLower)
                    || str_contains(strtolower($item['jenis_layanan'] ?? ''), $searchLower);
            }));

            $verifikasiList = array_values(array_filter($verifikasiList, function ($item) use ($searchLower) {
                return str_contains(strtolower($item['nomor_layanan'] ?? ''), $searchLower)
                    || str_contains(strtolower($item['nama_pemohon'] ?? ''), $searchLower)
                    || str_contains(strtolower($item['jenis_layanan'] ?? ''), $searchLower);
            }));
        }

        $stats = [
            'total_verifikasi' => count($verifikasiList),
            'total_jadwal' => count($jadwalList),
            'total_penerbitan' => count($penerbitanList),
            'total_selesai' => count(session('muda_history_list', $this->defaultHistoryList)),
        ];

        return view('muda.dashboard', compact('verifikasiList', 'jadwalList', 'penerbitanList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman History Verifikasi Kurator Muda.
     */
    public function history(Request $request): View
    {
        $historyList = session('muda_history_list', $this->defaultHistoryList);

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

        return view('muda.history', compact('historyList', 'stats', 'search'));
    }

    /**
     * Tampilkan detail verifikasi persyaratan sesuai ID layanan.
     */
    public function show(string|int $id): View|RedirectResponse
    {
        $verifikasiList = session('muda_verifikasi_list', $this->defaultVerifikasiList);
        $layanan = collect($verifikasiList)->firstWhere('id', (int) $id)
            ?? collect($verifikasiList)->firstWhere('id', (string) $id);

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
                    'nomor_layanan' => $permohonan->nomor_permohonan ?? 'W15.AHU-'.str_pad($permohonan->id, 5, '0', STR_PAD_LEFT),
                    'jenis_layanan' => 'Wasiat',
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
                    'status_label' => 'Disetujui Pertama',
                    'dokumen_count' => count($dokumenList),
                    'dokumen_total' => count($dokumenList),
                    'tipe_badge' => 'purple',
                    'petugas_pertama' => 'Iman, S.H.',
                    'catatan' => 'Permohonan masuk dari portal pemohon.',
                    'dokumen_list' => $dokumenList,
                ];
            }
        }

        if (! $layanan) {
            $layanan = $verifikasiList[0] ?? null;
        }

        if (! $layanan) {
            return redirect()->route('muda.dashboard')->with('error', 'Layanan tidak ditemukan.');
        }

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

        $verifikasiList = session('muda_verifikasi_list', $this->defaultVerifikasiList);
        $historyList = session('muda_history_list', $this->defaultHistoryList);

        $targetItem = null;
        $newVerifikasiList = [];

        foreach ($verifikasiList as $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetItem = $item;
            } else {
                $newVerifikasiList[] = $item;
            }
        }

        if ($targetItem) {
            $newHistoryItem = [
                'id' => time(),
                'nomor_layanan' => $targetItem['nomor_layanan'],
                'jenis_layanan' => $targetItem['jenis_layanan'],
                'nama_pemohon' => $targetItem['nama_pemohon'],
                'nama_pewasiat' => $targetItem['nama_pewasiat'],
                'tanggal_selesai' => now()->translatedFormat('d F Y'),
                'status_hasil' => $validated['status'],
                'status_label' => $validated['status'] === 'disetujui' ? 'Berkas Terverifikasi' : 'Perlu Revisi Pemohon',
                'petugas_verifikator' => auth()->user()?->name ?? 'Lutfy, S.H.',
                'catatan' => $validated['catatan'] ?? ($validated['status'] === 'disetujui' ? 'Dokumen persyaratan lengkap dan absah.' : 'Terdapat kekurangan berkas persyaratan.'),
            ];

            array_unshift($historyList, $newHistoryItem);

            session([
                'muda_verifikasi_list' => $newVerifikasiList,
                'muda_history_list' => $historyList,
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
                ? "Permohonan {$targetItem['nomor_layanan']} berhasil diverifikasi dan disetujui."
                : "Permohonan {$targetItem['nomor_layanan']} telah dikembalikan untuk perbaikan berkas.";

            return redirect()->route('muda.dashboard')->with('success', $pesan);
        }

        return redirect()->route('muda.dashboard');
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

        $jadwalList = session('muda_jadwal_list', $this->defaultJadwalList);
        $penerbitanList = session('muda_penerbitan_list', $this->defaultPenerbitanList);

        $targetItem = null;
        foreach ($jadwalList as $key => $item) {
            if ((string) $item['id'] === (string) $id) {
                $targetItem = $item;

                if ($validated['status'] === 'disetujui') {
                    $jadwalList[$key]['status'] = 'disetujui';
                    $jadwalList[$key]['status_label'] = 'Disetujui';
                    $jadwalList[$key]['status_level'] = 'success';
                    if (! empty($validated['lokasi'])) {
                        $jadwalList[$key]['lokasi'] = $validated['lokasi'];
                    }
                    if (! empty($validated['catatan'])) {
                        $jadwalList[$key]['catatan'] = $validated['catatan'];
                    }
                } elseif ($validated['status'] === 'reschedule') {
                    $jadwalList[$key]['status'] = 'menunggu_persetujuan';
                    $jadwalList[$key]['status_label'] = 'Jadwal Disesuaikan';
                    $jadwalList[$key]['status_level'] = 'warning';
                    if (! empty($validated['jadwal_tanggal'])) {
                        $jadwalList[$key]['jadwal_pemohon_tanggal'] = $validated['jadwal_tanggal'];
                    }
                    if (! empty($validated['jadwal_waktu'])) {
                        $jadwalList[$key]['jadwal_pemohon_waktu'] = $validated['jadwal_waktu'];
                    }
                    if (! empty($validated['catatan'])) {
                        $jadwalList[$key]['catatan'] = $validated['catatan'];
                    }
                } elseif ($validated['status'] === 'terbitkan') {
                    // Pindahkan / tambahkan ke Penerbitan Dokumen
                    $penerbitanList[] = [
                        'id' => time(),
                        'nomor_layanan' => $item['nomor_layanan'],
                        'jenis_layanan' => $item['jenis_layanan'],
                        'nama_pemohon' => $item['nama_pemohon'],
                        'nomor_telepon' => $item['nomor_telepon'],
                        'dokumen_terbit' => 'Berita Acara Pembukaan Wasiat',
                        'tanggal_pembukaan' => now()->translatedFormat('d F Y'),
                        'status_dokumen' => 'Draft Siap Diterbitkan',
                        'status_level' => 'info',
                        'nomor_akta' => 'BA-WST/'.date('m').'/'.date('Y').'/BHP.SBY-'.str_pad($item['id'], 5, '0', STR_PAD_LEFT),
                        'catatan' => $validated['catatan'] ?? 'Pembukaan telah selesai dilaksanakan.',
                    ];
                    unset($jadwalList[$key]);
                    $jadwalList = array_values($jadwalList);
                }
                break;
            }
        }

        session([
            'muda_jadwal_list' => $jadwalList,
            'muda_penerbitan_list' => $penerbitanList,
        ]);

        $pesan = match ($validated['status']) {
            'disetujui' => "Jadwal pembukaan wasiat {$targetItem['nomor_layanan']} berhasil disetujui.",
            'reschedule' => "Jadwal pembukaan wasiat {$targetItem['nomor_layanan']} berhasil diperbarui.",
            'terbitkan' => "Layanan {$targetItem['nomor_layanan']} berhasil diteruskan ke tahap Penerbitan Dokumen.",
        };

        return redirect()->route('muda.dashboard')->with('success', $pesan);
    }

    /**
     * Proses penerbitan dokumen atau pengiriman ke Kasi.
     */
    public function terbitkanDokumen(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status_dokumen' => ['required', 'string'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $penerbitanList = session('muda_penerbitan_list', $this->defaultPenerbitanList);

        foreach ($penerbitanList as $key => $item) {
            if ((string) $item['id'] === (string) $id) {
                $penerbitanList[$key]['status_dokumen'] = $validated['status_dokumen'];
                $penerbitanList[$key]['status_level'] = $validated['status_dokumen'] === 'Selesai & Terdistribusi' ? 'success' : 'warning';
                if (! empty($validated['catatan'])) {
                    $penerbitanList[$key]['catatan'] = $validated['catatan'];
                }
                break;
            }
        }

        session(['muda_penerbitan_list' => $penerbitanList]);

        return redirect()->route('muda.dashboard')->with('success', 'Status penerbitan dokumen berhasil diperbarui.');
    }
}
