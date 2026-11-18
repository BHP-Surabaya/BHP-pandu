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
            $table->string('status', 50)->default('draft')->change();
            $table->string('jenis_layanan', 50)->default('wasiat_tertutup')->after('nomor_permohonan');
            $table->text('catatan_petugas')->nullable()->after('catatan_revisi');
            $table->string('diverifikasi_oleh', 255)->nullable()->after('catatan_petugas');
            $table->timestamp('tanggal_diverifikasi')->nullable()->after('diverifikasi_oleh');
            $table->string('disposisi_pic', 255)->nullable()->after('tanggal_diverifikasi');
            $table->text('disposisi_kasi')->nullable()->after('disposisi_pic');
            $table->string('disposisi_prioritas', 50)->nullable()->default('biasa')->after('disposisi_kasi');
            $table->timestamp('tanggal_disposisi')->nullable()->after('disposisi_prioritas');
            $table->dateTime('jadwal_pembukaan')->nullable()->after('tanggal_disposisi');
            $table->string('tempat_pembukaan', 255)->nullable()->after('jadwal_pembukaan');
            $table->string('nomor_berita_acara', 100)->nullable()->after('tempat_pembukaan');
            $table->date('tanggal_berita_acara')->nullable()->after('nomor_berita_acara');
            $table->string('file_berita_acara', 255)->nullable()->after('tanggal_berita_acara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_layanan',
                'catatan_petugas',
                'diverifikasi_oleh',
                'tanggal_diverifikasi',
                'disposisi_pic',
                'disposisi_kasi',
                'disposisi_prioritas',
                'tanggal_disposisi',
                'jadwal_pembukaan',
                'tempat_pembukaan',
                'nomor_berita_acara',
                'tanggal_berita_acara',
                'file_berita_acara',
            ]);
            $table->enum('status', ['draft', 'menunggu_verifikasi', 'revisi', 'menunggu_voucher', 'selesai'])->default('draft')->change();
        });
    }
};
