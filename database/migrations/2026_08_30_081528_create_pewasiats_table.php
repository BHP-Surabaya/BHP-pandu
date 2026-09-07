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
        Schema::create('pewasiats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('dahulu_bernama')->nullable();
            $table->string('alias')->nullable();
            $table->string('nik', 16);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('tempat_tinggal_terakhir');
            $table->string('nomor_akta_ganti_nama')->nullable();
            $table->string('tempat_kematian');
            $table->date('tanggal_kematian');
            $table->string('nomor_akta_kematian');
            $table->date('tanggal_akta_kematian');
            $table->string('pejabat_pembuat_akta_kematian');
            $table->string('nomor_surat_dpw');
            $table->date('tanggal_surat_dpw');
            $table->string('status_pencatatan');
            $table->string('nomor_akta_penyimpanan');
            $table->date('tanggal_akta_penyimpanan');
            $table->string('nama_notaris');
            $table->string('kedudukan_notaris');
            $table->enum('status_kawin', ['tidak_kawin', 'kawin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pewasiats');
    }
};
