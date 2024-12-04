<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateManuskriptseitenMappingTable
 */
class CreateManuskriptseitenMappingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_mapping', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('manuskriptseite');
            $table->integer('sure_start');
            $table->integer('vers_start');
            $table->integer('wort_start');
            $table->integer('sure_ende');
            $table->integer('vers_ende');
            $table->integer('wort_ende');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manuskriptseiten_mapping');
    }
}
