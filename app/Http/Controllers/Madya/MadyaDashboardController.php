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
     * Default list permohonan yang perlu diverifikasi / ditelaah tingkat lanjut oleh Kurator Madya.
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
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'sky',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
            'catatan' => 'Pemeriksaan silsilah waris dan berkas telah divalidasi oleh Pertama & Muda.',
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
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 5,
            'dokumen_total' => 5,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
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
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'sky',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
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
            'status_label' => 'Menunggu Telaah Madya',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'purple',
            'petugas_pertama' => 'Iman, S.H.',
            'petugas_muda' => 'Lutfy, S.H.',
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
     * Default history riwayat permohonan yang telah selesai diverifikasi oleh Kurator Madya.
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
            'status_label' => 'Disetujui Madya',
            'petugas_verifikator' => 'Inara, S.H., M.H.',
            'catatan' => 'Semua dokumen sah, terverifikasi, dan siap diteruskan ke Kasi.',
        ],
        [
            'id' => 102,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00003',
            'jenis_layanan' => 'Permohonan SKHW',
            'nama_pemohon' => 'Anisa Rahmawati',
            'nama_pewasiat' => 'Almh. Hj. Fatimah',
            'tanggal_selesai' => '27 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Disetujui Madya',
            'petugas_verifikator' => 'Inara, S.H., M.H.',
            'catatan' => 'Silsilah waris telah divalidasi keabsahannya.',
        ],
        [
            'id' => 103,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00003',
            'jenis_layanan' => 'Wasiat Tertutup',
            'nama_pemohon' => 'Budi Santoso',
            'nama_pewasiat' => 'Alm. Soegeng Prawiro',
            'tanggal_selesai' => '26 Mei 2025',
            'status_hasil' => 'disetujui',
            'status_label' => 'Disetujui Madya',
            'petugas_verifikator' => 'Inara, S.H., M.H.',
            'catatan' => 'Keutuhan sampul wasiat tertutup terkonfirmasi sah.',
        ],
    ];

    /**
     * Hitung jumlah permohonan yang perlu diverifikasi oleh Kurator Madya.
     */
    public static function getPerluVerifikasiCount(): int
    {
        $instance = new self;
        $sessionList = session('madya_verifikasi_list', $instance->defaultVerifikasiList);

        $dbCount = Permohonan::where('status', 'menunggu_verifikasi')->count();

        return max(count($sessionList), $dbCount);
    }

    /**
     * Tampilkan halaman utama Verifikasi Persyaratan Kurator Madya.
     */
    public function index(Request $request): View
    {
        $verifikasiList = session('madya_verifikasi_list', $this->defaultVerifikasiList);

        // Gabungkan permohonan riil dari database bila ada
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
                    'status_label' => 'Menunggu Telaah Madya',
                    'dokumen_count' => 4,
                    'dokumen_total' => 4,
                    'tipe_badge' => 'purple',
                    'catatan' => 'Permohonan masuk dari portal pemohon.',
                ]);
            }
        }

        $search = $request->input('search');
        if ($search) {
            $verifikasiList = array_values(array_filter($verifikasiList, function ($item) use ($search) {
                return str_contains(strtolower($item['nomor_layanan']), strtolower($search))
                    || str_contains(strtolower($item['nama_pemohon']), strtolower($search))
                    || str_contains(strtolower($item['jenis_layanan']), strtolower($search));
            }));
        }

        $stats = [
            'total_perlu_verifikasi' => count($verifikasiList),
            'total_selesai' => count(session('madya_history_list', $this->defaultHistoryList)),
        ];

        return view('madya.dashboard', compact('verifikasiList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman History Verifikasi Kurator Madya.
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
     * Tampilkan detail verifikasi persyaratan sesuai ID layanan.
     */
    public function show(string|int $id): View|RedirectResponse
    {
        $verifikasiList = session('madya_verifikasi_list', $this->defaultVerifikasiList);
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
            $layanan = $verifikasiList[0] ?? null;
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

        $verifikasiList = session('madya_verifikasi_list', $this->defaultVerifikasiList);
        $historyList = session('madya_history_list', $this->defaultHistoryList);

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
                'status_label' => $validated['status'] === 'disetujui' ? 'Disetujui Madya' : 'Perlu Revisi Pemohon',
                'petugas_verifikator' => auth()->user()?->name ?? 'Inara, S.H., M.H.',
                'catatan' => $validated['catatan'] ?? ($validated['status'] === 'disetujui' ? 'Dokumen persyaratan lengkap, absah, dan disetujui Kurator Madya.' : 'Terdapat kekurangan berkas persyaratan.'),
            ];

            array_unshift($historyList, $newHistoryItem);

            session([
                'madya_verifikasi_list' => $newVerifikasiList,
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
