<?php

use Illuminate\Database\Seeder;
use App\Models\StatusEmployee\StatusEmployee;

class StatusEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Activo'],
            ['name' => 'Inactivo'],
            ['name' => 'Vacaciones'],
            ['name' => 'Licencia Maternal'],
            ['name' => 'Licencia '],
            ['name' => 'Licencia sin sueldo'],
        ]);

        foreach ($array as $value) {
            StatusEmployee::create([
                'name' => $value['name']
            ]);
        }
    }
}
