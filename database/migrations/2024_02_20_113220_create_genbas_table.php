<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genbas', function (Blueprint $table) {
            $table->id();
            $table->integer('pic_auditor_id')->references('id')->on('users');
            $table->integer('area_id')->references('id')->on('areas');
            $table->integer('team_id')->references('id')->on('teams');
            $table->string("tanggal_patrol");
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genbas');
    }
}
