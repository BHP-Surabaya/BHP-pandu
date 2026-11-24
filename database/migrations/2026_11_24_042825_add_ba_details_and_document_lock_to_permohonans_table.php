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
        Schema::table('permohonans', function (Blueprint $table) {
            $table->json('data_berita_acara')->nullable()->after('file_berita_acara');
            $table->boolean('dokumen_terkunci')->default(false)->after('data_berita_acara');
            $table->timestamp('dokumen_dikunci_at')->nullable()->after('dokumen_terkunci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'data_berita_acara',
                'dokumen_terkunci',
                'dokumen_dikunci_at',
            ]);
        });
    }
};
