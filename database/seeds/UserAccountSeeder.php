<?php

use App\Model\Payment;
use App\Model\RefundRequest;
use App\Model\UserAccount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $portfolio = random_int(1, 9);
            $payment_id = random_int(2, 11);
            $payment = Payment::find($payment_id);
            UserAccount::create([
                'payment_id' => $payment_id,
                'portfolio_management_id' => $portfolio,
                'price' => $payment->amount,
                'payment_kind' => 2,
                'payment_type' => 4,
                'transaction_date' => $payment->transaction_date
            ]);
        }
    }
}
