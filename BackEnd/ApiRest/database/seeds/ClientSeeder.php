<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i=0; $i < 5; $i++) { 
            DB::table('clients')->insert([
                'name' => $faker->name(),
                'email' => $faker->safeEmail,
                'phone' => 31*pow(10, 8)+$faker->randomNumber(8),
            ]);
        }
    }
}
