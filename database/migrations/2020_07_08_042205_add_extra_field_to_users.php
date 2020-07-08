<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldToUsers extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
                $table->string('national_code',10);
                $table->string('first_name',100);
                $table->string('last_name',100);
                $table->string('address',500)->nullable();
                $table->string('cell_phone',11)->unique();
//                $table->dropUnique('users_email_unique');
                $table->string('email')->nullable()->change();
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['national_code', 'first_name', 'last_name', 'address', 'cell_phone']);
//            $table->unique('email');
            $table->string('email')->nullable(false)->change();
        });
    }
}
