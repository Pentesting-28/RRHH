<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccupationDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupation_data', function (Blueprint $table) {
            $table->id();
            $table->date('start_contract');
            $table->date('probationary_period')->nullable();
            $table->date('end_contract')->nullable();  
            $table->text('end_your_contract')->nullable();  
            
            $table->string('account_number');  
            $table->string('shirt')->nullable();  
            $table->string('trousers')->nullable();  
            $table->string('dress')->nullable();  
            $table->string('footwear')->nullable();  
            
            $table->foreignId('employee_id')
                ->constrained();
            $table->foreignId('position_id')
                ->constrained();
            $table->foreignId('contract_type_id')
                ->constrained();
            $table->foreignId('status_employee_id')
                ->constrained();
            $table->foreignId('department_type_id')
                ->constrained();
            $table->foreignId('payment_method_id')
                ->constrained();
            $table->foreignId('bank_id')
                ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occupation_data');
    }
}
