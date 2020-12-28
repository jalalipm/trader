<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFinanceHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_finance_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('portfolio_management_id');
            $table->date('trade_date');
            $table->decimal('fund', 18, 2)->default(0);
            // $table->decimal('before_percent_of_basket', 18, 2)->default(0);
            $table->decimal('current_fund', 18, 2)->default(0);
            // $table->decimal('cost_benefit', 18, 2)->default(0);
            // $table->decimal('basket_commission', 18, 2)->default(0);
            // $table->decimal('remain_after_commission', 18, 2)->default(0);
            $table->decimal('deposit', 18, 2)->default(0);
            $table->decimal('withdraw', 18, 2)->default(0);
            // $table->decimal('withdrawable', 18, 2)->default(0);
            $table->decimal('pure_price', 18, 2)->default(0);
            $table->decimal('percent_of_basket', 18, 2)->default(0);
            $table->decimal('final_price', 18, 2)->default(0);
            $table->foreign('portfolio_management_id')->references('id')->on('portfolio_managements');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_finance_history');
    }
}
