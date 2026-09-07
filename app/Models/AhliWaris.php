<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AhliWaris extends Model
{
    use HasFactory;

    protected $table = 'ahli_waris';

    protected $fillable = [
        'pewasiat_id',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
    ];

    /**
     * Get the pewasiat that owns the ahli waris.
     */
    public function pewasiat(): BelongsTo
    {
        return $this->belongsTo(Pewasiat::class);
    }
}
