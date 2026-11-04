<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetugasDashboardController extends Controller
{
    /**
     * Default list permohonan yang perlu diverifikasi persyaratannya.
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
            'nama_pewasiat' => 'Alm. Soetrisno',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 14:32',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Berkas',
            'dokumen_count' => 4,
            'dokumen_total' => 4,
            'tipe_badge' => 'sky',
            'catatan' => 'Pemeriksaan silsilah ahli waris dan KTP pemohon.',
        ],
        [
            'id' => 2,
            'nomor_layanan' => 'W15.AHU.AH.06.01-00023',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pendaftaran Wasiat Terbuka',
            'nama_pemohon' => 'Ahmad Fadli',
            'nama_pewasiat' => 'Almh. Siti Hartini',
            'tanggal_masuk' => '30 Mei 2025',
            'waktu_masuk' => 'Pukul 11:18',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Berkas',
            'dokumen_count' => 5,
            'dokumen_total' => 5,
            'tipe_badge' => 'purple',
            'catatan' => 'Salinan akta wasiat terbuka dan surat kematian terlampir.',
        ],
        [
            'id' => 3,
            'nomor_layanan' => 'W15.AHU.AH.06.09-00022',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan Surat Keterangan Hak Waris',
            'nama_pemohon' => 'Rizka Amelia',
            'nama_pewasiat' => 'Alm. Johannes Tan',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 16:05',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Berkas',
            'dokumen_count' => 3,
            'dokumen_total' => 3,
            'tipe_badge' => 'sky',
            'catatan' => 'Berkas kepemilikan dan buku nikah.',
        ],
        [
            'id' => 4,
            'nomor_layanan' => 'W15.AHU.AH.06.01-00021',
            'jenis_layanan' => 'Wasiat',
            'detail_layanan' => 'Pelaporan Wasiat',
            'nama_pemohon' => 'Bambang Suryono',
            'nama_pewasiat' => 'Alm. Raden Mas Wardoyo',
            'tanggal_masuk' => '29 Mei 2025',
            'waktu_masuk' => 'Pukul 10:40',
            'status_verifikasi' => 'menunggu_telaah',
            'status_label' => 'Menunggu Telaah Berkas',
            'dokumen_count' => 6,
            'dokumen_total' => 6,
            'tipe_badge' => 'purple',
            'catatan' => 'Pemeriksaan sampul dan laporan akta wasiat.',
        ],
    ];

    /**
     * Default history riwayat permohonan yang telah selesai diverifikasi.
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
            'petugas_verifikator' => 'Iman, S.H.',
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
            'petugas_verifikator' => 'Iman, S.H.',
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
            'petugas_verifikator' => 'Iman, S.H.',
            'catatan' => 'Sampul wasiat tertutup utuh dan tersegel resmi.',
        ],
    ];

    /**
     * Hitung jumlah permohonan yang perlu diverifikasi persyaratannya.
     */
    public static function getPerluVerifikasiCount(): int
    {
        $instance = new self;
        $sessionList = session('petugas_verifikasi_list', $instance->defaultVerifikasiList);

        $dbCount = Permohonan::where('status', 'menunggu_verifikasi')->count();

        return max(count($sessionList), $dbCount);
    }

    /**
     * Tampilkan halaman utama Verifikasi Persyaratan.
     */
    public function index(Request $request): View
    {
        $verifikasiList = session('petugas_verifikasi_list', $this->defaultVerifikasiList);

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
                    'status_label' => 'Menunggu Telaah Berkas',
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
            'total_selesai' => count(session('petugas_history_list', $this->defaultHistoryList)),
        ];

        return view('petugas.dashboard', compact('verifikasiList', 'stats', 'search'));
    }

    /**
     * Tampilkan halaman History Verifikasi.
     */
    public function history(Request $request): View
    {
        $historyList = session('petugas_history_list', $this->defaultHistoryList);

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

        return view('petugas.history', compact('historyList', 'stats', 'search'));
    }

    /**
     * Proses telaah/verifikasi persyaratan (setujui / revisi).
     */
    public function tindakLanjut(Request $request, string|int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:disetujui,revisi,ditolak'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $verifikasiList = session('petugas_verifikasi_list', $this->defaultVerifikasiList);
        $historyList = session('petugas_history_list', $this->defaultHistoryList);

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
                'petugas_verifikator' => auth()->user()?->name ?? 'Petugas BHP',
                'catatan' => $validated['catatan'] ?? ($validated['status'] === 'disetujui' ? 'Dokumen persyaratan lengkap dan absah.' : 'Terdapat kekurangan berkas persyaratan.'),
            ];

            array_unshift($historyList, $newHistoryItem);

            session([
                'petugas_verifikasi_list' => $newVerifikasiList,
                'petugas_history_list' => $historyList,
            ]);

            $pesan = $validated['status'] === 'disetujui'
                ? "Permohonan {$targetItem['nomor_layanan']} berhasil diverifikasi dan disetujui."
                : "Permohonan {$targetItem['nomor_layanan']} telah dikembalikan untuk perbaikan berkas.";

            return redirect()->route('petugas.dashboard')->with('success', $pesan);
        }

        return redirect()->route('petugas.dashboard');
    }
}
