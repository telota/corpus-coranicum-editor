<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBelegstellenMappingTable
 */
class CreateBelegstellenMappingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belegstellen_mapping', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('belegstelle');
            $table->integer('sure_start');
            $table->integer('vers_start');
            $table->integer('sure_ende');
            $table->integer('vers_ende');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('belegstellen_mapping');
    }
}
