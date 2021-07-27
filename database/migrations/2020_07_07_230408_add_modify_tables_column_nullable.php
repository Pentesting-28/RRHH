<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModifyTablesColumnNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('tlf_home')->nullable()->change();
            $table->string('email')->nullable()->change();

            $table->dropColumn('tlf_other');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('tlf_home');
            $table->string('tlf_other')->nullable();
            $table->string('email')->unique();
        });
    }
}
