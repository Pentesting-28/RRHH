<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained();
            $table->string('name_father')->nullable();
            $table->string('name_mother')->nullable();
            $table->string('name_spouse')->nullable();
            $table->date('date_spouse')->nullable();
            $table->string('spouse_job')->nullable();
            $table->string('spouse_position')->nullable();
            $table->string('family_business');
            $table->string('urgency_notify');
            $table->string('urgency_relationship');
            $table->string('urgency_res');
            $table->string('urgency_office')->nullable();
            $table->string('urgency_address');
            $table->string('children_status');
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
        Schema::dropIfExists('dependents');
    }
}
