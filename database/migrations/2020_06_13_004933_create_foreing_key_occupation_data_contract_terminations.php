<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeingKeyOccupationDataContractTerminations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occupation_data', function (Blueprint $table) {
            $table->foreignId('contract_termination_id')
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occupation_data', function (Blueprint $table) {
            //
        });
    }
}