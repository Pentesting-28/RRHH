<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $array = collect([
            ['name' => 'ACH'],
            ['name' => 'CHEQUE'],
        ]);

        foreach ($array as $value) {
            PaymentMethod::create([
                'name' => $value['name']
            ]);
        }


   /*     $name = ['ACH', 'CHEQUE'];
        $description = ['Banco', 'Banco'];

        for ($i = 0; $i < count($name); $i++) {

            PaymentMethod::create([
                'name'      => $name[$i],
                'description'   => $description[$i],
            ]);
        }*/

    }
}
