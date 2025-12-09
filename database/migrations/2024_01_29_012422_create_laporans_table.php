<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->integer('genba_id')->references('id')->on('genbas')->nullable();
            $table->integer('patrol_id')->references('id')->on('ehs_patrols')->nullable();
            $table->integer('auditor_id')->references('id')->on('users');
            $table->integer('PIC_id')->references('id')->on('users');
            $table->integer('dept_ehs_id')->references('id')->on('users')->nullable();
            $table->integer('dept_pic_id')->references('id')->on('users')->nullable();
            $table->integer('team_id')->nullable();
            $table->integer('area_id')->references('id')->on('areas');
            $table->enum('rank', ['A', 'B', 'C']);
            $table->enum('kategori', ['5R', 'A', 'B', 'C', 'D', 'E', 'F', 'G']);
            $table->text('temuan')->nullable();
            $table->integer('analisis_genba_id')->nullable()->references('id')->on('analisis_genba');
            $table->string('foto_temuan')->nullable();
            $table->text('temporary_solution')->nullable();
            $table->text('penanggulangan')->nullable();
            $table->string('foto_penanggulangan')->nullable();
            $table->float('progress')->nullable();
            $table->string('alasan_penolakan')->nullable();
            $table->timestamp('deadline_date_awal')->nullable();
            $table->timestamp('deadline_date')->nullable();
            $table->boolean('status_due_date_lanjutan')->nullable();
            $table->timestamp('verify_submit_at')->nullable();
            $table->timestamp('PIC_submit_at')->nullable();
            $table->timestamp('ACC_Dept_Head_EHS_At')->nullable();
            $table->timestamp('ACC_Dept_Head_PIC_At')->nullable();
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
        Schema::dropIfExists('laporans');
    }
}
