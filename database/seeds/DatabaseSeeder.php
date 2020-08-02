<?php

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
        $this->call(PortfolioManagementSeeder::class);
        $this->call(StockDataSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(RefoundRequestSeeder::class);
    }
}
