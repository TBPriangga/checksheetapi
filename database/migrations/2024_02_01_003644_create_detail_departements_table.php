<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailDepartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_departements', function (Blueprint $table) {
            $table->id();
            $table->integer("departement_id")->references('id')->on('departments');
            $table->string("name");
            $table->string("code")->nullable();
            $table->string("email_depthead")->nullable();
            $table->string("email_director")->nullable();
            $table->string("email_spv")->nullable();
            $table->string("email_members")->nullable();
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
        Schema::dropIfExists('detail_departements');
    }
}
