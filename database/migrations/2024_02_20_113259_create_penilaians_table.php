<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->integer("pertanyaan_1");
            $table->integer("pertanyaan_2");
            $table->integer("pertanyaan_3");
            $table->integer("pertanyaan_4");
            $table->integer("pertanyaan_5");
            $table->integer("pertanyaan_6");
            $table->integer("pertanyaan_7");
            $table->integer("pertanyaan_8");
            $table->integer("pertanyaan_9");
            $table->integer("pertanyaan_10");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaians');
    }
}
