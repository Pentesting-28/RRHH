<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnMedicalInformationNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_information', function (Blueprint $table) {
            $table->string('height')->nullable()->change();
            $table->string('weight')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_information', function (Blueprint $table) {
            $table->string('height');
            $table->string('weight');
        });
    }
}
