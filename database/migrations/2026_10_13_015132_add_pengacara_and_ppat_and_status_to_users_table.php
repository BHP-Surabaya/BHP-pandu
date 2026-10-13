<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sk_ppat')->nullable()->after('sk_notaris');
            $table->string('berita_acara_sumpah')->nullable()->after('sk_ppat');
            $table->string('id_card_pengacara')->nullable()->after('berita_acara_sumpah');
            $table->string('jenis_akun')->default('perorangan')->after('pekerjaan');
            $table->string('status_akun')->default('perorangan')->after('jenis_akun');
            $table->string('status_verifikasi')->default('terverifikasi')->after('status_akun');
            $table->timestamp('verified_at')->nullable()->after('status_verifikasi');
            $table->text('catatan_verifikasi')->nullable()->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'sk_ppat',
                'berita_acara_sumpah',
                'id_card_pengacara',
                'jenis_akun',
                'status_akun',
                'status_verifikasi',
                'verified_at',
                'catatan_verifikasi',
            ]);
        });
    }
};
