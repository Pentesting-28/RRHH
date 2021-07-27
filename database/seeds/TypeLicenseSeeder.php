<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\TypeLicense;

class TypeLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'A'],
            ['name' => 'C'],
            ['name' => 'D'],
            ['name' => 'E1'],
            ['name' => 'E2'],
            ['name' => 'E3'],
            ['name' => 'F'],
            ['name' => 'G'],
            ['name' => 'H'],
            ['name' => 'I'],
            ['name' => 'J']
        ]);

        foreach ($array as $value) {
            TypeLicense::create([
                'name' => $value['name']
            ]);
        }
    }
}
