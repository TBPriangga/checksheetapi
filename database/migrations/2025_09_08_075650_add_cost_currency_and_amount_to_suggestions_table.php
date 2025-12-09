<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostCurrencyAndAmountToSuggestionsTable extends Migration
{
    public function up()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            $table->string('cost_currency')->after('kategori_ide')->nullable(); // Kolom untuk mata uang
            $table->decimal('cost_amount', 15, 2)->after('cost_currency')->nullable(); // Kolom untuk jumlah dengan 2 desimal
        });
    }

    public function down()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            $table->dropColumn(['cost_currency', 'cost_amount']);
        });
    }
}