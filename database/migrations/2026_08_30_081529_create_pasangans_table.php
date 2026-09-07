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
        Schema::create('pasangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pewasiat_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('tempat_kawin');
            $table->date('tanggal_kawin');
            $table->string('bukti_perkawinan');
            $table->string('nomor_bukti_perkawinan');
            $table->date('tanggal_bukti_perkawinan');
            $table->string('pejabat_pembuat_bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasangans');
    }
};
