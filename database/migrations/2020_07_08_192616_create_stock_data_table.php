<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDataTable extends Migration
{
    public function up()
    {
        Schema::create('stock_data', function (Blueprint $table) {
            $table->id();
            $table->double('general_index', 18, 2)->default(0);
            $table->double('general_index_change', 18, 2)->default(0);
            $table->double('general_index_same_weight', 18, 2)->default(0);
            $table->double('general_index_same_weight_change', 18, 2)->default(0);
            $table->double('market_value', 18, 2)->default(0);
            $table->double('transaction_count', 18, 2)->default(0);
            $table->double('transaction_value', 18, 2)->default(0);
            $table->double('transaction_volume', 18, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_data');
    }
}
