<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of user verification requests and active accounts.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = User::query()->where('role', '!=', 'master_admin');

        // Apply status filter
        if ($status === 'menunggu_verifikasi') {
            $query->where('status_verifikasi', 'menunggu_verifikasi');
        } elseif ($status === 'notaris') {
            $query->where('status_akun', 'notaris');
        } elseif ($status === 'pengacara') {
            $query->where('status_akun', 'pengacara');
        } elseif ($status === 'perorangan') {
            $query->where(function ($q) {
                $q->where('status_akun', 'perorangan')
                    ->orWhereNull('status_akun');
            })->where('status_verifikasi', '!=', 'menunggu_verifikasi');
        } elseif ($status === 'ditolak') {
            $query->where('status_verifikasi', 'ditolak');
        } elseif ($status === 'terverifikasi') {
            $query->where('status_verifikasi', 'terverifikasi');
        }

        // Apply search filter
        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('pekerjaan', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Calculate statistics for active accounts & pending verifications
        $stats = [
            'total_user' => User::where('role', '!=', 'master_admin')->count(),
            'total_notaris' => User::where('status_akun', 'notaris')->count(),
            'total_pengacara' => User::where('status_akun', 'pengacara')->count(),
            'total_perorangan' => User::where('role', '!=', 'master_admin')
                ->where(function ($q) {
                    $q->where('status_akun', 'perorangan')->orWhereNull('status_akun');
                })->count(),
            'total_pending' => User::where('status_verifikasi', 'menunggu_verifikasi')->count(),
        ];

        return view('admin.verifikasi.index', compact('users', 'stats', 'status', 'search'));
    }

    /**
     * Display the specified user verification detail.
     */
    public function show(User $user): View
    {
        return view('admin.verifikasi.show', compact('user'));
    }

    /**
     * Approve the user profession verification request.
     */
    public function approve(Request $request, User $user): RedirectResponse
    {
        $targetStatusAkun = in_array($user->jenis_akun, ['notaris', 'pengacara']) ? $user->jenis_akun : 'perorangan';

        $user->update([
            'status_akun' => $targetStatusAkun,
            'status_verifikasi' => 'terverifikasi',
            'verified_at' => now(),
            'catatan_verifikasi' => $request->input('catatan_verifikasi', 'Pengajuan verifikasi disetujui oleh Master Admin.'),
        ]);

        return redirect()->route('admin.verifikasi.index')
            ->with('status', "Akun {$user->name} berhasil disetujui dan ditingkatkan menjadi {$user->status_akun_label}.");
    }

    /**
     * Reject the user profession verification request with a note.
     */
    public function reject(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'catatan_verifikasi' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'catatan_verifikasi.required' => 'Mohon sertakan alasan penolakan atau kekurangan berkas.',
            'catatan_verifikasi.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $user->update([
            'status_akun' => 'perorangan',
            'status_verifikasi' => 'ditolak',
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return redirect()->route('admin.verifikasi.index')
            ->with('status', "Pengajuan verifikasi akun {$user->name} telah ditolak dengan catatan yang dikirimkan.");
    }

    /**
     * Move / switch user account status directly (e.g. Perorangan <-> Notaris <-> Pengacara).
     */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'status_akun' => ['required', 'string', 'in:perorangan,notaris,pengacara'],
            'catatan_verifikasi' => ['nullable', 'string', 'max:500'],
        ], [
            'status_akun.required' => 'Pilih status akun tujuan.',
            'status_akun.in' => 'Status akun yang dipilih tidak valid.',
        ]);

        $targetStatus = $validated['status_akun'];
        $oldStatusLabel = $user->status_akun_label;

        $updatePayload = [
            'status_akun' => $targetStatus,
            'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? 'Status akun dipindahkan oleh Master Admin.',
        ];

        if (in_array($targetStatus, ['notaris', 'pengacara'], true)) {
            $updatePayload['jenis_akun'] = $targetStatus;
            $updatePayload['status_verifikasi'] = 'terverifikasi';
            $updatePayload['verified_at'] = now();
        } else {
            // Perorangan
            $updatePayload['status_verifikasi'] = 'terverifikasi';
        }

        $user->update($updatePayload);

        return back()->with('status', "Status akun {$user->name} berhasil dipindahkan dari {$oldStatusLabel} menjadi {$user->status_akun_label}.");
    }
}
