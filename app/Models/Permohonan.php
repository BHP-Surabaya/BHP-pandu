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
        'jenis_layanan',
        'status',
        'catatan_revisi',
        'catatan_petugas',
        'diverifikasi_oleh',
        'tanggal_diverifikasi',
        'disposisi_pic',
        'disposisi_kasi',
        'disposisi_prioritas',
        'tanggal_disposisi',
        'jadwal_pembukaan',
        'tempat_pembukaan',
        'nomor_berita_acara',
        'tanggal_berita_acara',
        'file_berita_acara',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_diverifikasi' => 'datetime',
            'tanggal_disposisi' => 'datetime',
            'jadwal_pembukaan' => 'datetime',
            'tanggal_berita_acara' => 'date',
        ];
    }

    /**
     * Get user-friendly Indonesian label for the status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft Permohonan',
            'menunggu_verifikasi' => 'Menunggu Telaah Berkas',
            'revisi' => 'Perlu Revisi Pemohon',
            'disetujui_pertama', 'menunggu_disposisi' => 'Disetujui Pertama (Menunggu Disposisi)',
            'proses_muda' => 'Verifikasi Lanjutan & Penjadwalan',
            'proses_madya' => 'Proses Sidang & Berita Acara',
            'selesai' => 'Selesai',
            'ditolak' => 'Permohonan Ditolak',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    /**
     * Get human label for jenis layanan.
     */
    public function getJenisLayananLabelAttribute(): string
    {
        return match ($this->jenis_layanan) {
            'skhw' => 'Surat Keterangan Hak Waris (SKHW)',
            'wasiat_terbuka' => 'Pendaftaran Wasiat Terbuka',
            default => 'Pembukaan Wasiat Tertutup',
        };
    }

    /**
     * Get calculated SLA days remaining (Standard: 14 hari kerja / hari).
     */
    public function getSlaSisaHariAttribute(): int
    {
        $created = $this->created_at ?? now();
        $elapsed = (int) $created->diffInDays(now());
        $remaining = 14 - $elapsed;

        return max(0, $remaining);
    }

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

    /**
     * Get the audit logs for the permohonan.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class)->latest('created_at');
    }
}
