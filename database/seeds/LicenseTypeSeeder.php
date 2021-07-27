<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\LicenseType;

class LicenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Carnet Verde'],
            ['name' => 'Carnet Blanco']
        ]);

        foreach ($array as $value) {
            LicenseType::create([
                'name' => $value['name']
            ]);
        }
    }
}
