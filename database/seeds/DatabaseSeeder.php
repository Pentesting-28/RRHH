<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(PositionsSeeder::class);
        $this->call(ContractTypeSeeder::class);
        $this->call(StatusEmployeeSeeder::class);
        $this->call(LicenseTypeSeeder::class);
        $this->call(StatusMaritalSeeder::class);
        $this->call(TypeLicenseSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(ContractTerminationSeeder::class);    
        $this->call(CreditorSeeder::class);        
    }
}
