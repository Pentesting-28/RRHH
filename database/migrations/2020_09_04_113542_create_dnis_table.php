<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnis', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('employee_id')
                ->constrained();
            $table->string('number');
            $table->date('expiration');
            $table->string('status_dni');
            $table->string('photo_dni')->nullable();
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
        Schema::dropIfExists('dnis');
    }
}
