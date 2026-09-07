<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pewasiat_id',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'tempat_kawin',
        'tanggal_kawin',
        'bukti_perkawinan',
        'nomor_bukti_perkawinan',
        'tanggal_bukti_perkawinan',
        'pejabat_pembuat_bukti',
    ];

    /**
     * Get the pewasiat that owns the pasangan.
     */
    public function pewasiat(): BelongsTo
    {
        return $this->belongsTo(Pewasiat::class);
    }
}
