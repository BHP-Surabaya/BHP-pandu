<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LayananController extends Controller
{
    /**
     * Daftar katalog layanan Balai Harta Peninggalan yang dalam tahap pengembangan.
     *
     * @var array<string, array{slug: string, nama: string, kategori: string, badge: string, ringkasan: string, deskripsi: string, syarat: array<int, string>, color: string}>
     */
    protected array $layananList = [
        'pendaftaran-wasiat' => [
            'slug' => 'pendaftaran-wasiat',
            'nama' => 'Pendaftaran Wasiat',
            'kategori' => 'Registrasi Notaris',
            'badge' => 'Registrasi Notaris',
            'ringkasan' => 'Pencatatan dan pelaporan daftar akta wasiat yang dibuat di hadapan Notaris ke Pusat Pendaftaran Wasiat Balai Harta Peninggalan.',
            'deskripsi' => 'Layanan pendaftaran daftar akta wasiat yang dibuat di hadapan Notaris untuk dicatat ke dalam buku register resmi BHP Surabaya guna kepastian hukum pelaporan wasiat terdaftar.',
            'syarat' => [
                'Surat Pengantar resmi dari Notaris Pembuat Akta',
                'Salinan Akta Wasiat Notariil (Akta Umum / Rahasia)',
                'Identitas Pemberi Wasiat (KTP / KK)',
                'Bukti Pembayaran PNBP (bila berlaku)',
            ],
            'color' => 'sky',
        ],
        'perwalian' => [
            'slug' => 'perwalian',
            'nama' => 'Perwalian',
            'kategori' => 'Perlindungan Hukum',
            'badge' => 'Perlindungan Anak',
            'ringkasan' => 'Pengurusan, pemeliharaan, serta pengawasan atas harta kekayaan anak yang belum dewasa yang berada di bawah perwalian Balai Harta Peninggalan.',
            'deskripsi' => 'Pengawasan dan pengelolaan harta kekayaan anak di bawah umur yang orang tuanya telah meninggal dunia atau dicabut hak asuhnya berdasarkan penetapan pengadilan.',
            'syarat' => [
                'Salinan Penetapan Pengadilan Negeri / Pengadilan Agama tentang Perwalian',
                'Akta Kematian Orang Tua dari Dispendukcapil',
                'Akta Kelahiran Anak yang Berada di Bawah Perwalian',
                'Daftar Rincian Harta Peninggalan (Boedel)',
                'Identitas KTP & Kartu Keluarga Wali yang Ditunjuk',
            ],
            'color' => 'emerald',
        ],
        'pengampuan' => [
            'slug' => 'pengampuan',
            'nama' => 'Pengampuan (Curatele)',
            'kategori' => 'Perlindungan Hukum',
            'badge' => 'Curatele',
            'ringkasan' => 'Pengurusan dan perlindungan harta kekayaan bagi orang dewasa yang berada di bawah pengampuan karena kondisi kesehatan mental atau fisik.',
            'deskripsi' => 'Pelayanan kepengurusan harta dan pengawasan bagi individu dewasa yang ditetapkan di bawah pengampuan oleh Pengadilan karena sakit ingatan, pemborosan, atau keterbatasan fisik.',
            'syarat' => [
                'Salinan Penetapan Pengadilan Negeri tentang Pengampuan (Curatele)',
                'Surat Keterangan Dokter Spesialis / Rekam Medis yang Relevan',
                'Identitas KTP & Kartu Keluarga Orang yang Diampu dan Pengampu',
                'Daftar Rincian Aset / Harta Kekayaan yang Dikelola',
            ],
            'color' => 'teal',
        ],
        'skhw' => [
            'slug' => 'skhw',
            'nama' => 'Surat Keterangan Hak Waris (SKHW)',
            'kategori' => 'Wasiat & Waris',
            'badge' => 'Hak Waris',
            'ringkasan' => 'Penerbitan Surat Keterangan Hak Waris resmi untuk WNI keturunan Timur Asing dan Eropa berdasarkan ketentuan hukum perdata barat.',
            'deskripsi' => 'Penerbitan dokumen legalitas hak waris bagi subjek hukum yang menjadi kewenangan Balai Harta Peninggalan sesuai Kitab Undang-Undang Hukum Perdata (KUHPerdata).',
            'syarat' => [
                'Surat Kematian Pewaris dari Dispendukcapil',
                'Akta Perkawinan / Buku Nikah Pewaris',
                'Akta Kelahiran Seluruh Ahli Waris Sah',
                'KTP & Kartu Keluarga Seluruh Ahli Waris',
                'Surat Keterangan Wasiat dari Ditjen Administrasi Hukum Umum (AHU)',
            ],
            'color' => 'amber',
        ],
        'harta-pemilik-tidak-hadir' => [
            'slug' => 'harta-pemilik-tidak-hadir',
            'nama' => 'Layanan Harta Kekayaan Yang Pemiliknya Tidak Hadir (Afwezigheid)',
            'kategori' => 'Pengurusan Harta',
            'badge' => 'Afwezigheid',
            'ringkasan' => 'Penatausahaan dan pengelolaan harta kekayaan milik orang yang tidak hadir atau meninggalkan tempat tinggalnya tanpa menunjuk kuasa.',
            'deskripsi' => 'Pelayanan pengurusan harta milik orang yang hilang atau tidak diketahui keberadaannya berdasarkan putusan pengadilan guna melindungi hak-hak pihak ketiga dan ahli waris.',
            'syarat' => [
                'Salinan Penetapan Pengadilan Negeri tentang Ketidakhadiran (Afwezigheid)',
                'Surat Keterangan Orang Hilang dari Kepolisian RI',
                'Bukti Asli / Salinan Kepemilikan Aset dan Properti Terkait',
                'Identitas Pihak Pemohon / Keluarga yang Melapor',
            ],
            'color' => 'indigo',
        ],
        'harta-tidak-terurus' => [
            'slug' => 'harta-tidak-terurus',
            'nama' => 'Layanan Harta Peninggalan Yang Tidak Terurus (Onbeheerde Boedel)',
            'kategori' => 'Pengurusan Harta',
            'badge' => 'Onbeheerde Boedel',
            'ringkasan' => 'Pengurusan, pendaftaran, dan pemberesan boedel harta peninggalan yang tidak ada ahli warisnya atau seluruh ahli waris menolak warisan.',
            'deskripsi' => 'Pengelolaan, inventarisasi, dan penyelesaian kewajiban hutang-piutang atas harta peninggalan orang yang meninggal dunia tanpa ahli waris sah yang menerima warisan.',
            'syarat' => [
                'Surat Kematian Pewaris dari Rumah Sakit / Kelurahan / Dispendukcapil',
                'Keterangan Resmi Penolakan Waris dari Kepaniteraan Pengadilan Negeri (bila ada)',
                'Daftar Inventaris Aset / Harta Benda yang Ditinggalkan',
                'Surat Laporan dari Pihak Ketiga / Lingkungan / Aparat RT/RW Terkait',
            ],
            'color' => 'blue',
        ],
        'uang-pihak-ketiga' => [
            'slug' => 'uang-pihak-ketiga',
            'nama' => 'Layanan Uang Pihak Ketiga (Konsinyasi)',
            'kategori' => 'Pengurusan Harta',
            'badge' => 'Konsinyasi Kas BHP',
            'ringkasan' => 'Penerimaan, penyimpanan, dan penyaluran uang titipan milik pihak ketiga (konsinyasi pembebasan lahan, eksekusi, dll) pada kas BHP.',
            'deskripsi' => 'Penyimpanan dan penyaluran dana titipan pihak ketiga berdasarkan perintah pengadilan atau penetapan hukum (seperti ganti rugi pengadaan tanah untuk kepentingan umum).',
            'syarat' => [
                'Salinan Penetapan Konsinyasi dari Pengadilan Negeri',
                'Berita Acara Penitipan Uang Ganti Kerugian dari Instansi Pemohon',
                'Identitas Lengkap KTP & KK Pihak Penerima (Termohon Konsinyasi)',
                'Buku Rekening Bank Aktif atas nama Penerima yang Sah',
            ],
            'color' => 'cyan',
        ],
        'kepailitan' => [
            'slug' => 'kepailitan',
            'nama' => 'Layanan Kepailitan & Kurator Negara',
            'kategori' => 'Kepailitan',
            'badge' => 'Kurator Negara',
            'ringkasan' => 'Pelaksanaan tugas BHP sebagai Kurator Negara dalam kepengurusan dan pemberesan boedel harta debitur pailit berdasarkan putusan Pengadilan Niaga.',
            'deskripsi' => 'Pelaksanaan kewenangan kurator negara untuk mengamankan, menginventarisir, menilai, dan membagikan harta debitur pailit kepada para kreditur secara berkeadilan.',
            'syarat' => [
                'Salinan Putusan Pernyataan Pailit dari Pengadilan Niaga',
                'Daftar Identitas Kreditur dan Debitur Pailit Terdaftar',
                'Laporan Rincian Aset dan Harta Kekayaan Debitur Pailit',
                'Identitas Lengkap Kuasa Hukum / Pihak Pemohon Terkait',
            ],
            'color' => 'purple',
        ],
    ];

    /**
     * Tampilkan halaman status tahap pengembangan layanan.
     */
    public function show(string $slug): View
    {
        $layanan = $this->layananList[$slug] ?? [
            'slug' => $slug,
            'nama' => 'Layanan Balai Harta Peninggalan',
            'kategori' => 'Layanan Terpadu',
            'badge' => 'Tahap Pengembangan',
            'ringkasan' => 'Layanan resmi Balai Harta Peninggalan Surabaya.',
            'deskripsi' => 'Layanan ini sedang dalam proses digitalisasi dan integrasi sistem.',
            'syarat' => [
                'Identitas Resmi Pemohon (KTP / Paspor)',
                'Dokumen Legalitas dan Bukti Pendukung Terkait',
            ],
            'color' => 'blue',
        ];

        return view('layanan.pengembangan', compact('layanan'));
    }
}
