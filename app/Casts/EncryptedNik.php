<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class EncryptedNik implements CastsAttributes
{
    /**
     * Cast the given value from storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $unwrapped = (string) $value;

        // Loop to safely unwrap any potential double (or multiple) encryption
        while (str_starts_with($unwrapped, 'eyJ')) {
            try {
                $decrypted = Crypt::decryptString($unwrapped);
                $unwrapped = $decrypted;
            } catch (Throwable) {
                // If decryption fails (e.g. malformed JSON or mismatched APP_KEY), stop unwrapping
                break;
            }
        }

        return $unwrapped;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $plain = (string) $value;

        // If the incoming value is already encrypted, unwrap it first to get the clean plaintext
        while (str_starts_with($plain, 'eyJ')) {
            try {
                $plain = Crypt::decryptString($plain);
            } catch (Throwable) {
                break;
            }
        }

        // Always store as encrypted string
        return Crypt::encryptString($plain);
    }
}
