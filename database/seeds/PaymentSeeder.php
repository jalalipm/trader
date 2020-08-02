<?php

use App\Model\Payment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = $this->getFaker();
        for ($i = 0; $i < 10; $i++) {
            $rnd = random_int(1, 2);
            Payment::create([
                "user_id" => $rnd == 1 ? 2 : 9,
                "ref_id" => substr(md5(mt_rand()), 0, 7),
                "amount" =>  random_int(1000000, 20000000),
                "currency" => 'RIALS',
                "reference_number" =>  random_int(135254650, 323568599),
                "callback_url" =>  '',
                "description" => '',
                "status" => 1, //$rnd == 1 ? 'SUCCESS' : 'FAILED',
                "init_payer_ip" => '',
                "redirect_payer_ip" => '',
                "transaction_date" => Carbon::now(),
                "payer_card" =>  $rnd == 1 ? '6037-9910-2896-8045' : '6122-8811-2380-9025',
                "payer_name" => $rnd == 1 ? 'حسام فلاحیان' : 'نیکان باقرپور',
                "payment_kind" => 2,
                "is_success" => $rnd == 1 ? 1 : 0,
            ]);
        }
    }
}
