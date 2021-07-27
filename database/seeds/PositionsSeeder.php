<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\Position;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = collect([
            ['name' => 'Gerente'],
            ['name' => 'Ayudante General'],
        ]);

        foreach ($array as $value) {
            Position::create([
                'name' => $value['name']
            ]);
        }
    }
}
