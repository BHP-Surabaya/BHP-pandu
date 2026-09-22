<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'nik', 'phone', 'pekerjaan', 'alamat_ktp', 'alamat_domisili', 'sk_notaris', 'alamat_kantor', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
     * Get the permohonans for the user.
     */
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
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
            'password' => 'hashed',
        ];
    }
}
