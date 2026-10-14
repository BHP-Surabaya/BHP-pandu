<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a verified Notaris.
     */
    public function notaris(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_akun' => 'notaris',
            'jenis_akun' => 'notaris',
            'pekerjaan' => 'Notaris',
            'status_verifikasi' => 'terverifikasi',
        ]);
    }

    /**
     * Indicate that the user is a verified Pengacara.
     */
    public function pengacara(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_akun' => 'pengacara',
            'jenis_akun' => 'pengacara',
            'pekerjaan' => 'Pengacara',
            'status_verifikasi' => 'terverifikasi',
        ]);
    }

    /**
     * Indicate that the user is an Akun Perorangan.
     */
    public function perorangan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_akun' => 'perorangan',
            'jenis_akun' => 'perorangan',
            'pekerjaan' => 'Perorangan',
            'status_verifikasi' => 'terverifikasi',
        ]);
    }
}
