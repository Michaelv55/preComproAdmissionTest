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
        $this->call([
            ClientSeeder::class,
            SellerSeeder::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            ProductStatusSeeder::class,
            ProductSeeder::class,
            ProductByOrderSeeder::class,
        ]);
    }
}
