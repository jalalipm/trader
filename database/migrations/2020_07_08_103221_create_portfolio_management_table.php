<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioManagementTable extends Migration
{

    public function up()
    {
        Schema::create('portfolio_managements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('avatar', 200);
            $table->text('describtion')->nullable();
            $table->double('interest_rate', 4, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('portfolio_managements');
    }
}
