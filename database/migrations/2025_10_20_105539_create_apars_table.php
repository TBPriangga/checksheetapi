<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_apar')->unique(); // Kode unik APAR, e.g., APAR001
            $table->string('lokasi'); // Lokasi APAR, e.g., Lantai 1
            $table->boolean('is_checked')->default(false); // Status: sudah/belum dicek
            $table->dateTime('last_checked')->nullable(); // Tanggal terakhir dicek
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang cek
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apars');
    }
};