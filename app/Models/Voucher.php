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
        'nomor_voucher',
        'ntpn',
        'nominal',
        'status_pembayaran',
        'tanggal_bayar',
        'file_voucher',
        'kadaluarsa_pada',
        'catatan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_bayar' => 'date',
            'kadaluarsa_pada' => 'datetime',
            'nominal' => 'integer',
        ];
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    /**
     * Check if the voucher / PNBP is paid.
     */
    public function isLunas(): bool
    {
        return in_array($this->status_pembayaran, ['lunas', 'sudah_bayar'], true);
    }

    /**
     * Check if the voucher / PNBP is expired (exceeded 14 days SLA).
     */
    public function isKadaluarsa(): bool
    {
        if ($this->status_pembayaran === 'kadaluarsa') {
            return true;
        }

        if ($this->isLunas()) {
            return false;
        }

        if ($this->kadaluarsa_pada && $this->kadaluarsa_pada->isPast()) {
            return true;
        }

        return false;
    }

    /**
     * Calculate remaining days in 14-day SLA.
     */
    public function sisaHariSla(): int
    {
        if ($this->isLunas()) {
            return 0;
        }

        $deadline = $this->kadaluarsa_pada ?? $this->created_at?->copy()->addDays(14);
        if (! $deadline) {
            return 14;
        }

        $now = now()->startOfDay();
        $target = $deadline->copy()->startOfDay();

        return (int) max(0, $now->diffInDays($target, false));
    }

    /**
     * Format nominal to IDR Rupiah currency.
     */
    public function getFormattedNominalAttribute(): string
    {
        return 'Rp '.number_format($this->nominal ?? 0, 0, ',', '.');
    }
}
