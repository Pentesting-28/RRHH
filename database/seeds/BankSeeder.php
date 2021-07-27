<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'BAC'],
            ['name' => 'BANCO GENERAL'],
            ['name' => 'BANISTMO']
        ]);

        foreach ($array as $value) {
            Bank::create([
                'name' => $value['name']
            ]);
        }
    }
}
