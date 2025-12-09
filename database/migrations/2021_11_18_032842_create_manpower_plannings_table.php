<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManpowerPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manpower_plannings', function (Blueprint $table) {

            $table->id();
            $table->string('mpp_number')->unique();
            $table->integer('period');
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('section_id');
            $table->integer('additional');
            $table->integer('reduce');
            $table->enum('source', ['internal', 'external']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dept_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manpower_plannings');
    }
}
