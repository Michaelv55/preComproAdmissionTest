<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    private $data =  [
        [
            'name'=>'Abierta',
            'acronym'=>'A',
            'description'=>'Orden Abierta',
        ],
        [
            'name'=>'Finalizada',
            'acronym'=>'F',
            'description'=>'Orden Finalizada',
        ],
        [
            'name'=>'Cancelada',
            'acronym'=>'C',
            'description'=>'Orden Cancelada',
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
            DB::table('order_statuses')->insert([
                'name' => $value['name'],
                'acronym' => $value['acronym'],
                'description' => $value['description'],
            ]);
        }
    }
}
