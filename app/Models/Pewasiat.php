<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pewasiat extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'nama_lengkap',
        'dahulu_bernama',
        'alias',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'tempat_tinggal_terakhir',
        'nomor_akta_ganti_nama',
        'tempat_kematian',
        'tanggal_kematian',
        'nomor_akta_kematian',
        'tanggal_akta_kematian',
        'pejabat_pembuat_akta_kematian',
        'nomor_surat_dpw',
        'tanggal_surat_dpw',
        'status_pencatatan',
        'nomor_akta_penyimpanan',
        'tanggal_akta_penyimpanan',
        'nama_notaris',
        'kedudukan_notaris',
        'status_kawin',
    ];

    /**
     * Get the permohonan that owns the pewasiat.
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    /**
     * Get the pasangans for the pewasiat.
     */
    public function pasangans(): HasMany
    {
        return $this->hasMany(Pasangan::class);
    }

    /**
     * Get the ahli waris (anak) for the pewasiat.
     */
    public function ahliWaris(): HasMany
    {
        return $this->hasMany(AhliWaris::class);
    }
}
