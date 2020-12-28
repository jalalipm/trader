<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioDailyTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_daily_trade', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_management_id');
            $table->dateTime('trade_date');
            $table->decimal('trade_nav', 18, 2)->default(0);
            $table->double('trade_percent', 18, 2)->default(0);
            $table->foreign('portfolio_management_id')->references('id')->on('portfolio_managements');
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
        Schema::dropIfExists('portfolio_daily_trade');
    }
}
