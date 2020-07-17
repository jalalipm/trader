<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldToUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->enum('payment_kind', ['credit', 'debit']);
            $table->enum('payment_type', ['interest', 'loss', 'refund', 'payment']);
            $table->dateTime('transaction_date');
            $table->unsignedbiginteger('payment_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->dropColumn(['payment_kind', 'payment_type', 'transaction_date']);
            $table->unsignedbiginteger('payment_id')->nullable()->change();
        });
    }
}
