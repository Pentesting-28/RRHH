<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditorsModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditors_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('quantity');
            $table->foreignId('creditor_id')->constrained();
            $table->foreignId('type_expense_id')->constrained();
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
        Schema::dropIfExists('creditors_modules');
    }
}
