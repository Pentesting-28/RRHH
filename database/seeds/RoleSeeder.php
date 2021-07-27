<?php

use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Practicante', 'Admin'];
        $description = ['normal_user', 'admin_company'];

        for ($i = 0; $i < count($name); $i++) {

            Role::create([
                'name'      => $name[$i],
                'description'   => $description[$i],
            ]);
        }
    }
}
