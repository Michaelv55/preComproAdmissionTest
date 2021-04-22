<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    private $products = [
        [
            'name'=>'azucar',
            'description'=>'producto para la cocina',
            'value'=>4200,
        ],
        [
            'name'=>'marcador',
            'description'=>'producto para estudio de color negro',
            'value'=>2500,
        ],
        [
            'name'=>'metro',
            'description'=>'Hasta 500 centímetros de largo',
            'value'=>8900,
        ],
        [
            'name'=>'Coca Cola',
            'description'=>'Bebida',
            'value'=>2000,
        ],
        [
            'name'=>'Resma De Papel',
            'description'=>'producto para oficina',
            'value'=>23000,
        ],
        [
            'name'=>'Audífonos',
            'description'=>'producto electrónico',
            'value'=>56000,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->products as $value) {
            DB::table('products')->insert([
                'name' => $value['name'],
                'description' => $value['description'],
                'value' => $value['value'],
                'status_id' => 2,
            ]);
        }
    }
}
