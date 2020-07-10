<?php

use App\Model\StockData;
use Illuminate\Database\Seeder;

class StockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StockData::create([
            'general_index' => 1753642.79,
            'general_index_change' => 6563.78,
            'general_index_same_weight' => 478682.06,
            'general_index_same_weight_change' => 4319.00,
            'market_value' => 64957390.078,
            'transaction_count' => 6.888,
            'transaction_value' => 228533.558,
            'transaction_volume' => 16.176,
        ]);
    }
}
