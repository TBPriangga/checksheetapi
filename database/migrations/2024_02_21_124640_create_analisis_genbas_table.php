<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisGenbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis_genbas', function (Blueprint $table) {
            $table->id();
            $table->text('man')->nullable();
            $table->text('material')->nullable();
            $table->text('machine')->nullable();
            $table->text('methode')->nullable();
            $table->text('what')->nullable();
            $table->text('where')->nullable();
            $table->text('when')->nullable();
            $table->text('why')->nullable();
            $table->text('who')->nullable();
            $table->text('how')->nullable();
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
        Schema::dropIfExists('analisis_genbas');
    }
}
