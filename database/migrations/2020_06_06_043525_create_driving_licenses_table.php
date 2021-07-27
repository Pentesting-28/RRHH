<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrivingLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained();
            $table->string('number')->unique();
            $table->text('observation')->nullable();
         //   $table->string('type_id'); // Tipo de licencia
            $table->string('license_path')->unique()->nullable();
            $table->date('expiration');
            $table->foreignId('license_types_id')
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
        Schema::dropIfExists('driving_licenses');
    }
}
