<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $size = 3;
        for ($i=0; $i < $size; $i++) { 
            DB::table('orders')->insert([
                'client_id' => $i+1,
                'seller_id' => ($size-$i),
                'total' => 0,
                'status_id' => 1,
                'created_at' => $faker->dateTime('now'),
            ]);
        }
    }
}
