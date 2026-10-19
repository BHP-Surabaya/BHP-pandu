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
            'pic' => ['Rahmat', 'Kamal'],
            'sla_hari' => 9,
            'sla_label' => 'Hari ke-9',
            'sla_status' => 'PERHATIAN',
            'sla_level' => 'warning', // 8-12 hari
            'batas_waktu' => '5 Jun 2025',
            'tipe_badge' => 'purple',
        ],
        [
            'id' => 4,
            'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00015',
            'jenis_layanan' => 'SKHW',
            'detail_layanan' => 'Permohonan SKHW',
            'pemohon' => 'Budi Santoso',
            'tanggal_disposisi' => '22 Mei 2025',
            'pic' => ['Fajar', 'Dewi'],
            'sla_hari' => 5,
            'sla_label' => 'Hari ke-5',
            'sla_status' => 'NORMAL',
            'sla_level' => 'normal', // 1-7 hari
            'batas_waktu' => '12 Jun 2025',
            'tipe_badge' => 'sky',
        ],
    ];

    /**
     * Tampilkan halaman utama dashboard KASI (Kepala Seksi).
     */
    public function index(Request $request): View
    {
        $layananBaru = session('kasi_layanan_baru', $this->defaultLayananBaru);
        $pemantauanSla = session('kasi_pemantauan_sla', $this->defaultPemantauanSla);

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

        return view('kasi.dashboard', compact(
            'layananBaru',
            'pemantauanSla',
            'totalLayananBaru',
            'totalSla',
            'kuratorList',
            'petugasList'
        ));
    }

    /**
     * Tampilkan halaman riwayat disposisi / history layanan.
     */
    public function history(Request $request): View
    {
        $historyLayanan = session('kasi_history_layanan', [
            [
                'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.09-00003',
                'jenis_layanan' => 'SKHW',
                'detail_layanan' => 'Permohonan SKHW',
                'pemohon' => 'Bambang Sudibyo',
                'tanggal_disposisi' => '20 Mei 2025',
                'pic' => ['Januar', 'Maya'],
                'status' => 'Selesai',
                'selesai_pada' => '28 Mei 2025',
                'catatan' => 'Verifikasi berkas selesai, SKHW telah diterbitkan.',
                'tipe_badge' => 'sky',
            ],
            [
                'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00004',
                'jenis_layanan' => 'Wasiat',
                'detail_layanan' => 'Pendaftaran Wasiat',
                'pemohon' => 'Nurul Hidayati',
                'tanggal_disposisi' => '18 Mei 2025',
                'pic' => ['Rahmat'],
                'status' => 'Selesai',
                'selesai_pada' => '25 Mei 2025',
                'catatan' => 'Pendaftaran wasiat notaris terverifikasi dan tercatat di buku register.',
                'tipe_badge' => 'purple',
            ],
            [
                'nomor_layanan' => 'W15.AHU.AHU.1.AH.06.01-00002',
                'jenis_layanan' => 'Wasiat',
                'detail_layanan' => 'Wasiat Terbuka',
                'pemohon' => 'H. Suryadi',
                'tanggal_disposisi' => '14 Mei 2025',
                'pic' => ['Indra', 'Lisa'],
                'status' => 'Selesai',
                'selesai_pada' => '22 Mei 2025',
                'catatan' => 'Sidang pembukaan wasiat terlaksana dengan berita acara lengkap.',
                'tipe_badge' => 'purple',
            ],
        ]);

        return view('kasi.history', compact('historyLayanan'));
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
}
