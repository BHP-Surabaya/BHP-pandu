<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'email_verified_at',
    'nik',
    'phone',
    'foto_profil',
    'pekerjaan',
    'jenis_akun',
    'status_akun',
    'status_verifikasi',
    'verified_at',
    'catatan_verifikasi',
    'alamat_ktp',
    'alamat_domisili',
    'sk_notaris',
    'sk_ppat',
    'berita_acara_sumpah',
    'id_card_pengacara',
    'alamat_kantor',
    'password',
    'role',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Check if the user is a Master Admin.
     */
    public function isMasterAdmin(): bool
    {
        return $this->role === 'master_admin';
    }

    /**
     * Check if the user is a BHP petugas (staff).
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Check if the user is a pemohon (applicant).
     */
    public function isPemohon(): bool
    {
        return $this->role === 'pemohon';
    }

    /**
     * Check if the user registered as Notaris.
     */
    public function isNotaris(): bool
    {
        return $this->status_akun === 'notaris' || $this->jenis_akun === 'notaris';
    }

    /**
     * Check if the user registered as Pengacara.
     */
    public function isPengacara(): bool
    {
        return $this->status_akun === 'pengacara' || $this->jenis_akun === 'pengacara';
    }

    /**
     * Check if the account has pending verification from Master Admin.
     */
    public function isVerifikasiPending(): bool
    {
        return $this->status_verifikasi === 'menunggu_verifikasi';
    }

    /**
     * Check if the account is verified by Master Admin.
     */
    public function isTerverifikasi(): bool
    {
        return $this->status_verifikasi === 'terverifikasi';
    }

    /**
     * Check if current active status is perorangan.
     */
    public function isPerorangan(): bool
    {
        return $this->status_akun === 'perorangan' || empty($this->status_akun);
    }

    /**
     * Check if the user is authorized to access Notaris services (Pembukaan Wasiat, Pendaftaran Wasiat).
     */
    public function canAccessNotarisServices(): bool
    {
        return $this->isMasterAdmin() || $this->isPetugas() || $this->status_akun === 'notaris';
    }

    /**
     * Check if the user is authorized to access Pengacara services (Layanan Kepailitan).
     */
    public function canAccessPengacaraServices(): bool
    {
        return $this->isMasterAdmin() || $this->isPetugas() || $this->status_akun === 'pengacara';
    }

    /**
     * Get label for user account status.
     */
    public function getStatusAkunLabelAttribute(): string
    {
        if ($this->isMasterAdmin()) {
            return 'Master Admin';
        }

        if ($this->status_akun === 'notaris') {
            return 'Akun Notaris';
        }

        if ($this->status_akun === 'pengacara') {
            return 'Akun Pengacara';
        }

        return 'Akun Perorangan';
    }

    /**
     * Get the permohonans for the user.
     */
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }

    /**
     * Get the URL to the user's profile photo, or null.
     */
    public function getFotoProfilUrlAttribute(): ?string
    {
        if ($this->foto_profil) {
            return asset('storage/'.$this->foto_profil);
        }

        return null;
    }

    /**
     * Get initials of the user.
     */
    public function getInitialsAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->name));
        if (count($words) >= 2) {
            return strtoupper(mb_substr($words[0], 0, 1).mb_substr(end($words), 0, 1));
        }

        return strtoupper(mb_substr($this->name, 0, 2));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
