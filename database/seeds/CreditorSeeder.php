<?php

use Illuminate\Database\Seeder;
use App\Models\Creditors\Creditor;

class CreditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Creditor::create([
        	'name' => 'pensión'
        ]);
    }
}
