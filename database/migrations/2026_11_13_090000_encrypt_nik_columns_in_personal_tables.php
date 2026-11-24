<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pewasiats', function (Blueprint $table) {
            $table->text('nik')->change();
        });

        Schema::table('pasangans', function (Blueprint $table) {
            $table->text('nik')->nullable()->change();
        });

        Schema::table('ahli_waris', function (Blueprint $table) {
            $table->text('nik')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('nik')->nullable()->change();
        });

        // Encrypt any existing plaintext NIK in users table
        $users = DB::table('users')->whereNotNull('nik')->get(['id', 'nik']);
        foreach ($users as $user) {
            if (! str_starts_with((string) $user->nik, 'eyJ')) {
                try {
                    $encrypted = Crypt::encryptString($user->nik);
                    DB::table('users')->where('id', $user->id)->update(['nik' => $encrypted]);
                } catch (Throwable) {
                    // Ignore if already encrypted or invalid
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Decrypt users NIK if reverting
        $users = DB::table('users')->whereNotNull('nik')->get(['id', 'nik']);
        foreach ($users as $user) {
            try {
                $decrypted = Crypt::decryptString($user->nik);
                DB::table('users')->where('id', $user->id)->update(['nik' => substr($decrypted, 0, 16)]);
            } catch (Throwable) {
                // Ignore if not decryptable
            }
        }

        Schema::table('pewasiats', function (Blueprint $table) {
            $table->string('nik', 16)->change();
        });

        Schema::table('pasangans', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->change();
        });

        Schema::table('ahli_waris', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->change();
        });
    }
};
