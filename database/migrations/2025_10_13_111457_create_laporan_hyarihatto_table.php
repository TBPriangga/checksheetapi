<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_hyarihatto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patrol_id')->constrained('ehs_patrols')->onDelete('cascade'); // Relasi ke patrol
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('auditor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('PIC_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal'); // Kolom tanggal
            $table->string('nama_penemu'); // Nama
            $table->string('npk'); // NPK
            $table->text('problem_temuan'); // Problem
            $table->text('potensi_bahaya'); // Potensi Bahaya
            $table->string('kategori'); // Kategori
            $table->enum('rank', ['A', 'B', 'C']); // Rank
            $table->float('progress')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_hyarihatto');
    }
};