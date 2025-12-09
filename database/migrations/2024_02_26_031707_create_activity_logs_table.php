<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('auditor_id')->references('id')->on('users');
            $table->integer('laporan_id')->references('id')->on('laporans');
            $table->integer('area_id')->references('id')->on('areas');
            $table->enum('event_type', ['create', 'edit', 'delete','approve','update','tolak']);
            $table->text('deskripsi')->nullable();
            $table->boolean('status_read_auditor')->default(false);
            $table->boolean('status_read_ehs')->default(false);
            $table->boolean('status_read_PIC')->default(false);
            $table->boolean('status_read_Dept_head_EHS')->default(false);
            $table->boolean('status_read_Dept_head_PIC')->default(false);
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
        Schema::dropIfExists('activity_logs');
    }
}
