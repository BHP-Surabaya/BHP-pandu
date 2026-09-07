<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_permohonan',
        'status',
        'catatan_revisi',
    ];

    /**
     * Get the user who submitted the permohonan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pewasiat associated with the permohonan.
     */
    public function pewasiat(): HasOne
    {
        return $this->hasOne(Pewasiat::class);
    }

    /**
     * Get the dokumens for the permohonan.
     */
    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }

    /**
     * Get the voucher for the permohonan.
     */
    public function voucher(): HasOne
    {
        return $this->hasOne(Voucher::class);
    }
}
