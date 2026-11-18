<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['pewasiats', 'pasangans', 'ahli_waris', 'users'];

        foreach ($tables as $table) {
            $rows = DB::table($table)->whereNotNull('nik')->get(['id', 'nik']);

            foreach ($rows as $row) {
                $rawNik = (string) $row->nik;

                // Unwrap any multiple encryptions to find the real plaintext
                $plain = $rawNik;
                while (str_starts_with($plain, 'eyJ')) {
                    try {
                        $plain = Crypt::decryptString($plain);
                    } catch (Throwable) {
                        break;
                    }
                }

                // If it was plaintext, or was multi-encrypted, re-encrypt cleanly once
                if (! str_starts_with($rawNik, 'eyJ') || $plain !== $rawNik) {
                    try {
                        $cleanEncrypted = Crypt::encryptString($plain);
                        DB::table($table)->where('id', $row->id)->update(['nik' => $cleanEncrypted]);
                    } catch (Throwable) {
                        // Keep as is if error occurs
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversible if needed
    }
};
