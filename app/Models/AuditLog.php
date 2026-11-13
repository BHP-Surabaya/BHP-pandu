<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'permohonan_id',
        'action',
        'resource_type',
        'resource_id',
        'description',
        'ip_address',
        'user_agent',
        'details',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'details' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Pengguna yang melakukan aktivitas.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Permohonan terkait (jika ada).
     */
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }
}
