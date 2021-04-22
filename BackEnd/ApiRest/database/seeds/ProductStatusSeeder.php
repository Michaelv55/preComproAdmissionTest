<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStatusSeeder extends Seeder
{
    private $data =  [
        [
            'name'=>'Inactivo',
            'acronym'=>'I',
            'description'=>'El producto está inactivo'
        ],
        [
            'name'=>'Existe',
            'acronym'=>'E',
            'description'=>'Hay existencias en el stock'
        ],
        [
            'name'=>'NoExiste',
            'acronym'=>'NE',
            'description'=>'No hay existencias en el stock',
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $value) {
            DB::table('product_statuses')->insert([
                'name' => $value['name'],
                'acronym' => $value['acronym'],
                'description' => $value['description'],
            ]);
        }
    }
}
