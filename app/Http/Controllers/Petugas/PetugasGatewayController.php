<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PetugasGatewayController extends Controller
{
    /**
     * Hitung permohonan yang siap diproses Barcode & e-TTD untuk badge sidebar.
     */
    public static function getSiapProsesCount(): int
    {
        $antrean = session('gateway_antrean', null);
        if ($antrean === null) {
            return 3; // Default 3 dokumen siap
        }

        return collect($antrean)->where('status_dokumen', 'siap')->count();
    }

    /**
     * Hitung total dokumen terkirim untuk badge sidebar.
     */
    public static function getTerkirimCount(): int
    {
        $riwayat = session('gateway_riwayat', null);
        if ($riwayat === null) {
            return 4; // Default 4 dokumen terkirim
        }

        return count($riwayat);
    }

    /**
     * Halaman Utama Gateway Layanan: Proses Barcode & e-TTD.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $filterJenis = trim((string) $request->input('jenis', 'all'));

        $antrean = $this->getAntreanData();
        $riwayat = $this->getRiwayatData();

        $filteredAntrean = collect($antrean)->filter(function ($item) use ($search, $filterJenis) {
            if ($filterJenis !== 'all' && $item['jenis_layanan'] !== $filterJenis) {
                return false;
            }

            if ($search !== '') {
                $q = strtolower($search);
                $haystack = strtolower(
                    $item['nomor_layanan'].' '.
                    $item['jenis_layanan'].' '.
                    $item['nama_pemohon'].' '.
                    $item['penanggungjawab'].' '.
                    $item['email_pemohon']
                );

                return str_contains($haystack, $q);
            }

            return true;
        })->values()->all();

        $daftarJenisLayanan = collect($antrean)->pluck('jenis_layanan')->unique()->values()->all();

        $stats = [
            'total_antrean' => count($filteredAntrean),
            'total_semua_antrean' => count($antrean),
            'total_siap' => collect($antrean)->where('status_dokumen', 'siap')->count(),
            'total_menunggu' => collect($antrean)->where('status_dokumen', 'menunggu')->count(),
            'total_terkirim' => count($riwayat),
        ];

        return view('petugas.gateway.index', compact(
            'filteredAntrean',
            'daftarJenisLayanan',
            'stats',
            'search',
            'filterJenis'
        ));
    }

    /**
     * Halaman Riwayat Pengiriman Dokumen.
     */
    public function riwayat(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $filterBulan = trim((string) $request->input('bulan', 'all'));
        $filterTahun = trim((string) $request->input('tahun', 'all'));

        $riwayat = $this->getRiwayatData();
        $antrean = $this->getAntreanData();

        $filteredRiwayat = collect($riwayat)->filter(function ($item) use ($search, $filterBulan, $filterTahun) {
            if ($filterBulan !== 'all' && ($item['bulan'] ?? '') !== $filterBulan) {
                return false;
            }

            if ($filterTahun !== 'all' && ($item['tahun'] ?? '') !== $filterTahun) {
                return false;
            }

            if ($search !== '') {
                $q = strtolower($search);
                $haystack = strtolower(
                    $item['nomor_layanan'].' '.
                    $item['jenis_layanan'].' '.
                    $item['nama_pemohon'].' '.
                    $item['penanggungjawab'].' '.
                    $item['nama_file_terkirim']
                );

                return str_contains($haystack, $q);
            }

            return true;
        })->values()->all();

        $stats = [
            'total_terkirim' => count($filteredRiwayat),
            'total_siap_proses' => collect($antrean)->where('status_dokumen', 'siap')->count(),
        ];

        return view('petugas.gateway.riwayat', compact(
            'filteredRiwayat',
            'stats',
            'search',
            'filterBulan',
            'filterTahun'
        ));
    }

    /**
     * Download draf dokumen hukum yang telah disetujui Kepala BHP.
     */
    public function download(int $id): StreamedResponse
    {
        $antrean = collect($this->getAntreanData());
        $item = $antrean->firstWhere('id', $id);

        $fileName = $item['nama_dokumen'] ?? "Konsep_Disetujui_Dokumen_{$id}.pdf";
        $nomorLayanan = $item['nomor_layanan'] ?? 'W15.AHU.BHP.04.01-0000';
        $pemohon = $item['nama_pemohon'] ?? 'Pemohon';
        $jenisLayanan = $item['jenis_layanan'] ?? 'Layanan Publik BHP';

        $content = "%PDF-1.4\n";
        $content .= "1 0 obj << /Title ({$fileName}) /Creator (BHP Surabaya Gateway) >> endobj\n";
        $content .= "2 0 obj << /Type /Catalog /Pages 3 0 R >> endobj\n";
        $content .= "3 0 obj << /Type /Pages /Kids [4 0 R] /Count 1 >> endobj\n";
        $content .= "4 0 obj << /Type /Page /Parent 3 0 R /MediaBox [0 0 595 842] /Contents 5 0 R >> endobj\n";
        $content .= "5 0 obj << /Length 200 >> stream\n";
        $content .= "BT /F1 12 Tf 50 780 Td (KEMENTERIAN HUKUM REPUBLIK INDONESIA) Tj ET\n";
        $content .= "BT /F1 14 Tf 50 760 Td (BALAI HARTA PENINGGALAN SURABAYA) Tj ET\n";
        $content .= "BT /F1 10 Tf 50 720 Td (Nomor Berkas: {$nomorLayanan}) Tj ET\n";
        $content .= "BT /F1 10 Tf 50 700 Td (Jenis Layanan: {$jenisLayanan}) Tj ET\n";
        $content .= "BT /F1 10 Tf 50 680 Td (Pemohon: {$pemohon}) Tj ET\n";
        $content .= "BT /F1 10 Tf 50 650 Td (Status: DISETUJUI KEPALA BALAI - SIAP BARCODE & E-TTD) Tj ET\n";
        $content .= "endstream\nendobj\nxref\n0 6\n0000000000 65535 f \n";
        $content .= "trailer << /Size 6 /Root 2 0 R >>\nstartxref\n500\n%%EOF";

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $fileName, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    /**
     * Upload dan kirim dokumen final bertanda tangan elektronik & ber-barcode ke pemohon.
     */
    public function uploadKirim(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'konfirmasi' => ['required'],
            'dokumen_final' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $antrean = $this->getAntreanData();
        $riwayat = $this->getRiwayatData();

        $targetItem = collect($antrean)->firstWhere('id', $id);

        if (! $targetItem) {
            return back()->with('error', 'Berkas layanan tidak ditemukan dalam antrean.');
        }

        // Hapus dari antrean
        $newAntrean = collect($antrean)->reject(fn ($it) => $it['id'] === $id)->values()->all();

        // Nama file final bertanda tangan
        $finalFileName = str_replace('Konsep_Disetujui_', 'Final_Signed_', $targetItem['nama_dokumen']);
        if (! str_ends_with($finalFileName, '.pdf')) {
            $finalFileName .= '.pdf';
        }

        $now = now();
        $itemRiwayatBaru = [
            'id' => (int) $now->timestamp,
            'nomor_layanan' => $targetItem['nomor_layanan'],
            'jenis_layanan' => $targetItem['jenis_layanan'],
            'nama_pemohon' => $targetItem['nama_pemohon'],
            'email_pemohon' => $targetItem['email_pemohon'],
            'penanggungjawab' => auth()->user()?->name ?? 'Iman, S.H.',
            'nama_file_terkirim' => $finalFileName,
            'ukuran_file' => '245.8 KB',
            'keterangan_file' => 'Dokumen telah disematkan Barcode & e-TTD dan dikirimkan ke pemohon',
            'tanggal_selesai' => $now->translatedFormat('d M Y'),
            'waktu_kirim' => $now->translatedFormat('d M Y, H:i'),
            'bulan' => $now->format('m'),
            'tahun' => $now->format('Y'),
        ];

        // Tambah ke riwayat (paling atas)
        array_unshift($riwayat, $itemRiwayatBaru);

        // Simpan ke session
        session([
            'gateway_antrean' => $newAntrean,
            'gateway_riwayat' => $riwayat,
        ]);

        // Jika terdapat permohonan riil di database dengan nomor yang sama, perbarui statusnya
        $permohonan = Permohonan::where('nomor_permohonan', $targetItem['nomor_layanan'])->first();
        if ($permohonan) {
            $permohonan->update([
                'status' => 'selesai',
                'catatan_petugas' => 'Dokumen resmi telah disematkan Barcode verifikasi dan TTE Kepala BHP, kemudian diterbitkan kepada pemohon.',
            ]);
        }

        Log::info("Gateway e-TTD: Dokumen {$targetItem['nomor_layanan']} berhasil disematkan Barcode & e-TTD oleh ".auth()->user()?->name.' dan dikirimkan ke pemohon.');

        return redirect()->route('petugas.gateway.index')
            ->with('success', "Dokumen {$targetItem['nomor_layanan']} ({$targetItem['jenis_layanan']}) berhasil disematkan Barcode & e-TTD dan telah dikirimkan ke pemohon ({$targetItem['nama_pemohon']}).");
    }

    /**
     * Pulihkan data awal demonstrasi antrean dan riwayat Gateway Layanan.
     */
    public function resetData(): RedirectResponse
    {
        session()->forget(['gateway_antrean', 'gateway_riwayat']);

        return redirect()->route('petugas.gateway.index')
            ->with('success', 'Data antrean dan riwayat Gateway Layanan berhasil dipulihkan ke status awal.');
    }

    /**
     * Dapatkan data antrean Barcode & e-TTD (dari session atau default).
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getAntreanData(): array
    {
        $sessionData = session('gateway_antrean', null);
        if ($sessionData !== null) {
            return $sessionData;
        }

        return [
            [
                'id' => 1,
                'nomor_layanan' => 'W15.AHU.BHP.04.01-1104',
                'jenis_layanan' => 'Penerbitan SKHW',
                'nama_dokumen' => 'Konsep_Disetujui_SKHW_1104.pdf',
                'nama_pemohon' => 'Ir. Bambang Hermanto',
                'email_pemohon' => 'bambang.hermanto@mail.id',
                'penanggungjawab' => 'Iman, S.H.',
                'tanggal_permohonan' => '07 Nov 2026',
                'status_dokumen' => 'siap',
                'status_label' => 'Dokumen Siap',
                'status_detail' => 'Disetujui Kepala - Siap Barcode & e-TTD',
                'bisa_diproses' => true,
            ],
            [
                'id' => 2,
                'nomor_layanan' => 'W15.AHU.BHP.04.02-0941',
                'jenis_layanan' => 'Penetapan Pengawasan Perwalian',
                'nama_dokumen' => 'Konsep_Disetujui_Perwalian_0941.pdf',
                'nama_pemohon' => 'Siti Aminah Kusuma',
                'email_pemohon' => 'siti.aminah@mail.id',
                'penanggungjawab' => 'Iman, S.H.',
                'tanggal_permohonan' => '24 Okt 2026',
                'status_dokumen' => 'siap',
                'status_label' => 'Dokumen Siap',
                'status_detail' => 'Disetujui Kepala - Siap Barcode & e-TTD',
                'bisa_diproses' => true,
            ],
            [
                'id' => 3,
                'nomor_layanan' => 'W15.AHU.BHP.04.06-0612',
                'jenis_layanan' => 'Penatausahaan UPK (Konsinyasi)',
                'nama_dokumen' => 'Konsep_Disetujui_UPK_0612.pdf',
                'nama_pemohon' => 'Dr. Budi Santoso, Sp.B.',
                'email_pemohon' => 'budi.santoso@mail.id',
                'penanggungjawab' => 'Iman, S.H.',
                'tanggal_permohonan' => '02 Nov 2026',
                'status_dokumen' => 'siap',
                'status_label' => 'Dokumen Siap',
                'status_detail' => 'Disetujui Kepala - Siap Barcode & e-TTD',
                'bisa_diproses' => true,
            ],
            [
                'id' => 4,
                'nomor_layanan' => 'W15.AHU.BHP.04.05-0319',
                'jenis_layanan' => 'Verifikasi Tagihan Kepailitan',
                'nama_dokumen' => 'Draft_BA_Verifikasi_Kepailitan_0319.pdf',
                'nama_pemohon' => 'PT Samudra Jaya Abadi (Dalam Pailit)',
                'email_pemohon' => 'legal@samudrajaya.co.id',
                'penanggungjawab' => 'Iman, S.H.',
                'tanggal_permohonan' => '04 Nov 2026',
                'status_dokumen' => 'menunggu',
                'status_label' => 'Menunggu Dokumen',
                'status_detail' => 'Tahap Persetujuan Kepala',
                'bisa_diproses' => false,
            ],
            [
                'id' => 5,
                'nomor_layanan' => 'W15.AHU.BHP.04.04-0188',
                'jenis_layanan' => 'Pengurusan Harta Tidak Terurus',
                'nama_dokumen' => 'Draft_Penetapan_Harta_0188.pdf',
                'nama_pemohon' => 'Kantor Pertanahan Kota Kediri',
                'email_pemohon' => 'kantah.kediri@atrbpn.go.id',
                'penanggungjawab' => 'Iman, S.H.',
                'tanggal_permohonan' => '05 Nov 2026',
                'status_dokumen' => 'menunggu',
                'status_label' => 'Menunggu Dokumen',
                'status_detail' => 'Tahap Verifikasi Lanjutan',
                'bisa_diproses' => false,
            ],
        ];
    }

    /**
     * Dapatkan data riwayat pengiriman dokumen (dari session atau default).
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getRiwayatData(): array
    {
        $sessionData = session('gateway_riwayat', null);
        if ($sessionData !== null) {
            return $sessionData;
        }

        return [
            [
                'id' => 101,
                'nomor_layanan' => 'W15.AHU.BHP.04.01-0850',
                'jenis_layanan' => 'Pendaftaran Wasiat Tercatat',
                'nama_pemohon' => 'Raden Ahmad Fauzan',
                'email_pemohon' => 'ahmad.fauzan@mail.id',
                'penanggungjawab' => 'Iman, S.H.',
                'nama_file_terkirim' => 'SK_Wasiat_W15.AHU.BHP.04.01-0850.pdf',
                'ukuran_file' => '227.0 KB',
                'keterangan_file' => 'Dokumen telah disematkan Barcode & e-TTD dan dikirimkan ke pemohon',
                'tanggal_selesai' => '30 Okt 2026',
                'waktu_kirim' => '30 Okt 2026, 21:22',
                'bulan' => '10',
                'tahun' => '2026',
            ],
            [
                'id' => 102,
                'nomor_layanan' => 'W15.AHU.BHP.04.03-2044',
                'jenis_layanan' => 'Pembukaan Wasiat Tertutup/Rahasia',
                'nama_pemohon' => 'Budi Santoso',
                'email_pemohon' => 'budi.santoso@karya.co.id',
                'penanggungjawab' => 'Iman, S.H.',
                'nama_file_terkirim' => 'BA_Pembukaan_Wasiat_2044.pdf',
                'ukuran_file' => '415.2 KB',
                'keterangan_file' => 'Barcode & e-TTD telah disematkan sesuai persetujuan Kepala',
                'tanggal_selesai' => '06 Nov 2026',
                'waktu_kirim' => '06 Nov 2026, 16:15',
                'bulan' => '11',
                'tahun' => '2026',
            ],
            [
                'id' => 103,
                'nomor_layanan' => 'W15.AHU.BHP.04.08-0115',
                'jenis_layanan' => 'Pemisah Harta Peninggalan',
                'nama_pemohon' => 'Hendra Wijaya',
                'email_pemohon' => 'hendra.wijaya@mitra-teknik.id',
                'penanggungjawab' => 'Iman, S.H.',
                'nama_file_terkirim' => 'Penetapan_Pemisahan_Harta_0115.pdf',
                'ukuran_file' => '315.0 KB',
                'keterangan_file' => 'Sertifikat resmi bertanda tangan elektronik berlaku hingga Nov 2029',
                'tanggal_selesai' => '09 Nov 2026',
                'waktu_kirim' => '09 Nov 2026, 23:40',
                'bulan' => '11',
                'tahun' => '2026',
            ],
            [
                'id' => 104,
                'nomor_layanan' => 'W15.AHU.BHP.04.04-0174',
                'jenis_layanan' => 'Mewakili Harta Tidak Terurus',
                'nama_pemohon' => 'Muhammad Rizky Pratama',
                'email_pemohon' => 'rizky.pratama@mail.id',
                'penanggungjawab' => 'Iman, S.H.',
                'nama_file_terkirim' => 'Penetapan_Pengurusan_0174.pdf',
                'ukuran_file' => '195.4 KB',
                'keterangan_file' => 'Dokumen resmi tersertifikasi BSrE dan dikirim ke email pemohon',
                'tanggal_selesai' => '11 Nov 2026',
                'waktu_kirim' => '11 Nov 2026, 18:05',
                'bulan' => '11',
                'tahun' => '2026',
            ],
        ];
    }
}
