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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('status_pembayaran', 30)->default('belum_bayar')->change();
            $table->string('ntpn', 50)->nullable()->after('nomor_voucher');
            $table->unsignedBigInteger('nominal')->nullable()->after('ntpn');
            $table->date('tanggal_bayar')->nullable()->after('nominal');
            $table->string('file_voucher')->nullable()->after('tanggal_bayar');
            $table->timestamp('kadaluarsa_pada')->nullable()->after('file_voucher');
            $table->text('catatan')->nullable()->after('kadaluarsa_pada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn([
                'ntpn',
                'nominal',
                'tanggal_bayar',
                'file_voucher',
                'kadaluarsa_pada',
                'catatan',
            ]);
            $table->enum('status_pembayaran', ['belum_bayar', 'lunas'])->default('belum_bayar')->change();
        });
    }
};
