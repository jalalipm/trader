<?php

use App\Model\PortfolioManagement;
use App\Model\StockData;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(PortfolioManagement::class);
        $this->call(StockData::class);
    }
}
