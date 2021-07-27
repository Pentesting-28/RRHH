<?php

use Illuminate\Database\Seeder;
use App\Models\ContractType\ContractType;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Definido'],
            ['name' => 'Indefinido'],
        ]);

        foreach ($array as $value) {
            ContractType::create([
                'name' => $value['name']
            ]);
        }
    }
}
