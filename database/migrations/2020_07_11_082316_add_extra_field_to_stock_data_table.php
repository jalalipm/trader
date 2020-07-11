<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldToStockDataTable extends Migration
{

    public function up()
    {
        Schema::table('stock_data', function (Blueprint $table) {
            $table->string('market_value_symbol', 1)->default('B');
            $table->string('transaction_count_symbol', 1)->default('M');
            $table->string('transaction_value_symbol', 1)->default('B');
            $table->string('transaction_volume_symbol', 1)->default('B');
        });
    }


    public function down()
    {
        Schema::table('stock_data', function (Blueprint $table) {
            $table->dropColumn(['market_value_symbol','transaction_count_symbol',
                'transaction_value_symbol','transaction_volume_symbol']);
        });
    }
}
