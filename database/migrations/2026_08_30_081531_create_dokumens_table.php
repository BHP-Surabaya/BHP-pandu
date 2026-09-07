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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis_dokumen', ['akta_kematian', 'surat_keterangan_wasiat', 'akta_penyimpanan_wasiat', 'buku_nikah', 'akta_lahir_ktp_kk', 'dokumen_lainnya']);
            $table->string('file_path');
            $table->boolean('sudah_barcode')->default(false);
            $table->enum('status', ['belum_diunggah', 'diunggah', 'diverifikasi', 'ditolak'])->default('belum_diunggah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
