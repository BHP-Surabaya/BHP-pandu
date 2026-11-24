<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Persetujuan Berita Acara</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; color: #0f172a; margin: 0; padding: 24px;">
    <table role="presentation" style="width: 100%; max-width: 580px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; border-collapse: collapse;">
        <tr>
            <td style="background-color: #0c2a55; padding: 20px 24px; text-align: center; color: #ffffff;">
                <p style="margin: 0; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: #93c5fd; font-weight: bold;">
                    Kementerian Hukum RI &bull; Balai Harta Peninggalan Surabaya
                </p>
                <h1 style="margin: 6px 0 0; font-size: 18px; font-weight: bold; color: #ffffff;">
                    Otorisasi Berita Acara Wasiat Tertutup
                </h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 24px;">
                <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.5; color: #334155;">
                    Yth. <strong>Kurator Keperdataan Ahli Madya</strong>,
                </p>
                <p style="margin: 0 0 16px; font-size: 13px; line-height: 1.6; color: #475569;">
                    Berikut adalah kode verifikasi persetujuan (OTP) resmi untuk otorisasi penerbitan, penyimpanan, dan pencetakan 2 salinan <strong>Berita Acara Pembukaan dan Pembacaan Wasiat Tertutup</strong>:
                </p>

                <div style="background-color: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 16px; margin: 20px 0; text-align: center;">
                    <span style="display: block; font-size: 11px; text-transform: uppercase; font-weight: bold; letter-spacing: 0.05em; color: #64748b; margin-bottom: 6px;">
                        Kode Persetujuan (OTP)
                    </span>
                    <span style="font-family: 'Courier New', monospace; font-size: 32px; font-weight: 800; letter-spacing: 0.25em; color: #1d68d8;">
                        {{ $code }}
                    </span>
                    <span style="display: block; font-size: 11px; color: #dc2626; margin-top: 8px; font-weight: 600;">
                        Berlaku selama {{ $expiresMinutes }} menit
                    </span>
                </div>

                <table style="width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 12px; color: #334155;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; width: 140px;">No. Layanan:</td>
                        <td style="padding: 6px 0; font-weight: bold;">{{ $nomorLayanan }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Nama Pemohon/Notaris:</td>
                        <td style="padding: 6px 0; font-weight: bold;">{{ $namaPemohon }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b;">Waktu Permintaan:</td>
                        <td style="padding: 6px 0;">{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
                    </tr>
                </table>

                <p style="margin: 20px 0 0; font-size: 12px; color: #64748b; line-height: 1.5; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                    <em>Pemberitahuan:</em> Jangan berikan kode otorisasi ini kepada pihak yang tidak berkepentingan. Kode ini diperlukan untuk memastikan keabsahan warkah Berita Acara Balai Harta Peninggalan.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8fafc; padding: 14px 24px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
                &copy; {{ date('Y') }} Balai Harta Peninggalan Surabaya &bull; PanduBHP
            </td>
        </tr>
    </table>
</body>
</html>
