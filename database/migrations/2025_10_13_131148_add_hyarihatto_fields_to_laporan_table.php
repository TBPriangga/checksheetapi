<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->string('nama_penemu')->nullable()->after('auditor_id');
            $table->string('npk')->nullable()->after('nama_penemu');
            $table->date('tanggal')->nullable()->after('npk');
            $table->text('potensi_bahaya')->nullable()->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['nama_penemu', 'npk', 'tanggal', 'potensi_bahaya']);
        });
    }
};