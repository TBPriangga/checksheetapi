<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('apars', function (Blueprint $table) {
            $table->unsignedTinyInteger('area_id')->nullable()->after('id');
            $table->index('area_id'); // untuk performa
        });
    }

    public function down()
    {
        Schema::table('apars', function (Blueprint $table) {
            $table->dropIndex(['area_id']);
            $table->dropColumn('area_id');
        });
    }
};