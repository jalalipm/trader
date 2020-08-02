<?php

use App\Model\RefundRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RefoundRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $rnd = random_int(1, 2);
            RefundRequest::create([
                'user_id' =>  $rnd == 1 ? 2 : 9,
                'portfolio_management_id' => random_int(1, 9),
                'price' => random_int(1000000, 10000000),
                'status' => random_int(1, 4),
                'transaction_date' => Carbon::now(new \DateTimeZone('Asia/Tehran'))->subDay(random_int(1, 15))
            ]);
        }
    }
}
