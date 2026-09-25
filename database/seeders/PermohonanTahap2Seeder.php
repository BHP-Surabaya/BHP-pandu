<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\Permohonan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PermohonanTahap2Seeder extends Seeder
{
    /**
     * Run the database seeds for Tahap 2 (Dokumen Berkas).
     */
    public function run(): void
    {
        $permohonans = Permohonan::all();

        if ($permohonans->isEmpty()) {
            $this->call(PermohonanTahap1Seeder::class);
            $permohonans = Permohonan::all();
        }

        $documentTypes = [
            'surat_kuasa' => 'Surat Kuasa Ahli Waris Pewasiat',
            'akta_kematian' => 'Akta Kematian Pewasiat dari Disdukcapil',
            'surat_keterangan_wasiat' => 'Surat Keterangan Wasiat DPW Ditjen AHU',
            'akta_penyimpanan_wasiat' => 'Akta Penyimpanan Wasiat Notaris',
            'buku_nikah' => 'Buku Nikah / Akta Perkawinan Pewasiat',
            'akta_lahir_ktp_kk' => 'Akta Lahir, KTP dan KK Keluarga Pewasiat',
            'dokumen_lainnya' => 'Dokumen Pendukung Tambahan Permohonan Wasiat',
        ];

        foreach ($permohonans as $permohonan) {
            foreach ($documentTypes as $key => $title) {
                $dir = "dokumens/{$permohonan->id}";
                $fileName = "{$key}.pdf";
                $filePath = "{$dir}/{$fileName}";

                $pdfContent = $this->generateSamplePdf($title, $permohonan->nomor_permohonan);
                Storage::disk('public')->put($filePath, $pdfContent);

                Dokumen::updateOrCreate(
                    [
                        'permohonan_id' => $permohonan->id,
                        'jenis_dokumen' => $key,
                    ],
                    [
                        'file_path' => $filePath,
                        'status' => 'diunggah',
                        'sudah_barcode' => true,
                    ]
                );
            }
        }
    }

    /**
     * Generate a minimal, valid PDF binary string.
     */
    private function generateSamplePdf(string $docTitle, string $nomorPermohonan): string
    {
        $streamText = "BT /F1 16 Tf 50 720 Td (KEMENTERIAN HUKUM DAN HAM RI) Tj /F1 12 Tf 0 -22 Td (BALAI HARTA PENINGGALAN - PANDU LAYANAN WASIAT) Tj /F1 10 Tf 0 -20 Td (Nomor Registrasi: {$nomorPermohonan}) Tj 0 -20 Td (Jenis Berkas: {$docTitle}) Tj 0 -20 Td (Status: Terverifikasi Dokumen Asli / Sah) Tj ET";
        $streamLength = strlen($streamText);

        return "%PDF-1.4\n"
            ."1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n"
            ."2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n"
            ."3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n"
            ."4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>\nendobj\n"
            ."5 0 obj\n<< /Length {$streamLength} >>\nstream\n{$streamText}\nendstream\nendobj\n"
            ."xref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000266 00000 n \n0000000348 00000 n \n"
            ."trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n520\n%%EOF\n";
    }
}
