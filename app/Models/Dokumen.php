<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'jenis_dokumen',
        'file_path',
        'sudah_barcode',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'sudah_barcode' => 'boolean',
        ];
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }
}
