<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibFunctionsTable
 */
class CreateBibFunctionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_functions', function (Blueprint $table) {
            $table->increments('function_id');
            $table->string('function_name', 30)->unique('function');
            $table->string('function_abbr', 10);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_functions');
    }
}
