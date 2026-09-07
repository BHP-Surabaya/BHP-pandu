<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'kode_voucher',
        'nominal',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'kadaluarsa_pada',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }
}
