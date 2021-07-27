<?php

use App\Models\Employee\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => 'Juan',
            'middle_name' => '',
            'last_name' => 'Perez',
            'second_surname' => '',
            'dni' => '123',
            'start_contract' => '2020-05-01',
            'probationary_period' => '2020-05-01',
            'end_contract' => null,
            'tlf_home' => '11222',
            'tlf_movil' => '76867',
            'status_car' => 0,

            'status_marital_id' => 1,
            'contract_type_id' => 1,
            'position_id' => 1,
            'department_type_id' => 1,
            'payment_method_id' => 1,
            'status_employee_id' => 1,
        ]);


    }
}
