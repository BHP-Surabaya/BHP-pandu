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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Akun Petugas BHP
        User::factory()->create([
            'name' => 'Petugas BHP',
            'email' => 'petugas@bhp.test',
            'role' => 'petugas',
        ]);

        // Contoh akun Pemohon
        User::factory()->create([
            'name' => 'Contoh Pemohon',
            'email' => 'pemohon@bhp.test',
            'role' => 'pemohon',
        ]);
    }
}
