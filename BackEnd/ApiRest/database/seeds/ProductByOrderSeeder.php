<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductByOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Factory::create();
        for ($i=1; $i <= 3 ; $i++ ){ 
            $list = collect([]);
            for ($o=1; $o <=3 ; $o++) { 
                $number = $fake->numberBetween(1,6);
                $list->add($number);
                if(!$list->contains($number)){
                    DB::table('product_by_orders')->insert([
                        'order_id' => $i,
                        'product_id' => $number,
                        'amount' => $fake->numberBetween(1,9),
                    ]);
                }
            }
        }
    }
}
