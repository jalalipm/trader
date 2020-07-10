<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ref_id', 255); //شناسه یکتای درگاه(مثلا جیبیت)
            $table->decimal('amount', 18, 2)->default(0);
            $table->string('currency', 100)->nullable(); //واحد پول	
            $table->string('reference_number', 100)->nullable(); //شناسه یکتای پذیرنده	
            $table->string('callback_url', 250)->nullable(); //	
            $table->string('status', 100)->nullable(); //	
            $table->string('init_payer_ip', 100)->nullable(); //	
            $table->string('redirect_payer_ip', 100)->nullable(); //
            $table->dateTime('transaction_date'); //زمان
            $table->string('payer_card', 100)->nullable(); //شماره کارت	
            $table->string('payer_name', 100)->nullable(); //پرداخت کننده 
            $table->enum('payment_kind', ['credit', 'debit']);
            $table->boolean('is_success')->default(1);
            $table->text('description')->nullable(); //توضیحات
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        /*"id": "dw5QdxZw",
    "amount": 3700000.00,
    "currency": "TOMAN",
    "referenceNumber": "1594067952",
    "userIdentifier": "0",
    "callbackUrl": "http://3paresh.com/payment/zarinpal.php?back=rent.jabit.userapp.bookingDetails&i=2990",
    "status": "SUCCESS",
    "initPayerIp": "89.199.224.111",
    "redirectPayerIp": "89.199.224.111",
    "createdAt": "2020-07-06T20:39:13.196623Z",
    "modifiedAt": "2020-07-06T20:41:01.554475Z",
    "expirationDate": "2020-07-06T20:54:13.195959Z",
    "payerCard": "589463******6855",
    "payerName": " سيد حامد چاوشي" */

        /*"id": "83D50z0w",
    "amount": 3700000.00,
    "currency": "TOMAN",
    "referenceNumber": "1594065587",
    "userIdentifier": "0",
    "callbackUrl": "http://3paresh.com/payment/zarinpal.php?back=rent.jabit.userapp.bookingDetails&i=2990",
    "status": "EXPIRED",
    "initPayerIp": "5.74.55.103",
    "createdAt": "2020-07-06T19:59:48.733276Z",
    "modifiedAt": "2020-07-06T20:14:55.826676Z",
    "expirationDate": "2020-07-06T20:14:48.732629Z" */

        /*"id": "VrMEVQEr",
    "amount": 1000000.00,
    "currency": "TOMAN",
    "referenceNumber": "1593430526",
    "userIdentifier": "0",
    "callbackUrl": "http://3paresh.com/payment/zarinpal.php?back=Web&i=2948",
    "description": "پرداخت بابت رزرو شماره 2948",
    "status": "EXPIRED",
    "initPayerIp": "94.183.110.96",
    "createdAt": "2020-06-29T11:35:27.779430Z",
    "modifiedAt": "2020-06-29T11:50:51.977342Z",
    "expirationDate": "2020-06-29T11:50:27.778854Z"*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
