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
        Schema::table('dokumens', function (Blueprint $table) {
            $table->string('jenis_dokumen', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            $table->enum('jenis_dokumen', ['akta_kematian', 'surat_keterangan_wasiat', 'akta_penyimpanan_wasiat', 'buku_nikah', 'akta_lahir_ktp_kk', 'dokumen_lainnya'])->change();
        });
    }
};
