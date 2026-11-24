<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\User;
use App\Models\Voucher;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SecureDocumentController extends Controller
{
    /**
     * Tampilkan (stream inline) dokumen persyaratan permohonan secara aman.
     */
    public function showDokumen(Request $request, int|string $id): BinaryFileResponse
    {
        $dokumen = Dokumen::with('permohonan')->findOrFail($id);
        $user = $request->user();

        $isOwner = $dokumen->permohonan && (int) $dokumen->permohonan->user_id === (int) $user->id;
        $isStaff = $user->isBhpStaff();

        if (! $isOwner && ! $isStaff) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengakses dokumen ini.');
        }

        AuditLogger::log(
            action: 'view_dokumen',
            permohonan: $dokumen->permohonan,
            description: "Pengguna {$user->name} ({$user->role}) melihat berkas {$dokumen->jenis_dokumen}.",
            resource: $dokumen,
            details: ['jenis_dokumen' => $dokumen->jenis_dokumen, 'file_path' => $dokumen->file_path]
        );

        return $this->streamFile($dokumen->file_path, false);
    }

    /**
     * Unduh (download) dokumen persyaratan permohonan secara aman.
     */
    public function downloadDokumen(Request $request, int|string $id): BinaryFileResponse
    {
        $dokumen = Dokumen::with('permohonan')->findOrFail($id);
        $user = $request->user();

        $isOwner = $dokumen->permohonan && (int) $dokumen->permohonan->user_id === (int) $user->id;
        $isStaff = $user->isBhpStaff();

        if (! $isOwner && ! $isStaff) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengunduh dokumen ini.');
        }

        AuditLogger::log(
            action: 'download_dokumen',
            permohonan: $dokumen->permohonan,
            description: "Pengguna {$user->name} ({$user->role}) mengunduh berkas {$dokumen->jenis_dokumen}.",
            resource: $dokumen,
            details: ['jenis_dokumen' => $dokumen->jenis_dokumen, 'file_path' => $dokumen->file_path]
        );

        return $this->streamFile($dokumen->file_path, true);
    }

    /**
     * Tampilkan (stream inline) file bukti bayar / voucher PNBP secara aman.
     */
    public function showVoucher(Request $request, int|string $id): BinaryFileResponse
    {
        $voucher = Voucher::with('permohonan')->findOrFail($id);
        $user = $request->user();

        $isOwner = $voucher->permohonan && (int) $voucher->permohonan->user_id === (int) $user->id;
        $isStaff = $user->isBhpStaff();

        if (! $isOwner && ! $isStaff) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengakses bukti voucher ini.');
        }

        if (empty($voucher->file_voucher)) {
            abort(404, 'Berkas fisik voucher belum diunggah.');
        }

        AuditLogger::log(
            action: 'view_voucher',
            permohonan: $voucher->permohonan,
            description: "Pengguna {$user->name} ({$user->role}) melihat bukti bayar voucher PNBP {$voucher->nomor_voucher}.",
            resource: $voucher,
            details: ['nomor_voucher' => $voucher->nomor_voucher, 'ntpn' => $voucher->ntpn]
        );

        return $this->streamFile($voucher->file_voucher, false);
    }

    /**
     * Tampilkan berkas verifikasi akun (SK Notaris, SK PPAT, dll.) secara aman.
     */
    public function showUserDokumen(Request $request, int|string $userId, string $type): BinaryFileResponse
    {
        $allowedTypes = ['sk_notaris', 'sk_ppat', 'berita_acara_sumpah', 'id_card_pengacara'];

        if (! in_array($type, $allowedTypes, true)) {
            abort(400, 'Tipe dokumen tidak valid.');
        }

        $targetUser = User::findOrFail($userId);
        $currentUser = $request->user();

        $isSelf = (int) $currentUser->id === (int) $targetUser->id;
        $isAdmin = $currentUser->isMasterAdmin() || $currentUser->isPetugas();

        if (! $isSelf && ! $isAdmin) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengakses berkas ini.');
        }

        $filePath = $targetUser->{$type};

        if (empty($filePath)) {
            abort(404, 'Berkas fisik tidak ditemukan untuk pengguna ini.');
        }

        return $this->streamFile($filePath, false);
    }

    /**
     * Stream file dengan header keamanan anti-sniffing & anti-caching proxy.
     */
    protected function streamFile(string $filePath, bool $download = false): BinaryFileResponse
    {
        // Prioritaskan private local disk (storage/app/private), fallback ke public disk
        $disk = null;
        if (Storage::disk('local')->exists($filePath)) {
            $disk = 'local';
        } elseif (Storage::disk('public')->exists($filePath)) {
            $disk = 'public';
        }

        if (! $disk) {
            abort(404, 'Berkas fisik tidak ditemukan di penyimpanan server.');
        }

        $fullPath = Storage::disk($disk)->path($filePath);
        $mimeType = Storage::disk($disk)->mimeType($filePath) ?: 'application/pdf';
        $fileName = basename($filePath);

        $headers = [
            'Content-Type' => $mimeType,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        if ($download) {
            return response()->download($fullPath, $fileName, $headers);
        }

        $headers['Content-Disposition'] = 'inline; filename="'.$fileName.'"';

        return response()->file($fullPath, $headers);
    }
}
