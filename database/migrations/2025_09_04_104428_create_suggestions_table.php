<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up(): void
       {
           Schema::create('suggestions', function (Blueprint $table) {
               $table->id();
               $table->string('nama');
               $table->string('npk')->unique();
               $table->string('departemen');
               $table->string('section');
               $table->string('kategori_ide');
               $table->decimal('cost_saving', 15, 2)->nullable();
               $table->string('judul_ide');
               $table->text('before');
               $table->text('after');
               $table->string('before_image')->nullable();
               $table->string('after_image')->nullable();
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->timestamps();
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('suggestions');
       }
   };