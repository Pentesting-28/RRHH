<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'role_id' => 1,
            'name'   =>  'cliente',
            'email'   =>  'cliente@fe.com',
            'password' => bcrypt('1qaz2wsx')
        ]);

        $user->permission()->sync([1,4]);

        $admin = User::create([
            'role_id' => 2,
            'name'   =>  'admin',
            'email'   =>  'admin@cacosa.net',
            'password' => bcrypt('Cacosa')
        ]);

        $admin->permission()->sync([1,2,3,4]);
    }
}
