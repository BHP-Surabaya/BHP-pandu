<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Akun Master Admin BHP
        User::firstOrCreate(
            ['email' => 'admin@pandubhp.go.id'],
            [
                'name' => 'Master Admin BHP',
                'password' => bcrypt('password'),
                'role' => 'master_admin',
                'pekerjaan' => 'Master Admin',
                'jenis_akun' => 'master_admin',
                'status_akun' => 'master_admin',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Akun Petugas BHP
        User::firstOrCreate(
            ['email' => 'petugas@bhp.test'],
            [
                'name' => 'Petugas BHP',
                'password' => bcrypt('password'),
                'role' => 'petugas',
                'pekerjaan' => 'Petugas BHP',
                'status_akun' => 'petugas',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Akun KASI (Kepala Seksi)
        User::firstOrCreate(
            ['email' => 'kasi@pandubhp.go.id'],
            [
                'name' => 'Ahmad Rizki, S.T.',
                'password' => bcrypt('password'),
                'role' => 'kasi',
                'pekerjaan' => 'Kepala Seksi',
                'status_akun' => 'kasi',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Contoh akun Pemohon
        User::firstOrCreate(
            ['email' => 'pemohon@bhp.test'],
            [
                'name' => 'Contoh Pemohon',
                'password' => bcrypt('password'),
                'role' => 'pemohon',
                'pekerjaan' => 'Wiraswasta',
                'jenis_akun' => 'perorangan',
                'status_akun' => 'perorangan',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );
    }
}
