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

        // Akun JFKK Pertama (Kurator Keperdataan Pertama)
        User::firstOrCreate(
            ['email' => 'jfkk.pertama@pandubhp.go.id'],
            [
                'name' => 'Iman, S.H.',
                'password' => bcrypt('password'),
                'role' => 'petugas',
                'pekerjaan' => 'Kurator Keperdataan Pertama',
                'status_akun' => 'petugas',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Akun JFKK Muda (Kurator Keperdataan Muda)
        User::firstOrCreate(
            ['email' => 'jfkk.muda@pandubhp.go.id'],
            [
                'name' => 'Lutfy, S.H.',
                'password' => bcrypt('password'),
                'role' => 'kurator_muda',
                'pekerjaan' => 'Kurator Keperdataan Muda',
                'status_akun' => 'kurator_muda',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Akun JFKK Madya (Kurator Keperdataan Madya)
        User::firstOrCreate(
            ['email' => 'jfkk.madya@pandubhp.go.id'],
            [
                'name' => 'Inara, S.H., M.H.',
                'password' => bcrypt('password'),
                'role' => 'kurator_madya',
                'pekerjaan' => 'Kurator Keperdataan Madya',
                'status_akun' => 'kurator_madya',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Akun Bendahara Penerimaan
        User::firstOrCreate(
            ['email' => 'bendahara@pandubhp.go.id'],
            [
                'name' => 'Bendahara Penerimaan BHP',
                'password' => bcrypt('password'),
                'role' => 'bendahara',
                'pekerjaan' => 'Bendahara Penerimaan',
                'status_akun' => 'bendahara',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );

        // Akun Pemohon / Notaris
        User::firstOrCreate(
            ['email' => 'f.tsaqif2004@gmail.com'],
            [
                'name' => 'Fernanda Tsaqif',
                'password' => bcrypt('password'),
                'role' => 'pemohon',
                'pekerjaan' => 'Notaris',
                'jenis_akun' => 'notaris',
                'status_akun' => 'notaris',
                'status_verifikasi' => 'terverifikasi',
                'email_verified_at' => now(),
            ]
        );
    }
}
