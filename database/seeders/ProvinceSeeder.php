<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Metro Manila',
            ],
            [
                'name' => 'Bulacan'
            ]
            ];
            foreach ($data as $item){
                Province::create($item);
            }
    }
}
