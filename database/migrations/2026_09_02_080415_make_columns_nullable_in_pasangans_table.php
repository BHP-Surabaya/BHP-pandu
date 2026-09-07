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
        Schema::table('pasangans', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->string('tempat_kawin')->nullable()->change();
            $table->date('tanggal_kawin')->nullable()->change();
            $table->string('bukti_perkawinan')->nullable()->change();
            $table->string('nomor_bukti_perkawinan')->nullable()->change();
            $table->date('tanggal_bukti_perkawinan')->nullable()->change();
            $table->string('pejabat_pembuat_bukti')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasangans', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->string('tempat_kawin')->nullable(false)->change();
            $table->date('tanggal_kawin')->nullable(false)->change();
            $table->string('bukti_perkawinan')->nullable(false)->change();
            $table->string('nomor_bukti_perkawinan')->nullable(false)->change();
            $table->date('tanggal_bukti_perkawinan')->nullable(false)->change();
            $table->string('pejabat_pembuat_bukti')->nullable(false)->change();
        });
    }
};
