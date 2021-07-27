<?php

use Illuminate\Database\Seeder;
use App\Models\StatusMarital\StatusMarital;

class StatusMaritalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Soltero'],
            ['name' => 'Casado'],
            ['name' => 'Divorciado'],
            ['name' => 'Viudo'],
            ['name' => 'Unido'],
        ]);

        foreach ($array as $value) {
            StatusMarital::create([
                'name' => $value['name']
            ]);
        }
    }
}
