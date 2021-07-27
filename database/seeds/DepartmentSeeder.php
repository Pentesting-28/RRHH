<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\DepartmentType;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'RRHH'],
            ['name' => 'Informatica'],
        ]);

        foreach ($array as $value) {
            DepartmentType::create([
                'name' => $value['name']
            ]);
        }
    }
}
