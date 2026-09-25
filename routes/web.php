<?php

use App\Http\Controllers\LayananController;
use App\Http\Controllers\PermohonanWasiatController;
use App\Http\Controllers\ProfileController;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isPetugas()) {
        return redirect()->route('petugas.dashboard');
    }

    $user = auth()->user();
    $userPermohonans = Permohonan::with(['pewasiat', 'voucher'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();

    $stats = [
        'total' => $userPermohonans->count(),
        'verifikasi' => $userPermohonans->where('status', 'menunggu_verifikasi')->count(),
        'voucher' => $userPermohonans->where('status', 'menunggu_voucher')->count(),
        'siap' => $userPermohonans->where('status', 'selesai')->count(),
    ];

    $permohonanPerluTindakan = $userPermohonans->first(fn ($p) => in_array($p->status, ['menunggu_voucher', 'revisi']));
    $permohonanSiapSidang = $userPermohonans->firstWhere('status', 'selesai');

    return view('dashboard', compact('userPermohonans', 'stats', 'permohonanPerluTindakan', 'permohonanSiapSidang'));
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/permohonan', [PermohonanWasiatController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/buat', [PermohonanWasiatController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan/buat', [PermohonanWasiatController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan/{permohonan}/tahap-2', [PermohonanWasiatController::class, 'tahap2'])->name('permohonan.tahap2');
    Route::post('/permohonan/{permohonan}/tahap-2', [PermohonanWasiatController::class, 'storeTahap2'])->name('permohonan.tahap2.store');
    Route::get('/permohonan/{permohonan}/tahap-3', [PermohonanWasiatController::class, 'tahap3'])->name('permohonan.tahap3');
    Route::post('/permohonan/{permohonan}/tahap-3', [PermohonanWasiatController::class, 'storeTahap3'])->name('permohonan.tahap3.store');
    Route::get('/permohonan/{permohonan}/tahap-4', [PermohonanWasiatController::class, 'tahap4'])->name('permohonan.tahap4');
    Route::post('/permohonan/{permohonan}/tahap-4', [PermohonanWasiatController::class, 'storeTahap4'])->name('permohonan.tahap4.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/layanan/{slug}', [LayananController::class, 'show'])->name('layanan.pengembangan');
});

require __DIR__.'/auth.php';
