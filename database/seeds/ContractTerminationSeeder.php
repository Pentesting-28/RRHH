<?php

use Illuminate\Database\Seeder;
use App\Models\Employee\ContractTermination\ContractTermination;

class ContractTerminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Despido'],
            ['name' => 'Mutuo acuerdo'],
            ['name' => 'Renuncia']
        ]);

        foreach ($array as $value) {
            ContractTermination::create([
                'name' => $value['name']
            ]);
        }
    }
}
