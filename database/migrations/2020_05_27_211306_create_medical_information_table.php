<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained();
            $table->string('height');
            $table->string('weight');
            $table->string('blood_type');
            $table->string('donor');
            $table->string('hospitalized');
            $table->text('hospitalized_explain')->nullable();
            $table->string('disease')->nullable();
            $table->text('disease_explain')->nullable();
            $table->string('treatment');
            $table->text('treatment_explain')->nullable();
            $table->string('allergic');
            $table->text('allergic_explain')->nullable();
            $table->string('lenses');
            $table->string('hearing');
            $table->string('drugs');
            $table->text('drugs_explain')->nullable();
            $table->string('psychiatric');
            $table->text('psychiatric_explain')->nullable();
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
        Schema::dropIfExists('medical_information');
    }
}
