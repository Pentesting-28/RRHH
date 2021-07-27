<?php

use App\Models\Permission\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Dashboard'],
            ['name' => 'Usuarios'],
            ['name' => 'Empleados'],
            ['name' => 'Configuraciones'],
        ]);

        foreach ($array as $value) {
            Permission::create([
                'name' => $value['name']
            ]);
        }
    }
}
